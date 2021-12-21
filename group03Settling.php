<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Solder Soirée jeux de société</title>
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
        <h1>Soirée jeux de société - Solder</h1>
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
                <td>Sarah Croche</td>
                <td>50€</td>
                <td>Nono Debt</td>
            </tr>
            <tr>
                <td>Machin Bidule</td>
                <td>50€</td>
                <td>Nono Debt</td>
            </tr>
            </tbody>
        </table>
        <?php
        include("inc/group03ExpensesTotal.inc.php");
        ?>
        <footer class="settleChoices choices">
            <form action="group03Settled.php">
                <button class="accept" name="confirmSettle" id="confirmSettle" type="submit">Confirmer solde</button>
            </form>
            <form action="group03.php">
                <button class="decline" name="cancelSettle" id="cancelSettle" type="submit">Annuler solde</button>
            </form>
        </footer>
    </section>
    <section class="participants">
        <h2>Participants (3)</h2>
        <?php
        include("inc/group02Participants.inc.php");
        ?>
    </section>
</main>
</body>
</html>