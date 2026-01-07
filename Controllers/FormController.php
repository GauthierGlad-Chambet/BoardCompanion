<?php
namespace App\Controllers;

    class FormController {

        public function newProject() {
            require_once("view/partials/header.php");
            include("view/main/newProjectForm.php");
            require_once("view/partials/footer.php");
        }

        public function detailedAnalysis() {
            require_once("view/partials/header.php");
            include("view/main/detailedAnalysisForm.php");
            require_once("view/partials/footer.php");
        }
    }