<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Entities\Project;
use GauthierGladchambet\BoardCompanion\Models\MotherModel;

class ProjectModel extends MotherModel {

    // Ajout d'un projet dans la base de données
    function addProject(Project $project) {

        // Préparation de la requête pour ajouter un projet dans la base de données
        $query = "
            INSERT INTO project (
                name, studio, episode_nb, episode_title, nb_predec, is_alone, 
                is_cleaning, script_path,";
        
        if($project->getTemplate_path() !== null) {
            $query .= "template_path,";
        }
        
        $query .= "date_beginning, date_end, fk_user
            ) VALUES (
                :name, :studio, :episode_nb, :episode_title, :nb_predec, :is_alone, 
                :is_cleaning, :script_path,";
        
        if($project->getTemplate_path() !== null) {
            $query .= ":template_path,";
        }
        
        $query .= ":date_beginning, :date_end, :fk_user
            )";

        $prepare = $this->_db->prepare($query);

        // Liaison des paramètres
        $prepare->bindValue(':name', $project->getName(), PDO::PARAM_STR);
        $prepare->bindValue(':studio', $project->getStudio(), PDO::PARAM_STR);
        $prepare->bindValue(':episode_nb', $project->getEpisode_nb(), PDO::PARAM_STR);
        $prepare->bindValue(':episode_title', $project->getEpisode_title(), PDO::PARAM_STR);
        $prepare->bindValue(':nb_predec', $project->getNb_predecs(), PDO::PARAM_INT);
        $prepare->bindValue(':is_alone', $project->getIs_alone(), PDO::PARAM_BOOL);
        $prepare->bindValue(':is_cleaning', $project->getIs_cleaning(), PDO::PARAM_BOOL);
        $prepare->bindValue(':script_path', $project->getScript_path(), PDO::PARAM_STR);
        if($project->getTemplate_path() !== null) {
            $prepare->bindValue(':template_path', $project->getTemplate_path(), PDO::PARAM_STR);
        }
        $prepare->bindValue(':date_beginning', $project->getDate_beginning(), PDO::PARAM_STR);
        $prepare->bindValue(':date_end', $project->getDate_end(), PDO::PARAM_STR);
        $prepare->bindValue(':fk_user', $project->getFk_user(), PDO::PARAM_INT);

        // Exécution de la requête
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de l'insertion du projet : " . implode(", ", $prepare->errorInfo()));
        }
        return $this->_db->lastInsertId(); // Retourne l'ID du projet nouvellement créé
    }


    // trouver le projet en fonction de son ID
    function getProjectById($id) {

        $query = "
            SELECT *
            FROM project
            WHERE id = :id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':id', $id, PDO::PARAM_INT);

        // Exécution de la requête
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la récupération du projet : " . implode(", ", $prepare->errorInfo()));
        }
        return $prepare->fetch(PDO::FETCH_ASSOC); // Retourne les données du projet sous forme de tableau associatif
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

    //Trouver tous les projets d'un utilisateur
    function getAllProjectsByUser(int $userId): array {
        $query = "
            SELECT project.id, name, studio, episode_nb, episode_title, nb_predec, is_alone, is_cleaning, date_beginning, date_end, nb_total_pages, nb_assigned_pages, estimated_total_duration, recommended_pages_per_day, label as appreciation_label
            FROM project
            LEFT JOIN final_report ON final_report.fk_project = project.id
            LEFT JOIN appreciation ON final_report.fk_appreciation = appreciation.id
            JOIN user ON project.fk_user = user.id
            WHERE fk_user = :user_id
            ORDER BY date_beginning DESC
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $prepare->execute();

        return $prepare->fetchAll(PDO::FETCH_ASSOC); // Retourne un tableau de tous les projets de l'utilisateur
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


    // Mise à jour du nombre de pages du projet
    function updateNbPagesProject(Project $project) {

        $query = "
            UPDATE project
            SET nb_total_pages = :nb_total_pages,
                nb_assigned_pages = :nb_assigned_pages
            WHERE id = :project_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':nb_total_pages', $project->getNb_total_pages(), PDO::PARAM_INT);
        $prepare->bindValue(':nb_assigned_pages', $project->getNb_assigned_pages(), PDO::PARAM_INT);
        $prepare->bindValue(':project_id', $project->getId(), PDO::PARAM_INT);
        
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour du nombre de pages du projet : " . implode(", ", $prepare->errorInfo()));
            }
    }

    // Mise à jour du nombre de pages assignées du projet
    function updateNbPagesAssignedProject(Project $project) {

        $query = "
            UPDATE project
            SET nb_assigned_pages = :nb_assigned_pages
            WHERE id = :project_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':nb_assigned_pages', $project->getNb_assigned_pages(), PDO::PARAM_INT);
        $prepare->bindValue(':project_id', $project->getId(), PDO::PARAM_INT);

        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour du nombre de pages assignées du projet : " . implode(", ", $prepare->errorInfo()));
        }
    }

     // Mise à jour du temps moyen de cleaning pour le projet
    function updateAvgCleaningProject(Project $project) {

        $query = "
            UPDATE project
            SET estimated_cleaning_duration = :estimated_cleaning_duration
            WHERE id = :project_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':estimated_cleaning_duration', $project->getEstimated_cleaning_duration(), PDO::PARAM_STR);
        $prepare->bindValue(':project_id', $project->getId(), PDO::PARAM_INT);
        
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour du temps moyen de cleaning du projet : " . implode(", ", $prepare->errorInfo()));
            }
    }


    // Mise à jour de la durée totale estimée du projet
    function updateTotalDurationProject(Project $project) {

        $query = "
            UPDATE project
            SET estimated_total_duration = :estimated_total_duration
            WHERE id = :project_id
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':estimated_total_duration', $project->getEstimated_total_duration(), PDO::PARAM_STR);
        $prepare->bindValue(':project_id', $project->getId(), PDO::PARAM_INT);
        
        if (!$prepare->execute()) {
            throw new \Exception("Erreur lors de la mise à jour de la durée totale estimée du projet : " . implode(", ", $prepare->errorInfo()));
            }
    }


    // Mise à jour du rythme recommandé du projet
    function updateRecommendedPagesPerDayProject(Project $project) {
        
        $query = " 
            UPDATE project
            SET recommended_pages_per_day = :recommended_pages_per_day
            WHERE id = :project_id
        ";
            
        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':recommended_pages_per_day', $project->getRecommended_pages_per_day(), PDO::PARAM_STR);
        $prepare->bindValue(':project_id', $project->getId(), PDO::PARAM_INT);

        if (!$prepare->execute()) { 
            throw new \Exception("Erreur lors de la mise à jour du nombre de pages recommandées par jour du projet : " . implode(", ", $prepare->errorInfo())); 
        } 
    }
}

