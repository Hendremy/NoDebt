<?php
session_start();
if (isset($_SESSION['userId'])){
    $ses_uid = $_SESSION['userId'];
    $ses_firstName = $_SESSION['firstName'];
    $ses_lastName = $_SESSION['lastName'];
    $ses_email = $_SESSION['email'];
    $ses_groups = $_SESSION['groups'];
    $ses_invites = $_SESSION['invite'];
    //cookies pour récupérer la page de groupe sur laquelle était l'user à la session précédente
} else {
    $path = $_SERVER['PHP_SELF'];
    $file = basename ($path);
    if ($file !== 'index.php' && $file !== 'contact.php' && $file !== 'signup.php'
    && $file !== 'fogottenPassword.php') header('location: index.php');
}
?>