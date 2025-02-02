<?php

namespace NoDebt;

use DB\DBLink;
use PDO;
use PDOException;
use NoDebt\ExpenseRepository;

require_once 'ParticipationRepository.php';
require_once 'ExpenseRepository.php';
require_once 'DBLink.php';
require_once 'php/domain/Group.php';

class GroupRepository
{
    const TABLE_NAME = 'nodebt_groupe';
    const DB_ERROR_MESSAGE ='Erreur: Veuillez réessayer ultérieurement';

    public function insert($groupName, $currency, $ownerUid, &$message){
        $db = null;
        $insertedId = 0;
        try{
            $db = DBLink::connectToDb();
            $db->beginTransaction();
            $stmt = $db->prepare('INSERT INTO '. self::TABLE_NAME .' (nom, devise, own_uid) '
            . 'VALUES (:groupname, :currency, :ownerUid)');
            $stmt->bindValue(':groupname', $groupName);
            $stmt->bindValue(':currency', $currency);
            $stmt->bindValue(':ownerUid', $ownerUid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $insertedId = $db->lastInsertId();
                $this->insertParticipation($db, $ownerUid, $insertedId);
                $db->commit();
                $message = 'Groupe créé avec succès';
            }
        }catch(PDOException $e){
            $db->rollBack();
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $insertedId;
    }

    private function insertParticipation($db, $uid, $gid){
        $stmt = $db->prepare('INSERT INTO '. ParticipationRepository::TABLE_NAME.
            ' (uid, gid, estConfirme) VALUES (:uid, :gid, TRUE);');
        $stmt->bindValue(':uid', $uid);
        $stmt->bindValue(':gid', $gid);
        $stmt->execute();
    }

    public function getGeneralInfo($gid, &$message = ''){
        $group = null;
        $db = null;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT gr.gid, gr.nom  AS name, gr.devise AS currency,
                CONCAT(owner.firstname,' ', owner.lastname) 
                AS owner_name, IFNULL(SUM(dep.montant),0) AS total
                FROM nodebt_groupe gr
                JOIN nodebt_utilisateur owner on gr.own_uid = owner.uid
                LEFT JOIN nodebt_depense dep on dep.gid = gr.gid
                WHERE gr.gid = :gid
                GROUP BY gr.gid;");
            $stmt->bindValue(':gid', $gid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $group = $stmt->fetchObject("NoDebt\Group");
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $group;
    }

    public function update($group, &$message=''){
        $db = null;
        $updateOk = false;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("UPDATE ".self::TABLE_NAME
                ." SET nom = :name, devise = :currency"
                ." WHERE gid = :gid");
            $stmt->bindValue(':name', $group->name);
            $stmt->bindValue(':currency', $group->currency);
            $stmt->bindValue(':gid', $group->gid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $updateOk = true;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $updateOk;
    }

    public function delete($gid, &$message=''){
        $db = null;
        $deleteOk = false;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("DELETE FROM ".self::TABLE_NAME
                ." WHERE gid = :gid");
            $stmt->bindValue(':gid',$gid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $deleteOk = true;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $deleteOk;
    }

    public function getUserGroups($uid, $participates, &$message =''){
        $invites = null;
        $db = null;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT gr.gid, gr.nom  AS name, gr.devise AS currency,"
                ." CONCAT(owner.firstname,' ', owner.lastname) AS owner_name,"
                ." IFNULL(SUM(dep.montant),0) AS total"
                ." FROM ". GroupRepository::TABLE_NAME ." gr"
                ." JOIN ". UserRepository::TABLE_NAME ." owner on gr.own_uid = owner.uid"
                ." LEFT JOIN ". ExpenseRepository::TABLE_NAME ." dep on dep.gid = gr.gid"
                ." JOIN " . ParticipationRepository::TABLE_NAME." par on par.gid = gr.gid"
                ." WHERE par.uid = :uid AND par.estConfirme = :participates"
                ." GROUP BY gr.gid;");
            $stmt->bindValue(':uid', $uid);
            $stmt->bindValue(':participates',$participates);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $invites = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,"NoDebt\Group");
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $invites;
    }
}