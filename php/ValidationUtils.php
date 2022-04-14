<?php

namespace NoDebt;

class ValidationUtils
{
    const MAIL_ADDRESS_MAX_LENGTH = 254;
    const NAME_MAX_LENGTH = 50;
    const TAG_MAX_LENGTH = 50;
    const TAG_SEPARATOR = ',';

    public function nameIsValid($name){
        return isset($name) && !empty($name) && strlen($name) <= self::NAME_MAX_LENGTH;
    }

    public function emailIsValid($email){
        return isset($email) && !empty($email) && strlen($email) <= self::MAIL_ADDRESS_MAX_LENGTH
            && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function dateIsValid($date){
        return isset($date) && !empty($date) && strtotime($date);
    }

    public function validateDate($date){
        $fmtDate = null;
        if($this->dateIsValid($date)){
            $time = strtotime($date);
            $fmtDate = date('Y-m-d',$time);
        }
        return $fmtDate;
    }
    public function validateString($string){
        return htmlspecialchars($string);
    }

    public function currencyIsValid($currency){
        $pattern = "/[A-Z]{3}/";
        return !empty($currency) && preg_match($pattern, $currency) && $this->currencyIsSupported($currency);
    }

    private function currencyIsSupported($currency){
        return in_array($currency,array('EUR','USD','JPY','GBP'), true);
    }

    public function expenseAmountIsValid($amount){
        return isset($amount) && $amount > 0;
    }

    public function tagsAreValid($tags){
        $tagsTab = explode(self::TAG_SEPARATOR, $tags);
        foreach ($tagsTab as $tag){
            if(!$this->tagIsValid($tag)) return false;
        }
        return true;
    }

    public function tagIsValid($tag){
        return isset($name) && !empty($name) && strlen($name) <= self::TAG_MAX_LENGTH;
    }

    public function extractTags($tags){
        $tagsTab = explode(self::TAG_SEPARATOR, $tags);
        foreach ($tagsTab as &$tag){
            $tag = trim($this->validateString($tag));//Validation du tag + Nettoyage d'espace superflus
        }
        return $tagsTab;
    }

}