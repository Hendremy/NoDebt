<?php

namespace NoDebt;

class Payment
{
    private $gid;
    private $debtor;
    private $debtorId;
    private $creditor;
    private $creditorId;
    private $amount;
    private $dateHeure;
    private $isConfirmed;

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

    public function __set($var, $value){
        $this->$var = $value;
    }

    public function __get($var){
        return $this->$var;
    }

}