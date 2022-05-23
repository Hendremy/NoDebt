<?php
include 'inc/session.inc.php';
?>
<?php
require_once 'php/utils/CurrencyFormatter.php';
require_once 'php/utils/ValidationUtils.php';
require_once 'php/repository/ParticipationRepository.php';
require_once 'php/repository/ExpenseRepository.php';
require_once 'php/domain/Expense.php';
require_once 'php/domain/Tag.php';
require_once ('php/utils/Alert.php');

use NoDebt\Alert;
use NoDebt\CurrencyFormatter;
use NoDebt\Expense;
use NoDebt\ExpenseRepository;
use NoDebt\ParticipationRepository;
use NoDebt\Tag;
use NoDebt\ValidationUtils;

$actionSelf = htmlspecialchars($_SERVER['PHP_SELF']);

if(isset($_POST['editBtn']) || isset($_POST['confirmBtn'])){
    $validator = new ValidationUtils();
    $currFmt = new CurrencyFormatter();
    $participRepo = new ParticipationRepository();

    if(isset($_POST['editBtn'])){
        $expenseRepo = new ExpenseRepository();
        $did = intval($_POST['did']);
        $expense = $expenseRepo->getExpenseById($did);
    }else {
        $expense = new Expense();
        $expense->gid = intval($_POST['gid']);
        $expense->did = intval($_POST['did']);
    }

    $currency = $validator->currencyIsValid($_POST['groupCurr']) ? $validator->validateString($_POST['groupCurr']) : 'EUR';
    $currSymb = $currFmt->getCurrencySymbol($currency);
    $participants = $participRepo->getParticipants($expense->gid);

    if(isset($_POST['confirmBtn'])) {
        //Validation des champs
        $fieldsOk = true;

        $expense->uid = intval($_POST['participant']);
        if (!isset($_POST['participant']) || !in_array($expense->uid, array_keys($participants)) ) {
            $expense->uid = -1;
            $alertParticipant = 'Participant sélectionné invalide';
            $fieldsOk = false;
        }

        if($validator->expenseAmountIsValid($_POST['amount'])){
            $expense->montant = floatval($_POST['amount']);
        }else{
            $fieldsOk = false;
            $expense->montant = $_POST['amount'];
            $alertAmount = 'Montant invalide: doit être positif';
        }

        if ($validator->dateIsValid($_POST['date'])) {
            $expense->paydate = $validator->validateDate($_POST['date']);
        } else {
            $expense->paydate = $_POST['date'];
            $alertDate = 'Date encodée invalide - Rappel: Format (jj-mm-aaaa)';
            $fieldsOk = false;
        }

        if ($validator->nameIsValid($_POST['label'])) {
            $expense->libelle = $validator->validateString($_POST['label']);
        } else {
            $expense->libelle = $_POST['label'];
            $alertLabel = 'Nom trop long: maximum 50 caractères';
            $fieldsOk = false;
        }

        if($validator->tagsAreValid($_POST['tags'])){
            $expense->tagsTab = $validator->extractTags($_POST['tags']);
            foreach ($expense->tagsTab as $index =>$tagLibelle){
                $expense->tagsTab[$index] = new Tag($tagLibelle, $expense->gid);
                $expense->tagsTab[$index]->did = $expense->did;
            }
            $expense->tagsString = $validator->validateString($_POST['tags']);
        }else{
            $expense->tagsString = $_POST['tags'];
            $alertTags = 'Tags invalide: maximum 50 caractères par tag';
            $fieldsOk = false;
        }

        if($fieldsOk){
            $message = '';
            $expRepo = new ExpenseRepository();
            if($expRepo->update($expense, $message)){
                //header('location: group.php');
                $successUpdate = 'Modification enregistrées !';
            }else{
                $alertUpdate = $message;
            }
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
    <title>No Debt - Editer la dépense <?php echo $expense->libelle ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <?php include('inc/groupGoback.inc.php')?>
        <h1>Editer la dépense <?php echo $expense->libelle ?></h1>
        <form class="field-list" action="<?php echo $actionSelf?>" method="post">
            <label for="participant">Participant *</label>
            <select name="participant" id="participant" required>
                <?php
                foreach($participants as $id => $name){
                    $selected = $id == $expense->uid ? 'selected' : '';
                    echo "<option value='$id' $selected>$name</option>";
                }
                ?>
            </select>
            <?php if(isset($alertParticipant)) Alert::error($alertParticipant)?>

            <label for="expenseDate">Date (jj-mm-aaaa) *</label>
            <input type="date" name="date" id="expenseDate" required value="<?php if(isset($expense->paydate)) echo $expense->paydate?>"/>
            <?php if(isset($alertDate)) Alert::error($alertDate)?>


            <label for="amount">Montant (<?php echo $currSymb?>) *</label>
            <input type="number" name="amount" id="amount" required value="<?php if(isset($expense->montant)) echo $expense->montant?>"/>
            <?php if(isset($alertAmount)) Alert::error($alertAmount)?>

            <label for="label">Libellé (max 50 caractères) *</label>
            <input type="text" name="label" id="label" required value="<?php if(isset($expense->libelle)) echo $expense->libelle?>"/>
            <?php if(isset($alertLabel)) Alert::error($alertLabel)?>

            <label for="tags">Tags (séparés par une virgule ",")</label>
            <input type="text" id="tags" name="tags" value="<?php if(isset($expense->tagsString)) echo $expense->tagsString?>"/>
            <?php if(isset($alertTags)) Alert::error($alertTags)?>

            <input type="hidden" name="gid" value="<?php echo $expense->gid ?>" readonly>
            <input type="hidden" name="did" value="<?php echo $expense->did ?>" readonly>
            <input type="hidden" name="groupCurr" value="<?php echo $currency?>" readonly>

            <button type="submit" class="submit" name="confirmBtn">Enregistrer modifications</button>
            <?php if(isset($alertUpdate)) Alert::error($alertUpdate);?>
            <?php if(isset($successUpdate)) Alert::success($successUpdate);?>
        </form>
    </main>
    <?php
    include 'inc/footer.inc.php';
    ?>
</body>
</html>