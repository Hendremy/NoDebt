<?php
namespace DB;
require 'db_config.php';
use PDO;

/**
 * Classe DBLink : gestionnaire de la connexion à la base de données
 * @author Vincent MARTIN
 * @version 2.0
 */
class DBLink {

    //TODO: Remplacer les constantes des repository du même nom
    const DB_ERROR_MESSAGE ='Erreur: Veuillez réessayer ultérieurement';

    public static function connectToDb(){
        $link = new PDO('mysql:host=' . MYHOST . ';dbname=' . MYDB . ';charset=UTF8', MYUSER, MYPASS);
        $link->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $link->exec("set names utf8");
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $link;
    }

    public static function disconnect (&$link) {
        $link = null;
    }
}
?>