<?php
include('inc/session.inc.php');
?>
<?php
require_once 'php/repository/UserRepository.php';
require_once 'php/repository/ParticipationRepository.php';
require_once 'php/utils/ValidationUtils.php';
require_once 'php/utils/PasswordUtils.php';
require_once ('php/utils/Alert.php');

use NoDebt\Alert;
use NoDebt\ParticipationRepository;
use NoDebt\UserRepository;
use NoDebt\ValidationUtils;
$validator = new ValidationUtils();
$userRepo = new UserRepository();
$email = isset($ses_email) ? $ses_email : '';
$firstName = isset($ses_firstName) ? $ses_firstName : '';
$lastName = isset($ses_lastName) ? $ses_lastName : '';

if(isset($_POST['infoBtn'])){
    $email = $validator->validateString($_POST['userEmail']);
    $lastName = $validator->validateString($_POST['lastName']);
    $firstName = $validator->validateString($_POST['firstName']);

    $fieldsValid = true;

    if(!$validator->emailIsValid($email)){
        $fieldsValid = false;
        $alertEmail = 'Adresse e-mail invalide';
    }else if(isset($ses_email) && $email != $ses_email && $userRepo->alreadyExists($email)){
        $fieldsValid = false;
        $alertEmail = 'Cette adresse e-mail est déjà utilisée';
    }
    if(!$validator->nameIsValid($lastName)){
        $fieldsValid = false;
        $alertLastName = 'Nom trop long: maximum 50 caractères';
    }if(!$validator->nameIsValid($firstName)){
        $fieldsValid = false;
        $alertFirstName = 'Prénom trop long: maximum 50 caractères';
    }
    if($fieldsValid && isset($ses_uid) && isset($email) && isset($lastName) && isset($firstName)){
        $message = '';
        $updateOk = $userRepo->updateUserInfo($ses_uid, $email, $lastName, $firstName, $message);
        $updateResult = $updateOk ? 'Modification enregistrées !' : 'Erreur lors de l\'enregistrement des données';
        if($updateOk){
            $ses_email = $email;
            $ses_firstName = $firstName;
            $ses_lastName = $lastName;
        }
    }
}else if(isset($_POST['passwordBtn'])){
    $password = $validator->validateString($_POST['newUserPassword']);
    $passwordRep = $validator->validateString($_POST['newUserPasswordRep']);

    if($password !== $passwordRep){
        $alertPassword = 'Le mot de passe et sa répétition ne sont pas identiques';
    }else if(isset($ses_email) && isset($password) && isset($passwordRep)){
        $userRepo = new UserRepository();
        $message = '';
        $passUpdateOk = $userRepo->updatePasswordForEmail($ses_email, $password, $message);
        $passUpdateMessage = $passUpdateOk ? 'Mot de passe modifié avec succès !' : 'Erreur lors de la modification du mot de passe: '.$message;
    }
}else if(isset($_POST['deleteAccount'])){
    $message ='';
    $participRepo = new ParticipationRepository();
    if(isset($ses_uid) && !($participRepo->userHasActiveParticipations($ses_uid, $message))){
        header('location: confirmDeleteAccount.php');
    }else{
        $alertDelete = empty($message) ? 'Impossible de supprimer le compte: vous avez des participations en cours' : $message;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Modifier le profil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main class="form-list">
        <h1>Modifier le profil</h1>
        <form class="field-list" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <label for="userEmail">Adresse e-mail</label>
            <input type="email" name="userEmail" id="userEmail" value="<?php if(isset($email)) echo $email?>"/>
            <?php if(isset($alertEmail)) Alert::error($alertEmail)?>
            <label for="firstName">Prénom</label>
            <input type="text" name="firstName" id="firstName" value="<?php if(isset($firstName)) echo $firstName?>"/>
            <?php if(isset($alertFirstName)) Alert::error($alertFirstName)?>
            <label for="lastName">Nom</label>
            <input type="text" name="lastName" id="lastName" value="<?php if(isset($lastName)) echo $lastName?>"/>
            <?php if(isset($alertLastName)) Alert::error($alertLastName)?>
            <button type="submit" class="submit" name="infoBtn">Valider modifications</button>
            <?php
            if(isset($updateResult)) {
                if($updateOk){
                    Alert::success($updateResult);
                } else{
                    Alert::error($updateResult);
                }
            }
            ?>
        </form>
        <form class="field-list" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <label for="newUserPassword">Nouveau mot de passe</label>
            <input type="password" name="newUserPassword" id="newUserPassword" value="<?php if(isset($password)) echo $password?>"/>
            <label for="newUserPasswordRep">Répetez le mot de passe</label>
            <input type="password" name="newUserPasswordRep" id="newUserPasswordRep" value="<?php if(isset($passwordRep)) echo $passwordRep?>"/>
            <?php if(isset($alertPassword)) Alert::error($alertPassword)?>
            <button type="submit" class="submit" name="passwordBtn">Valider modifications</button>
            <?php
            if(isset($passUpdateMessage)) {
                if($passUpdateOk){
                    Alert::success($passUpdateMessage);
                } else{
                    Alert::error($passUpdateMessage);
                }
            }
            ?>
        </form>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <button type="submit" class="delete decline" name="deleteAccount" id="deleteAccount">Supprimer le profil</button>
        </form>
    </main>
</body>
</html>