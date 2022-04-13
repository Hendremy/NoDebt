<?php

namespace NoDebt;

require_once 'php/Expense.php';

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
                ." ORDER BY dateheure DESC " . $limit);
            $stmt->bindValue(':gid', $gid);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $expenses = $stmt->fetchAll(PDO::FETCH_CLASS,"NoDebt\Expense");
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


}