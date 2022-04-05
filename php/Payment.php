<?php

namespace NoDebt;

class Payment
{
    private $sender;
    private $receiver;
    private $amount;
    private $date;
    private $isConfirmed;

    public function __constructor($sender, $receiver, $amount){
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->amount = $amount;
        $this->date = null;
        $this->isConfirmed = false;
    }
}