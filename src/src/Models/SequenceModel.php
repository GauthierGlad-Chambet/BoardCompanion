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
                    title, number, script, lines_count, is_assigned, duration_estimated, fk_type, fk_project
                ) VALUES (
                    :title, :number, :script, :lines_count, :is_assigned, :duration_estimated, :fk_type, :fk_project
                )";

            $prepare = $this->_db->prepare($query);

            // Liaison des paramètres
            $prepare->bindValue(':title', $sequence->getTitle(), PDO::PARAM_STR);
            $prepare->bindValue(':number', $sequence->getNumber(), PDO::PARAM_INT);
            $prepare->bindValue(':script', $sequence->getScript(), PDO::PARAM_STR);
            $prepare->bindValue(':lines_count', $sequence->getLines_count(), PDO::PARAM_INT);
            $prepare->bindValue(':is_assigned', $sequence->getIs_assigned(), PDO::PARAM_BOOL);
            $prepare->bindValue(':duration_estimated', $sequence->getDuration_estimated(), PDO::PARAM_INT);
            $prepare->bindValue(':fk_type', $sequence->getFk_type(), PDO::PARAM_INT);
            $prepare->bindValue(':fk_project', $sequence->getFk_project(), PDO::PARAM_INT);

            if (!$prepare->execute()) {
                throw new \Exception("Erreur lors de l'insertion de la séquence : " . implode(", ", $prepare->errorInfo()));
            }
    }

    function updateSequence(Sequence $sequence) {
        $query = "
            UPDATE sequence
            SET fk_type = :fk_type,
                is_assigned = :is_assigned
            WHERE id = :id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':fk_type', $sequence->getFk_type(), PDO::PARAM_INT);
        $prepare->bindValue(':is_assigned', $sequence->getIs_assigned(), PDO::PARAM_BOOL);
        $prepare->bindValue(':id', $sequence->getId(), PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour de la séquence : " . implode(", ", $prepare->errorInfo()));
        }
    }

    //Ajout de la durée réelle d'une séquence
    function updateRealDuration(Sequence $sequence)
    {
        $query = "
            UPDATE sequence
            SET duration_real = :duration_real
            WHERE id = :sequence_id
            ";
        
        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':duration_real', $sequence->getDuration_real(), PDO::PARAM_INT);
        $prepare->bindValue(':sequence_id', $sequence->getId(), PDO::PARAM_INT);
        
         if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de l'insertion de la durée réelle de la séquence : " . implode(", ", $prepare->errorInfo()));
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

    function findSequenceStatsByUserAndType(int $userId, int $typeId) {
        $query = "
            SELECT sequence.lines_count, sequence.duration_real
            FROM sequence
            JOIN project ON sequence.fk_project = project.id
            WHERE project.fk_user = :user_id
            AND sequence.fk_type = :type_id
            AND sequence.duration_real IS NOT NULL
            AND sequence.duration_real > 0
            AND sequence.lines_count > 0
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $prepare->bindValue(':type_id', $typeId, PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la récupération des stats par type : " . implode(", ", $prepare->errorInfo()));
        }

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }
}