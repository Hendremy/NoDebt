<?php

namespace NoDebt;

use DB\DBLink;
use Exception;
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
        return $hasActiveParticipations;
    }

    public function getUserInvitations($uid){
        return $this->getUserGroups($uid, false);
    }

    public function getUserGroups($uid, $active = true){
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
            $groupIds = null;
        }
        return $groupIds;
    }
}