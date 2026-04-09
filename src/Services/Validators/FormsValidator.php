<?php

namespace GauthierGladchambet\BoardCompanion\Services\Validators;

use DateTime;
use finfo;

class FormsValidator {

    //Vérifier si le champ n'est pas vide
    public function validerChamp($champ) {
            if (empty($champ)) {
                return "Ce champ est obligatoire.";
            } else if (strlen($champ) > 50) {
                return "Ce champ ne peut excéder 50 caractères.";
            }
            return null;
        }

    //Vérifier si le champ 'numéro d'épisode' est au bon format XXX
    public function validerNumEp($numEp) {
        if (empty($numEp)) {
                return "Ce champ est obligatoire.";
        } else if (!preg_match('/^\d{3,7}$/', $numEp)) {
            return "Ce champ doit correpondre au format 'NumSaisonNumEpisode'.";
        } else if (strlen($numEp) > 10) {
                return "Ce champ ne peut excéder 10 caractères.";
            }
        return null;
    }

    //Vérifier si le champ contient bien un entier positif
    public function verifierInputNumber($number) {
        if (empty($number)) {
                return "Ce champ est obligatoire.";
        } else if (filter_var($number, FILTER_VALIDATE_INT) !== false && $number <= 0) {
            return "Ce champ attend un nombre entier positif.";
        }
        return null;
    }

    //Vérifier si le champ contient bien un entier positif, version champ optionnel
    public function verifierInputNumberOptionnel($number) {
        //Le champ n'est pas obligatoire
        if (empty($number)) {
            return null;
        }
        if (filter_var($number, FILTER_VALIDATE_INT) !== false && $number <= 0) {
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

    //Vérifier si un des boutons radio du formulaire de bilan final est coché
    public function verifierRadioFinalReport($radio) {
        if ($radio < 1 || $radio > 4) {
            return "Veuillez sélectionner une appréciation.";
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

    //Vérifier si la durée du cleaning est inférieure à la durée totale et si le champ contient bien un entier positif
    public function verifierDureeCleaning($dureeCleaning, $dureeTotale) {
        if (empty($dureeCleaning)) {
                return null;
        } else if (filter_var($dureeCleaning, FILTER_VALIDATE_INT) !== false && $dureeCleaning <= 0) {
            return "Ce champ attend un nombre entier positif.";
        } else if ($dureeCleaning >= $dureeTotale) {
            return "La durée du cleaning ne peut pas être supérieure à la durée totale du projet.";
        }
        return null;
    }

    //Vérifier si le champ contient bien un entier positif
    public function verifierDureeSequence($dureeSequence) {
        if (empty($dureeSequence)) {
                return null;
        } else if (filter_var($dureeSequence, FILTER_VALIDATE_FLOAT) !== false && $dureeSequence <= 0) {
            return "Ce champ attend un nombre positif.";
        }
        return null;
    }

}