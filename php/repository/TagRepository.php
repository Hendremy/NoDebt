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

    public function getTagsForId($db,$did){
        $tagsTab = array();
        $stmt = $db->prepare("SELECT t.tag FROM ".self::TABLE_NAME." t"
            ." JOIN " . self::ASSOC_TABLE_NAME . " c ON t.tid = c.tid"
            ." WHERE c.did = :did");
        $stmt->bindValue(':did', $did);
        if($stmt->execute() && $stmt->rowCount() > 0){
            $tags = $stmt->fetchAll();
            foreach ($tags as $tag){
                $tagsTab[] = $tag[0];
            }
        }
        return $tagsTab;
    }

    public function resetTagsForExpense($db, $did){
        $stmt = $db->prepare("DELETE FROM ". self::ASSOC_TABLE_NAME." WHERE did = :did");
        $stmt->bindValue(':did', $did);
        return $stmt->execute();
    }

    public function tagExists($db, $tid){
        $exists = null;
        $stmt = $db->prepare("SELECT * FROM ". self::TABLE_NAME. " WHERE tid = :tid");
        $stmt->bindValue(':tid', $tid);
        if($stmt->execute()){
            $exists = $stmt->rowCount() == 1;
        }
        return $exists;
    }

    public function associateTag($db, $did, $gid, $tag){
        $assocOk = false;
        $stmt = $db->prepare("INSERT INTO ". self::ASSOC_TABLE_NAME . " (did, tid)"
            ." VALUES (:did, 
            (SELECT tid FROM ".self::TABLE_NAME ." WHERE tag = :tag AND gid = :gid))");
        $stmt->bindValue(':did', $did);
        $stmt->bindValue(':gid', $gid);
        $stmt->bindValue(':tag', $tag);
        if($stmt->execute() && $stmt->rowCount() == 1){
            $assocOk = true;
        }
        return $assocOk;
    }
}














