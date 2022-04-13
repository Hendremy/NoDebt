<?php

require_once 'php/GroupRepository.php';
require_once 'php/ExpenseRepository.php';
use NoDebt\ExpenseRepository;
use NoDebt\GroupRepository;

if(isset($_GET['groupId'])){
    $groupId = intval($_GET['groupId']);
    $groupRepo = new GroupRepository();
    $expenseRepo = new ExpenseRepository();

    $group = $groupRepo->getGeneralInfo($groupId);
    $expensesPreview = $expenseRepo->getExpenses($groupId,3);
}
?>
<li class="groupPreview">
    <?php if(isset($groupId) && isset($group->name) && isset($group->owner_name) && isset($group->total) && isset($group->currency)):?>
    <header><span><a href="group.php?gid=<?php echo $groupId?>"><?php echo $group->name ?></a>
            | Créé par: <?php echo $group->owner_name ?>
            | Montant total des dépenses : <?php echo $group->formatAmount($group->total,$group->currency)?></span>
    </header>
    <?php if(isset($expensesPreview) && count($expensesPreview) > 0) :?>
            <h3>Dernières dépenses</h3>
            <ul class="expenses-table-view">
                <?php
                foreach($expensesPreview as $expense){
                    $_GET['expenseId'] = $expense->did;
                    $_GET['amount'] = $group->formatAmount($expense->montant);
                    $_GET['date'] = $expense->paydate;
                    $_GET['label'] = $expense->libelle;
                    $_GET['spender'] = $expense->spender;
                    include('inc/expense.inc.php');
                }
                ?>
            </ul>
    <?php else:?>
        <h3>Aucune dépense</h3>
    <?php endif?>
    <?php endif?>
</li>