<?php
include 'inc/session.inc.php';

if(isset($_SESSION['userId'])){
    header('location: myGroups.php');
}
?>
<?php
require_once('php/repository/UserRepository.php');
require_once('php/repository/ParticipationRepository.php');
require_once('php/utils/Alert.php');
require_once 'php/utils/ValidationUtils.php';

use NoDebt\Alert;
use NoDebt\UserRepository;
use NoDebt\ValidationUtils;

if(isset($_GET['userEmail']) || isset($_POST['reviveAct'])){
    $validator = new ValidationUtils();
    $userEmail = $validator->validateString($_REQUEST['userEmail']);
    if(isset($_POST['reviveAct'])){
        $userPassword = $validator->validateString($_POST['userPassword']);

        $userRepo = new UserRepository();
        $message = '';

        $userId = $userRepo->getUserId($userEmail, $userPassword, $message);
        echo $userId;
        if(isset($userId) && $userId > 0) {
            if ($userRepo->reviveAccount($userId)) {
                session_start();
                $_SESSION['userId'] = $userId;
                if (isset($_COOKIE['gid'])) {
                    $gid = $_COOKIE['gid'];
                    header("location: group.php?gid=$gid");
                } else {
                    header("location: myGroups.php");
                }
            }
        }else {
            $message = 'Réactivation échouée - Email ou mot de passe incorrect';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>No Debt - Réactiver du compte</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" sizes="16x16" href="images/icon.png">
    <meta name="description" content="No Debt - Gérez facilement vos dépenses de groupe">
</head>
<body>
    <?php
    include("inc/header.inc.php");
    ?>
    <main>
        <h1>Réactivation du compte</h1>
        <form class="field-list" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
            <label for="userEmail">Adresse e-mail *</label>
            <input type="email" name="userEmail" id="userEmail" required value="<?php if(isset($userEmail)) echo $userEmail?>"/>
            <label for="userPassword">Mot de passe *</label>
            <input type="password" name="userPassword" id="userPassword" required value="<?php if(isset($userPassword)) echo $userPassword?>"/>
            <button type="submit" name="reviveAct">Réactiver le compte</button>
            <?php if(isset($message)) Alert::error($message) ?>
        </form>
    </main>
</body>
</html>