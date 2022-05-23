<?php
require_once 'php/repository/PaymentRepository.php';
require_once 'php/repository/DBLink.php';

use DB\DBLink;
use NoDebt\PaymentRepository;

$gid = intval($_COOKIE['gid']);
$paymentRepo = new PaymentRepository();
if($paymentRepo->deleteGroupPayments($gid)){
    header('location: group.php');
}

