<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Editer le groupe Roadtrip Allemagne</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Editer le groupe Roadtrip Allemagne</h1>
        <form class="field-list" action="group.php">
            <label for="name">Nom du groupe</label>
            <input type="text" name="name" id="name" value="Roadtrip Allemagne" required/>
            <label for="devise">Devise</label>
            <select name="devise" id="devise" required>
                <option value="EUR" selected>Euros - &euro;</option>
                <option value="USD">Dollars - &dollar;</option>
                <option value="JPY">Yen - &yen;</option>
                <option value="GBP">Livres Sterling - &pound;</option>
            </select>
            <button type="submit" class="submit" name="sendbutton">Valider modifications</button>
        </form>
    </main>
</body>
</html>