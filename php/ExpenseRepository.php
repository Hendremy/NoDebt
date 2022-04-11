<?php

namespace NoDebt;

class ExpenseRepository
{
    const TABLE_NAME = 'nodebt_depense';

    public function getExpenses($gid, $top = 0){
        $expensesToSelect = $top != 0 ? "LIMIT $top": '';
    }
}