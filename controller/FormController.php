<?php

    class FormController {

        // Afficher l'écran de partie solo
        public function newProject() {
            require_once("view/partials/header.php");
            include("view/main/newProjectForm.php");
            require_once("view/partials/footer.php");
        }
    }