<?php

namespace NoDebt;

use DB\DBLink;
use Exception;
use PDO;
use PDOException;

require ('DBLink.php');
require ('User.php');
require('PasswordUtils.php');

class UserRepository
{
    const TABLE_NAME = 'nodebt_utilisateur';
    const DB_ERROR_MESSAGE = 'Erreur: Veuillez réessayer ultérieurement';

    public function alreadyExists($email){
        $message = '';
        $exists = true;
        try {
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare ("SELECT uid FROM ". self::TABLE_NAME
                ." WHERE email = :email");
            $stmt->bindValue(":email", $email);
            if($stmt->execute() && $stmt->rowCount() === 0) {
                $exists = false;
            }
        }catch(Exception $e){
            $message = 'Erreur';
        }
        DBLink::disconnect($db);
        return $exists;
    }

    public function insert($email, $lastname, $firstname, $password, &$message){
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

    public function updatePasswordForEmail($email, $password, &$message){
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
                $message .= 'Mot de passe modifié avec succès';
            }else{
                $message .= 'Erreur dans l\'update';
            }
        }catch(PDOException $e){
            $message .= self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($db);
        return $updateOk;
    }

    public function updateUserInfo($uid, $email, $lastname, $firstname, &$message){
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

    public function getUserID($userEmail, $userPassword, &$message = ''){
        $userId = 0;
        $userPassword = $this->hashPassword($userPassword);
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare ("SELECT uid FROM ". self::TABLE_NAME
                ." WHERE email = :email AND hashpass = :hashpass");
            $stmt->bindValue(':email', $userEmail);
            $stmt->bindValue(':hashpass', $userPassword);
            if($stmt->execute()){
                $userId = $stmt->fetch();
            }
        }catch(Exception $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($bd);
        return $userId;
    }

    public function deleteUser($uid, &$message){
        $bd = null;
        $deleteOk = false;
        try{
            $bd = DBLink::connectToDb();
            $stmt = $bd->prepare('DELETE FROM '. self::TABLE_NAME .
                ' WHERE uid = :uid;' );
            $stmt->bindValue(':uid', $uid);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $deleteOk = true;
            }
        }catch(Exception $e){
            $message = self::DB_ERROR_MESSAGE;
        }
        DBLink::disconnect($bd);
        return $deleteOk;
    }

    private function hashPassword($password){
        $passUtils = new PasswordUtils();
        return $passUtils->hashPassword($password);
    }


}