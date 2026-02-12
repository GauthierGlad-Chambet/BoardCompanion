<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use PDOException;

abstract class MotherModel {
    const HOST = "localhost";
    const DB = "board_companion";
    const USER = "root";
    const PASS = "";

    // Connexion à la base de données en singleton en utilisant les informations çi dessus
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
