<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController;
use GauthierGladchambet\BoardCompanion\Entities\Appreciation;
use GauthierGladchambet\BoardCompanion\Entities\FinalReport;
use GauthierGladchambet\BoardCompanion\Entities\Project;
use GauthierGladchambet\BoardCompanion\Entities\Sequence;
use GauthierGladchambet\BoardCompanion\Models\AppreciationModel;
use GauthierGladchambet\BoardCompanion\Models\FinalReportModel;
use GauthierGladchambet\BoardCompanion\Models\ProjectModel;
use GauthierGladchambet\BoardCompanion\Models\SequenceModel;
use GauthierGladchambet\BoardCompanion\Models\UserModel;
use GauthierGladchambet\BoardCompanion\Models\UserStatByTypeModel;

class StatisticsController extends MotherController
{

    public function dashboard()
    {
    
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $projectModel = new ProjectModel();

        // récupération de tous les projets de l'utilisateur connecté
        $projects = $projectModel->getAllProjectsByUser($_SESSION['user']['id']);

        // On parcourt le tableau pour créer des objets
        $projectsToDisplay = array();
        foreach($projects as $detProject){
            $project = new Project();
            $project->hydrate($detProject);
            $projectsToDisplay[] = $project;
        }
      

        $this->_arrData['projects'] = $projectsToDisplay;
        $this->_display("statistics/dashboard");
    }

    public function details() {
        
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        if (!isset($_GET['project_id'])) {
            echo "ID du projet non spécifié.";
            exit;
        }


        // Récupération des attributs du projet
        $projectId = $_GET['project_id'];
        $projectModel = new ProjectModel();
        $projectData = $projectModel->getProjectById($projectId);

        if (!$projectData) {
            echo "Projet non trouvé.";
            exit;
        }

        $project = new Project();
        $project->hydrate($projectData);
        $this->_arrData['project'] = $project;
        
        // Récupérer les séquences du projet
        $sequenceModel = new SequenceModel();
        $sequences = $sequenceModel->findAllSequencesByProjectId($projectId);
        
        // On parcourt le tableau pour créer des objets
        $sequencesToDisplay = array();

        foreach($sequences as $detSequence) {
            $sequence = new Sequence();
            $sequence->hydrate($detSequence);

            // On n'affiche que les séquences du projet assignées à l'utilisateur
            if (isset($detSequence['is_assigned']) && $detSequence['is_assigned'] == 1) {
            $sequencesToDisplay[] = $sequence;
            }
        }

        // Récupération des attributs du bilan final
        $finalReportModel = new FinalReportModel();
        $finalReportData = $finalReportModel->getFinalReportByProjectId($projectId);
        
        $finalReport = null; // Par défaut il n'y a pas de bilan

        // Ne créer un objet finalreport que s'il en existe un en BDD
        if ($finalReportData) {
            $finalReport = new FinalReport();
            $finalReport->hydrate($finalReportData);  
        } 
        

        // Récupération de tous les autres projets

        // création d'une entité projet et injection des attributs
        $projectModel = new ProjectModel();

        // récupération de tous les projets de l'utilisateur connecté
        $projects = $projectModel->getAllProjectsByUser($_SESSION['user']['id']);


        // On parcourt le tableau pour créer des objets
        $projectsToDisplay = array();
        foreach($projects as $detProject){
            $project = new Project();
            $project->hydrate($detProject);
            $projectsToDisplay[] = $project;
        }

        $this->_arrData['projects'] = $projectsToDisplay;
        $this->_arrData['sequences'] = $sequencesToDisplay;
        $this->_arrData['finalReport'] = $finalReport;
        
        $this->_display("statistics/details");
    }

