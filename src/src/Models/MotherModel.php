<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use PDOException;

abstract class MotherModel {

    // Connexion à la base de données en singleton en utilisant les informations çi dessus
    protected object $_db;
            private static ?PDO $_dbInstance = null;

            public function __construct(){
                // Récupère ou crée la connexion singleton
                if (self::$_dbInstance === null) {
                    try{
                        self::$_dbInstance = new PDO(
                            "mysql:host=" . $_ENV['DB_HOSTNAME'] . ";dbname=" . $_ENV['DB_DATABASE'] . ";charset=utf8",
                            $_ENV['DB_USERNAME'],
                            $_ENV['DB_PASSWORD'],
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
