<?php

namespace NoDebt;

use DB\DBLink;

class TagRepository
{
    const TABLE_NAME = 'nodebt_tag';
    const ASSOC_TABLE_NAME = 'nodebt_tag_caracterise';
    const DB_ERROR_MESSAGE = DBLink::DB_ERROR_MESSAGE;

    public function insertTag($db, $tag){
        $insertOk = false;
        $stmt = $db->prepare("INSERT INTO ". self::TABLE_NAME . " (tag, gid) "
        ." VALUES (:libelle, :gid);");
        $stmt->bindValue(":libelle", $tag->tag);
        $stmt->bindValue(":gid", $tag->gid);
        if($stmt->execute() && $stmt->rowCount() == 1){
            $tag->tid = $db->lastInsertId();
            $assoStmt = $db->prepare("INSERT INTO ". self::ASSOC_TABLE_NAME ." (did, tid)"
                ." VALUES (:did, :tid)");
            $assoStmt->bindValue(':did', $tag->did);
            $assoStmt->bindValue(':tid', $tag->tid);
            if($assoStmt->execute() && $assoStmt->rowCount() == 1){
                $insertOk = true;
            }
        }
        return $insertOk;
    }
}