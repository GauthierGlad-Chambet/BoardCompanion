<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Models\MotherModel;

class UserStatByTypeModel extends MotherModel {

    function addUserStatByType(int $userId, string $typeId, float $avgPagesPerDay) {

        $query = "
            INSERT INTO user_type_statistics (
                fk_user, fk_type, avg_pages_per_day
            ) VALUES (
                :user_id, :type_id, :avg_pages_per_day
            )
            ON DUPLICATE KEY UPDATE
                avg_pages_per_day = VALUES(avg_pages_per_day)
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $prepare->bindValue(':type_id', $typeId, PDO::PARAM_STR);
        $prepare->bindValue(':avg_pages_per_day', $avgPagesPerDay, PDO::PARAM_STR);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de l'insertion ou de la mise à jour des statistiques de l'utilisateur : " . implode(", ", $prepare->errorInfo()));
        }
    }

    function findByUserIdAndType(int $userId, string $typeId): array {
        $query = "
            SELECT avg_pages_per_day
            FROM user_type_statistics
            WHERE fk_user = :user_id AND fk_type = :type_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $prepare->bindValue(':type_id', $typeId, PDO::PARAM_STR);
        $prepare->execute();

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
      
    }
}