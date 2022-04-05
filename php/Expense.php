<?php

namespace NoDebt;

class Expense
{
    private $amount;
    private $user;
    private $date;
    private $label;
    private $bills;

    public function __construct($user, $amount, $label)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->label = $label;
        $this->date = date("Y/m/D");
        $this->bills = array();
    }

}