    public function finalReport() {
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        // Récupération du projet en cours
         if (!isset($_GET['project_id'])) {
            echo "ID du projet non spécifié.";
            exit;
        }

        $projectId = $_GET['project_id'];
        $projectModel = new ProjectModel();
        $projectData = $projectModel->getProjectById($projectId);

        if (!$projectData) {
            echo "Projet non trouvé.";
            exit;
        }

        $project = new Project();
        $project->hydrate($projectData);
        
        $this->_arrData['project'] = $project;


        // Récupération de tous les autres projets

        // création d'une entité projet et injection des attributs
        $projectModel = new ProjectModel();

        // récupération de tous les projets de l'utilisateur connecté
        $projects = $projectModel->getAllProjectsByUser($_SESSION['user']['id']);


        // On parcourt le tableau pour créer des objets
        $projectsToDisplay = array();
        foreach($projects as $detProject){
            $project = new Project();
            $project->hydrate($detProject);
            if($project->getAppreciation_label() == "Non renseigné") {
                $projectsToDisplay[] = $project;
            }
        }
        
        // Récupération des différentes appréciations possibles

        $appreciationModel = new AppreciationModel();
        $appreciations = $appreciationModel->findAllAppreciations();

        // On parcourt le tableau pour créer des objets
        $appreciationsToDisplay = array();

        foreach($appreciations as $labelAppreciation){
            $appreciation = new Appreciation();
            $appreciation->hydrate($labelAppreciation);
            $appreciationsToDisplay[] = $appreciation;
        }

        // Récupérer les séquences du projet
        $sequenceModel = new SequenceModel();
        $sequences = $sequenceModel->findAllSequencesByProjectId($projectId);
        
        // On parcourt le tableau pour créer des objets
        $sequencesToDisplay = array();

        foreach($sequences as $detSequence){
            $sequence = new Sequence();
            $sequence->hydrate($detSequence);

            // On n'affiche que les séquences du projet assignées à l'utilisateur
            if (isset($detSequence['is_assigned']) && $detSequence['is_assigned'] == 1) {
            $sequencesToDisplay[] = $sequence;
            }
        }

        
        $this->_arrData['sequences'] = $sequencesToDisplay;
        $this->_arrData['arrAppreciations'] = $appreciationsToDisplay;
        $this->_arrData['projects'] = $projectsToDisplay;


        // Récupération des infos du formulaire et mise en BDD
        if(count($_POST) > 0)
        {
       
            // Récupération de toutes les données du post qui concernent la table final_report en BDD
            $dureeTotaleProjetForm      = (float)trim(filter_input(INPUT_POST,"duree_totale_projet", FILTER_SANITIZE_NUMBER_FLOAT))??'';
            $dureeCleaningForm          = (float)trim(filter_input(INPUT_POST,"duree_cleaning", FILTER_SANITIZE_NUMBER_FLOAT))??'';
            $totalPlansForm             = (int)trim(filter_input(INPUT_POST,"total_plans", FILTER_SANITIZE_NUMBER_INT))??'';
            $commentaireForm            = trim(filter_input(INPUT_POST,"commentaire", FILTER_SANITIZE_SPECIAL_CHARS))??'';
            $idAppreciationForm         = (int)filter_input(INPUT_POST,"appreciation", FILTER_SANITIZE_NUMBER_INT)??0;
            $idProjectForm              = (int)filter_input(INPUT_POST,"project_id", FILTER_SANITIZE_NUMBER_INT)??'';

            // création de l'objet final report
            $finalReport = new FinalReport();
            $finalReport->setTotal_duration($dureeTotaleProjetForm);
            $finalReport->setCleaning_duration($dureeCleaningForm);
            $finalReport->setNb_shots($totalPlansForm);
            $finalReport->setCommentary($commentaireForm);
            $finalReport->setFk_appreciation($idAppreciationForm);
            $finalReport->setFk_project($idProjectForm);
            
            // Insertion du bilan final en bdd
            try {
                $finalReportModel = new FinalReportModel();
                $finalReportModel->addFinalReport($finalReport);
            
                echo "Bilan final ajouté avec succès.";
                
            } catch (\Exception $e) {
                echo "Erreur lors de l'ajout du bilan : " . htmlspecialchars($e->getMessage());
                exit;
            }

            // Récupération des durées réelles de séquences depuis le tableau dans le POST
            $dureeSequencesForm = $_POST['duree_sequence']??[];

            // Boucle de création des objets séquence et insertion dans la BDD
            foreach($dureeSequencesForm as $sequenceId => $duree) {

                // Ignorer les champs vides
                if ($duree === '') {
                    continue;
                }

                // Convertir la durée en float
                $duree = (float)$duree;

                //Création de l'objet séquence
                $sequence = new Sequence();
                $sequence ->setId($sequenceId);
                $sequence->setDuration_real($duree);

                try {
                    $sequenceModel = new SequenceModel();
                    $sequenceModel->updateRealDuration($sequence);
                    
                } catch (\Exception $e) {
                    echo "Erreur lors de l'ajout du bilan : " . htmlspecialchars($e->getMessage());
                    exit;
                }

                echo "Durées réelles des séquences ajoutées avec succès.";
                
            }
            
            //Modifier statistiques utilisateur avec les nouvelles infos du bilan :
            $this->updateUserAvgPagesPerDay($_SESSION['user']['id']);
            $this->updateUserAvgCleaningDuration($_SESSION['user']['id']);
            $this->updateUserAvgAppreciation($_SESSION['user']['id']);
            $this->updateUserAvgShotsPerPage($_SESSION['user']['id']);
            $this->updateUserStatsByType($_SESSION['user']['id']);

            header("Location: index.php?controller=statistics&action=details&project_id=" . $project->getId() . "#bilanFinal");
            exit;

        }
   
        $this->_display("statistics/finalReportForm");

    }

