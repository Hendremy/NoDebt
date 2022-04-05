<?php

namespace NoDebt;

class Group
{
    private $id;
    private $creator;
    private $name;
    private $currency;
    private $participants;
    private $expenses;
    private $tags;
    private $payments;

    public function __construct($creator, $name, $currency, $participants = [$creator], $expenses = [], $tags = [], $payments = [], $id = 0)
    {
        $this->id = $id;
        $this->creator = $creator;
        $this->name = $name;
        $this->currency = $currency;
        $this->participants = $participants;
        $this->expenses = $expenses;
        $this->tags = $tags;
        $this->payments = $payments;
    }
}