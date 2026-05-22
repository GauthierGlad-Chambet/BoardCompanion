<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController;

class MainController extends MotherController
{

    public function home()
    {
        // Variables du head
        $this->_arrData['strTitle']        = "BoardCompanion";
        $this->_arrData['strMetaDesc']     = "Gérez facilement vos projets avec Board Companion : organisation, suivi et progression réunis dans une interface simple, efficace et immersive.";

        // Message de la mascotte
        $this->_arrData['msgBoardy']     = "Bonjour {$_SESSION['user']['pseudo']}, comment vas-tu ?";

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

        // Variables du head
        $this->_arrData['strTitle']        = "Mentions légales | BoardCompanion";
        $this->_arrData['strMetaDesc']     = "Mentions légales de BoardCompanion : informations sur l'éditeur, l'hébergeur, protection des données personnelles et conditions d'utilisation.";

        // Message de la mascotte
        $this->_arrData['msgBoardy']     = "Rien que du légal par ici !";

        //Check si l'utilisateur est connecté pour afficher le header ou non
        if (empty($_SESSION)) {
            $this->_display("legals", false);
            exit;
        }

        $this->_display("legals");
    }
}
