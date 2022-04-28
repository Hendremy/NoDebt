<?php
include 'inc/session.inc.php';

require_once('php/repository/ParticipationRepository.php');
require_once('php/utils/ValidationUtils.php');
require_once('php/domain/MailSender.php');

use NoDebt\MailSender;
use NoDebt\ParticipationRepository;
use NoDebt\ValidationUtils;

if(isset($_POST['inviteRefuse'])){
    $partRepo = new ParticipationRepository();
    $validator = new ValidationUtils();
    $gid = intval($_POST['gid']);
    $groupName = $validator->validateString($_POST['groupName']);
    $groupOwner = $validator->validateString($_POST['ownerName']);
    $uid = $ses_uid;

    if($partRepo->refuseInvite($gid, $uid)){
        $participantsEmails = $partRepo->getParticipantsEmails($gid);
        $mailer = new MailSender();

        $from = MailSender::noreply;
        $subject = 'NoDebt - Invitation refusée';
        $body = "L'utilisateur $ses_firstName $ses_lastName ($ses_email) a refusé l'invitation à rejoindre le groupe $groupName créé par $groupOwner.";
        foreach ($participantsEmails as $email){
            $mailer->sendMail(MailSender::noreply, $email, $subject, $body);
        }
        header('location: myGroups.php');
    }else{
        header('location: groupPeek.php');
    }
}

