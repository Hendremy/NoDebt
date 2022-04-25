<?php
include 'inc/session.inc.php';
?>
<?php
require_once 'php/repository/GroupRepository.php';
require_once 'php/repository/ParticipationRepository.php';
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/repository/PaymentRepository.php';
require_once 'php/utils/ValidationUtils.php';
require_once 'php/utils/Alert.php';
require_once 'php/domain/GroupSettler.php';

use NoDebt\Alert;
use NoDebt\GroupRepository;
use NoDebt\ParticipationRepository;
use NoDebt\ExpenseRepository;
use NoDebt\GroupSettler;
use NoDebt\PaymentRepository;

if(isset($_COOKIE['gid'])){
    $actionSelf = htmlspecialchars($_SERVER['PHP_SELF']);
    $gid = intval($_COOKIE['gid']);

    $groupRepo = new GroupRepository();
    $expenseRepo = new ExpenseRepository();
    $participRepo = new ParticipationRepository();

    $group = $groupRepo->getGeneralInfo($gid);
    $group->expenses = $expenseRepo->getExpenses($gid);
    $group->participants = $participRepo->getParticipantsTotals($gid);
    $averageExp = count($group->participants) != 0 ? $group->total / count($group->participants) : $group->total;

    $groupSettler = new GroupSettler($group);
    $payments = $groupSettler->settleGroup();

    if(isset($_POST['confirmBtn'])){
        $message = '';
        $paymentRepo = new PaymentRepository();
        if($paymentRepo->insertPayments($payments,$message)){
            header('location: group.php');
        }else{
            $alertInsert = $message;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Solder <?php echo $group->name?></title>
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
            <h1><?php echo $group->name ?> - Solder</h1>
        </header>
        <section class="payments">
            <header>
                <h2>Virements</h2>
            </header>
            <ul>
                <?php
                foreach ($payments as $payment){
                    $payment->amount = $group->formatAmount($payment->amount);
                    include 'inc/payment.inc.php';
                }
                ?>
            </ul>
            <?php
            include("inc/groupExpensesTotal.inc.php");
            ?>
            <footer class="settleChoices choices">
                <form action="<?php echo $actionSelf?>" method="post">
                    <button class="accept" name="confirmBtn" id="confirmSettle" type="submit">Confirmer solde</button>
                </form>
                <form action="group.php" method="post">
                    <button class="decline" name="cancelBtn" id="cancelSettle" type="submit">Annuler solde</button>
                </form>
            </footer>
            <?php if(isset($alertInsert)) Alert::error($alertInsert) ?>
        </section>
        <section class="participants">
            <h2>Participants (<?php echo count($group->participants)?>)</h2>
            <?php include 'inc/groupParticipants.inc.php'?>
        </section>
    </main>
</body>
</html>