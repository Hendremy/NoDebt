<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Editer dépense Choucroute</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
<?php
include("inc/header.inc.php");
?>
<main>
    <h1>Choucroute - Editer dépense</h1>
    <form class="field-list" action="group01.php">
        <label for="participant">Participant</label>
        <select name="participant" id="participant" required>
            <option value="participant1">Machin Bidule</option>
            <option value="participant2">Helmut Frites</option>
            <option value="participant3" selected>Hans Zwei</option>
            <option value="participant4">Jean Néplin</option>
        </select>
        <label for="expenseDate">Date</label>
        <input type="date" name="date" id="expenseDate" value="2021-05-04" readonly required/>
        <label for="amount">Montant en euros (€)</label>
        <input type="number" name="amount" id="amount" value="50" required/>
        <label for="name">Libellé</label>
        <input type="text" name="name" id="name" value="Choucroute" required/>
        <label for="tags">Tags (séparés par une virgule ",")</label>
        <input type="text" id="tags" name="tags"/>
        <button type="submit" class="submit" name="sendbutton">Enregistrer les modifications</button>
    </form>
</main>
</body>
</html>