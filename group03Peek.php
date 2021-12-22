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
<div class="confirm-invite-peek">
    <p>Êtes vous sûr de vouloir refuser l'invitation ?</p>
    <section class="choices">
            <form action="group03.php" class="accept-invite">
                <button type="submit" class="accept">Rejoindre le groupe</button>
            </form>
            <form action="myGroups.php" class="decline-invite">
                <button type="submit" class="decline">Supprimer l'invitation</button>
            </form>
    </section>
</div>
<main>
    <header>
        <h1>Soirée jeux de société créé par Nono Debt</h1>
    </header>
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
        <table class="expenses-table-view all-expenses">
            <?php
            include("inc/expensesTableHead.inc.php");
            ?>
            <tbody>
            <?php
            include("inc/group03LastThreeExpensesPeek.inc.php");
            ?>
            </tbody>
        </table>
        <section class="expenses-total">
            <p>Montant total : 150€</p>
            <p>Moyenne : 75€</p>
        </section>
    </section>
    <section class="participants">
        <h2>Participants (2)</h2>
        <ul class="participants-list">
            <li class="participant">
                <span>Nono Debt</span>
                <p>Dépense totale : <span>150€</span></p>
                <p>Différence à la moyenne : <span>+75€</span></p>
            </li>
            <li class="participant">
                <span>Sarah Croche</span>
                <p>Dépense totale : <span>0€</span></p>
                <p>Différence à la moyenne : <span>-75€</span></p>
            </li>
        </ul>
    </section>
</main>
</body>
</html>