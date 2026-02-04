<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Entities\User;

class UserModel extends MotherModel {


    function addUser(User $user) {
        // Connexion à la base de données
        $pdo = $this->connect();

        // Préparation de la requête pour ajouter un utilisateur dans la base de données
        $query = "
            INSERT INTO user (
                pseudo, email, pwd
            ) VALUES (
                :pseudo, :email, :pwd
            )";

        $prepare = $pdo->prepare($query);

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

        $pdo = $this->connect();

        // Requête préparée pour récupérer les informations de l'utilisateur
        $query =
            "SELECT id, pseudo, email FROM user
            WHERE email=:email";

        $prepare = $pdo->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":email", $email, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function getPasswordHash(string $email) {

        $pdo = $this->connect();

        // Requête préparée pour trouver le hash du mot de passe de l'utilisateur
        $query =
            "SELECT pwd FROM user
            WHERE email=:email";

        $prepare = $pdo->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":email", $email, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }
}