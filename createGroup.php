<?php
include('inc/session.inc.php');
?>
<?php
require 'php/ValidationUtils.php';
require 'php/GroupRepository.php';
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
        $groupRepo = new \NoDebt\GroupRepository();
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
            <input type="text" name="name" id="name" required/>
            <?php if(isset($alertName)) echo "<span class='alert'>$alertName</span>"?>
            <label for="currency">Devise</label>
            <select name="currency" id="currency" required>
                <option value="EUR" selected>Euros - &euro;</option>
                <option value="USD">Dollars - &dollar;</option>
                <option value="JPY">Yen - &yen;</option>
                <option value="GBP">Livres Sterling - &pound;</option>
            </select>
            <?php if(isset($alertCurrency)) echo "<span class='alert'>$alertCurrency</span>"?>
            <button type="submit" class="submit" name="createBtn">Créer groupe</button>
        </form>
    </main>
</body>
</html>