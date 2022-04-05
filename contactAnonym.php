<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Nous contacter</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/headerAnonym.inc.php");
    ?>
    <main>
        <h1>Nous contacter</h1>
        <form class="field-list">
            <label for="userEmail">Adresse e-mail</label>
            <input type="email" name="userEmail" id="userEmail" required/>
            <label for="mailTopic">Sujet</label>
            <input type="text" name="mailTopic" id="mailTopic" required/>
            <label for="mailMessage">Message</label>
            <textarea name="mailMessage" id="mailMessage" rows="20" cols="50" required></textarea>
            <button type="submit" class="submit" name="sendbutton">Envoyer</button>
        </form>
    </main>
</body>
</html>