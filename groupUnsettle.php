<?php
require_once 'php/repository/PaymentRepository.php';

use NoDebt\PaymentRepository;

$gid = intval($_COOKIE['gid']);
$paymentRepo = new PaymentRepository();
if($paymentRepo->deleteGroupPayments($gid)){
    header('location: group.php');
}

