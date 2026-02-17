<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use GauthierGladchambet\BoardCompanion\Entities\User;
use GauthierGladchambet\BoardCompanion\Models\MotherModel;
use PDO;

class UserModel extends MotherModel {


    function addUser(User $user) {

        // Préparation de la requête pour ajouter un utilisateur dans la base de données
        $query = "
            INSERT INTO user (
                pseudo, email, pwd
            ) VALUES (
                :pseudo, :email, :pwd
            )";

        $prepare = $this->_db->prepare($query);

        // Liaison des paramètres
        $prepare->bindValue(':pseudo', $user->getPseudo(), PDO::PARAM_STR);
        $prepare->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $prepare->bindValue(':pwd', $user->getPwd(), PDO::PARAM_STR);

        

        // Exécution de la requête
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de l'insertion du projet : " . implode(", ", $prepare->errorInfo()));
        }
    }

    function findByMail(string $email) {

        // Requête préparée pour récupérer les informations de l'utilisateur
        $query =
            "SELECT id, pseudo, email FROM user
            WHERE email=:email";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":email", $email, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function getPasswordHash(string $email) {

        // Requête préparée pour trouver le hash du mot de passe de l'utilisateur
        $query =
            "SELECT pwd FROM user
            WHERE email=:email";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":email", $email, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function findById(string $id) {

        // Requête préparée pour récupérer les informations de l'utilisateur
        $query =
            "SELECT id, pseudo, email, avg_pages_per_day, avg_cleaning_duration FROM user
            WHERE id=:id";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id", $id, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }
}