<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Entities\Sequence;
use GauthierGladchambet\BoardCompanion\Models\MotherModel;

class SequenceModel extends MotherModel {

// Ajout de la séquence en base de données  
    function addSequence(Sequence $sequence) {
        $query = "
                INSERT INTO sequence (
                    title, script, lines_count, is_assigned, type, fk_project
                ) VALUES (
                    :script, :lines_count, :is_assigned, :type, :fk_project
                )";

            $prepare = $this->_db->prepare($query);

            // Liaison des paramètres
            $prepare->bindValue(':title', $sequence->getTitle(), PDO::PARAM_STR);
            $prepare->bindValue(':script', $sequence->getScript(), PDO::PARAM_STR);
            $prepare->bindValue(':lines_count', $sequence->getLines_count(), PDO::PARAM_INT);
            $prepare->bindValue(':is_assigned', $sequence->getIs_assigned(), PDO::PARAM_BOOL);
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

    // Estimation de la durée d'une séquence en fonction de son type
    // function estimateDurationByType(string $type): float {
    //     // Exemple d'estimation basée sur le type de séquence
    //     switch ($type) {
    //         case 'Action':
    //             return ; //Temps moyen *  
    //         case 'Comédie':
    //             return 1.0; // 1 heure pour une séquence de dialogue
    //         case 'Mixte':
    //             return 0.5; // 30 minutes pour une séquence mixte
    //         default:
    //             return 1.5; // Durée par défaut pour le type mixte
    //     }
    // }
}