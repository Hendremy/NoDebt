<?php

require 'php/ParticipationRepository.php';
require 'php/UserRepository.php';

use NoDebt\ParticipationRepository;
use NoDebt\UserRepository;

session_start();

if (isset($_SESSION['userId'])){
    $ses_uid = $_SESSION['userId'];

    $userRepo = new UserRepository();
    $participRepo = new ParticipationRepository();
    $user = $userRepo->getUserInfo($ses_uid);
    $groups = $participRepo->getUserGroups($ses_uid);
    $invites = $participRepo->getUserInvitations($ses_uid);

    $ses_firstName = $user->firstname;
    $ses_lastName = $user->lastname;
    $ses_email = $user->email;
    $ses_groups = $groups;
    $ses_invites = $invites;
    //cookies pour récupérer la page de groupe sur laquelle était l'user à la session précédente
} else {
    $path = $_SERVER['PHP_SELF'];
    $file = basename ($path);
    if ($file !== 'index.php' && $file !== 'contact.php' && $file !== 'signup.php'
    && $file !== 'fogottenPassword.php') header('location: index.php');
}
?>