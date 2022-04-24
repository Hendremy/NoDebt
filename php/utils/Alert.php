<?php

namespace NoDebt;

class Alert
{
    public static function error($message){
        $alertMessage = $message;
        include('inc/alertError.inc.php');
    }

    public static function success($message){
        $alertMessage = $message;
        include('inc/alertSuccess.inc.php');
    }
}