<?php

namespace App\Controllers;

use App\Entities\Project;
use App\Models\NewProjectModel;

class FormController extends MotherController
{

    public function newProject()
    {
        // require_once("Views/partials/header.php");
        // include("Views/projectForm/newProjectForm.php");
        // require_once("Views/partials/footer.php");
        
        $name               =trim($_POST['name']??'');    //trim remove invisibles characters like spaces, before and after the text
        $studio             =trim($_POST['studio']??'');
        $episodeNb          =trim($_POST['episode_nb']??'');
        $episodeTitle       =trim($_POST['episode_title']??'');
        $dateBegin          =$_POST['date_begin']??'';
        $dateEnd            =$_POST['date_end']??'';
        $nbPredecs          =$_POST['nb_predec']??'';
        $isCleaning         =$_POST['is_cleaning']??'';
        $isAlone            =$_POST['is_alone']??'';

        //if script field existe, and no error during upload
        if (isset($_FILES['script']) && $_FILES['script']['error'] === 0) {

        // application/pdf is the official MIME type for PDF
        $allowedTypes = ['application/pdf'];
        //if the type of the file is correct, continue, if not stop it with and error msg
        if (!in_array($_FILES['script']['type'], $allowedTypes)) {
            die('Le fichier doit être un PDF.');
        }


        //get the original name of the file
        $originalName = $_FILES['script']['name'];

        //PATHINFO_EXTENSION collect the extension of the file
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);

        //uniqid generate a unique number just after 'script_', concatenate with the extension of the file
        $newFileName = uniqid('script_') . '.' . $extension;

        //to construct the real path for the file, starting by the current directory
        $uploadDir = __DIR__ . '/../../uploads/scripts/';

        // the place where the file will be saved
        $destination = $uploadDir . $newFileName;

        //move_uploaded_file move the file from the temporary place to the destination
        move_uploaded_file($_FILES['script']['tmp_name'], $destination);
        $scriptFilePath    =realpath($destination);
        }

        // Don't work if php.ini is not right configurated, have to setup upload_max_filesize, post_max_size and memory_limit
        if (isset($_FILES['template']) && $_FILES['template']['error'] === 0) {
        $allowedTypes = ['image/vnd.adobe.photoshop','application/octet-stream'];
        if (!in_array($_FILES['template']['type'], $allowedTypes)) {
            die('Le fichier doit être un PSD ou un SBBKP.');
        }
        $originalName = $_FILES['template']['name'];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $newFileName = uniqid('template_') . '.' . $extension;
        $uploadDir = __DIR__ . '/../../uploads/templates/';
        $destination = $uploadDir . $newFileName;
        move_uploaded_file($_FILES['template']['tmp_name'], $destination);
        $templateFilePath   = realpath($destination);
        }

        $project = new Project();
        $project->setName($name);
        $project->setStudio($studio);
        $project->setEpisodeNb($episodeNb);
        $project->setEpisodeTitle($episodeTitle);
        $project->setDateBegin($dateBegin);
        $project->setDateEnd($dateEnd);
        $project->setNbPredecs(intval($nbPredecs));
        $project->setIsCleaning($isCleaning);
        $project->setIsAlone($isAlone);
        if (isset($scriptFilePath)) {
            $project->setScriptFilePath($scriptFilePath);
        }
        if (isset($templateFilePath)) {
            $project->setTemplateFilePath($templateFilePath);
        }

        // Get the user ID from session or default to 1 if not set
        $userId = $_SESSION['user_id'] ?? 1;
        // Assuming you have a method to set the user in Project entity
        // You would need to inject the user object into the project entity
        // For now, we'll just set the user ID directly
        $project->setUser($userId);

        // Save the project using the model
        try {
            $newProjectModel = new NewProjectModel();
            $newProjectModel->add($project);
            echo "Projet ajouté avec succès.";
        } catch (\Exception $e) {
            echo "Erreur lors de l'ajout du projet : " . htmlspecialchars($e->getMessage());
            exit;
        }

        $this->_display("projectForm/newProjectForm");

    }

    public function detailedAnalysis()
    {
        // require_once("Views/partials/header.php");
        // include("Views/projectForm/detailedAnalysisForm.php");
        // require_once("Views/partials/footer.php");
    }
}
