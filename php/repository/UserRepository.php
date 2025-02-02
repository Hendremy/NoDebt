<?php

namespace NoDebt;

use DB\DBLink;
use Exception;
use PDOException;

require('DBLink.php');
require('php/domain/User.php');
require('php/utils/PasswordUtils.php');

class UserRepository
{
    const TABLE_NAME = 'nodebt_utilisateur';
    const DB_ERROR_MESSAGE = 'Erreur: Veuillez réessayer ultérieurement';

    public function alreadyExists($email,&$message=''){
        $exists = true;
        try {
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare ("SELECT uid FROM ". self::TABLE_NAME
                ." WHERE email = :email");
            $stmt->bindValue(":email", $email);
            if($stmt->execute() && $stmt->rowCount() === 0) {
                $exists = false;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $exists;
    }

    public function insert($email, $lastname, $firstname, $password, &$message=''){
        $insertedId = 0;
        $password = $this->hashPassword($password);
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare("INSERT INTO ".self::TABLE_NAME." (email, lastname, firstname, hashpass)
            VALUES (:email, :lastname, :firstname, :hashpass);");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":lastname", $lastname);
            $stmt->bindValue(":firstname", $firstname);
            $stmt->bindValue(":hashpass", $password);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $insertedId = $bd->lastInsertId();
                $message .= 'Compte créé avec succès';
            }else{
                $message .= 'Erreur lors de la création du compte';
            }
        }catch(PDOException $e){
            $insertedId = -1;
            $message.= self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($bd);
        return $insertedId;
    }

    public function updatePasswordForEmail($email, $password, &$message=''){
        $db = null;
        $updateOk = false;
        $password = $this->hashPassword($password);
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare(
                "UPDATE ". self::TABLE_NAME
                ." SET hashpass = :hashpass WHERE email = :email;");
            $stmt->bindValue(':hashpass', $password);
            $stmt->bindValue(':email', $email);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $updateOk = true;
                $message = 'Mot de passe modifié avec succès';
            }else{
                $message = 'Erreur dans l\'update';
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $updateOk;
    }

    public function updateUserInfo($uid, $email, $lastname, $firstname, &$message=''){
        $db = null;
        $updateOk = false;
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare(
                'UPDATE '. self::TABLE_NAME
                .' SET firstname = :firstname, lastname = :lastname, email = :email WHERE uid = :uid;');
            $stmt->bindValue(':firstname', $firstname);
            $stmt->bindValue(':lastname', $lastname);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':uid', $uid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $updateOk = true;
                $message .= 'Utilisateur modifié avec succès';
            }else{
                $message .= 'Erreur dans la mise à jour d\'information';
            }
        }catch(PDOException $e){
            $message .= self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $updateOk;
    }

    public function getUserInfo($uid, &$message = ''){
        $user = null;
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare ("SELECT uid, email, firstname, lastname FROM ". self::TABLE_NAME
                ." WHERE uid = :uid");
            $stmt->bindValue(':uid', $uid);
            if($stmt->execute()){
                $user = $stmt->fetchObject("NoDebt\User");
            }
        }catch(Exception $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($bd);
        return $user;
    }

    public function getUserId($userEmail, $userPassword, $isActive = false ,&$message = ''){
        $userId = 0;
        $userPassword = $this->hashPassword($userPassword);
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare ("SELECT uid FROM ". self::TABLE_NAME
                ." WHERE email = :email AND hashpass = :hashpass AND isActive = :isActive");
            $stmt->bindValue(':email', $userEmail);
            $stmt->bindValue(':hashpass', $userPassword);
            $stmt->bindValue(':isActive', $isActive);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $userId = $stmt->fetch()[0];
            }
        }catch(Exception $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($bd);
        return $userId;
    }

    public function getActiveUserId($userEmail, $userPassword, &$message=''){
        return $this->getUserId($userEmail, $userPassword,true, $message);
    }

    public function killUser($uid, &$message=''){
        $bd = null;
        $killOk = false;
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare('UPDATE '. self::TABLE_NAME
                .' SET isActive = FALSE'
                .' WHERE uid = :uid;');
            $stmt->bindValue(':uid', $uid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $killOk = true;
            }
        }catch(Exception $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($bd);
        return $killOk;
    }

    public function generateUser($email,$password, &$message = ''){
        return $this->insert($email,'Compte','Mon',$password,$message);
    }

    private function hashPassword($password){
        $passUtils = new PasswordUtils();
        return $passUtils->hashPassword($password);
    }

    public function userIsInactive($email, &$message = ''){
        $db = null;
        $userIsInactive = false;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare('SELECT * FROM '.self::TABLE_NAME
                .' WHERE email = :email AND isActive = false');
            $stmt->bindValue(':email', $email);
            if($stmt->execute()){
                $userIsInactive = $stmt->rowCount() == 1;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $userIsInactive;
    }

    public function reviveAccount($userId, &$message=''){
        $db = null;
        $reviveOk = false;
        try{
            $db = DBLink::connectToDb();
            $stmt = $db->prepare("UPDATE ".self::TABLE_NAME
                ." SET isActive = TRUE"
                ." WHERE uid = :uid");
            $stmt->bindValue(':uid',$userId);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $reviveOk = true;
            }
        }catch(PDOException $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $reviveOk;
    }


}