<?php

namespace NoDebt;

require_once 'php/domain/Payment.php';
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
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $insertOk;
    }

    public function getPaymentsForGroup($gid,&$message=''){
        $db = null;
        $payments = array();
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT pay.gid, CONCAT(debt.firstname,' ',debt.lastname) as debtor, pay.debtorId,"
                ." CONCAT(cred.firstname,' ',cred.lastname) as creditor, pay.creditorId, pay.amount, pay.dateHeure, pay.isConfirmed"
                ." FROM ".self::TABLE_NAME ." pay "
                ." JOIN " . UserRepository::TABLE_NAME ." debt ON debt.uid = pay.debtorId"
                ." JOIN " . UserRepository::TABLE_NAME ." cred ON cred.uid = pay.creditorId"
                ." WHERE gid = :gid");
            $stmt->bindValue(':gid', $gid);
            if($stmt->execute()){
                $payments = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "NoDebt\Payment"
                    ,array('gid','debtor','debtorId','creditor','creditorId','amount','dateHeure','isConfirmed'));
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $payments;
    }

    public function confirmPayment($gid, $credId, $debtId, &$message=''){
        $db = null;
        $confirmOk = false;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("UPDATE ".self::TABLE_NAME
                ." SET isConfirmed = TRUE, dateHeure = NOW()"
                ." WHERE gid = :gid AND creditorId = :credId AND debtorId = :debtId");
            $stmt->bindValue(':gid',$gid);
            $stmt->bindValue(':credId',$credId);
            $stmt->bindValue(':debtId',$debtId);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $confirmOk = true;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $confirmOk;
    }

    public function allPaymentsDone($gid, &$message =''){//Aucun non confirmé
        return $this->getPaymentsCount($gid, false, $message) == 0;
    }

    public function allPaymentsPending($gid, &$message=''){//Aucun confirmé
        return $this->getPaymentsCount($gid, true, $message) == 0;
    }

    private function getPaymentsCount($gid, $isConfirmed, &$message = ''){
        $db = null;
        $paymentsCount = -1;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT * FROM ".self::TABLE_NAME.
                " WHERE gid = :gid AND isConfirmed = :isConfirmed");
            $stmt->bindValue(':gid',$gid);
            $stmt->bindValue(':isConfirmed',$isConfirmed);
            if($stmt->execute()){
                $paymentsCount = $stmt->rowCount();
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $paymentsCount;
    }

    public function deleteGroupPayments($gid, &$message=''){
        $db = null;
        $deleteOk = false;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("DELETE FROM ".self::TABLE_NAME.
                " WHERE gid = :gid");
            $stmt->bindValue(':gid',$gid);
            if($stmt->execute()){
                $deleteOk = true;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $deleteOk;
    }
}