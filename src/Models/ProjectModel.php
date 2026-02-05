<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Entities\Project;

class ProjectModel extends MotherModel {

    // Ajout d'un projet dans la base de données
    function addProject(Project $project) {;

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

        $prepare = $this->_db->prepare($query);

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
        return $this->_db->lastInsertId(); // Retourne l'ID du projet nouvellement créé
    }


    // Mise à jour du nombre de pages du projet
    function updateNbPagesProject(Project $project) {

        $query = "
            UPDATE project
            SET nb_total_pages = :nb_total_pages
            WHERE id = :project_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':nb_total_pages', $project->getNbTotalPages(), PDO::PARAM_INT);
        $prepare->bindValue(':project_id', $project->getId(), PDO::PARAM_INT);
        
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour du nombre de pages du projet : " . implode(", ", $prepare->errorInfo()));
            }
    }

    // trouve l'id du dernier projet ajouté
    function findLastProjectId() {

        $query = "
            SELECT id
            FROM project
            ORDER BY id DESC
            LIMIT 1
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->execute();

        // Exécution de la requête
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la récupération du dernier projet : " . implode(", ", $prepare->errorInfo()));
        }
        $row = $prepare->fetch(PDO::FETCH_ASSOC);
        return $row['id'] ?? null; // <-- retourne directement l'id du projet
    }
    
    // Récupération du chemin du dernier script ajouté dans la base de données
    function findLastScriptPath() {

        $query = "
            SELECT script_path
            FROM project
            ORDER BY id DESC
            LIMIT 1
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->execute();

        // Exécution de la requête
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la récupération du dernier script : " . implode(", ", $prepare->errorInfo()));
        }
        $row = $prepare->fetch(PDO::FETCH_ASSOC);
        return $row['script_path'] ?? null; // <-- retourne directement la string
    }

    // Mise à jour du nombre de pages assignées du projet
    function updateNbPagesAssignedProject(Project $project) {

        $query = "
            UPDATE project
            SET nb_assigned_pages = :nb_assigned_pages
            WHERE id = :project_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':nb_assigned_pages', $project->getNbAssignedPages(), PDO::PARAM_INT);
        $prepare->bindValue(':project_id', $project->getId(), PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour du nombre de pages assignées du projet : " . implode(", ", $prepare->errorInfo()));
        }
    }
    
}