    public function updateFinalReport() {
         //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        // Récupération du projet en cours
         if (!isset($_GET['project_id'])) {
            echo "ID du projet non spécifié.";
            exit;
        }

        $projectId = $_GET['project_id'];
        $projectModel = new ProjectModel();
        $projectData = $projectModel->getProjectById($projectId);

        if (!$projectData) {
            echo "Projet non trouvé.";
            exit;
        }

        $project = new Project();
        $project->hydrate($projectData);
        
        $this->_arrData['project'] = $project;


        // Récupération de tous les autres projets

        // création d'une entité projet et injection des attributs
        $projectModel = new ProjectModel();

        // récupération de tous les projets de l'utilisateur connecté
        $projects = $projectModel->getAllProjectsByUser($_SESSION['user']['id']);


        // On parcourt le tableau pour créer des objets
        $projectsToDisplay = array();
        foreach($projects as $detProject){
            $project = new Project();
            $project->hydrate($detProject);
            if($project->getAppreciation_label() != "Non renseigné") {
                $projectsToDisplay[] = $project;
            }
        }
      
        
        // Récupération des différentes appréciations possibles

        $appreciationModel = new AppreciationModel();
        $appreciations = $appreciationModel->findAllAppreciations();

        // On parcourt le tableau pour créer des objets
        $appreciationsToDisplay = array();

        foreach($appreciations as $labelAppreciation){
            $appreciation = new Appreciation();
            $appreciation->hydrate($labelAppreciation);
            $appreciationsToDisplay[] = $appreciation;
        }

        // Récupérer les séquences du projet
        $sequenceModel = new SequenceModel();
        $sequences = $sequenceModel->findAllSequencesByProjectId($projectId);
        
        // On parcourt le tableau pour créer des objets
        $sequencesToDisplay = array();

        foreach($sequences as $detSequence){
            $sequence = new Sequence();
            $sequence->hydrate($detSequence);

            // On n'affiche que les séquences du projet assignées à l'utilisateur
            if (isset($detSequence['is_assigned']) && $detSequence['is_assigned'] == 1) {
            $sequencesToDisplay[] = $sequence;
            }
        }

        $finalreportModel = new FinalReportModel();
        $finalReportData = $finalreportModel->getFinalReportByProjectId($projectId);

        if (!$finalReportData) {
            echo "Bilan non trouvé.";
            exit;
        }

        $finalReport = new FinalReport();
        $finalReport->hydrate($finalReportData);
        
        $this->_arrData['finalReport'] = $finalReport;
        $this->_arrData['sequences'] = $sequencesToDisplay;
        $this->_arrData['arrAppreciations'] = $appreciationsToDisplay;
        $this->_arrData['projects'] = $projectsToDisplay;

        if(count($_POST) > 0){

            $dureeTotale      = (float)trim(filter_input(INPUT_POST,"duree_totale_projet", FILTER_SANITIZE_NUMBER_FLOAT))??'';
            $dureeCleaning    = (float)trim(filter_input(INPUT_POST,"duree_cleaning", FILTER_SANITIZE_NUMBER_FLOAT))??'';
            $totalPlans       = (int)trim(filter_input(INPUT_POST,"total_plans", FILTER_SANITIZE_NUMBER_INT))??'';
            $commentaire      = trim(filter_input(INPUT_POST,"commentaire", FILTER_SANITIZE_SPECIAL_CHARS))??'';
            $appreciation     = (int)filter_input(INPUT_POST,"appreciation", FILTER_SANITIZE_NUMBER_INT)??0;
            $projectId        = (int)filter_input(INPUT_POST,"project_id", FILTER_SANITIZE_NUMBER_INT)??'';
         
            $finalReportUpdated = new FinalReport();
            $finalReportUpdated->setId($finalReport->getId());
            $finalReportUpdated->setTotal_duration($dureeTotale);
            $finalReportUpdated->setCleaning_duration($dureeCleaning);
            $finalReportUpdated->setNb_shots($totalPlans);
            $finalReportUpdated->setCommentary($commentaire);
            $finalReportUpdated->setFk_appreciation($appreciation);
            $finalReportUpdated->setFk_project($projectId);

            try {
                $newFinalReportModel = new FinalReportModel();
                $newFinalReportModel->updateFinalReport($finalReportUpdated);
                
            } catch (\Exception $e) {
                echo "Erreur lors de la modification du bilan final : " . htmlspecialchars($e->getMessage());
                exit;
            }

           // Récupération des durées réelles de séquences depuis le tableau dans le POST
            $dureeSequencesForm = $_POST['duree_sequence']??[];

            // Boucle de création des objets séquence et insertion dans la BDD
            foreach($dureeSequencesForm as $sequenceId => $duree) {

                // Reinitialiser les champs vides
                if ($duree === '' ||$duree == 0 ) {
                    $duree = NULL;
                    // continue;
                } else {
                    // Convertir la durée en float
                    $duree = (float)$duree;
                }

                //Création de l'objet séquence
                $sequence = new Sequence();
                $sequence ->setId($sequenceId);
                $sequence->setDuration_real($duree);

                try {
                    $sequenceModel = new SequenceModel();
                    $sequenceModel->updateRealDuration($sequence);
                    
                } catch (\Exception $e) {
                    echo "Erreur lors de l'ajout du bilan : " . htmlspecialchars($e->getMessage());
                    exit;
                }
            }

            //Modifier statistiques utilisateur avec les nouvelles infos du bilan :
            $this->updateUserAvgPagesPerDay($_SESSION['user']['id']);
            $this->updateUserAvgCleaningDuration($_SESSION['user']['id']);
            $this->updateUserAvgAppreciation($_SESSION['user']['id']);
            $this->updateUserAvgShotsPerPage($_SESSION['user']['id']);
            $this->updateUserStatsByType($_SESSION['user']['id']);
    
            header("Location: index.php?controller=statistics&action=dashboard");
            exit;

        }

        $this->_display("statistics/updateFinalReportForm");
    }

