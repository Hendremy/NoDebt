<?php
include 'inc/session.inc.php';

use NoDebt\ExpenseRepository;
use NoDebt\GroupRepository;
use NoDebt\ParticipationRepository;

require_once 'php/repository/GroupRepository.php';
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/repository/ParticipationRepository.php';


?>
<?php

if(isset($_POST['inviteRefuse'])){
    $gid = intval($_POST['gid']);

    $groupRepo = new GroupRepository();
    $expenseRepo = new ExpenseRepository();
    $participRepo = new ParticipationRepository();

    $group = $groupRepo->getGeneralInfo($gid);
    $group->expenses = $expenseRepo->getExpenses($gid);
    $group->participants = $participRepo->getParticipantsTotals($gid);
    $averageExp = count($group->participants) != 0 ? $group->total / count($group->participants) : $group->total;

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - <?php echo $group->name ?></title>
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
            <form action="inviteAccept.php" class="accept-invite" method="post">
                <input type="hidden" name="gid" value="<?php echo $group->gid ?>"/>
                <button type="submit" class="accept" name="inviteAccept">Rejoindre le groupe</button>
            </form>
            <form action="inviteRefuse.php" class="decline-invite" method="post">
                <input type="hidden" name="gid" value="<?php echo $group->gid ?>"/>
                <input type="hidden" name="groupName" value="<?php echo $group->name?>"/>
                <input type="hidden" name="ownerName" value="<?php echo $group->owner_name?>"/>
                <button type="submit" class="decline" name="inviteRefuse">Refuser l'invitation</button>
            </form>
        </section>
    </div>
    <main>
        <header>
            <h1><?php echo "$group->name créé par $group->owner_name"?></h1>
        </header>
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
            <?php
            include("inc/groupExpensesTotal.inc.php");
            ?>
        </section>
        <section class="participants">
            <h2>Participants (<?php echo count($group->participants)?>)</h2>
            <?php include 'inc/groupParticipants.inc.php'?>
    </main>
    <?php
    include 'inc/footer.inc.php';
    ?>
</body>
</html>
