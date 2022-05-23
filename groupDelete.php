<?php
include 'inc/session.inc.php';
?>
<?php

require_once 'php/utils/ValidationUtils.php';
require_once 'php/repository/PaymentRepository.php';
require_once 'php/repository/GroupRepository.php';

use NoDebt\Alert;
use NoDebt\PaymentRepository;
use NoDebt\GroupRepository;
use NoDebt\ValidationUtils;

$paymentRepo = new PaymentRepository();
$actionSelf = htmlspecialchars($_SERVER['PHP_SELF']);
$gid = intval($_COOKIE['gid']);

if(!$paymentRepo->allPaymentsDone($gid)){
    header('location: group.php');
}

if(isset($_POST['deleteGroup']) || isset($_POST['confirmBtn'])){
    $validator = new ValidationUtils();
    $groupName = $validator->validateString($_POST['groupName']);

    if(isset($_POST['confirmBtn'])){
        $message = '';
        $groupRepo = new GroupRepository();
        if($groupRepo->delete($gid,$message)){
            setcookie('gid', "", time()-3600, "/");
            header('location: myGroups.php');
        }else{
            $alertDelete = $message;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Supprimer le groupe <?php echo $groupName?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <header>
            <h1>Supprimer le groupe <?php echo $groupName?></h1>
        </header>
        <p class="center">Tous les virements ont été confirmés, confirmez-vous la suppression du groupe ?</p>
        <section class="choices biggerBtn">
            <form action="<?php echo $actionSelf?>" class="accept-delete" method="post">
                <input type="hidden" name="groupName" value="<?php echo $groupName?>"/>
                <button type="submit" class="accept" name="confirmBtn">Confirmer</button>
            </form>
            <form action="group.php" class="decline-delete" method="post">
                <button type="submit" class="decline" name="cancelBtn">Annuler</button>
            </form>
        </section>
        <?php if(isset($alertDelete)) Alert::error($alertDelete)?>
    </main>
    <?php
    include 'inc/footer.inc.php';
    ?>
</body>
</html>