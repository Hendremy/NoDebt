<!DOCTYPE html>
<?php
use NoDebt\MailSender;
require './php/MailSender.php';
const admin = 'r.hendrice@student.helmo.be';

if(!isset($sendOk)) $sendOk = false;

$fromEmail = !empty($_POST['userEmail']) ? htmlentities($_POST['userEmail']) : '';
$mailTopic = !empty($_POST['mailTopic']) ? htmlentities($_POST['mailTopic']) : '';
$mailMessage = !empty($_POST['mailMessage']) ? htmlentities($_POST['mailMessage']) : '';


if (isset($_POST["sendbutton"])) {
    $resultMsg = '';
    $mailSender = new MailSender();
    $sendOk = $mailSender->sendMail($fromEmail, admin, $mailTopic, $mailMessage, $resultMsg);
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
            <label for="userEmail" hidden>Adresse e-mail *</label>
            <input type="email" name="userEmail" id="userEmail" value="machin@bidule.be" hidden readonly required/>
            <label for="mailTopic">Sujet *</label>
            <input type="text" name="mailTopic" id="mailTopic" required value="<?php if(!$sendOk && isset($mailTopic)) echo $mailTopic?>"/>
            <label for="mailMessage">Message *</label>
            <textarea name="mailMessage" id="mailMessage" rows="20" cols="50" required><?php if(!$sendOk && isset($mailMessage)) echo $mailMessage?></textarea>
            <button type="submit" class="submit" name="sendbutton">Envoyer</button>
            <?php if(isset($resultMsg)) echo "<span>$resultMsg</span>";?>
        </form>
    </main>
</body>
</html>