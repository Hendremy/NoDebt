<?php
include('inc/session.inc.php');
?>
<?php
require_once 'php/ValidationUtils.php';
require_once 'php/GroupRepository.php';
use NoDebt\GroupRepository;
use NoDebt\ValidationUtils;
if(isset($_POST['createBtn'])){
    $validator = new ValidationUtils();
    $groupName = $validator->validateString($_POST['name']);
    $currency = $validator->validateString($_POST['currency']);

    $fieldsOk = true;
    if(!$validator->nameIsValid($groupName)){
        $fieldsOk = false;
        $alertName = 'Nom trop long: maximum 50 caractères';
    }

    if(!$validator->currencyIsValid($currency)){
        $fieldsOk = false;
        $alertCurrency = 'Erreur: la devise sélectionnée n\'est pas prise en charge';
    }

    if($fieldsOk && isset($ses_uid)){
        $groupRepo = new GroupRepository();
        $message = '';
        if($gid = $groupRepo->insert($groupName, $currency, $ses_uid,$message)){
            $_SESSION['groups'] [] = $gid;
            header("location: group.php/?gid=$gid");
        }else{
            $alertInsert = $message;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Créer un groupe</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Créer un groupe</h1>
        <form class="field-list" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <label for="name">Nom du groupe</label>
            <input type="text" name="name" id="name" required value="<?php if(isset($groupName)) echo $groupName?>"/>
            <?php if(isset($alertName)) echo "<span class='alert'>$alertName</span>"?>
            <label for="currency">Devise</label>
            <select name="currency" id="currency" required>
                <option value="EUR" <?php echo isset($currency) ? $currency == 'EUR' ? 'selected':'' : 'selected' ?>>Euros - &euro;</option>
                <option value="USD" <?php if(isset($currency) && $currency =='USD') echo 'selected' ?>>Dollars - &dollar;</option>
                <option value="JPY" <?php if(isset($currency) && $currency =='JPY') echo 'selected' ?>>Yen - &yen;</option>
                <option value="GBP" <?php if(isset($currency) && $currency =='GBP') echo 'selected' ?>>Livres Sterling - &pound;</option>
            </select>
            <?php if(isset($alertCurrency)) echo "<span class='alert'>$alertCurrency</span>"?>
            <button type="submit" class="submit" name="createBtn">Créer groupe</button>
            <?php if(isset($alertInsert)) echo "<span class='alert'>$alertInsert</span>"?>
        </form>
    </main>
</body>
</html>