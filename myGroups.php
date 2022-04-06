<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Mes groupes</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Mes groupes</h1>
        <section class="invitationList">
            <h2>Mes invitations</h2>
            <article class="invitation">
                <header class="invitation-proposition">
                    <span>Nono Debt vous a invité à rejoindre le groupe <span class="groupe">"Soirée jeux de société"</span></span>
                    <ul class="invitationChoice choices">
                        <li>
                            <form action="group03.php" class="accept-invite">
                                <button type="submit" class="accept">Accepter</button>
                            </form>
                        </li>
                        <li>
                            <form action="group03Peek.php" class="decline-invite">
                                <button type="submit" class="decline">Refuser</button>
                            </form>
                        </li>
                    </ul>
                </header>
                <article class="groupPreview">
                    <header><span>Soirée jeux de société | Créé par: Nono Debt | Montant total des dépenses : 150 €</span>
                    </header>
                    <h3>Dernières dépenses</h3>
                    <ul class="choices">
                        <?php
                        include("inc/expensesHead.inc.php");
                        ?>
                    </ul>
                </article>
            </article>
        </section>
        <section class="groupList">
            <h2>Mes groupes</h2>
            <article class="groupPreview">
                <header><span><a href="group01.php">Roadtrip Allemagne</a> | Créé par: Machin Bidule | Montant total des dépenses : 210 €</span>
                </header>
                <h3>Dernières dépenses</h3>
                <table class="expenses-table-view">
                    <?php
                    include("inc/expensesHead.inc.php");
                    ?>
                    <tbody>
                    <?php
                    include("inc/group01LastThreeExpenses.inc.php");
                    ?>
                    </tbody>
                </table>
            </article>
        </section>
    </main>
</body>
</html>