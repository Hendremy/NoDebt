<?php
include('inc/session.inc.php');
?>
<?php
require_once 'php/GroupRepository.php';
require_once 'php/ExpenseRepository.php';
use NoDebt\GroupRepository;
use NoDebt\ExpenseRepository;

if(isset($_GET['gid'])){
    $gid = intval($_GET['gid']);
    if(isset($ses_groups) && !in_array($gid, $ses_groups)){//Si accès illégal à un groupe, retour à page des groupes
        header('location: myGroups.php');
    }
    $groupRepo = new GroupRepository();
    $expenseRepo = new ExpenseRepository();
    $group = $groupRepo->getGeneralInfo($gid);
    $expenses = $expenseRepo->getExpenses($gid);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - <?php echo $group->name ?></title>
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
            <h1><?php echo "$group->name créé par $group->owner_name"?></h1>
            <a href="group01Edit.php">Editer le groupe</a>
            <a href="group01Settling.php">Solder le groupe</a>
        </header>
        <section class="groupView">
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
            <ul class="expenses-table-view">
                <?php
                foreach($expenses as $expense){
                    $_GET['expenseId'] = $expense->did;
                    $_GET['amount'] = $group->formatAmount($expense->montant);
                    $_GET['date'] = $expense->paydate;
                    $_GET['label'] = $expense->libelle;
                    $_GET['spender'] = $expense->spender;
                    include('inc/expense.inc.php');
                }
                ?>
            </ul>
            <a href="group01AddExpense.php">+ Ajouter une dépense</a>
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