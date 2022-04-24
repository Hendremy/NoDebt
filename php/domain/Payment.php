<?php

namespace NoDebt;

class Payment
{
    public $debtor;
    public $creditor;
    public $amount;
    public $date;
    public $isConfirmed;

    public function __construct($debtor, $creditor, $amount)
    {
        $this->debtor = $debtor;
        $this->creditor = $creditor;
        $this->amount = $amount;
    }
}