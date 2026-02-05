<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Entities\Sequence;

class SequenceModel extends MotherModel {

// Ajout de la séquence en base de données  
    function addSequence(Sequence $sequence) {
        $query = "
                INSERT INTO sequence (
                    script, is_assigned, type, fk_project
                ) VALUES (
                    :script, :is_assigned, :type, :fk_project
                )";

            $prepare = $this->_db->prepare($query);

            // Liaison des paramètres
            $prepare->bindValue(':script', $sequence->getScript(), PDO::PARAM_STR);
            $prepare->bindValue(':is_assigned', $sequence->getIsAssigned(), PDO::PARAM_BOOL);
            $prepare->bindValue(':type', $sequence->getType(), PDO::PARAM_STR);
            $prepare->bindValue(':fk_project', $sequence->getProject(), PDO::PARAM_INT);

            if (!$prepare->execute()) {
                throw new \Exception("Erreur lors de l'insertion de la séquence : " . implode(", ", $prepare->errorInfo()));
            }
    }

    // Récupération de toutes les séquences d'un projet
    function findAllSequencesByProjectId(int $projectId): array {

    $query = "
        SELECT *
        FROM sequence
        WHERE fk_project = :project_id
    ";

    $prepare = $this->_db->prepare($query);
    $prepare->bindValue(':project_id', $projectId, PDO::PARAM_INT);
    $prepare->execute();

    return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupération de toutes les séquences d'un même projet
    function findSequencesByProjectId(int $projectId): array {
        $query = "
            SELECT *
            FROM sequence
            WHERE fk_project = :project_id AND is_assigned = 1
        ";
        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':project_id', $projectId, PDO::PARAM_INT);
        $prepare->execute();

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }
}