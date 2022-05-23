<?php
namespace NoDebt;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/Exception.php';


class MailSender{

    const noreply = 'no-reply@helmo.be';
    const admin = 'r.hendrice@student.helmo.be';

    public function sendMail($from, $to, $subject, $body, &$resultMsg='')
    {
        return $this->sendMailWithCC($from, $to, $subject, $body, null, $resultMsg);
    }

    public function sendMailWithCC($from, $to, $subject, $body, $cc, &$resultMsg=''){
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($from);
            $mail->addAddress($to);
            $mail->addReplyTo(self::noreply);
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $body;
            if(isset($cc)){
                $mail->addCC($cc);
            }
            $mail->send();
            $resultMsg = 'E-mail envoyé';
            return true;
        } catch(Exception $e){
            $resultMsg = 'Erreur lors de l\'envoi de l\'email: '.$mail->ErrorInfo;
            return false;
        }
    }
}