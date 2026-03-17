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
        $query ="
            SELECT pwd FROM user
            WHERE email=:email
            ";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":email", $email, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function findById(string $id) {

        // Requête préparée pour récupérer les informations de l'utilisateur
        $query ="
            SELECT user.id, pseudo, email, avg_pages_per_day, avg_cleaning_duration, avg_shots_per_page, user.fk_appreciation, appreciation.label as appreciation_label
            FROM user
            LEFT JOIN appreciation ON user.fk_appreciation = appreciation.id
            WHERE user.id=:id
            ";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id", $id, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }


    function deleteUserById(int $userId) {
        $queries = [
            "DELETE FROM sequence WHERE fk_project IN (SELECT id FROM project WHERE fk_user = :user_id)",
            "DELETE FROM final_report WHERE fk_project IN (SELECT id FROM project WHERE fk_user = :user_id)",
            "DELETE FROM project WHERE fk_user = :user_id",
            "DELETE FROM user_type_statistics WHERE fk_user = :user_id",
            "DELETE FROM user WHERE id = :user_id",
        ];

        foreach ($queries as $query) {
            $prepare = $this->_db->prepare($query);
            $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);

            if (!$prepare->execute()) {
                throw new \Exception("Erreur lors de la suppression de l'utilisateur : " . implode(", ", $prepare->errorInfo()));
            }
        }
    }

    function updateAvgPagesPerDay(int $userId, float $avgPagesPerDay) {

        $query = "
            UPDATE user
            SET avg_pages_per_day = :avg_pages_per_day
            WHERE id = :user_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':avg_pages_per_day', $avgPagesPerDay, PDO::PARAM_STR);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour de avg_pages_per_day : " . implode(", ", $prepare->errorInfo()));
        }
    }

   function updateAvgCleaningDuration(int $userId, float $avgCleaningDuration) {
        $query = "
            UPDATE user
            SET avg_cleaning_duration = :avg_cleaning_duration
            WHERE id = :user_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':avg_cleaning_duration', $avgCleaningDuration, PDO::PARAM_STR);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour de avg_cleaning_duration : " . implode(", ", $prepare->errorInfo()));
        }
    }

    function updateAvgAppreciation(int $userId, int $avgAppreciation) {
        $query = "
            UPDATE user
            SET fk_appreciation = :fk_appreciation
            WHERE id = :user_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':fk_appreciation', $avgAppreciation, PDO::PARAM_INT);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour de fk_appreciation : " . implode(", ", $prepare->errorInfo()));
        }
    }

    function updateAvgShotsPerPage(int $userId, int $avgShotsPerPage) {
        $query = "
            UPDATE user
            SET avg_shots_per_page = :avg_shots_per_page
            WHERE id = :user_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':avg_shots_per_page', $avgShotsPerPage, PDO::PARAM_STR);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour de avg_shots_per_page : " . implode(", ", $prepare->errorInfo()));
        }
    }

}