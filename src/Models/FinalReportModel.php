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

    // Récupération de toutes les séquences d'un projet
    function getFinalReportByProjectId(int $projectId): array {

    $query = "
        SELECT total_duration, cleaning_duration, nb_shots, commentary, fk_appreciation, fk_project
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

}