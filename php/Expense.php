<?php

namespace NoDebt;

class Expense
{
    private $id;
    private $amount;
    private $user;
    private $date;
    private $label;
    private $bills;

    public function __construct($user, $amount, $label, $date, $id = 0, $bills = [])
    {
        $this->id = $id;
        $this->user = $user;
        $this->amount = $amount;
        $this->label = $label;
        $this->date = $date ?? date("Y/m/D");
        $this->bills = $bills;
    }

}