    public function deleteProject() {
        
        $project_id = $_POST['project_id']??'';

        $projectModel = new ProjectModel();
        $projectModel->deleteProjetbyId($project_id);

        //Modifier statistiques utilisateur après supression d'un projet :
        $this->updateUserAvgPagesPerDay($_SESSION['user']['id']);
        $this->updateUserAvgCleaningDuration($_SESSION['user']['id']);
        $this->updateUserAvgAppreciation($_SESSION['user']['id']);
        $this->updateUserAvgShotsPerPage($_SESSION['user']['id']);
        $this->updateUserStatsByType($_SESSION['user']['id']);

        header("Location: index.php?controller=statistics&action=dashboard");
        exit;

    }

    public function updateUserAvgPagesPerDay(int $userId) {
        // récupération de tous les projets de l'utilisateur connecté
        $projectModel = new ProjectModel();
        $projects = $projectModel->findAllProjectsWithFinalReportByUser($userId);

        $total = 0;
        foreach ($projects as $project) {
            $boardingDuration = $project['total_duration'] - $project['cleaning_duration'];
            $total += $project['nb_assigned_pages'] / $boardingDuration;
        }
        
        // Empêche erreur de division par 0 s'il n'y a aucun projet enregistré
        if(count($projects) > 0) {
            $avgPagesPerDay = $total / count($projects);
        } else {
            $avgPagesPerDay = 1;
        }
        
        $userModel = new UserModel();
        $userModel->updateAvgPagesPerDay($userId, round($avgPagesPerDay, 2));
    }

