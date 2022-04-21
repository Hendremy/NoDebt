<?php

use NoDebt\Bill;
use NoDebt\BillRepository;
use NoDebt\ExpenseRepository;
use NoDebt\UploadStorage;

include'inc/session.inc.php';
?>
<?php
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/repository/BillRepository.php';
require_once 'php/storage/UploadStorage.php';
require_once 'php/domain/Bill.php';

if(isset($_POST['did'])){
    $did = intval($_POST['did']);
    $expenseRepo = new ExpenseRepository();
    $billRepo = new BillRepository();

    $expense = $expenseRepo->getExpenseById($did);

    if(isset($_POST['addBill'])){
        $fileStorage = new UploadStorage();
        $message = '';
        $destination = $expense->libelle. $expense->did . '_'. time();
        $file = $_FILES['bill'];
        if(isset($file) && $fileStorage->receiveFile($file,$destination, $message)){//Si fichier correct
            $bill = new Bill();
            $bill->did = $expense->did;
            $bill->scanFilePath = $destination;
            $billRepo->insert($bill);
            $succesFile = $message;
        }else{//Si erreur, gérer cas d'erreur
            $alertFile = $message;
        }
    }

    $bills = $billRepo->getBillsForExpense($did);
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
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo UploadStorage::MAX_FILE_SIZE ?>>" />
            <input type="file" name="bill" id="bill" accept="image/*,.gif,.jpg,.png"/>
            <input type="hidden" name="did" value="<?php echo $expense->did?>"/>
            <button type="submit" class="submit" name="addBill">Ajouter une facture</button>
            <?php
            if(isset($alertFile)) {
                $alertMessage = $alertFile;
                include('inc/alertError.inc.php');
            }else if(isset($succesFile)){
                $alertMessage = $succesFile;
                include ('inc/alertSuccess.inc.php');
            }
            ?>
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