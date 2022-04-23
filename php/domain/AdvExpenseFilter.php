<?php

namespace NoDebt;

class AdvExpenseFilter
{
    private $label;
    private $minAmount;
    private $maxAmount;
    private $startDate;
    private $endDate;

    public function __construct($label, $minAmount,$maxAmount,$startDate,$endDate)
    {
        $this->label = $label;
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function filter($expenses){
        if(isset($this->label) && !empty($this->label))
            $expenses = array_filter($expenses, array($this,'labelFilter'));
        if(isset($this->minAmount))
            $expenses = array_filter($expenses, array($this,'minAmountFilter'));
        if(isset($this->maxAmount) && $this->maxAmount > 0)
            $expenses = array_filter($expenses, array($this,'maxAmountFilter'));
        if(isset($this->startDate))
            $expenses = array_filter($expenses, array($this,'startDateFilter'));
        if(isset($this->endDate))
            $expenses = array_filter($expenses, array($this,'endDateFilter'));
        return $expenses;
    }

    private function labelFilter($expense){
        $wordPos = strpos(strtolower($expense->libelle), strtolower($this->label));
        return $wordPos === 0 || $wordPos != false;
    }

    private function minAmountFilter($expense){
        return $expense->montant >= $this->minAmount;
    }

    private function maxAmountFilter($expense){
        return $expense->montant <= $this->maxAmount;
    }

    private function startDateFilter($expense){
        return $expense->paydate >= $this->startDate;
    }

    private function endDateFilter($expense){
        return $expense->paydate <= $this->endDate;
    }

}