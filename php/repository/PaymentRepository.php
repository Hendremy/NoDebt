<?php

namespace NoDebt;

use DB\DBLink;
use PDO;
use PDOException;

class PaymentRepository
{
    const TABLE_NAME = 'nodebt_versement';
    const DB_ERROR_MESSAGE = DBLink::DB_ERROR_MESSAGE;

    public function insertPayments($payments, &$message=''){
        $db = null;
        $insertOk = false;
        try{
            $db = DBLink::connectToDb();
            $db->beginTransaction();
            foreach ($payments as $payment){
                $stmt = $db->prepare("INSERT INTO ".self::TABLE_NAME." (debtorId, creditorId, gid, amount)"
                    ." VALUES (:debtorId, :creditorId, :gid, :amount)");
                $stmt->bindValue(':debtorId', $payment->debtorId);
                $stmt->bindValue(':creditorId', $payment->creditorId);
                $stmt->bindValue(':gid', $payment->gid);
                $stmt->bindValue(':amount', $payment->amount);
                $stmt->execute();
            }
            $insertOk = true;
            $db->commit();
        }catch(PDOException $e){
            $db->rollBack();
            $message = $e->getMessage();
        }
        DBLink::disconnect($db);
        return $insertOk;
    }

    public function getPaymentsForGroup($gid,&$message=''){
        $db = null;
        $payments = array();
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT debtorId, CONCAT(debt.firstname,' ',debt.lastname) as debtor, "
                ."creditorId, CONCAT(cred.firsntmae,' ',cred.lastname) as creditor, amount, dateHeure, isConfirmed"
                ." FROM ".self::TABLE_NAME ." pay "
                ." JOIN " . UserRepository::TABLE_NAME ." debt ON debt.uid = pay.verseId"
                ." JOIN " . UserRepository::TABLE_NAME ." cred ON cred.uid = pay.recoitId"
                ." WHERE groupId = :gid");
            $stmt->bindValue(':gid', $gid);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $payments = $stmt->fetchAll(PDO::FETCH_CLASS, "NoDebt\Payment");
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $payments;
    }
}