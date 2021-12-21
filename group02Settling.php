<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Solder Anniversaire de Carlo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="img/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
<?php
include("inc/header.inc.php");
?>
<main>
    <header>
        <h1>Anniversaire de Carlo - Solder</h1>
    </header>
    <section class="groupPreview payments">
        <header>
            <h2>Virements</h2>
        </header>
        <table class="expenses-table-view all-expenses">
            <thead>
            <tr>
                <th>Emetteur</th>
                <th>Montant</th>
                <th>Receveur</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Patrick Etoile</td>
                <td>$40</td>
                <td>Bob Eponge</td>
            </tr>
            <tr>
                <td>Eugene Krabs</td>
                <td>$80</td>
                <td>Bob Eponge</td>
            </tr>
            <tr>
                <td>Eugene Krabs</td>
                <td>$5</td>
                <td>Sandy Squirrel</td>
            </tr>
            <tr>
                <td>Machin Bidule</td>
                <td>$90</td>
                <td>Bob Eponge</td>
            </tr>
            </tbody>
        </table>
        <?php
        include("inc/group02ExpensesTotal.inc.php");
        ?>
        <footer class="settleChoices choices">
            <form action="group02Settled.php">
                <button class="accept" name="confirmSettle" id="confirmSettle" type="submit">Confirmer solde</button>
            </form>
            <form action="group02.php">
                <button class="decline" name="cancelSettle" id="cancelSettle" type="submit">Annuler solde</button>
            </form>
        </footer>
    </section>
    <section class="participants">
        <h2>Participants (5)</h2>
        <?php
        include("inc/group02Participants.inc.php");
        ?>
    </section>
</main>
</body>
</html>