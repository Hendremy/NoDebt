<?php
include('inc\session.inc.php');
?>
<?php
require_once('php/repository/ParticipationRepository.php');
require_once('php/repository/UserRepository.php');
require_once ('php/utils/Alert.php');

use NoDebt\Alert;
use NoDebt\ParticipationRepository;
use NoDebt\UserRepository;
if(isset($ses_uid)){
    $participRepo = new ParticipationRepository();
    $message = '';
    if($participRepo->userHasActiveParticipations($ses_uid, $message)){
        header('location: myGroups.php');
    }
}
if(isset($_POST['confirmDeleteAccount'])){
    $userRepo = new UserRepository();
    if(isset($ses_uid)) {
        $message ='';
        $deleteOk = $userRepo->deleteUser($ses_uid, $message);
        if($deleteOk){
            header('location: disconnect.php');
        }else{
            $alert = 'Erreur: Veuillez réessayer ultérieurement';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Supprimer le profil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Supprimer le profil</h1>
        <p>Confirmez-vous la suppression de votre compte ?</p>
        <section class="deleteChoices">
        <ul class="choices">
            <li>
                <form method ="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <button type="submit" class="accept" name="confirmDelete" id="confirmDeleteAccount">Confirmer</button>
                </form>
            </li>
            <?php if(isset($alert)) Alert::error($alert)?>
            <li>
                <form method="post" action="editProfile.php">
                    <button type="submit" class="decline" name="cancelDelete" id="cancelDeleteAccount">Annuler</button>
                </form>
            </li>
        </ul>
        </section>
    </main>
    <?php
    include 'inc/footer.inc.php';
    ?>
</body>
</html>