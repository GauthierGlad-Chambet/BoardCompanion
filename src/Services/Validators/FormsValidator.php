<?php

namespace GauthierGladchambet\BoardCompanion\Services\Validators;

use DateTime;
use finfo;

class FormsValidator {

    //Vérifier si le champ n'est pas vide
    public function validerChamp($champ) {
            if (empty($champ)) {
                return "Ce champ est obligatoire.";
            }
            return null;
        }

    //Vérifier si le champ 'numéro d'épisode' est au bon format XXX
    public function validerNumEp($numEp) {
        if (empty($numEp)) {
                return "Ce champ est obligatoire.";
        } else if (!preg_match('/^\d{3,7}$/', $numEp)) {
            return "Ce champ doit correpondre au format 'NumSaisonNumEpisode'.";
        }
        return null;
    }

    //Vérifier si le champ contient bien un entier positif
    public function verifierPredec($predec) {
        if (empty($predec)) {
                return "Ce champ est obligatoire.";
        } else if (filter_var($predec, FILTER_VALIDATE_INT) !== false && $predec <= 0) {
            return "Ce champ attend un nombre entier positif.";
        }
        return null;
    }

    //Vérifier si un des boutons radio d'un choix binaire est coché
    public function verifierRadio($radio) {
        if ($radio !== '0' && $radio !== '1') {
            return "Veuillez cocher une case.";
        }
        return null;
    }

     //Vérifier si un des boutons radio du formulaire d'analyse détaillée est coché
    public function verifierRadioDetailed($radio) {
        if ($radio !== 'Action' && $radio !== 'Comedie' && $radio !== 'Mixte' && $radio !== 'Indetermine') {
            return "Veuillez cocher une case.";
        }
        return null;
    }

    public function verifierDates($dateBegin,$dateEnd) {
        if (empty($dateBegin) || empty($dateEnd)) {
            return "Veuillez entrer des dates de début et de fin de projet.";
        }

        $dateBeginFormated = new DateTime($dateBegin);
        $dateEndFormated   = new DateTime($dateEnd);
        
        if ($dateBeginFormated >= $dateEndFormated) {
            return "La date de fin ne peut pas se situer avant ou à la date de début.";
        }
        return null;
    }

    //Vérifier existance et format du fichier de script
    public function verifierScript($script) {
        //On vérifie si le champ de script existe
        if (empty($script['name'])) {
            return "Un script au format .pdf est obligatoire.";
        // On vérifie qu'aucune erreur ne se produit lors du chargement
        } else if ($script['error'] !== UPLOAD_ERR_OK) {
            return "Erreur lors de l'envoi du fichier.";
        }
        // On créé un objet finfo qui est un analyseur du type de fichier
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        // On demande le type du fichier qui a été uploadé indépendament de ce qu'envoie le navigateur (falsifiable)
        $mimeType = $finfo->file($script['tmp_name']);
        // On récupère l'extension du fichier
        $extension = pathinfo($script['name'], PATHINFO_EXTENSION);
        // application/pdf est le type MIME officiel pour les PDF
        if ($mimeType !== 'application/pdf' || strtolower($extension) !== 'pdf') {
            return "Un script au format .pdf est obligatoire.";
        }
        return null;
    }

    //Vérifier format du fichier de template
    // Cela ne fonctionnera pas si le fichier php.ini n'est pas correctement configuré ;
    // il faut configurer upload_max_filesize, post_max_size et memory_limit.
    public function verifierTemplate($template) {
        //Le fichier de template n'est pas obligatoire
        if (empty($template['name'])) {
            return null;
        }
         // On vérifie qu'aucune erreur ne se produit lors du chargement
        if ($template['error'] !== UPLOAD_ERR_OK) {
            return "Erreur lors de l'envoi du fichier.";
        }

        // On créé un objet finfo qui est un analyseur du type de fichier
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        // On demande le type du fichier qui a été uploadé indépendament de ce qu'envoie le navigateur (falsifiable)
        $mimeType = $finfo->file($template['tmp_name']);
        // On récupère l'extension du fichier
        $extension = pathinfo($template['name'], PATHINFO_EXTENSION);

        if (
            ($mimeType !== 'image/vnd.adobe.photoshop' && $mimeType !== 'application/octet-stream')
            ||
            (strtolower($extension) !== 'psd' && strtolower($extension) !== 'sbbkp')
           ) {
            return "Le fichier doit être un PSD ou un SBBKP.";
        }
        return null;
    }

    
}