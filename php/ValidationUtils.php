<?php

namespace NoDebt;

class ValidationUtils
{
    const MAIL_ADDRESS_MAX_LENGTH = 254;
    const NAME_MAX_LENGTH = 50;

    public function nameIsValid($name){
        return !empty($name) && strlen($name) <= self::NAME_MAX_LENGTH;
    }

    public function emailIsValid($email){
        return !empty($email) && strlen($email) <= self::MAIL_ADDRESS_MAX_LENGTH
            && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function validateString($string){
        return htmlspecialchars($string);
    }

}