<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Supprimer le profil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
<?php
include("inc/header.inc.php");
?>
<main>
    <h1>Supprimer le profil</h1>
    <p>Confirmez-vous la suppression de votre compte ?</p>
    <form action="index.php">
        <button type="submit" class="accept" name="confirmDeleteAccount" id="confirmDeleteAccount">Oui</button>
    </form>
    <form action="editProfile.php">
        <button type="submit" class="decline" name="confirmDeleteAccount" id="cancelDeleteAccount">Non</button>
    </form>
</main>
</body>
</html>