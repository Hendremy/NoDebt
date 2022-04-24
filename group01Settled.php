<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Roadtrip Allemagne</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <header>
        <h1>Roadtrip Allemagne créé par Machin Bidule</h1>
        <!--<a href="group01Delete.php">Supprimer le groupe</a> actif si tous les virements ont été confirmés-->
        <a href="groupSettling.php">Annuler solde</a><!-- actif car tous les virements n'ont pas été confirmés-->
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
                    <td>Helmut Fritz</td>
                    <td>12,5€</td>
                    <td>Machin Bidule</td>
                    <td><form class="choices" action="group01Settled.php"><button type="submit" class="accept">Confirmer</button></form></td>
                </tr>
                <tr>
                    <td>Hans Zwei</td>
                    <td>2,5€</td>
                    <td>Machin Bidule</td>
                    <td><form class="choices" action="group01Settled.php"><button type="submit" class="accept">Confirmer</button></form></td>
                </tr>
                <tr>
                    <td>Jean Néplin</td>
                    <td>62,5€</td>
                    <td>Machin Bidule</td>
                    <td><form class="choices" action="group01Settled.php"><button type="submit" class="accept">Confirmer</button></form></td>
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
            <table class="expenses-table-view all-expenses">
                <?php
                include("inc/expensesHead.inc.php");
                ?>
                <tbody>
                <?php
                include("inc/group01LastThreeExpenses.inc.php");
                ?>
                </tbody>
            </table>
            <?php
            include("inc/group01ExpensesTotal.inc.php");
            ?>
        </section>
        <section class="participants">
            <h2>Participants (4)</h2>
            <form name="invite-participant">
                <label for="participantEmail">Inviter un participant par e-mail</label>
                <input type="email" name="participantEmail" id="participantEmail"/>
                <button type="submit" name="inviteParticipant" id="inviteParticipant">Inviter</button>
            </form>
            <?php
            include("inc/group01Participants.inc.php");
            ?>
        </section>
    </main>
</body>
</html>