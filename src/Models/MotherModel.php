<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use PDOException;

//A ANALYSER POUR COMPRENDRE
abstract class MotherModel {
    const HOST = "localhost";
    const DB = "board_companion";
    const USER = "root";
    const PASS = "";

    // Connexion à la base de données en utilisant les informations çi dessus
//     function connect()
//     {
//         try {
//             return new PDO(
//                 "mysql:host=" . MotherModel::HOST . ";dbname=" . MotherModel::DB . ";charset=utf8",
//                 MotherModel::USER,
//                 MotherModel::PASS,
//                 array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC)
//             );
//         } catch (PDOException $ex) {
//             return $ex->getMessage(); // Retourne un message d'erreur en cas de problème
//         }
//     }
// }
    protected object $_db;
            private static ?PDO $_dbInstance = null;

            public function __construct(){
                // Récupère ou crée la connexion singleton
                if (self::$_dbInstance === null) {
                    try{
                        self::$_dbInstance = new PDO(
                            "mysql:host=" . MotherModel::HOST . ";dbname=" . MotherModel::DB . ";charset=utf8",
                            MotherModel::USER,
                            MotherModel::PASS,
                            array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC)
                        );
                        self::$_dbInstance->exec("SET CHARACTER SET utf8");
                        self::$_dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch(PDOException $e) {
                        echo "Échec : " . $e->getMessage();
                    }
                }
                // Assigne la connexion singleton
                $this->_db = self::$_dbInstance;
            }
        }
