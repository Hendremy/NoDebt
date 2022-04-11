<?php
include('inc/session.inc.php');
require('php/GroupRepository.php');
require('php/TemplateCreator.php');
require('php/ExpenseRepository.php');
use NoDebt\TemplateCreator;
use NoDebt\GroupRepository;
use NoDebt\ExpenseRepository;
?>
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
            <ul id="invites">
                <?php
                if(isset($ses_invites)){
                    foreach($ses_invites as $inviteId){

                    }
                }
                ?>
            </ul>
        </section>
        <section class="groupList">
            <h2>Mes groupes</h2>
            <ul id="groups">
                <?php
                if(isset($ses_groups)){
                    $templateCreator = new TemplateCreator();
                    $groupRepo = new GroupRepository();
                    $expenseRepo = new ExpenseRepository();
                    foreach($ses_groups as $groupId){
                        $group = $groupRepo->getGeneralInfo($groupId);
                        $expensesPreview = $expenseRepo->getExpenses($groupId,3);
                        if(isset($group) && isset($expensesPreview)){
                            $templateCreator->echoGroupPreview($group, $expensesPreview);
                        }
                    }
                }
                ?>
            </ul>
        </section>
    </main>
</body>
</html>