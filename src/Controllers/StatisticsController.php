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

class StatisticsController extends MotherController
{

    public function dashboard()
    {
    
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
        }

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
      

        $this->_arrData['Projects'] = $projectsToDisplay;
        $this->_display("statistics/dashboard");
    }

    public function details()
    {
        
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
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

        foreach($sequences as $detSequence){
            $sequence = new Sequence();
            $sequence->hydrate($detSequence);

            // On n'affiche que les séquences du projet assignées à l'utilisateur
            if (isset($detSequence['is_assigned']) && $detSequence['is_assigned'] == 1 && $detSequence['duration_real'] != 0) {
            $sequencesToDisplay[] = $sequence;
            }
        }

        // Récupération des attributs du bilan final
        $finalReportModel = new FinalReportModel();
        $finalReportData = $finalReportModel->getFinalReportByProjectId($projectId);
        
        $finalReport = null; // Par défaut il n'y a pas de bilan

        if (!$finalReportData) {
            echo "Projet non trouvé.";
            
        } else {
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
      

        $this->_arrData['Projects'] = $projectsToDisplay;
        $this->_arrData['sequences'] = $sequencesToDisplay;
        $this->_arrData['finalReport'] = $finalReport;
        
        $this->_display("statistics/details");
    }

    public function finalReport()
    {
        
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
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
            $projectsToDisplay[] = $project;
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
        $this->_arrData['Projects'] = $projectsToDisplay;


        // Récupération des infos du formulaire et mise en BDD
        if(count($_POST) > 0)
        {
            // Récupération de toutes les données du post qui concernent la table final_report en BDD
            $dureeTotaleProjetForm = (float)$_POST['duree_totale_projet']??'';
            $dureeCleaningForm = (float)$_POST['duree_cleaning']??'';
            $totalPlansForm = (int)$_POST['total_plans']??'';
            $commentaireForm = $_POST['commentaire']??'';
            $idAppreciationForm = (int)($_POST['appreciation']??0);
            $idProjectForm = (int)$_POST['project_id']??'';

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
                
             header("Location: index.php?controller=statistics&action=details&project_id=" . $project->getId() . "#bilanFinal");

        }
   
        $this->_display("statistics/finalReportForm");

    }
}
