<?php

namespace NoDebt;

use DB\DBLink;

class UserRepository
{
    const TABLE_NAME = 'nodebt_utilisateur';

    public function exists($user){
        $message = '';
        DBLink::connect2db($message);
    }

    public function insert($user){

    }

    public function update($user){

    }

    public function authentifyUser(){

    }
}