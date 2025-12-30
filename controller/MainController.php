<?php

    class MainController {

        // Show home page
        public function home() {
            require_once("view/partials/header.php");
            include("view/main/home.php");
            require_once("view/partials/footer.php");
        }

        // Show signUp/signIn page
        public function signIn() {
            require_once("view/partials/header.php");
            include("view/main/signIn.php");
            require_once("view/partials/footer.php");
        }

      
    }