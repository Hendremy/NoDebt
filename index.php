<?php
require_once ('./php/UserRepository.php');
require_once ('./php/ParticipationRepository.php');
use NoDebt\UserRepository;

if(isset($_POST['loginBtn'])){
    $userEmail = !empty($_POST['userEmail']) ? htmlspecialchars($_POST['userEmail']) : '';
    $userPassword = !empty($_POST['userPassword']) ? htmlspecialchars($_POST['userPassword']) : '';

    $userRepo = new UserRepository();
    $message = '';
    $userId = $userRepo->getUserId($userEmail, $userPassword, $message);

    if(isset($userId) && $userId > 0){
        session_start();
        $_SESSION['userId'] = $userId;
        header("location: myGroups.php");
    }else{
        if(empty($message))$message = 'Connexion échouée - Email ou mot de passe incorrect';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Accueil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Connexion</h1>
        <form class="field-list" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
            <label for="userEmail">Adresse e-mail *</label>
            <input type="email" name="userEmail" id="userEmail" required value="<?php if(isset($userEmail)) echo $userEmail?>"/>
            <label for="userPassword">Mot de passe *</label>
            <input type="password" name="userPassword" id="userPassword" required value="<?php if(isset($userPassword)) echo $userPassword?>"/>
            <button type="submit" name="loginBtn">Se connecter</button>
            <?php if(isset($message)) echo "<span>$message</span>" ?>
        </form>
        <a href="forgottenPassword.php">Mot de passe oublié ?</a>
        <a href="signup.php">Inscrivez-vous !</a>
    </main>
</body>
</html>