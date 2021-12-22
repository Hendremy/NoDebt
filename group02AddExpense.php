<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Ajouter une dépense au groupe Anniversaire de Carlo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe" >
</head>
<body>
<?php
include("inc/header.inc.php");
?>
    <main>
        <h1>Ajouter une dépense au groupe Anniversaire de Carlo</h1>
        <form class="field-list" action="group02.php">
            <label for="participant">Participant</label>
            <select name="participant" id="participant" required>
                <option value="participant1" selected>Machin Bidule</option>
                <option value="participant2">Bob Eponge</option>
                <option value="participant3">Patrick Etoile</option>
                <option value="participant4">Eugene Krabs</option>
                <option value="participant5">SandySquirrel</option>
            </select>
            <label for="expenseDate">Date</label>
            <input type="date" name="date" id="expenseDate" required/>
            <label for="amount">Montant en dollars ($)</label>
            <input type="number" name="amount" id="amount" required/>
            <label for="name">Libellé</label>
            <input type="text" name="name" id="name" required/>
            <label for="bill">Facture</label>
            <input type="file" name="bill" id="bill" accept=".pdf,.jpg,.png"/>
            <label for="tags">Tags (séparés par une virgule ",")</label>
            <input type="text" id="tags" name="tags"/>
            <button type="submit" class="submit" name="sendbutton">Ajouter la dépense</button>
        </form>
    </main>
</body>
</html>