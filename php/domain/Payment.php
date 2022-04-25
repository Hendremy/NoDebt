<?php

namespace NoDebt;

class Payment
{
    public $gid;
    public $debtor;
    public $debtorId;
    public $creditor;
    public $creditorId;
    public $amount;
    public $dateHeure;
    public $isConfirmed;

    public function __construct($gid,$debtor,$debtorId, $creditor, $creditorId, $amount, $dateHeure = null, $isConfirmed = false)
    {
        $this->gid = $gid;
        $this->debtor = $debtor;
        $this->debtorId = $debtorId;
        $this->creditor = $creditor;
        $this->creditorId = $creditorId;
        $this->amount = $amount;
        $this->dateHeure = $dateHeure;
        $this->isConfirmed = $isConfirmed;
    }
}