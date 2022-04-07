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
        <?php
        require ('php\UserRepository.php');
        use NoDebt\UserRepository;

        if(isset($_POST['loginBtn'])){
            $userEmail = isset($_POST['userEmail']) ? htmlentities($_POST['userEmail']) : '';
            $userPassword = isset($_POST['userPassword']) ? htmlentities($_POST['userPassword']) : '';
            $message = '';

            $userRepo = new UserRepository();
            $user = $userRepo->getUser($userEmail, $userPassword, $message);
            if($user != null){
                $_SESSION['userId'] = $user->id;
                $_SESSION['firstName'] = $user->firstName;
                $_SESSION['lastName'] = $user->lastName;
                $_SESSION['email'] = $user->email;
                header("location: mygroups.php");
            }else{
                $message = 'Connexion échouée - Email ou mot de passe incorrect';
            }
        }
        ?>
        <h1>Connexion</h1>
        <form class="field-list" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
            <label for="userEmail">Adresse e-mail *</label>
            <input type="email" name="userEmail" id="userEmail" required value="<?php if(isset($userEmail)) echo $userEmail?>"/>
            <label for="userPassword">Mot de passe *</label>
            <input type="password" name="userPassword" id="userPassword" required value="<?php if(isset($userPassword)) echo $userPassword?>"/>
            <button type="submit" name="loginBtn">Se connecter</button>
            <?php if(isset($message) && !empty($message)) echo "<span>$message</span>" ?>
        </form>
        <a href="forgottenPassword.php">Mot de passe oublié ?</a>
        <a href="signin.php">Inscrivez-vous !</a>
    </main>
</body>
</html>