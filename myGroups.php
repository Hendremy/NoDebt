<?php
include('inc/session.inc.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Mes groupes</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Mes groupes</h1>
        <section class="invitationList">
            <h2>Mes invitations</h2>
            <ul id="invites">
                <?php

                ?>
            </ul>
        </section>
        <section class="groupList">
            <h2>Mes groupes</h2>
            <ul id="groups">
                <?php ?>
            </ul>
        </section>
    </main>
</body>
</html>