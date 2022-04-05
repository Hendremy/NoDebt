<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Mot de passe oublié</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/headerAnonym.inc.php");
    ?>
    <main>
        <h1>Mot de passe oublié</h1>
        <form class="field-list" action="index.php">
            <label for="userEmail">Encodez votre adresse e-mail pour recevoir un nouveau mot de passe</label>
            <input type="email" name="userEmail" id="userEmail" required/>
            <button type="submit" name="resetUserPassword">Envoyer</button>
        </form>
    </main>
</body>
</html>