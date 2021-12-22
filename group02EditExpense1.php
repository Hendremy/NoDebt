<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Editer dépense Equipement karaté</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
<?php
include("inc/header.inc.php");
?>
<main>
    <h1>Equipement karaté - Editer dépense</h1>
    <form class="field-list" action="group02.php">
        <label for="participant">Participant</label>
        <select name="participant" id="participant" required>
            <option value="participant1">Bob Eponge</option>
            <option value="participant2" selected>Sandy Squirrel</option>
            <option value="participant3">Patrick Etoile</option>
            <option value="participant4">Eugene Krabs</option>
            <option value="participant5">Machin Bidule</option>
        </select>
        <label for="expenseDate">Date</label>
        <input type="date" name="date" id="expenseDate" value="2021-06-25" readonly required/>
        <label for="amount">Montant en euros ($)</label>
        <input type="number" name="amount" id="amount" value="95" required/>
        <label for="name">Libellé</label>
        <input type="text" name="name" id="name" value="Equipement karaté" required/>
        <label for="tags">Tags (séparés par une virgule ",")</label>
        <input type="text" id="tags" name="tags"/>
        <button type="submit" class="submit" name="sendbutton">Enregistrer les modifications</button>
    </form>
</main>
</body>
</html>