<?php

namespace NoDebt;

class User
{
    private $id;
    private $email;
    private $firstName;
    private $lastName;
    private $hashPass;
    private $isActive;

    public function __construct($email, $firstName, $lastName, $hashPass, $isActive = true, $id = 0){
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->hashPass = $hashPass;
        $this->isActive = $isActive;
    }

    public function __set($prop, $value){
        $this->$prop = $value;
    }
}
