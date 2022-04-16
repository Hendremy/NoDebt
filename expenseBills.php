<?php

use NoDebt\BillRepository;
use NoDebt\ExpenseRepository;

include'inc/session.inc.php';
?>
<?php
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/repository/BillRepository.php';

if(isset($_GET['did'])){
    $did = intval($_GET['did']);
    $expenseRepo = new ExpenseRepository();
    $billRepo = new BillRepository();
    $expense = $expenseRepo->getExpenseById($did);
    $bills = $billRepo->getBillsForExpense($did);

    if(isset($_POST['addBill'])){

    }

    if(isset($_POST['deleteBill'])){

    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Dépense <?php echo $expense->libelle ?> - Factures</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Dépense <?php echo $expense->libelle ?> - Factures</h1>
        <h2>Ajouter une facture</h2>
        <form class="field-list" action="expenseBills.php" method="post" enctype="multipart/form-data">
            <label for="bill">Scan de facture</label>
            <input type="file" name="bill" id="bill" accept=".pdf,.jpg,.png"/>
            <button type="submit" class="submit" name="addBill">Ajouter une facture</button>
        </form>
        <h2>Factures (<?php echo count($bills) ?>)</h2>
        <ul class="bills-list">
            <?php
            foreach ($bills as $bill){
                include 'inc/bill.inc.php';
            }
            ?>
        </ul>
    </main>
</body>
</html>