<?php
session_start();
if (isset($_SESSION['userId'])){
    $ses_uid = htmlspecialchars($_SESSION['userId']);
    $ses_firstName = htmlspecialchars($_SESSION['firstName']);
    $ses_lastName = htmlspecialchars($_SESSION['lastName']);
    $ses_email = htmlspecialchars($_SESSION['email']);
    //cookies pour récupérer la page de groupe sur laquelle était l'user à la session précédente
} else {
    $path = $_SERVER['PHP_SELF'];
    $file = basename ($path);
    if ($file !== 'index.php' && $file !== 'contact.php' && $file !== 'signup.php'
    && $file !== 'fogottenPassword.php') header('location: index.php');
}
?>