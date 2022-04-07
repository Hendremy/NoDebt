<?php
include('inc\session.inc.php');
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
        <form class="field-list">
            <label for="userEmail">Adresse e-mail</label>
            <input type="email" name="userEmail" id="userEmail" value="machin@bidule.com"/>
            <label for="firstName">Prénom</label>
            <input type="text" name="firstName" id="firstName" value="Machin"/>
            <label for="lastName">Nom</label>
            <input type="text" name="lastName" id="lastName" value="Bidule"/>
            <button type="submit" class="submit" name="sendbutton">Valider modifications</button>
        </form>
        <form class="field-list">
            <label for="newUserPassword">Nouveau mot de passe</label>
            <input type="password" name="newUserPassword" id="newUserPassword"/>
            <label for="newUserPasswordRep">Répetez le mot de passe</label>
            <input type="password" name="newUserPasswordRep" id="newUserPasswordRep"/>
            <button type="submit" class="submit" name="sendbutton">Valider modifications</button>
        </form>
        <form action="confirmDeleteAccount.php">
            <button type="submit" class="delete decline" name="deleteAccount" id="deleteAccount">Supprimer le profil</button>
        </form>
    </main>
</body>
</html>