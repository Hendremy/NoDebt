<?php

namespace NoDebt;

require_once 'php/domain/Participant.php';
use DB\DBLink;
use PDO;
use PDOException;

class ParticipationRepository
{

    const TABLE_NAME = 'nodebt_participe';
    const DB_ERROR_MESSAGE ='Erreur: Veuillez réessayer ultérieurement';

    public function userHasActiveParticipations($uid, &$message){
        $hasActiveParticipations = true;
        $bd = null;
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare("SELECT * FROM ". self::TABLE_NAME ." 
            WHERE uid = :uid AND estConfirme = TRUE");
            $stmt->bindValue('uid', $uid);
            if($stmt->execute() && $stmt->rowCount() == 0){
                $hasActiveParticipations = false;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $hasActiveParticipations;
    }

    public function getUserInvitations($uid){
        return $this->getUserGroups($uid, false);
    }

    public function getUserGroups($uid, $active = true, &$message =''){
        $bd = null;
        $groupIds = array();
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare("SELECT gid FROM ". self::TABLE_NAME
                ." WHERE uid = :uid AND estConfirme = :active");
            $stmt->bindValue(':uid', $uid);
            $stmt->bindValue(':active', $active);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $groups = $stmt->fetchAll();
                foreach ($groups as $groupId){
                    $groupIds[] = $groupId[0];
                }
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($bd);
        return $groupIds;
    }

    public function getParticipants($gid, &$message =''){
        $db = null;
        $participantMap = array();
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT par.uid, CONCAT(us.firstname,' ', us.lastname) AS name"
                . " FROM ". self::TABLE_NAME." par "
                . " JOIN " . UserRepository::TABLE_NAME ." us ON us.uid = par.uid"
                . " WHERE gid = :gid AND estConfirme = TRUE;");
            $stmt->bindValue(':gid',$gid);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $participants = $stmt->fetchAll();
                foreach($participants as $participant){
                    $partId = $participant['uid'];
                    $partName = $participant['name'];
                    $participantMap[$partId] = $partName;
                }
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $participantMap;
    }

    public function getParticipantsTotals($gid, &$message=''){
        $db = null;
        $expenses = array();
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT CONCAT(us.firstname,' ',us.lastname) AS name, IFNULL(SUM(exp.montant),0) AS total"
                ." FROM ". self::TABLE_NAME ." par"
                ." JOIN ". UserRepository::TABLE_NAME ." us ON us.uid = par.uid"
                ." LEFT JOIN ". ExpenseRepository::TABLE_NAME ." exp ON exp.uid = par.uid AND exp.gid = par.gid"
                ." WHERE par.gid = :gid AND par.estConfirme = TRUE"
                ." GROUP BY par.gid, par.uid");
            $stmt->bindValue(':gid',$gid);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $expenses = $stmt->fetchAll(PDO::FETCH_CLASS,"NoDebt\Participant");
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $expenses;
    }

    public function insertInvitation($gid, $email, &$message=''){
        $db = null;
        $insertOk = false;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("INSERT INTO ". self::TABLE_NAME ."(gid, uid) VALUES (:gid,"
                . "(SELECT uid FROM ". UserRepository::TABLE_NAME ." WHERE email = :email))");
            $stmt->bindValue(':email',$email);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $insertOk = true;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $insertOk;
    }
}