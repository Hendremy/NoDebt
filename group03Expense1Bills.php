<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Dépense Ingrédients Burger - Factures</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
<?php
include("inc/header.inc.php");
?>
<main>
    <h1>Dépense Ingrédients Burger - Factures</h1>
    <h2>Ajouter une facture</h2>
    <form class="field-list" action="group03Expense1Bills.php">
        <label for="bill">Scan de facture</label>
        <input type="file" name="bill" id="bill" accept=".pdf,.jpg,.png"/>
        <button type="submit" class="submit" name="sendbutton">Ajouter une facture</button>
    </form>
    <h2>Factures (1)</h2>
    <ul class="bills-list">
        <li>
            <img alt="scan facture 1" src="img/group03Expense1Bill1.png"/>
            <form>
                <button type="button" class="decline">Supprimer facture</button>
            </form>
        </li>
    </ul>
</main>
</body>
</html>