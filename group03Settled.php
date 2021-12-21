<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Soirée jeux de société</title>
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
        <h1>Soirée jeux de société créé Nono Debt</h1>
        <!--<a href="group03Delete.php">Supprimer le groupe</a> actif si tous les virements ont été confirmés-->
        <a href="group03Settling.php">Annuler solde</a><!-- actif car tous les virements n'ont pas été confirmés-->
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
                <th>Confirmation</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Sarah Croche</td>
                <td>50€</td>
                <td>Nono Debt</td>
                <td>En attente</td>
            </tr>
            <tr>
                <td>Machin Bidule</td>
                <td>50€</td>
                <td>Nono Debt</td>
                <td><form class="choices" action="group03Settled.php"><button type="submit" class="accept">Confirmer</button></form></td>
            </tr>
            </tbody>
        </table>
    </section>
    <section class="groupPreview groupView">
        <header class="expenses">
            <h2>Dépenses</h2>
            <ul class="search">
                <li>
                    <form name="simple-search-expense" class="search">
                        <label for="search">Rechercher une dépense </label>
                        <input type="text" id="search" name="search" placeholder="Rechercher..."/>
                    </form>
                </li>
                <li>
                    <details>
                        <summary>Recherche avancée</summary>
                        <form name="advanced-search-expense" class="search">
                            <label for="name">Libellé</label>
                            <input type="text" name="name" id="name"/>
                            <fieldset name="amountSpan">
                                <label for="minAmount">Montant (€): Entre</label>
                                <input type="number" name="minAmount" id="minAmount"/>
                                <label for="maxAmount"> et </label>
                                <input type="number" name="maxAmount" id="maxAmount"/>
                            </fieldset>
                            <fieldset name="dateSpan">
                                <label for="startDate">Date: Entre</label>
                                <input type="date" name="startDate" id="startDate"/>
                                <label for="endDate"> et </label>
                                <input type="date" name="endDate" id="endDate"/>
                            </fieldset>
                            <label for="tags">Tags :</label>
                            <input type="text" name="tags" id="tags"/>
                        </form>
                    </details>
                </li>
            </ul>
        </header>
        <?php
        include("inc/group03Expenses.inc.php");
        ?>
        <?php
        include("inc/group03ExpensesTotal.inc.php");
        ?>
    </section>
    <section class="participants">
        <h2>Participants (3)</h2>
        <?php
        include("inc/group03Participants.inc.php");
        ?>
    </section>
</main>
</body>
</html>