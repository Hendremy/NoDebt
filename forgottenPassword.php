<?php
require('php/repository/UserRepository.php');
require('php/domain/MailSender.php');
require_once ('php/utils/Alert.php');

use NoDebt\Alert;
use NoDebt\UserRepository;
use NoDebt\PasswordUtils;
use NoDebt\MailSender;

const noreply = 'noreply@helmo.be';

if(isset($_POST['resetPassBtn'])){
    $userEmail = !empty($_POST['userEmail']) ? htmlentities($_POST['userEmail']) : '';

    $userRepo = new UserRepository();
    if(filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        if ($userRepo->alreadyExists($userEmail)) {
            $passUtils = new PasswordUtils();
            $password = $passUtils->generatePassword();
            $message = '';
            $mailSender = new MailSender();
            $mailTopic = 'NoDebt - Réinitialisation de mot de passe';
            $mailBody = "Voici votre nouveau mot de passe suite à votre demande de réinitalisation :\n\n$password";
            $sendOk = $mailSender->sendMail(noreply, $userEmail, $mailTopic, $mailBody, $message);
            if ($sendOk) {
                $userRepo->updatePasswordForEmail($userEmail, $password, $message);
            }
        }
    }else{
        $alertEmail = 'Adresse e-mail invalide';
    }
        //Sécurité: ne pas préciser si l'adresse e-mail existe déjà
        $alertSuccess = 'Un mot de passe vous a été envoyé si le compte existe';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Mot de passe oublié</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Mot de passe oublié</h1>
        <form class="field-list" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <label for="userEmail">Encodez votre adresse e-mail pour recevoir un nouveau mot de passe</label>
            <input type="email" name="userEmail" id="userEmail" required value="<?php if(isset($userEmail)) echo $userEmail?>"/>
            <button type="submit" name="resetPassBtn">Envoyer</button>
            <?php
            if(isset($alertEmail)){
                Alert::error($alertEmail);
            }else if(isset($alertSuccess)){
                Alert::success($alertSuccess);
            }
            ?>
        </form>
    </main>
    <?php
    include 'inc/footer.inc.php';
    ?>
</body>
</html>