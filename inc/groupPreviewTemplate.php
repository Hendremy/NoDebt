<?php

use NoDebt\ExpenseRepository;
use NoDebt\GroupRepository;

if(isset($_GET['groupId'])){
    $groupId = intval($_GET['groupId']);
    $groupRepo = new GroupRepository();
    $expenseRepo = new ExpenseRepository();

    $group = $groupRepo->getGeneralInfo($groupId);
    //$expensesPreview = $expenseRepo->getExpenses($groupId,3);
}
?>
<li class="groupPreview">
    <?php if(isset($groupId) && isset($group->name) && isset($group->owner_name) && isset($group->total) && isset($group->currency)):?>
    <header><span><a href="group.php/?gid=<?php echo $groupId?>"><?php echo $group->name ?></a>
            | Créé par: <?php echo $group->owner_name ?>
            | Montant total des dépenses : <?php echo $group->formatAmount($group->total,$group->currency)?></span>
    </header>
    <h3>Dernières dépenses</h3>
    <ul class="expenses-table-view">

    </ul>
    <?php endif?>
</li>