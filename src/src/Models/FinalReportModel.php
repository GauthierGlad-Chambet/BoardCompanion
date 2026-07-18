<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use GauthierGladchambet\BoardCompanion\Entities\FinalReport;
use PDO;

class FinalReportModel extends MotherModel {

// Ajout de la séquence en base de données  
    function addFinalReport(FinalReport $finalReport) {
        $query = "
                INSERT INTO final_report (
                    total_duration, cleaning_duration, nb_shots, commentary, fk_appreciation, fk_project
                ) VALUES (
                    :total_duration, :cleaning_duration, :nb_shots, :commentary, :fk_appreciation, :fk_project
                )";

            $prepare = $this->_db->prepare($query);

            // Liaison des paramètres
            $prepare->bindValue(':total_duration', $finalReport->getTotal_duration(), PDO::PARAM_STR);
            $prepare->bindValue(':cleaning_duration', $finalReport->getCleaning_duration(), PDO::PARAM_STR);
            $prepare->bindValue(':nb_shots', $finalReport->getNb_shots(), PDO::PARAM_INT);
            $prepare->bindValue(':commentary', $finalReport->getCommentary(), PDO::PARAM_STR);
            $prepare->bindValue(':fk_appreciation', $finalReport->getFk_appreciation(), PDO::PARAM_INT);
            $prepare->bindValue(':fk_project', $finalReport->getFk_project(), PDO::PARAM_INT);

            if (!$prepare->execute()) {
                throw new \Exception("Erreur lors de l'insertion du bilan : " . implode(", ", $prepare->errorInfo()));
            }
    }

    // Récupération de toutes les infos d'un bilan
    function getFinalReportByProjectId(int $projectId): array {

    $query = "
        SELECT id, total_duration, cleaning_duration, nb_shots, commentary, fk_appreciation, fk_project
        FROM final_report
        WHERE fk_project = :project_id
    ";

    $prepare = $this->_db->prepare($query);
    $prepare->bindValue(':project_id', $projectId, PDO::PARAM_INT);
    $prepare->execute();

    $result = $prepare->fetch(PDO::FETCH_ASSOC);

    // Retourner null si aucun résultat au lieu de false
    return $result ?: [];
    }

    function updateFinalReport(FinalReport $finalReport) {
        $query = "
            UPDATE final_report
            SET total_duration = :total_duration,
                cleaning_duration = :cleaning_duration,
                nb_shots = :nb_shots,
                commentary = :commentary,
                fk_appreciation = :fk_appreciation
            WHERE id = :id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':total_duration', $finalReport->getTotal_duration(), PDO::PARAM_STR);
        $prepare->bindValue(':cleaning_duration', $finalReport->getCleaning_duration(), PDO::PARAM_STR);
        $prepare->bindValue(':nb_shots', $finalReport->getNb_shots(), PDO::PARAM_INT);
        $prepare->bindValue(':commentary', $finalReport->getCommentary(), PDO::PARAM_STR);
        $prepare->bindValue(':fk_appreciation', $finalReport->getFk_appreciation(), PDO::PARAM_INT);
        $prepare->bindValue(':id', $finalReport->getId(), PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour de la séquence : " . implode(", ", $prepare->errorInfo()));
        }
    }

    function findAllCleaningDurationsByUser(int $userId) {
        $query = "
            SELECT final_report.cleaning_duration
            FROM final_report
            JOIN project ON final_report.fk_project = project.id
            WHERE project.fk_user = :user_id
            AND final_report.cleaning_duration > 0
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la récupération des durées de cleaning : " . implode(", ", $prepare->errorInfo()));
        }

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    function findAllAppreciationsByUser(int $userId) {
        $query = "
            SELECT final_report.fk_appreciation
            FROM final_report
            JOIN project ON final_report.fk_project = project.id
            WHERE project.fk_user = :user_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la récupération des appréciations : " . implode(", ", $prepare->errorInfo()));
        }

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    function findAllShotsAndPagesByUser(int $userId): array
    {
        $query = "
            SELECT final_report.nb_shots, project.nb_assigned_pages
            FROM final_report
            JOIN project ON final_report.fk_project = project.id
            WHERE project.fk_user = :user_id
            AND final_report.nb_shots > 0
            AND project.nb_assigned_pages > 0
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la récupération des plans/pages : " . implode(", ", $prepare->errorInfo()));
        }

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

}