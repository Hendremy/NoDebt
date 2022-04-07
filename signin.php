<?php
require ('php\UserRepository.php');
use NoDebt\UserRepository;

if(isset($_POST['sendbutton'])){
    $userEmail = isset($_POST['userEmail']) ? htmlentities($_POST['userEmail']) : '';
    $userPassword = isset($_POST['userPassword']) ? htmlentities($_POST['userPassword']) : '';
    $userPasswordRep = isset($_POST['userPasswordRep']) ? htmlentities($_POST['userPasswordRep']) : '';
    $firstName = isset($_POST['firstName']) ? htmlentities($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? htmlentities($_POST['lastName']) : '';
    $message = '';

    $userRepo = new UserRepository();
    if($userPassword === $userPasswordRep && $userRepo->alreadyExists($userEmail)){
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
            <input type="text" name="firstName" id="firstName" required/>
            <label for="lastName">Nom *</label>
            <input type="text" name="lastName" id="lastName" required/>
            <label for="userEmail">Adresse e-mail *</label>
            <input type="email" name="userEmail" id="userEmail" required/>
            <label for="userPassword">Mot de passe *</label>
            <input type="password" name="userPassword" id="userPassword" required/>
            <label for="userPasswordRep">Répetez le mot de passe *</label>
            <input type="password" name="userPasswordRep" id="userPasswordRep" required/>
            <button type="submit" class="submit" name="sendbutton">S'inscrire</button>
        </form>
    </main>
</body>
</html>