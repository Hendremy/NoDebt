<?php

require_once 'php/utils/ValidationUtils.php';
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/repository/BillRepository.php';
require_once 'php/storage/UploadStorage.php';

use NoDebt\BillRepository;
use NoDebt\UploadStorage;
use NoDebt\ValidationUtils;
use NoDebt\ExpenseRepository;

if(isset($_POST['deleteBtn']) || isset($_POST['confirmDelete'])){
    $validator = new ValidationUtils();
    $did = intval($_POST['did']);
    $expenseRepo = new ExpenseRepository();
    $expense = $expenseRepo->getExpenseById($did);
    $returnPage = isset($_COOKIE['gid']) ? 'group.php' : 'myGroups.php';
    if(isset($_POST['confirmDelete'])){
        $uploadStor = new UploadStorage();
        $billRepo = new BillRepository();
        $message = '';
        $bills = $billRepo->getBillsForExpense($expense->did);//Récupération des factures à supprimer du serveur
        if($expenseRepo->delete($did, $message)){
            foreach ($bills as $bill){
                $uploadStor->delete($bill->filename);
            }
            header('location: '.$returnPage);
        }else{
            $alert = $message;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Supprimer la dépense <?php echo $expense->libelle ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Supprimer la dépense</h1>
        <p class="center">Confirmez-vous la suppression de la dépense <?php echo $expense->libelle ?> ?</p>
        <section class="deleteChoices">
        <ul class="choices">
            <li>
                <form method ="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <input type="hidden" name="did" value="<?php echo $did?>"/>
                    <button type="submit" class="accept" name="confirmDelete" id="confirmDeleteExpense">Confirmer</button>
                </form>
            </li>
            <?php if(isset($alert)) $alertMessage = $alert; include'inc/alertError.inc.php'?>
            <li>
                <form method="post" action="<?php echo isset($returnPage) ? $returnPage : 'myGroups.php'?>">
                    <button type="submit" class="decline" name="cancelDelete" id="cancelDeleteExpense">Annuler</button>
                </form>
            </li>
        </ul>
        </section>
    </main>
</body>
</html>