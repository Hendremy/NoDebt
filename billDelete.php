<?php

require_once 'php/utils/ValidationUtils.php';
require_once 'php/repository/BillRepository.php';
require_once 'php/storage/UploadStorage.php';
require_once ('php/utils/Alert.php');

use NoDebt\Alert;
use NoDebt\BillRepository;
use NoDebt\UploadStorage;
use NoDebt\ValidationUtils;
use NoDebt\ExpenseRepository;
use DB\DBLink;

if(isset($_POST['deleteBtn']) || isset($_POST['confirmDelete'])){
    $validator = new ValidationUtils();
    $billRepo = new BillRepository();
    $uploadStor = new UploadStorage();
    $fid = intval($_POST['fid']);
    $bill = $billRepo->getBill($fid);

    $returnPage = isset($_POST['fid']) ? "expenseBills.php?did=$bill->did" : 'myGroups.php';

    if(isset($_POST['confirmDelete'])){
        $message = '';
        if($billRepo->delete($fid, $message) && $uploadStor->delete($bill->filename)){
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
    <title>No Debt - Supprimer la facture</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Supprimer la facture</h1>
        <p class="center">Confirmez-vous la suppression de cette facture ?</p>
        <section class="deleteChoices">
        <ul class="choices">
            <li>
                <form method ="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <input type="hidden" name="fid" value="<?php echo $bill->fid?>"/>
                    <button type="submit" class="accept" name="confirmDelete" id="confirmDeleteExpense">Confirmer</button>
                </form>
            </li>
            <?php if(isset($alert)) Alert::error($alert)?>
            <li>
                <form method="post" action="<?php echo isset($returnPage) ? $returnPage : 'myGroups.php'?>">
                    <button type="submit" class="decline" name="cancelDelete" id="cancelDeleteExpense">Annuler</button>
                </form>
            </li>
        </ul>
        </section>
        <?php if(isset($bill)) :?>
            <figure class="bill-li">
                <img class="bill-scan" src="<?php if(isset($uploadStor)) echo $uploadStor->getRelativePath($bill->filename)?>" alt="scan facture"/>
            </figure>
        <?php endif?>
    </main>
    <?php
    include 'inc/footer.inc.php';
    ?>
</body>
</html>