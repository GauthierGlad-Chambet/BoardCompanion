<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController;

class MainController extends MotherController
{
    
    public function home()
    {
        
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
        }

        
        $this->_display("home");
    }
}
