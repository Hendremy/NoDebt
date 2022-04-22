<?php

namespace NoDebt;

class SimpleExpenseFilter
{
    private $searchWord;

    public function __construct($searchWord){
        $this->searchWord = $searchWord;
    }
    public function simpleFilter($expenses){
        if(empty($this->searchWord)) return $expenses;
        return array_filter($expenses, array($this,'expenseContainsWord'));
    }

    public function expenseContainsWord($expense){
        $wordPos = strpos(strtolower($expense->libelle), strtolower($this->searchWord));
        return $wordPos === 0 || $wordPos != false;
    }
}