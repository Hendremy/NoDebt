<?php

namespace NoDebt;

use DB\DBLink;
use Exception;
use PDO;
require ('DBLink.php');
require ('User.php');

class UserRepository
{
    const TABLE_NAME = 'nodebt_utilisateur';

    public function alreadyExists($email){
        $message = '';
        $exists = true;
        try {
            $bd = DBLink::connectToDb($message);
            $stmt = $bd->prepare ("SELECT uid FROM ". self::TABLE_NAME
                ." WHERE email = :email");
            $stmt->bindValue(":email", $email);
            if($stmt->execute() && $stmt->rowCount() === 0) {
                $exists = false;
            }
        }catch(Exception $e){
            $message = 'Erreur';
        }finally{
            DBLink::disconnect($db);
            return $exists;
        }
    }

    public function insert($email, $lastname, $firstname, $password, &$message){
        $insertOk = false;
        $password = $this->hashPassword($password);
        try{
            $bd = DBLink::connectToDb($message);
            $stmt = $bd->prepare("INSERT INTO ".self::TABLE_NAME."(email, lastname, firstname, hashpass)
            VALUES (:email, :lastname, :firstname, :hashpass);");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":lastname", $lastname);
            $stmt->bindValue(":firstname", $firstname);
            $stmt->bindValue(":password", $password);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $insertOk = true;
                $message .= 'Compte créé avec succès';
            }else{
                $message .= 'Erreur lors de la création du compte';
            }
        }catch(Exception $e){
            $message.= 'Error in DB :' . $e->getMessage();
        }finally{
            DBLink::disconnect($bd);
            return $insertOk;
        }
    }

    public function update($user){

    }

    public function getUser($userEmail, $userPassword, &$message){
        $user = null;
        $userPassword = $this->hashPassword($userPassword);
        try{
            $bd = DBLink::connectToDb($message);
            $stmt = $bd->prepare ("SELECT uid, email, firstname, lastname FROM ". self::TABLE_NAME
                ." WHERE email = :email AND hashpass = :hashpass");
            $stmt->bindValue(':email', $userEmail);
            $stmt->bindValue(':hashpass', $userPassword);
            if($stmt->execute()){
                $user = $stmt->fetchObject("NoDebt\User");
            }
        }catch(Exception $e){
            $message = "Erreur: " . $e->getMessage();
        }finally{
            DBLink::disconnect($bd);
            return $user;
        }
    }

    private function hashPassword($password){
        return hash("sha512",$password);
    }
}