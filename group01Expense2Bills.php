<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Dépense Choucroute - Factures</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Dépense Choucroute - Factures</h1>
        <h2>Ajouter une facture</h2>
        <form class="field-list" action="group01Expense2Bills.php">
            <label for="bill">Scan de facture</label>
            <input type="file" name="bill" id="bill" accept=".pdf,.jpg,.png"/>
            <button type="submit" class="submit" name="sendbutton">Ajouter une facture</button>
        </form>
        <h2>Factures (0)</h2>
        <ul class="bills-list">
        </ul>
    </main>
</body>
</html>