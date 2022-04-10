<?php

namespace NoDebt;

use DB\DBLink;
use Exception;

class ParticipationRepository
{

    const TABLE_NAME = 'nodebt_participe';
    public function userHasActiveParticipations($uid, &$message){
        $hasActiveParticipations = true;
        $bd = null;
        try{
            $bd = DBLink::connectToDb($message);
            $stmt = $bd->prepare("SELECT * FROM ". self::TABLE_NAME ." 
            WHERE uid = :uid AND estConfirme = TRUE");
            $stmt->bindValue('uid', $uid);
            if($stmt->execute() && $stmt->rowCount() == 0){
                $hasActiveParticipations = false;
            }
        }catch(Exception $e){
            $message = 'Erreur: Veuillez réessayer ultérieurement';
        }
        return $hasActiveParticipations;
    }
}