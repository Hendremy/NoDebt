<?php
include('inc\session.inc.php');
?>
<?php
require('php/ParticipationRepository.php');
require('php/UserRepository.php');

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
                    <button type="submit" class="accept" name="confirmDeleteAccount" id="confirmDeleteAccount">Oui, supprimer le compte</button>
                </form>
            </li>
            <?php if(isset($alert)) echo $alert?>
            <li>
                <form method="post" action="editProfile.php">
                    <button type="submit" class="decline" name="confirmDeleteAccount" id="cancelDeleteAccount">Non</button>
                </form>
            </li>
        </ul>
        </section>
    </main>
</body>
</html>