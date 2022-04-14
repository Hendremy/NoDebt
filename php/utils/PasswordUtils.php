<?php

namespace NoDebt;

class PasswordUtils
{
    public function hashPassword($password){
        return hash("sha512",$password);
    }

    public function generatePassword(){
        $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $pass = '';
            for($i = 0; $i < 12; $i++){
                $pass .= $char[rand(0, strlen($char)-1)];
            }
        return $pass;
    }
}