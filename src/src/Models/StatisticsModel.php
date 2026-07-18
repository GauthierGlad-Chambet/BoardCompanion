<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Models\MotherModel;

class StatisticsModel extends MotherModel {

    function getStatisticsByProject(int $projectId): array {
        $query = "
            SELECT name, date_beginning, date_end, nb_assigned_pages, estimated_total_duration, recommended_pages_per_day, label
            FROM project
            JOIN final_report ON final_report.fk_project = project.id
            JOIN appreciation ON final_report.fk_appreciation = appreciation.id
            WHERE id = :project_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':project_id', $projectId, PDO::PARAM_INT);
        $prepare->execute();

        return $prepare->fetch(PDO::FETCH_ASSOC);
    }
}