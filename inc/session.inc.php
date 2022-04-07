<?php
session_start();
if (isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $firstName = $_SESSION['firstName'];
    $lastName = $_SESSION['lastName'];
    $email = $_SESSION['email'];
} else {
    $path = $_SERVER['PHP_SELF'];
    $file = basename ($path);
    if ($file !== 'index.php' && $file !== 'contact.php' && $file !== 'signin.php'
    && $file !== 'fogottenPassword.php') header('location: index.php');
}
?>