<?php
include('inc/session.inc.php');
?>
<?php
require_once 'php/utils/ValidationUtils.php';
require_once 'php/repository/GroupRepository.php';
use NoDebt\GroupRepository;
use NoDebt\ValidationUtils;
if(isset($_REQUEST['gid'])){
    $validator = new ValidationUtils();
    $groupRepo = new GroupRepository();
    $gid = intval($_REQUEST['gid']);
    $group = $groupRepo->getGeneralInfo($gid);

    if(isset($_POST['confirmBtn'])) {
        $group->name = $validator->validateString($_POST['name']);
        $group->currency = $validator->validateString($_POST['currency']);

        $fieldsOk = true;
        if (!$validator->nameIsValid($group->name)) {
            $fieldsOk = false;
            $alertName = 'Nom trop long: maximum 50 caractères';
        }

        if (!$validator->currencyIsValid($group->currency)) {
            $fieldsOk = false;
            $alertCurrency = 'Erreur: la devise sélectionnée n\'est pas prise en charge';
        }

        if ($fieldsOk) {
            $message = '';
            if ($groupRepo->update($group, $message)) {
                header("location: group.php?gid=$group->gid");
            } else {
                $alertUpdate = $message;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Editer le groupe <?php echo $group->name ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Editer le groupe <?php echo $group->name?></h1>
        <form class="field-list" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <input type="hidden" name="gid" value="<?php echo $group->gid?>"/>
            <label for="name">Nom du groupe</label>
            <input type="text" name="name" id="name" required value="<?php if(isset($group->name)) echo $group->name?>"/>
            <?php if(isset($alertName)) {$alertMessage = $alertName; include 'inc/alertError.inc.php';}?>
            <label for="currency">Devise</label>
            <select name="currency" id="currency" required>
                <option value="EUR" <?php echo isset($group->currency) ? $group->currency == 'EUR' ? 'selected':'' : 'selected' ?>>Euros - &euro;</option>
                <option value="USD" <?php if(isset($group->currency) && $group->currency =='USD') echo 'selected' ?>>Dollars - &dollar;</option>
                <option value="JPY" <?php if(isset($group->currency) && $group->currency =='JPY') echo 'selected' ?>>Yen - &yen;</option>
                <option value="GBP" <?php if(isset($group->currency) && $group->currency =='GBP') echo 'selected' ?>>Livres Sterling - &pound;</option>
            </select>
            <?php if(isset($alertCurrency)) {$alertMessage = $alertCurrency; include 'inc/alertError.inc.php';}?>
            <button type="submit" class="submit" name="confirmBtn">Enregistrer modifications</button>
            <?php if(isset($alertUpdate)) {$alertMessage = $alertUpdate; include 'inc/alertError.inc.php';}?>
        </form>
    </main>
</body>
</html>