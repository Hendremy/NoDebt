<?php

namespace NoDebt;

use DB\DBLink;
use PDO;
use PDOException;
use NoDebt\Bill;
require_once 'php/domain/Bill.php';
require_once 'php/repository/DBLink.php';


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
            $stmt = $db->prepare("SELECT fid, scan as filename, did"
                ." FROM ".self::TABLE_NAME
                ." WHERE did = :did");
            $stmt->bindValue(':did', $did);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $bills = $stmt->fetchAll(PDO::FETCH_CLASS,"NoDebt\Bill");
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $bills;
    }

    public function getBill($fid, &$message=''){
        $db = null;
        $bill = null;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT fid, scan as filename, did"
                ." FROM ".self::TABLE_NAME
                ." WHERE fid = :fid");
            $stmt->bindValue(':fid',$fid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $bill = $stmt->fetchObject('NoDebt\Bill');
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $bill;
    }

    public function delete($fid, &$message=''){
        $db = null;
        $deleteOk = false;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("DELETE"
                ." FROM ".self::TABLE_NAME
                ." WHERE fid = :fid");
            $stmt->bindValue(':fid',$fid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $deleteOk = true;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $deleteOk;
    }

    public function insert($bill,&$message=''){
        $db = null;
        $insertOk = false;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("INSERT INTO ". self::TABLE_NAME. " (scan, did)"
                ." VALUES (:filename,:did)");
            $stmt->bindValue(':filename', $bill->filename);
            $stmt->bindValue(':did', $bill->did);
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