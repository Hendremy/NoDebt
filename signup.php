<?php
require 'php/UserRepository.php';
use NoDebt\UserRepository;
const MAX_CHAR = 50;

if(isset($_POST['sendbutton'])){
    $userEmail = isset($_POST['userEmail']) ? substr(htmlspecialchars($_POST['userEmail']),0,MAX_CHAR) : '';
    $userPassword = isset($_POST['userPassword']) ? substr(htmlspecialchars($_POST['userPassword']),0, MAX_CHAR) : '';
    $userPasswordRep = isset($_POST['userPasswordRep']) ? substr(htmlspecialchars($_POST['userPasswordRep']),0, MAX_CHAR) : '';
    $firstName = isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : '';

    $message = '';
    $validForm = true;

    $userRepo = new UserRepository();
    if($userPassword !== $userPasswordRep){
        $passwordMessage = 'Le mot de passe et sa répétition ne sont pas identiques';
        $validForm = false;
    }
    if($userRepo->alreadyExists($userEmail)){
        $emailMessage = 'Cette adresse e-mail est déjà utilisée';
        $validForm = false;
    }
    if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
        $emailMessage = 'Adresse e-mail invalide';
        $validForm = false;
    }
    if($validForm){
        $insertedUid = $userRepo->insert($userEmail, $lastName, $firstName, $userPassword, $message);
        if($insertedUid > 0){
            session_start();
            $_SESSION['userId'] = $insertedUid;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['email'] = $userEmail;
            header("location: myGroups.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Inscription</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Inscription</h1>
        <form class="field-list" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <label for="firstName">Prénom *</label>
            <input type="text" name="firstName" id="firstName" required value="<?php if(isset($firstName)) echo $firstName?>"/>
            <label for="lastName">Nom *</label>
            <input type="text" name="lastName" id="lastName" required value="<?php if(isset($lastName)) echo $lastName?>"/>
            <label for="userEmail">Adresse e-mail *</label>
            <input type="email" name="userEmail" id="userEmail" required value="<?php if(isset($userEmail)) echo $userEmail?>"/>
            <?php if(isset($emailMessage)) echo "<span class='error-message'>$emailMessage</span>"?>
            <label for="userPassword">Mot de passe *</label>
            <input type="password" name="userPassword" id="userPassword" required value="<?php if(isset($userPassword)) echo $userPassword?>"/>
            <label for="userPasswordRep">Répetez le mot de passe *</label>
            <input type="password" name="userPasswordRep" id="userPasswordRep" required value="<?php if(isset($userPasswordRep)) echo $userPasswordRep?>"/>
            <?php if(isset($passwordMessage)) echo "<span class='error-message'>$passwordMessage</span>"?>
            <button type="submit" class="submit" name="sendbutton">S'inscrire</button>
            <?php if(isset($message)) echo $message?>
        </form>
    </main>
</body>
</html>