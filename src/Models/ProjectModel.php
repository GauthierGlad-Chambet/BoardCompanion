<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Entities\Project;
use GauthierGladchambet\BoardCompanion\Entities\Sequence;

class ProjectModel extends MotherModel {

    function addProject(Project $project) {
        // Connexion à la base de données
        $pdo = $this->connect();

        // Préparation de la requête pour ajouter un projet dans la base de données
        $query = "
            INSERT INTO project (
                name, studio, episode_nb, episode_title, nb_predec, is_alone, 
                is_cleaning, script_path,";
        
        if($project->getTemplateFilePath() !== null) {
            $query .= "template_path,";
        }
        
        $query .= "date_beginning, date_end, fk_user
            ) VALUES (
                :name, :studio, :episode_nb, :episode_title, :nb_predec, :is_alone, 
                :is_cleaning, :script_path,";
        
        if($project->getTemplateFilePath() !== null) {
            $query .= ":template_path,";
        }
        
        $query .= ":date_beginning, :date_end, :fk_user
            )";

        $prepare = $pdo->prepare($query);

        // Liaison des paramètres
        $prepare->bindValue(':name', $project->getName(), PDO::PARAM_STR);
        $prepare->bindValue(':studio', $project->getStudio(), PDO::PARAM_STR);
        $prepare->bindValue(':episode_nb', $project->getEpisodeNb(), PDO::PARAM_STR);
        $prepare->bindValue(':episode_title', $project->getEpisodeTitle(), PDO::PARAM_STR);
        $prepare->bindValue(':nb_predec', $project->getNbPredecs(), PDO::PARAM_INT);
        $prepare->bindValue(':is_alone', $project->getIsAlone(), PDO::PARAM_BOOL);
        $prepare->bindValue(':is_cleaning', $project->getIsCleaning(), PDO::PARAM_BOOL);
        $prepare->bindValue(':script_path', $project->getScriptFilePath(), PDO::PARAM_STR);
        if($project->getTemplateFilePath() !== null) {
            $prepare->bindValue(':template_path', $project->getTemplateFilePath(), PDO::PARAM_STR);
        }
        $prepare->bindValue(':date_beginning', $project->getDateBegin(), PDO::PARAM_STR);
        $prepare->bindValue(':date_end', $project->getDateEnd(), PDO::PARAM_STR);
        $prepare->bindValue(':fk_user', $project->getUser(), PDO::PARAM_INT);

        // Exécution de la requête
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de l'insertion du projet : " . implode(", ", $prepare->errorInfo()));
        }
    }

    function findLastScriptPath() {
        $pdo = $this->connect();

        $query = "
            SELECT script_path
            FROM project
            ORDER BY id DESC
            LIMIT 1
        ";

        $prepare = $pdo->prepare($query);
        $prepare->execute();

        // Exécution de la requête
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la récupération du dernier script : " . implode(", ", $prepare->errorInfo()));
        }
        $row = $prepare->fetch(PDO::FETCH_ASSOC);
        return $row['script_path'] ?? null; // <-- retourne directement la string
    }



    function addSequences(Sequence $sequence) {
        $pdo = $this->connect();

        $query = "
            INSERT INTO sequence (
                name, description, duration, fk_project
            ) VALUES (
                :name, :description, :duration, :fk_project
            )
        ";

        $prepare = $pdo->prepare($query);
        $prepare->bindValue(':name', $sequence->getName(), PDO::PARAM_STR);
        $prepare->bindValue(':description', $sequence->getDescription(), PDO::PARAM_STR);
        $prepare->bindValue(':duration', $sequence->getDuration(), PDO::PARAM_STR);
        $prepare->bindValue(':fk_project', $sequence->getProjectId(), PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de l'insertion de la séquence : " . implode(", ", $prepare->errorInfo()));
        }
    }

    function findAllSequencesByProjectId(int $projectId): array {
    $pdo = $this->connect();

    $query = "
        SELECT *
        FROM sequence
        WHERE fk_project = :project_id
    ";

    $prepare = $pdo->prepare($query);
    $prepare->bindValue(':project_id', $projectId, PDO::PARAM_INT);
    $prepare->execute();

    return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }
}

