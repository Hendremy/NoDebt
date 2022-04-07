<?php

namespace NoDebt;

class User
{
    private $uid;
    private $email;
    private $firstname;
    private $lastname;

    public function __construct($id, $email, $firstname, $lastname){
        $this->uid = $id;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function __set($prop, $value){
        $this->$prop = $value;
    }

    public function __get($prop){
        return $this->$prop;
    }
}
