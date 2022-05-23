<?php
include('inc/session.inc.php');
?>
<!DOCTYPE html>
<?php

use NoDebt\Alert;
use NoDebt\MailSender;
require_once 'php/domain/MailSender.php';
require_once ('php/utils/Alert.php');

if(!isset($sendOk)) $sendOk = false;

$fromEmail = !empty($_POST['userEmail']) ? htmlentities($_POST['userEmail']) : '';
$mailTopic = !empty($_POST['mailTopic']) ? htmlentities($_POST['mailTopic']) : '';
$mailMessage = !empty($_POST['mailMessage']) ? htmlentities($_POST['mailMessage']) : '';

if (isset($_POST["sendbutton"])) {
    $resultMsg = '';
    $mailSender = new MailSender();
    $sendOk = $mailSender->sendMailWithCC($fromEmail, MailSender::admin, $mailTopic, $mailMessage, $fromEmail, $resultMsg);
}

if($sendOk){
    $fromEmail = null;
    $mailTopic = null;
    $mailMessage = null;
}

?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Nous contacter</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Nous contacter</h1>
        <form class="field-list" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <?php if(isset($ses_uid)): ?>
                <label for="userEmail" hidden>Adresse e-mail *</label>
                <input type="email" name="userEmail" id="userEmail" value="<?php if(isset($ses_email)) echo $ses_email?>" hidden readonly required/>
            <?php else:?>
                <label for="userEmail">Adresse e-mail *</label>
                <input type="email" name="userEmail" id="userEmail" value="<?php if(isset($fromEmail)) echo $fromEmail?>" required/>
            <?php endif?>
            <label for="mailTopic">Sujet *</label>
            <input type="text" name="mailTopic" id="mailTopic" required value="<?php if(isset($mailTopic)) echo $mailTopic?>"/>
            <label for="mailMessage">Message *</label>
            <textarea name="mailMessage" id="mailMessage" rows="20" cols="50" required><?php if(isset($mailMessage)) echo $mailMessage?></textarea>
            <button type="submit" class="submit" name="sendbutton">Envoyer</button>
            <?php
            if(isset($resultMsg) && isset($sendOk) && !empty($resultMsg)){
                if($sendOk){
                    Alert::success($resultMsg);
                }else{
                    Alert::error($resultMsg);
                }
            }
            ?>
        </form>
    </main>
    <?php
    include 'inc/footer.inc.php';
    ?>
</body>
</html>