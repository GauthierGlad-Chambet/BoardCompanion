<?php

namespace App\Models;

use PDO;
use PDOException;

//A ANALYSER POUR COMPRENDRE
abstract class MainModel
{
    const HOST = "localhost";
    const DB = "board_companion";
    const USER = "root";
    const PASS = "";

    // Connexion à la base de données en utilisant les informations çi dessus
    function connect()
    {
        try {
            return new PDO(
                "mysql:host=" . MainModel::HOST . ";dbname=" . MainModel::DB . ";charset=utf8",
                MainModel::USER,
                MainModel::PASS,
                array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC)
            );
        } catch (PDOException $ex) {
            return $ex->getMessage(); // Retourne un message d'erreur en cas de problème
        }
    }
}
