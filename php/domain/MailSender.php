<?php
namespace NoDebt;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/Exception.php';


class MailSender{

    const noreply = 'no-reply@helmo.be';

    public function sendMail($from, $to, $subject, $body, &$resultMsg='')
    {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($from);
            $mail->addAddress($to);
            $mail->addReplyTo(self::noreply);
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();
            $resultMsg = 'E-mail envoyé';
            return true;
        } catch(Exception $e){
            $resultMsg = 'Erreur lors de l\'envoi de l\'email: '.$mail->ErrorInfo;
            return false;
        }
    }
}