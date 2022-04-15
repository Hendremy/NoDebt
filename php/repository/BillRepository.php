<?php

namespace NoDebt;

class BillRepository
{
    const TABLE_NAME = 'nodebt_facture';
    public function deleteBillsForExpense($db, $did){
        $stmt = $db->prepare("DELETE FROM ".self::TABLE_NAME." WHERE did = :did");
        $stmt->bindValue(':did', $did);
        return $stmt->execute();
    }

}