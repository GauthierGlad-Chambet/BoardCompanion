<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController;

class MainController extends MotherController
{
    
    public function home()
    {
        
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: /BoardCompanion/connexion");
            exit;
        }

        // Ajoute une classe css pour gérer les pages qui ont un titre court
        $this->_arrData['pageClass'] = 'page-title-nowrap';
        $this->_display("home");
    }

    public function legals()
    {
        
        //Check si l'utilisateur est connecté pour afficher le header ou non
        if (empty($_SESSION)) {
            $this->_display("legals", false);
            exit;
        }

        $this->_display("legals");
        
    }
}
