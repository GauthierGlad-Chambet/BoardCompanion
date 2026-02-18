<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController;
use GauthierGladchambet\BoardCompanion\Entities\Appreciation;
use GauthierGladchambet\BoardCompanion\Entities\Project;
use GauthierGladchambet\BoardCompanion\Entities\Sequence;
use GauthierGladchambet\BoardCompanion\Models\AppreciationModel;
use GauthierGladchambet\BoardCompanion\Models\ProjectModel;
use GauthierGladchambet\BoardCompanion\Models\SequenceModel;

class StatisticsController extends MotherController
{

    public function dashboard()
    {
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
      

        $this->_arrData['arrProjects'] = $projectsToDisplay;
        $this->_display("statistics/dashboard");
    }

    public function details()
    {
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
      

        $this->_arrData['arrProjects'] = $projectsToDisplay;
        
        $this->_display("statistics/details");
    }

    public function finalReport()
    {
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
        $this->_arrData['arrProjects'] = $projectsToDisplay;
        
        $this->_display("statistics/finalReport");
    }
}
