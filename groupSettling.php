<?php
include 'inc/session.inc.php';
?>
<?php
require_once 'php/repository/GroupRepository.php';
require_once 'php/repository/ParticipationRepository.php';
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/utils/ValidationUtils.php';

use NoDebt\GroupRepository;
use NoDebt\ParticipationRepository;
use NoDebt\ExpenseRepository;
use NoDebt\GroupSettler;

if(isset($_POST['gid'])){
    $gid = intval($_POST['gid']);

    $groupRepo = new GroupRepository();
    $expenseRepo = new ExpenseRepository();
    $participRepo = new ParticipationRepository();

    $group = $groupRepo->getGeneralInfo($gid);
    $group->expenses = $expenseRepo->getExpenses($gid);
    $group->participants = $participRepo->getParticipantsTotals($gid);
    $averageExp = count($group->participants) != 0 ? $group->total / count($group->participants) : $group->total;

    $groupSettler = new GroupSettler($group);
    $payments = $groupSettler->settleGroup();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Solder Roadtrip Allemagne</title>
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
            <h1>Roadtrip Allemagne - Solder</h1>
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
                    <td>Helmut Fritz</td>
                    <td>12,5€</td>
                    <td>Machin Bidule</td>
                </tr>
                <tr>
                    <td>Hans Zwei</td>
                    <td>2,5€</td>
                    <td>Machin Bidule</td>
                </tr>
                <tr>
                    <td>Jean Néplin</td>
                    <td>62,5€</td>
                    <td>Machin Bidule</td>
                </tr>
                </tbody>
            </table>
            <?php
            include("inc/group01ExpensesTotal.inc.php");
            ?>
            <footer class="settleChoices choices">
                <form action="group01Settled.php">
                    <button class="accept" name="confirmSettle" id="confirmSettle" type="submit">Confirmer solde</button>
                </form>
                <form action="group.php">
                    <button class="decline" name="cancelSettle" id="cancelSettle" type="submit">Annuler solde</button>
                </form>
            </footer>
        </section>
        <section class="participants">
            <h2>Participants (<?php echo count($group->participants)?>)</h2>
            <?php include 'inc/groupParticipants.inc.php'?>
        </section>
    </main>
</body>
</html>