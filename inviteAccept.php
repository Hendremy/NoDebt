<?php
include 'inc/session.inc.php';

require_once('php/repository/ParticipationRepository.php');
use NoDebt\ParticipationRepository;

if(isset($_POST['inviteAccept'])){
    $gid = intval($_POST['gid']);
    $uid = $ses_uid;
    $partRepo = new ParticipationRepository();
    if($partRepo->acceptInvite($gid, $uid)){
        setcookie('gid',$gid, time() + (3600*24*30), '/');
        header('location: group.php');
    }else{
        header('location: myGroups.php');
    }
}
