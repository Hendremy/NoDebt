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
        <form class="field-list" method="post" action="myGroups.php">
            <label for="userEmail">Adresse e-mail *</label>
            <input type="email" name="userEmail" id="userEmail" required/>
            <label for="userPassword">Mot de passe *</label>
            <input type="password" name="userPassword" id="userPassword" required/>
            <button type="submit" name="sendbutton">Se connecter</button>
        </form>
        <a href="forgottenPassword.php">Mot de passe oublié ?</a>
        <a href="signin.php">Inscrivez-vous !</a>
    </main>
</body>
</html>