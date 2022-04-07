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

    public function exists($user){
        $message = '';
        DBLink::connect2db($message);
    }

    public function insert($user){

    }

    public function update($user){

    }

    public function getUser($userEmail, $userPassword, &$message){
        $userPassword = $this->hashPassword($userPassword);
        try{
            $bd = DBLink::connect2db($message);
            $stmt = $bd->query("SELECT uid, email, firstname, lastname FROM nodebt_utilisateur WHERE email = :email AND hashpass = :hashpass;");
            $stmt->bindValue(':email', $userEmail);
            $stmt->bindValue(':hashpass', $userPassword);
            if($stmt->execute() && $stmt->rowCount() == 1){
                return $stmt->fetch(PDO::FETCH_CLASS, "NoDebt\User");
            }else{
                return null;
            }
        }catch(Exception $e){
            $message = "Erreur: " . $e->getMessage();
            return null;
        }
    }

    private function hashPassword($password){
        return hash("sha512",$password);
    }
}