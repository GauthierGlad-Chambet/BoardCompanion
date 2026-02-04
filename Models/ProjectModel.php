<?php

namespace App\Models;

use PDO;
use App\Entities\Project;

class ProjectModel extends MotherModel {


    function add(Project $project) {
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
}

//  INSERT INTO project (
//                 name, studio, episode_nb, episode_title, nb_predec, is_alone, 
//                 is_cleaning, script_path,template_path,date_beginning, date_end, fk_user
//             ) VALUES (
//                 'name', 'studio', '124', 'episodetitle', '2', '1', 
//                 '1', 'script_path','template_path','2025:01:23', '2025:01:23', '1'
//             )
         