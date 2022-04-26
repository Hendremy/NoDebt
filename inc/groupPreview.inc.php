<?php

require_once 'php/repository/GroupRepository.php';
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/repository/PaymentRepository.php';
use NoDebt\ExpenseRepository;
use NoDebt\GroupRepository;
use NoDebt\PaymentRepository;

if(isset($groupId)){
    $groupId = intval($groupId);
    $groupRepo = new GroupRepository();
    $expenseRepo = new ExpenseRepository();
    $paymentRepo = new PaymentRepository();

    $group = $groupRepo->getGeneralInfo($groupId);
    $expensesPreview = $expenseRepo->getExpenses($groupId,3);
    $isSettled = count($paymentRepo->getPaymentsForGroup($group->gid)) > 0;
}
?>
<li class="groupPreview">
    <?php if(isset($groupId) && isset($group->name) && isset($group->owner_name) && isset($group->total) && isset($group->currency)):?>
    <header><span><a href="group.php?gid=<?php echo $groupId?>"><?php echo $group->name ?></a>
            | Créé par: <?php echo $group->owner_name ?>
            | Total : <?php echo $group->formatAmount($group->total,$group->currency)?></span>
    </header>
    <?php if(isset($expensesPreview) && count($expensesPreview) > 0) :?>
            <h3>Dernières dépenses</h3>
            <ul class="expenses-table-view">
                <?php
                foreach($expensesPreview as $expense){
                    $expense->montant = $group->formatAmount($expense->montant);
                    include('inc/expense.inc.php');
                }
                ?>
            </ul>
    <?php else:?>
        <h3>Aucune dépense</h3>
    <?php endif?>
    <?php endif?>
</li>