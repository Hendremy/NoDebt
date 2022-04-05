<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Ajouter une dépense au groupe Roadtrip Allemagne</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Ajouter une dépense au groupe Roadtrip Allemagne</h1>
        <form class="field-list" action="group01.php">
            <label for="participant">Participant</label>
            <select name="participant" id="participant" required>
                <option value="participant1" selected>Machin Bidule</option>
                <option value="participant2">Helmut Frites</option>
                <option value="participant3">Hans Zwei</option>
                <option value="participant4">Jean Néplin</option>
            </select>
            <label for="expenseDate">Date</label>
            <input type="date" name="date" id="expenseDate" required/>
            <label for="amount">Montant en euros (€)</label>
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