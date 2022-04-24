<?php

namespace NoDebt;

require 'php/utils/CurrencyFormatter.php';

class Group
{
    public $gid;
    public $name;
    public $owner_name;
    public $currency;
    public $total;
    public $expenses;
    public $participants;

    public function getCurrencySymbol(){
        $fmt = new CurrencyFormatter();
        return $fmt->getCurrencySymbol($this->currency);
    }

    public function formatAmount($amount){
        $fmt = new CurrencyFormatter();
        return $fmt->formatCurrency($amount, $this->currency);
    }

    public function formatTotal(){
        return $this->formatAmount($this->total);
    }
}