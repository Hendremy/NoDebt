<?php
use NoDebt\ExpenseRepository;
use NoDebt\PaymentRepository;

if(isset($group)):?>
<?php

require_once 'php/repository/ExpenseRepository.php';
require_once 'php/repository/PaymentRepository.php';


$groupId = intval($group->gid);
$expenseRepo = new ExpenseRepository();
$paymentRepo = new PaymentRepository();

$expensesPreview = $expenseRepo->getExpenses($groupId,3);
$isSettled = count($paymentRepo->getPaymentsForGroup($group->gid)) > 0;
?>
<li class="groupPreview">
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
</li>
<?php endif?>