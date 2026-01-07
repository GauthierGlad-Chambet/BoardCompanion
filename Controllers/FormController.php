<?php

namespace App\Controllers;

class FormController extends MainController
{

    public function newProject()
    {
        // require_once("Views/partials/header.php");
        // include("Views/projectForm/newProjectForm.php");
        // require_once("Views/partials/footer.php");

        $this->_display("projectForm/newProjectForm");
    }

    public function detailedAnalysis()
    {
        // require_once("Views/partials/header.php");
        // include("Views/projectForm/detailedAnalysisForm.php");
        // require_once("Views/partials/footer.php");
    }
}
