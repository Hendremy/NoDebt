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
use NoDebt\CurrencyFormatter;
use NoDebt\Expense;
use NoDebt\ExpenseRepository;
use NoDebt\ParticipationRepository;
use NoDebt\Tag;
use NoDebt\ValidationUtils;

$actionSelf = htmlspecialchars($_SERVER['PHP_SELF']);

if(isset($_POST['addExpenseBtn']) || isset($_POST['confirmBtn']) || isset($_POST['editBtn'])){
    $validator = new ValidationUtils();
    $currFmt = new CurrencyFormatter();
    $participRepo = new ParticipationRepository();

    if(isset($_POST['editBtn'])){
        $expenseRepo = new ExpenseRepository();
        $did = intval($_POST['did']);
        $expense = $expenseRepo->getExpenseById($did);
        $currency = $validator->currencyIsValid($_POST['groupCurr']) ? $validator->validateString($_POST['groupCurr']) : 'EUR';
        $currSymb = $currFmt->getCurrencySymbol($currency);
        $participants = $participRepo->getParticipants($expense->gid);
        $isEdit = true;
    }else if(isset($_POST['gid'])) {
        $gid = intval($_POST['gid']);
        $groupName = $validator->validateString($_POST['groupName']);
        $currency = $validator->currencyIsValid($_POST['groupCurr']) ? $validator->validateString($_POST['groupCurr']) : 'EUR';
        $currSymb = $currFmt->getCurrencySymbol($currency);
        $participants = $participRepo->getParticipants($gid);

        $expense = new Expense();
        $expense->gid = $gid;

        //Par défaut, utilisateur sélectionné & date = aujourd'hui
        if (isset($ses_uid) && !isset($_POST['participant'])) $expense->uid = $ses_uid;
        if (!isset($_POST['date'])) $expense->paydate = date('Y-m-d', time());
    }

    if(isset($_POST['confirmBtn'])) {
        //Validation des champs
        $fieldsOk = true;
        if(isset($_POST['isEdit'])) $isEdit = true;

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
            $tagsTab = $validator->extractTags($_POST['tags']);
            foreach ($tagsTab as $tagLibelle){
                $expense->tagsTab[] = new Tag($tagLibelle, $expense->gid);
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
            if($isEdit){
                if($expRepo->update($expense, $message)){
                    header('location: group.php');
                }else{
                    $alertInsert = $message;
                }
            }else {
                if ($expRepo->insert($expense, $message)) {
                    header('location: group.php');
                } else {
                    $alertInsert = $message;
                }
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
    <?php if(isset($isEdit) && $isEdit):?>
    <title>No Debt - Editer la dépense <?php echo $expense->libelle ?></title>
    <?php else:?>
    <title>No Debt - Ajouter une dépense au groupe <?php echo $groupName ?></title>
    <?php endif?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <?php if(isset($isEdit) && $isEdit):?>
            <h1>Editer la dépense <?php echo $expense->libelle ?></h1>
        <?php else:?>
            <h1>Ajouter une dépense au groupe <?php echo $groupName ?></h1>
        <?php endif?>
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
            <label for="expenseDate">Date (jj-mm-aaaa) *</label>
            <input type="date" name="date" id="expenseDate" required value="<?php if(isset($expense->paydate)) echo $expense->paydate?>"/>
            <?php if(isset($alertDate)) echo "<span class='alert'>$alertDate</span>"?>
            <label for="amount">Montant (<?php echo $currSymb?>) *</label>
            <input type="number" name="amount" id="amount" required value="<?php if(isset($expense->montant)) echo $expense->montant?>"/>
            <?php if(isset($alertAmount)) echo "<span class='alert'>$alertAmount</span>"?>
            <label for="label">Libellé (max 50 caractères) *</label>
            <input type="text" name="label" id="label" required value="<?php if(isset($expense->libelle)) echo $expense->libelle?>"/>
            <?php if(isset($alertLabel)) echo "<span class='alert'>$alertLabel</span>"?>
            <label for="tags">Tags (séparés par une virgule ",")</label>
            <input type="text" id="tags" name="tags" value="<?php if(isset($expense->tagsString)) echo $expense->tagsString?>"/>
            <?php if(isset($alertTags)) echo "<span class='alert'>$alertTags</span>"?>
            <input type="hidden" name="gid" value="<?php echo $expense->gid ?>" readonly>
            <?php if(!isset($isEdit) || !$isEdit) :?>
            <input type="hidden" name="groupName" value="<?php echo $groupName?>" readonly>
            <?php endif ?>
            <input type="hidden" name="groupCurr" value="<?php echo $currency?>" readonly>
            <?php if(isset($isEdit) && $isEdit):?>
            <input type="hidden" name="isEdit" value="true" readonly>
            <?php endif?>
            <button type="submit" class="submit" name="confirmBtn"><?php echo isset($isEdit) && $isEdit ? "Confirmer modifications" : "Ajouter la dépense"?></button>
            <?php if(isset($alertInsert)) echo "<span class='alert'>$alertInsert</span>"?>
        </form>
    </main>
</body>
</html>