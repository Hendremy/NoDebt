<?php
include('inc/session.inc.php');
?>
<?php
require_once 'php/repository/GroupRepository.php';
require_once 'php/repository/UserRepository.php';
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/repository/ParticipationRepository.php';
require_once 'php/repository/PaymentRepository.php';
require_once 'php/utils/ValidationUtils.php';
require_once 'php/utils/PasswordUtils.php';
require_once 'php/domain/MailSender.php';
require_once 'php/domain/SimpleExpenseFilter.php';
require_once 'php/domain/AdvExpenseFilter.php';
require_once ('php/utils/Alert.php');

use NoDebt\AdvExpenseFilter;
use NoDebt\Alert;
use NoDebt\GroupRepository;
use NoDebt\ExpenseRepository;
use NoDebt\MailSender;
use NoDebt\ParticipationRepository;
use NoDebt\PasswordUtils;
use NoDebt\PaymentRepository;
use NoDebt\SimpleExpenseFilter;
use NoDebt\UserRepository;
use NoDebt\ValidationUtils;

if(isset($_GET['gid']) || isset($_COOKIE['gid'])){
    $gid = isset($_GET['gid']) ? intval($_GET['gid']) : intval($_COOKIE['gid']);
    if(isset($ses_groups) && !in_array($gid, $ses_groups)){//Si accès illégal à un groupe, retour à page des groupes
        setcookie('gid', "", time()-3600, "/");//Destruction du cookie au cas où cookie modifié par l'utilisateur
        header('location: myGroups.php');
    }
    setcookie('gid',$gid, time() + (3600*24*30), '/');//refresh du cookie + modification si param GET différent
    $actionSelf = htmlspecialchars($_SERVER['PHP_SELF']);

    $groupRepo = new GroupRepository();
    $expenseRepo = new ExpenseRepository();
    $participRepo = new ParticipationRepository();
    $paymentRepo = new PaymentRepository();
    $validator = new ValidationUtils();

    if(isset($_POST['confirmPayment'])){
        $gid = intval($_POST['gid']);
        $credId = intval($_POST['credId']);
        $debtId = intval($_POST['debtId']);
        $message = '';
        if(!$paymentRepo->confirmPayment($gid, $credId, $debtId,$message)){
            $alertPayConfirm = $message;
        }
    }

    /*if(isset($_POST['error'])){
      pour réceptionner un message d'erreur venant d'une autre page
    }*/

    $group = $groupRepo->getGeneralInfo($gid);
    $group->expenses = $expenseRepo->getExpenses($gid);
    $group->participants = $participRepo->getParticipantsTotals($gid);
    $averageExp = count($group->participants) != 0 ? $group->total / count($group->participants) : $group->total;
    $message ='';
    $payments = $paymentRepo->getPaymentsForGroup($group->gid,$message);
    $isSettled = count($payments) > 0;
    if($isSettled){
        $canDelete = $paymentRepo->allPaymentsDone($gid);
        $canRevert = $paymentRepo->allPaymentsPending($gid);
    }

    if(isset($_POST['inviteBtn'])){
        $inviteEmail = $validator->validateString($_POST['inviteEmail']);
        if($validator->emailIsValid($inviteEmail)){//TODO: Refactoriser dans une classe InviteSender
            $mailer = new MailSender();
            $mailTopic = 'NoDebt - Invitation à rejoindre un groupe';
            $inviterName = isset($ses_lastName) && isset($ses_firstName) ? "$ses_firstName $ses_lastName" : 'un ami';

            $userRepo = new UserRepository();
            if($exists = $userRepo->alreadyExists($inviteEmail)){
                $mailBody = "Vous avez été invité à rejoindre le groupe $group->name par $inviterName"
                    ."\nConnectez-vous pour accepter l'invitation !";
            }else{
                $passwordUtils = new PasswordUtils();
                $password = $passwordUtils->generatePassword();
                $mailBody = "Bonjour et bienvenu à Nodebt !"
                    ."\nVous avez été invité à rejoindre le groupe $group->name par $inviterName"
                    ."\nUn compte a été créé pour vous:"
                    ."\n\n login: $inviteEmail"."\n password: $password"
                    ."\n\nConnectez-vous pour accepter l'invitation !";
            }
            $alertEmail = '';
            if($inviteOk = $mailer->sendMail(MailSender::noreply, $inviteEmail,$mailTopic,$mailBody,$alertEmail)){
                if(!$exists) $userRepo->generateUser($inviteEmail, $password);
                $participRepo->insertInvitation($gid,$inviteEmail);
                $inviteEmail = '';
            }
        }
    }else if(isset($_POST['searchBtn'])){
        $searchWord = $validator->validateString($_POST['searchWord']);
        $expenseFilter = new SimpleExpenseFilter($searchWord);
        $group->expenses = $expenseFilter->filter($group->expenses);
    }else if(isset($_POST['advSearchBtn'])){
        //TODO: Vérifier validité des champs
        $label = $validator->validateString($_POST['label']);
        $minAmount = floatval($_POST['minAmount']);
        $maxAmount = floatval($_POST['maxAmount']);
        $startDate = $validator->validateDate($_POST['startDate']);
        $endDate = $validator->validateDate($_POST['endDate']);
        $tags = $validator->validateString($_POST['tags']);
        $expenseFilter = new AdvExpenseFilter($label,$minAmount,$maxAmount,$startDate,$endDate,$tags);
        $group->expenses = $expenseFilter->filter($group->expenses);
    }
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
            <?php if($isSettled):?>
                <?php if($canDelete) :?>
                <form action="groupDelete.php" method="post">
                    <input type="hidden" name="groupName" value="<?php echo $group->name?>"/>
                    <button type="submit" name="deleteGroup">Supprimer le groupe</button><!-- actif si tous les virements ont été confirmés-->
                </form>
                <?php endif?>
                <?php if($canRevert):?>
                <form action="groupUnsettle.php" method="post">
                    <button type="submit" name="unsettleGroup">Annuler solde</button><!-- actif si tous les virements n'ont pas été confirmés-->
                </form>
                <?php endif?>
            <?php else:?>
            <form action="groupEdit.php" method="post">
                <input type="hidden" name="gid" value="<?php echo $group->gid?>"/>
                <button type="submit" name="editBtn" id="editBtn">Editer le groupe</button>
            </form>
                <?php if($group->total > 0 && count($group->participants) > 1 /*&& différences à la moyenne != 0*/):?>
                <form action="groupSettling.php" method="post">
                    <button type="submit" name="settleBtn" id="settleBtn">Solder le groupe</button>
                </form>
                <?php endif?>
            <?php endif?>
        </header>
        <?php if($isSettled) :?>
        <section>
            <h2 class="center">Virements</h2>
            <ul class="payments">
                <?php
                foreach ($payments as $payment){
                    include 'inc/payment.inc.php';
                }
                ?>
            </ul>
            <?php if($canDelete) Alert::success('Tous les virements ont été confirmés, vous pouvez à présent supprimer le groupe !');?>
            <?php if(isset($alertPayConfirm)) Alert::error($alertPayConfirm);?>
        </section>
        <?php endif?>
        <section class="groupView groupExpenses">
            <header class="expenses">
                <h2>Dépenses</h2>
                <ul class="search">
                    <li>
                        <form name="simple-search-expense" class="search" method="post" action="<?php echo $actionSelf?>">
                            <label for="search">Rechercher une dépense </label>
                            <input type="text" id="search" name="searchWord" placeholder="Rechercher..." <?php if(isset($searchWord)) echo "value='$searchWord'"?>/>
                            <button type="submit" name="searchBtn"><img class="iconx24" src="images/search.png" alt="Rechercher"/></button>
                        </form>
                    </li>
                    <li>
                        <details <?php if(isset($_POST['advSearchBtn'])) echo 'open' ?>>
                            <summary>Recherche avancée</summary>
                            <form name="advanced-search-expense" class="search" method="post" action="<?php echo $actionSelf?>">
                                <label for="label">Libellé</label>
                                <input type="text" name="label" id="label" value="<?php if(isset($label)) echo $label ?>"/>
                                <fieldset name="amountSpan">
                                    <label for="minAmount">Montant: de </label>
                                    <input type="number" name="minAmount" id="minAmount" value="<?php if(isset($minAmount)) echo $minAmount ?>"/>
                                    <label for="maxAmount"> à </label>
                                    <input type="number" name="maxAmount" id="maxAmount" value="<?php if(isset($maxAmount)) echo $maxAmount ?>"/>
                                </fieldset>
                                <fieldset name="dateSpan">
                                    <label for="startDate">Date: de</label>
                                    <input type="date" name="startDate" id="startDate" value="<?php if(isset($startDate)) echo $startDate ?>"/>
                                    <label for="endDate"> à </label>
                                    <input type="date" name="endDate" id="endDate" value="<?php if(isset($endDate)) echo $endDate ?>"/>
                                </fieldset>
                                <label for="tags">Tags :</label>
                                <input type="text" name="tags" id="tags" value="<?php if(isset($tags)) echo $tags ?>"/>
                                <button type="submit" name="advSearchBtn"><img class="iconx24" src="images/search.png" alt="Rechercher"/></button>
                            </form>
                        </details>
                    </li>
                </ul>
            </header>
            <ul class="expense-list">
                <?php if(count($group->expenses) > 0) :?>
                <?php
                foreach($group->expenses as $expense){
                    $expense->montant = $group->formatAmount($expense->montant);
                    include('inc/expense.inc.php');
                }
                ?>
                <?php else:?>
                <li>
                    <span>Aucune dépense trouvée</span>
                </li>
                <?php endif?>
            </ul>
            <?php if(!$isSettled) :?>
            <form class="addButton" method="post" action="expenseAdd.php">
                <input type="hidden" name="gid" value="<?php echo $gid ?>"/>
                <input type="hidden" name="groupName" value="<?php echo $group->name ?>"/>
                <input type="hidden" name="groupCurr" value="<?php echo $group->currency ?>"/>
                <button class="biggerBtn" type="submit" name="addExpenseBtn" id="addExpenseBtn">+ Ajouter une dépense</button>
            </form>
            <?php endif?>
            <?php
            include("inc/groupExpensesTotal.inc.php");
            ?>
        </section>
        <section class="participants">
            <h2>Participants (<?php echo count($group->participants)?>)</h2>
            <?php if(!$isSettled):?>
            <form name="invite-participant" method="post" action="<?php echo $actionSelf?>">
                <label for="inviteEmail">Inviter un participant par e-mail</label>
                <input type="email" name="inviteEmail" id="inviteEmail" value="<?php if(isset($inviteEmail)) echo $inviteEmail ?>"/>
                <button type="submit" name="inviteBtn" id="inviteBtn">Inviter</button>
                <?php
                if(isset($alertEmail) && isset($inviteOk)) {
                    if($inviteOk){
                        Alert::success($alertEmail);
                    }else{
                        Alert::error($alertEmail);
                    }
                }
                ?>
            </form>
            <?php endif?>
            <?php include 'inc/groupParticipants.inc.php'?>
        </section>
    </main>
    <?php
    include 'inc/footer.inc.php';
    ?>
</body>
</html>