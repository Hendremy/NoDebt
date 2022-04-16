<?php

namespace NoDebt;

use DB\DBLink;
use PDO;
use PDOException;

class BillRepository
{
    const TABLE_NAME = 'nodebt_facture';
    const DB_ERROR_MESSAGE = DBLink::DB_ERROR_MESSAGE;
    public function deleteBillsForExpense($db, $did){
        $stmt = $db->prepare("DELETE FROM ".self::TABLE_NAME." WHERE did = :did");
        $stmt->bindValue(':did', $did);
        return $stmt->execute();
    }

    public function getBillsForExpense($did, &$message = ''){
        $db = null;
        $bills = array();
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT fid, scan as scanfilepath, did"
                ." FROM ".self::TABLE_NAME
                ." WHERE did = :did");
            $stmt->bindValue(':did', $did);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $bills = $stmt->fetchAll(PDO::FETCH_CLASS,"NoDebt/Bill");
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $bills;
    }

}