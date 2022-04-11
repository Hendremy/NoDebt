<?php

namespace NoDebt;

use DB\DBLink;
use PDOException;

require 'DBLink.php';
class GroupRepository
{
    const TABLE_NAME = 'nodebt_groupe';

    public function insert($groupName, $currency, $ownerUid, &$message){
        $db = null;
        $insertedId = 0;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare('INSERT INTO '. self::TABLE_NAME .' (nom, devise, own_uid) '
            . 'VALUES (:groupname, :currency, :ownerUid)');
            $stmt->bindValue(':groupname', $groupName);
            $stmt->bindValue(':currency', $currency);
            $stmt->bindValue(':ownerUid', $ownerUid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $insertOk = $db->lastInsertId();
                $message = 'Groupe créé avec succès';
            }
        }catch(PDOException $e){
            $message = 'Erreur: Veuillez réessayer ultérieurement.';
        }
        DBLink::disconnect($db);
        return $insertOk;
    }

}