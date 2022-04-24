<?php

namespace NoDebt;

class Payment
{
    public $debtor;
    public $debtorId;
    public $creditor;
    public $creditorId;
    public $amount;
    public $date;
    public $isConfirmed;

    public function __construct($debtor,$debtorId, $creditor, $creditorId, $amount)
    {
        $this->debtor = $debtor;
        $this->debtorId = $debtorId;
        $this->creditor = $creditor;
        $this->creditorId = $creditorId;
        $this->amount = $amount;
    }
}