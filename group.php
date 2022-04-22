<?php
include('inc/session.inc.php');
?>
<?php
require_once 'php/repository/GroupRepository.php';
require_once 'php/repository/UserRepository.php';
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/repository/ParticipationRepository.php';
require_once 'php/utils/ValidationUtils.php';
require_once 'php/utils/PasswordUtils.php';
require_once 'php/domain/MailSender.php';
require_once 'php/domain/SimpleExpenseFilter.php';
use NoDebt\GroupRepository;
use NoDebt\ExpenseRepository;
use NoDebt\MailSender;
use NoDebt\ParticipationRepository;
use NoDebt\PasswordUtils;
use NoDebt\SimpleExpenseFilter;
use NoDebt\UserRepository;
use NoDebt\ValidationUtils;

if(isset($_GET['gid']) || isset($_COOKIE['gid'])){
    $gid = isset($_GET['gid']) ? intval($_GET['gid']) : intval($_COOKIE['gid']);
    if(isset($ses_groups) && !in_array($gid, $ses_groups)){//Si accès illégal à un groupe, retour à page des groupes
        header('location: myGroups.php');
    }
    setcookie('gid',$gid, time() + (3600*24*30), '/');//refresh du cookie + modification si param GET différent
    $actionSelf = htmlspecialchars($_SERVER['PHP_SELF']);

    $groupRepo = new GroupRepository();
    $expenseRepo = new ExpenseRepository();
    $participRepo = new ParticipationRepository();
    $validator = new ValidationUtils();

    $group = $groupRepo->getGeneralInfo($gid);
    $expenses = $expenseRepo->getExpenses($gid);
    $participants = $participRepo->getParticipantsTotals($gid);
    $averageExp = count($participants) != 0 ? $group->total / count($participants) : $group->total;

    if(isset($_POST['inviteBtn'])){
        $inviteEmail = $validator->validateString($_POST['inviteEmail']);
        if($validator->emailIsValid($inviteEmail)){//TODO: Refactoriser dans une classe InviteSender
            $mailer = new MailSender();
            $mailTopic = 'NoDebt - Invitation à rejoindre un groupe';
            $inviterName = isset($ses_lastname) && isset($ses_firstName) ? "$ses_firstName $ses_lastname" : 'un ami';

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
        $expenses = $expenseFilter->simpleFilter($expenses);
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
            <form action="groupEdit.php" method="post">
                <input type="hidden" name="gid" value="<?php echo $group->gid?>"/>
                <button type="submit" name="editBtn" id="editBtn">Editer le groupe</button>
            </form>
            <form action="group01Settling.php" method="post">
                <input type="hidden" name="gid" value="<?php echo $group->gid?>"/>
                <button type="submit" name="settleBtn" id="settleBtn">Solder le groupe</button>
            </form>
        </header>
        <section class="groupView">
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
                        <details>
                            <summary>Recherche avancée</summary>
                            <form name="advanced-search-expense" class="search">
                                <label for="name">Libellé</label>
                                <input type="text" name="name" id="name"/>
                                <fieldset name="amountSpan">
                                    <label for="minAmount">Montant: de </label>
                                    <input type="number" name="minAmount" id="minAmount"/>
                                    <label for="maxAmount"> à </label>
                                    <input type="number" name="maxAmount" id="maxAmount"/>
                                </fieldset>
                                <fieldset name="dateSpan">
                                    <label for="startDate">Date: de</label>
                                    <input type="date" name="startDate" id="startDate"/>
                                    <label for="endDate"> à </label>
                                    <input type="date" name="endDate" id="endDate"/>
                                </fieldset>
                                <label for="tags">Tags :</label>
                                <input type="text" name="tags" id="tags"/>
                                <button type="submit" name="advSearchBtn"><img class="iconx24" src="images/search.png" alt="Rechercher"/></button>
                            </form>
                        </details>
                    </li>
                </ul>
            </header>
            <ul class="expense-list">
                <?php if(count($expenses) > 0) :?>
                <?php
                foreach($expenses as $expense){
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
            <form class="addButton" method="post" action="expenseAdd.php">
                <input type="hidden" name="gid" value="<?php echo $gid ?>"/>
                <input type="hidden" name="groupName" value="<?php echo $group->name ?>"/>
                <input type="hidden" name="groupCurr" value="<?php echo $group->currency ?>"/>
                <button class="biggerBtn" type="submit" name="addExpenseBtn" id="addExpenseBtn">+ Ajouter une dépense</button>
            </form>
            <section class="expenses-total">
                <p>Total : <?php echo $group->formatTotal() ?></p>
                <p>Moyenne : <?php echo $group->formatAmount($averageExp)?></p>
            </section>
        </section>
        <section class="participants">
            <h2>Participants (<?php echo count($participants)?>)</h2>
            <form name="invite-participant" method="post" action="<?php echo $actionSelf?>">
                <label for="inviteEmail">Inviter un participant par e-mail</label>
                <input type="email" name="inviteEmail" id="inviteEmail" value="<?php if(isset($inviteEmail)) echo $inviteEmail ?>"/>
                <button type="submit" name="inviteBtn" id="inviteBtn">Inviter</button>
                <?php
                if(isset($alertEmail) && isset($inviteOk)) {
                    $alertMessage = $alertEmail;
                    if($inviteOk){
                        include 'inc/alertSuccess.inc.php';
                    }else{
                        include 'inc/alertError.inc.php';
                    }
                }
                ?>
            </form>
            <ul class="participants-list">
                <?php
                foreach ($participants as $participant){
                    include('inc/participantTemplate.php');
                }
                ?>
            </ul>
        </section>
    </main>
</body>
</html>