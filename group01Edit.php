<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Editer le groupe Roadtrip Allemagne</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
<?php
include("inc/header.inc.php");
?>
<main>
    <h1>Editer le groupe Roadtrip Allemagne</h1>
    <form class="field-list" action="group01.php">
        <label for="name">Nom du groupe</label>
        <input type="text" name="name" id="name" value="Roadtrip Allemagne" required/>
        <label for="devise">Devise</label>
        <select name="devise" id="devise" required>
            <option value="EUR" selected>&euro;</option>
            <option value="USD">&dollar;</option>
            <option value="JPY">&yen;</option>
            <option value="GBP">&pound;</option>
        </select>
        <button type="submit" class="submit" name="sendbutton">Valider modifications</button>
    </form>
</main>
</body>
</html>