    public function updateUserAvgCleaningDuration(int $userId) {
        $finalReportModel = new FinalReportModel();
        $cleaningDurations = $finalReportModel->findAllCleaningDurationsByUser($userId);

        $total = 0;
        foreach ($cleaningDurations as $cleaningDuration) {
            $total += $cleaningDuration['cleaning_duration'];
        }
        
        // Empêche erreur de division par 0 si la durée de cleaning est de 0
        if(count($cleaningDurations) > 0) {
            $avgCleaningDuration = $total / count($cleaningDurations);
        } else {
            $avgCleaningDuration = 0.2;
        }

        $userModel = new UserModel();
        $userModel->updateAvgCleaningDuration($userId, round($avgCleaningDuration, 2));
    }

    public function updateUserAvgAppreciation(int $userId) {
        $finalReportModel = new FinalReportModel();
        $appreciations = $finalReportModel->findAllAppreciationsByUser($userId);

        $total = 0;
        foreach ($appreciations as $appreciation) {
            $total += $appreciation['fk_appreciation'];
        }
        
        // Empêche erreur de division par 0 si la durée de cleaning est de 0
        if(count($appreciations) > 0) {
            $avg = $total / count($appreciations);
        } else {
        $avg = 2;
        }

        // Arrondi à l'entier le plus proche, clampé entre 1 et 4
        $rounded = (int) round($avg);
        $clamped = max(1, min(4, $rounded));

        $userModel = new UserModel();
        $userModel->updateAvgAppreciation($userId, $clamped);
    }

    public function updateUserAvgShotsPerPage(int $userId) {
        $finalReportModel = new FinalReportModel();
        $avgshots = $finalReportModel->findAllShotsAndPagesByUser($userId);

        $total = 0;
        foreach ($avgshots as $avgshot) {
            $total += $avgshot['nb_shots'] / $avgshot['nb_assigned_pages'];
        }
        
        // Empêche erreur de division par 0 si la durée de cleaning est de 0
        if(count($avgshots) > 0) {
            $avg = $total / count($avgshots);
        } else {
            $avg = 0;
        }
        

        $userModel = new UserModel();
        $userModel->updateAvgShotsPerPage($userId, round($avg));
    }

    public function updateUserStatsByType(int $userId) {
    $sequenceModel = new SequenceModel();
    $userStatByTypeModel = new UserStatByTypeModel();

    foreach ([1, 2, 3] as $typeId) {
        $datas = $sequenceModel->findSequenceStatsByUserAndType($userId, $typeId);

        if (empty($datas)) {
            continue;
        }

        $total = 0;
        $count = 0;

        foreach ($datas as $data) {
    
            if (!isset($data['lines_count'], $data['duration_real']) || $data['duration_real'] <= 0 || $data['lines_count'] <= 0) {
                continue;
            }
            $pages = $data['lines_count'] / 33;
            $durationDays = $data['duration_real'] / 8;
            $total += $pages / $durationDays;
            $count++;
        }

        if ($count === 0) {
            continue;
        }

        $avg = round($total / $count, 2);

        // Sécurité pour éviter les erreurs de division par 0 on n'envoie jamais 0 en bdd, si c'est le cas, on reset avec la valeur par défaut
        $avg = $avg > 0 ? $avg : 1;

        $userStatByTypeModel->updateUserStatByType($userId, $typeId, $avg);
    }
}

}
