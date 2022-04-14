<?php
include 'inc/session.inc.php';
?>
<?php
require_once 'php/CurrencyFormatter.php';
require_once 'php/ParticipationRepository.php';
require_once 'php/ExpenseRepository.php';
require_once 'php/ValidationUtils.php';
use NoDebt\CurrencyFormatter;
use NoDebt\ExpenseRepository;
use NoDebt\ParticipationRepository;
use NoDebt\ValidationUtils;

$actionSelf = htmlspecialchars($_SERVER['PHP_SELF']);

if(isset($_POST['addExpenseBtn']) || isset($_POST['confirmAddBtn'])){
    $validator = new ValidationUtils();
    $currFmt = new CurrencyFormatter();
    $participRepo = new ParticipationRepository();

    $gid = intval($_POST['gid']);
    $groupName = $validator->validateString($_POST['groupName']);
    $currency = $validator->currencyIsValid($_POST['groupCurr']) ? $validator->validateString($_POST['groupCurr']) : 'EUR';
    $currSymb = $currFmt->getCurrencySymbol($currency);
    $participants = $participRepo->getParticipants($gid);

    //Par défaut, utilisateur sélectionné & date = aujourd'hui
    if(isset($ses_uid) && !isset($_POST['participant'])) $selectedUid = $ses_uid;
    if(!isset($_POST['date'])) $date = date('Y-m-d',time());

    if(isset($_POST['confirmAddBtn'])) {
        //Validation des champs
        $fieldsOk = true;

        $selectedUid = intval($_POST['participant']);
        if (!isset($_POST['participant']) || !in_array($selectedUid, array_keys($participants)) ) {
            $selectedUid = -1;
            $alertParticipant = 'Participant sélectionné invalide';
            $fieldsOk = false;

        }

        if($validator->expenseAmountIsValid($_POST['amount'])){
            $amount = intval($_POST['amount']);
        }else{
            $fieldsOk = false;
            $amount = $_POST['amount'];
            $alertAmount = 'Montant invalide: doit être positif';
        }

        if ($validator->dateIsValid($_POST['date'])) {
            $date = $validator->validateDate($_POST['date']);
        } else {
            $date = $_POST['date'];
            $alertDate = 'Date encodée invalide - Rappel: Format (jj-mm-aaaa)';
            $fieldsOk = false;
        }

        if ($validator->nameIsValid($_POST['label'])) {
            $label = $validator->validateString($_POST['label']);
        } else {
            $label = $_POST['label'];
            $alertLabel = 'Nom trop long: maximum 50 caractères';
            $fieldsOk = false;
        }

        if($validator->tagsAreValid($_POST['tags'])){
            $tagsTab = $validator->extractTags($_POST['tags']);
            $tags = $validator->validateString($_POST['tags']);
        }else{
            $tags = $_POST['tags'];
            $alertTags = 'Tags invalide: maximum 50 caractères par tag';
            $fieldsOk = false;
        }

        if($fieldsOk){
            $expRepo = new ExpenseRepository();
        }
    }
}else{
    header('location: myGroups.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Ajouter une dépense au groupe <?php echo $groupName ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Ajouter une dépense au groupe <?php echo $groupName ?></h1>
        <form class="field-list" action="<?php echo $actionSelf?>" method="post">
            <label for="participant">Participant *</label>
            <select name="participant" id="participant" required>
                <?php
                foreach($participants as $id => $name){
                    $selected = $id == $selectedUid ? 'selected' : '';
                    echo "<option value='$id' $selected>$name</option>";
                }
                ?>
            </select>
            <label for="expenseDate">Date (jj-mm-aaaa) *</label>
            <input type="date" name="date" id="expenseDate" required value="<?php if(isset($date)) echo $date?>"/>
            <?php if(isset($alertDate)) echo "<span class='alert'>$alertDate</span>"?>
            <label for="amount">Montant (<?php echo $currSymb?>) *</label>
            <input type="number" name="amount" id="amount" required value="<?php if(isset($amount)) echo $amount?>"/>
            <?php if(isset($alertAmount)) echo "<span class='alert'>$alertAmount</span>"?>
            <label for="label">Libellé (max 50 caractères) *</label>
            <input type="text" name="label" id="label" required value="<?php if(isset($label)) echo $label?>"/>
            <?php if(isset($alertLabel)) echo "<span class='alert'>$alertLabel</span>"?>
            <label for="tags">Tags (séparés par une virgule ",")</label>
            <input type="text" id="tags" name="tags" value="<?php if(isset($tags)) echo $tags?>"/>
            <?php if(isset($alertTags)) echo "<span class='alert'>$alertTags</span>"?>
            <input type="hidden" name="gid" value="<?php echo $gid ?>">
            <input type="hidden" name="groupName" value="<?php echo $groupName?>">
            <input type="hidden" name="groupCurr" value="<?php echo $currency?>">
            <button type="submit" class="submit" name="confirmAddBtn">Ajouter la dépense</button>
        </form>
    </main>
</body>
</html>