<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Supprimer le groupe Anniversaire de Carlo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
<?php
include("inc/header.inc.php");
?>
<main>
    <header>
        <h1>Supprimer le groupe Anniversaire de Carlo</h1>
    </header>
    <p>Tous les virements ont été effectués, confirmez-vous la suppression du groupe ?</p>
    <section class="choices deleteChoices">
        <form action="myGroups.php" class="accept-delete">
            <button type="submit" class="accept">Confirmer</button>
        </form>
        <form action="group02Settled.php" class="decline-delete">
            <button type="submit" class="decline">Annuler</button>
        </form>
    </section>
</main>
</body>
</html>