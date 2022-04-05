<?php

namespace NoDebt;

class User
{
    private $email;
    private $firstName;
    private $lastName;
    private $hashPass;
    private $isActive;

    public function __construct($email, $firstName, $lastName, $hashPass){
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->hashPass = $hashPass;
        $this->isActive = true;
    }

    public function __set($prop, $value){
        $this->$prop = $value;
    }
}
