<?php
require ('php\UserRepository.php');
use NoDebt\UserRepository;

if(isset($_POST['sendbutton'])){
    $userEmail = isset($_POST['userEmail']) ? htmlspecialchars($_POST['userEmail']) : '';
    $userPassword = isset($_POST['userPassword']) ? htmlspecialchars($_POST['userPassword']) : '';
    $userPasswordRep = isset($_POST['userPasswordRep']) ? htmlspecialchars($_POST['userPasswordRep']) : '';
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
    if($validForm){
        $userRepo->insert($userEmail, $lastName, $firstName, $userPassword, $message);
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