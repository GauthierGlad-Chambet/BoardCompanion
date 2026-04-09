<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController;

class ErrorsController extends MotherController
{

    /**
     * Page d'erreur 404
     * @return void
     */
    public function error_404()
    {
        // Variables du head
        $this->_arrData['strTitle']        = "Erreur 404";
        $this->_arrData['strMetaDesc']     = "Erreur 404";

        $this->_display("errors/error_404", false);
    }

    /**
     * Page d'erreur 403
     * @return void
     */
    public function error_403()
    {
        // Création des variables du head
        $this->_arrData['strTitle']        = "Erreur 403";
        $this->_arrData['strMetaDesc']     = "Erreur 403";

        $this->_display("errors/error_403", false);
        
    }
}
