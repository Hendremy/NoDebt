<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Créer un groupe</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
<?php
include("inc/header.inc.php");
?>
<main>
    <h1>Créer un groupe</h1>
    <form class="field-list" action="">
        <label for="name">Nom du groupe</label>
        <input type="text" name="name" id="name" required/>
        <label for="devise">Devise</label>
        <select name="devise" id="devise" required>
            <option value="EUR" selected>&euro;</option>
            <option value="USD">&dollar;</option>
            <option value="JPY">&yen;</option>
            <option value="GBP">&pound;</option>
        </select>
        <button type="submit" class="submit" name="sendbutton">Créer groupe</button>
    </form>
</main>
</body>
</html>