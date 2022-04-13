<?php

namespace NoDebt;

require_once 'php/Expense.php';

use DB\DBLink;
use PDO;
use PDOException;

class ExpenseRepository
{
    const TABLE_NAME = 'nodebt_depense';

    public function getExpenses($gid, $top = 0){
        $top = intval($top);
        $limit = $top != 0 ? "LIMIT $top" : '';
        $db = null;
        $expenses = array();
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("SELECT did,  montant, DATE_FORMAT(dateHeure,'%Y-%m-%d') AS paydate, libelle, uid, gid
            FROM ". self::TABLE_NAME .
            " WHERE gid = :gid ORDER BY dateheure DESC ". $limit);
            $stmt->bindValue(':gid', $gid);
            if($stmt->execute() && $stmt->rowCount() > 0){
                $expenses = $stmt->fetchAll(PDO::FETCH_CLASS,"NoDebt\Expense");
                foreach ($expenses as $expense){
                    $expense->spender = $this->getSpender($db, $expense->uid);
                }
            }
        }catch(PDOException $e){

        }
        DBLink::disconnect($db);
        return $expenses;
    }

    private function getSpender($db, $uid){
        $spenderName = 'Not Found';
        $stmt = $db->prepare("SELECT CONCAT(firstname,' ', lastname) AS spender_name FROM ". UserRepository::TABLE_NAME .
        " WHERE uid = :uid");
        $stmt->bindValue(':uid',$uid);
        if($stmt->execute() && $stmt->rowCount() == 1){
            $spenderName = $stmt->fetch()[0];
        }
        return $spenderName;
    }
}