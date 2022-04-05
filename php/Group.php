<?php

namespace NoDebt;

class Group
{
    private $creator;
    private $name;
    private $currency;
    private $participants;
    private $expenses;
    private $tags;
    private $payments;

    public function __construct($creator, $name, $currency)
    {
        $this->creator = $creator;
        $this->name = $name;
        $this->currency = $currency;
        $this->participants = array($creator);
        $this->expenses = array();
        $this->tags = array();
        $this->payments = array();
    }
}