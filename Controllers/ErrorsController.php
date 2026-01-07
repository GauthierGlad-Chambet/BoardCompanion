<?php

namespace App\Controllers;

use App\Controllers\MainController;

class ErrorsController extends MainController
{

    /**
     * Page d'erreur 404
     * @return void
     */
    public function error_404()
    {
        // Création des variables d'affichage
        $this->_arrData['strTitle']        = "Erreur 404";
        $this->_arrData['strH1']         = "Erreur 404";
        $this->_arrData['strMetaDesc']     = "Erreur 404";
        $this->_arrData['strDesc']        = "La page n'existe pas";

        // Variable technique
        $this->_arrData['strPage']        = "error_404";

        $this->_display("errors/error_404");
    }

    /**
     * Page d'erreur 403
     * @return void
     */
    public function error_403()
    {
        // Création des variables d'affichage
        $this->_arrData['strTitle']        = "Erreur 403";
        $this->_arrData['strH1']        = "Erreur 403";
        $this->_arrData['strMetaDesc']     = "Erreur 403";
        $this->_arrData['strDesc']        = "Vous devez vous connecter pour accéder à ces informations";

        // Variable technique
        $this->_arrData['strPage']        = "error_403";

        $this->_display("errors/error_403");
    }
}
