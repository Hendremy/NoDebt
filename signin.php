<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Inscription</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
<?php
include("inc/headerAnonym.inc.php");
?>
<main>
    <h1>Inscription</h1>
    <form class="signin-form auth" action="myGroups.php">
        <label for="userEmail">Adresse e-mail</label>
        <input type="email" name="userEmail" id="userEmail" required/>
        <fieldset>
        <label for="userPassword">Mot de passe</label>
        <input type="password" name="userPassword" id="userPassword" required/>
        <label for="userPasswordRep">Répetez le mot de passe</label>
        <input type="password" name="userPasswordRep" id="userPasswordRep" required/>
        </fieldset>
        <fieldset>
        <label for="firstName">Prénom</label>
        <input type="text" name="firstName" id="firstName" required/>
        <label for="lastName">Nom</label>
        <input type="text" name="lastName" id="lastName" required/>
        </fieldset>
        <button type="submit" class="submit" name="sendbutton">S'inscrire</button>
    </form>
</main>
</body>
</html>