<?php

namespace NoDebt;

require_once 'php/domain/Expense.php';
require_once 'php/repository/TagRepository.php';
require_once 'php/repository/BillRepository.php';
require_once 'php/repository/DBLink.php';

use DB\DBLink;
use PDO;
use PDOException;

class ExpenseRepository
{
    const TABLE_NAME = 'nodebt_depense';
    const DB_ERROR_MESSAGE ='Erreur: Veuillez réessayer ultérieurement';

    public function getExpenses($gid, $top = 0){
        $top = intval($top);
        $limit = $top != 0 ? "LIMIT $top" : '';
        $db = null;
        $expenses = array();
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT exp.did,  exp.montant, DATE_FORMAT(exp.dateHeure,'%Y-%m-%d') AS paydate, exp.libelle, exp.uid, exp.gid,
            CONCAT(us.firstname,' ', us.lastname) AS spender FROM ". self::TABLE_NAME ." exp "
                ." JOIN ". UserRepository::TABLE_NAME ." us ON exp.uid = us.uid"
                ." WHERE gid = :gid"
                ." ORDER BY dateHeure DESC " . $limit);
            $stmt->bindValue(':gid', $gid);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $expenses = $stmt->fetchAll(PDO::FETCH_CLASS,"NoDebt\Expense");
                $tagRepo = new TagRepository();
                foreach ($expenses as $expense){
                    $expense->tagsTab = $tagRepo->getTagsForId($db, $expense->did);
                }
            }
        }catch(PDOException $e){

        }
        DBLink::disconnect($db);
        return $expenses;
    }

    private function getSpender($db, $uid){
        $spenderName = 'Not Found';
        $stmt = $db->prepare("SELECT CONCAT(firstname,' ', lastname) AS spender_name FROM ". UserRepository::TABLE_NAME .
        " WHERE uid = :uid");
        $stmt->bindValue(':uid',$uid);
        if($stmt->execute() && $stmt->rowCount() == 1){
            $spenderName = $stmt->fetch()[0];
        }
        return $spenderName;
    }

    public function insert($expense, &$message=''){
        $db = null;
        $insertOk = false;
        try{
            $db = DBLink::connectToDb();
            $db->beginTransaction();
            $stmt = $db->prepare("INSERT INTO ". self::TABLE_NAME ." (dateHeure, montant, libelle, uid, gid)"
                ."VALUES (:paydate,:montant,:libelle,:uid, :gid);");
            $stmt->bindValue(':paydate', $expense->paydate);
            $stmt->bindValue(':montant', $expense->montant);
            $stmt->bindValue(':libelle', $expense->libelle);
            $stmt->bindValue(':uid', $expense->uid);
            $stmt->bindValue(':gid', $expense->gid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $did = $db->lastInsertId();
                $tagsRepo = new TagRepository();
                foreach ($expense->tagsTab as $tag){
                    $tag->did = $did;
                    if(!$tagsRepo->insertTag($db, $tag)) throw new PDOException();
                }
            }
            if($db->commit()) $insertOk = true;
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
            if(isset($db)) $db->rollBack();
        }
        DBLink::disconnect($db);
        return $insertOk;
    }

    public function getExpenseById($did, &$message=''){
        $db = null;
        $expense = null;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT did, montant, DATE_FORMAT(dateHeure,'%Y-%m-%d') AS paydate, libelle, uid, gid"
                ." FROM ". self::TABLE_NAME
                ." WHERE did = :did");
            $stmt->bindValue(':did',$did);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $expense = $stmt->fetchObject("NoDebt\Expense");
                $tagsRepo = new TagRepository();
                $expense->tagsTab = $tagsRepo->getTagsForId($db, $did);
                $expense->tagsString = $expense->implodeTags();
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $expense;
    }

    public function update($expense, &$message=''){
        $db = null;
        $updateOk = false;
        try{
            $db = DBLink::connectToDb();
            $db->beginTransaction();
            $stmt = $db->prepare("UPDATE ". self::TABLE_NAME
                . " SET dateHeure = :paydate, montant = :montant, libelle = :libelle, uid = :uid"
                ." WHERE did = :did");
            $stmt->bindValue(':paydate', $expense->paydate);
            $stmt->bindValue(':montant', $expense->montant);
            $stmt->bindValue(':libelle', $expense->libelle);
            $stmt->bindValue(':uid', $expense->uid);
            $stmt->bindValue(':did', $expense->did);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $tagsRepo = new TagRepository();
                if(!$tagsRepo->resetTagsForExpense($db, $expense->did)) throw new PDOException();
                foreach ($expense->tagsTab as $tag){
                    if($tagsRepo->tagExists($db, $tag)){
                        if(!$tagsRepo->associateTag($db, $expense->did, $expense->gid, $tag)) throw new PDOException();
                    }else{
                        if(!$tagsRepo->insertTag($db, $tag)) throw new PDOException();
                    }
                }
            }
            if($db->commit()) $updateOk = true;
        }catch(PDOException $e){
            $message .= self::DB_ERROR_MESSAGE;
            if(isset($db)) $db->rollBack();
        }
        DBLink::disconnect($db);
        return $updateOk;
    }

    public function delete($did, &$message = ''){
        $db = null;
        $deleteOk = false;
        try{
            $db = DBLink::connectToDb();
            $tagsRepo = new TagRepository();
            $billRepo = new BillRepository();
            $db->beginTransaction();
            if($tagsRepo->resetTagsForExpense($db, $did) && $billRepo->deleteBillsForExpense($db, $did)){
                $stmt = $db->prepare("DELETE FROM ".self::TABLE_NAME." WHERE did = :did");
                $stmt->bindValue(':did', $did);
                if($stmt->execute() && $stmt->rowCount() == 1){
                    $deleteOk = true;
                    $db->commit();
                }
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $deleteOk;
    }


}