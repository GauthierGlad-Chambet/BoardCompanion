<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Entities\Project;
use GauthierGladchambet\BoardCompanion\Models\ProjectModel;

class FormController extends MotherController {

    public function newProject() {
        
        if(count($_POST) > 0){

            $name               =trim($_POST['name']??'');    //La fonction trim supprime les caractères invisibles comme les espaces, avant et après le texte.
            $studio             =trim($_POST['studio']??'');
            $episodeNb          =trim($_POST['episode_nb']??'');
            $episodeTitle       =trim($_POST['episode_title']??'');
            $dateBegin          =$_POST['date_begin']??'';
            $dateEnd            =$_POST['date_end']??'';
            $nbPredecs          =$_POST['nb_predec']??'';
            $isCleaning         =$_POST['is_cleaning']??'';
            $isAlone            =$_POST['is_alone']??'';
            $script_detailed    =$_POST['script_detailed']??'';

            //si le champ de script existe et qu'aucune erreur ne se produit lors du chargement
            if (isset($_FILES['script']) && $_FILES['script']['error'] === 0) {

            // application/pdf is the official MIME type for PDF
            $allowedTypes = ['application/pdf'];
            //Si le type de fichier est correct, continuez ; sinon, arrêtez-vous et affichez un message d'erreur.
            if (!in_array($_FILES['script']['type'], $allowedTypes)) {
                die('Le fichier doit être un PDF.');
            }


            //obtenir le nom original du fichier
            $originalName = $_FILES['script']['name'];

            //PATHINFO_EXTENSION collect the extension of the file
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);

            //uniqid génère un numéro unique juste après 'script_', concaténé avec l'extension du fichier
            $newFileName = uniqid('script_') . '.' . $extension;

            //pour construire le chemin réel du fichier, en commençant par le répertoire courant
            $uploadDir = __DIR__ . '/../../uploads/scripts/';

            // the place where the file will be saved
            $destination = $uploadDir . $newFileName;

            //move_uploaded_file Déplacer le fichier de l'emplacement temporaire vers la destination
            move_uploaded_file($_FILES['script']['tmp_name'], $destination);
            $scriptFilePath    =realpath($destination);
            }

            // Cela ne fonctionnera pas si le fichier php.ini n'est pas correctement configuré ; il faut configurer upload_max_filesize, post_max_size et memory_limit.
            if (isset($_FILES['template']) && $_FILES['template']['error'] === 0) {
                $allowedTypes = ['image/vnd.adobe.photoshop','application/octet-stream'];
                if (!in_array($_FILES['template']['type'], $allowedTypes)) {
                    die('Le fichier doit être un PSD ou un SBBKP.');
                }
                $originalName = $_FILES['template']['name'];
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $newFileName = uniqid('template_') . '.' . $extension;
                $uploadDir = __DIR__ . '/../../uploads/templates/';
                $destination = $uploadDir . $newFileName;
                move_uploaded_file($_FILES['template']['tmp_name'], $destination);
                $templateFilePath   = realpath($destination);
            }

            $project = new Project();
            $project->setName($name);
            $project->setStudio($studio);
            $project->setEpisodeNb($episodeNb);
            $project->setEpisodeTitle($episodeTitle);
            $project->setDateBegin($dateBegin);
            $project->setDateEnd($dateEnd);
            $project->setNbPredecs(intval($nbPredecs));
            $project->setIsCleaning($isCleaning);
            $project->setIsAlone($isAlone);
            if (isset($scriptFilePath)) {
                $project->setScriptFilePath($scriptFilePath);
            }
            if (isset($templateFilePath)) {
                $project->setTemplateFilePath($templateFilePath);
            }

            // Get the user ID from session or default to 1 if not set
            $userId = $_SESSION['user']['id'];
            // Assuming you have a method to set the user in Project entity
            // You would need to inject the user object into the project entity
            // For now, we'll just set the user ID directly
            $project->setUser($userId);

            // Save the project using the model
            try {
                $newProjectModel = new ProjectModel();
                $newProjectModel->addProject($project);
                echo "Projet ajouté avec succès.";
                if($script_detailed === 'oui'){
                    header("Location: index.php?controller=form&action=detailedAnalysis");
                    }
            } catch (\Exception $e) {
                echo "Erreur lors de l'ajout du projet : " . htmlspecialchars($e->getMessage());
                exit;
            }

            
        }
            $this->_display("projectForm/newProjectForm");
        
    }

    public function cleanPDF($text) {

        $lines = explode("\n", $text);
    
        // Compter les occurrences de chaque ligne
        $lineCount = array_count_values(array_map('trim', $lines));
        
        // Définir un seuil : si une ligne apparaît plus de X fois, c'est probablement un en-tête/pied
        $threshold = 2;
        
        $cleanedLines = [];
        foreach ($lines as $line) {
            $trimmedLine = trim($line);
            
            // Ignorer les lignes vides
            if (empty($trimmedLine)) continue;
            
            // Ignorer les lignes qui se répètent trop souvent
            if (isset($lineCount[$trimmedLine]) && $lineCount[$trimmedLine] > $threshold) {
                continue;
            }
            
            $cleanedLines[] = $line;
        }
    
        $text = implode("\n", $cleanedLines);

        // Supprimer tous les astérisques
        $text = str_replace('*', '', $text);

        // Suppression des lignes type "1    1", "14   14"
        $text = preg_replace('/^(\d+)\s+\1\s*$/m', '', $text);

        // Nettoyer les lignes vides multiples
        $text = preg_replace('/\n\s*\n+/', "\n\n", $text);

        return trim($text);
    }

    public function extractSequences($text) {
        $lines = explode("\n", $text);
        $extracts = [];
        $keywords = ['INT.', 'EXT.', 'I/E'];
        
        for ($i = 0; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            
            // Vérifier si la ligne contient un des mots-clés
            foreach ($keywords as $keyword) {
                if (stripos($line, $keyword) !== false) {
                    // Récupérer les 8 lignes suivantes
                    $extract = [];
                         
                    // Ajouter les 8 lignes suivantes
                    for ($j = 1; $j <= 8 && ($i + $j) < count($lines); $j++) {
                        $nextLine = trim($lines[$i + $j]);
                        if (!empty($nextLine)) { // Ignorer les lignes vides
                            $extract[] = $nextLine;
                        }
                    }
                    
                    $extracts[] = [
                        'keyword' => $keyword,
                        'line_number' => $i + 1,
                        'header' => $line,
                        'content' => $extract
                    ];
                    
                    break; // Passer à la ligne suivante
                }
            }
        }

        return $extracts;
    }


// ----------------- DIRE QUE JE VEUX SUPPRIMER QUE LES LIGNES QUI SE REPETENT QUI FONT UNE CERTAINE LONGUEUR ----------------- //
                                             // POUR RETROUVER LES NOMS DES PERSOS //



    public function detailedAnalysis(){
        require_once __DIR__ . '/../../vendor/autoload.php';

        $scriptPath = new ProjectModel();
        $scriptPath = $scriptPath->findLastScriptPath();

         if (!$scriptPath || !file_exists($scriptPath)) {
        echo "Fichier PDF introuvable.";
        exit;
        }

        try {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($scriptPath);
        $text = $pdf->getText();

        $text = $this->cleanPDF($text);

        // Extraction des séquences
        $sequences = $this->extractSequences($text);

        // Passer à la vue
        $data = [
            'extractedText' => $text,
            'sceneHeaders' => $sequences
        ];
        $this->_display("projectForm/detailedAnalysisForm", true, $data);
        
    } catch (\Exception $e) {
        echo "Erreur : " . $e->getMessage();
        exit;
    }
}

        // $scriptPath = str_replace('\\', '/', $scriptPath);
        // $cmd = 'pdftotext -enc UTF-8 ' . $scriptPath . ' -';
        
        
        // // Construction de la commande
        // // $cmd = 'pdftotext -enc UTF-8 ' . escapeshellarg($scriptPath) . ' -';
        // var_dump($cmd);

        // // PHP lance une procédure système pour exécuter la commande pdftotext
        // exec($cmd, $output, $returnCode);

        // // Vérification
        // if ($returnCode !== 0) {
        //     echo "Une erreur est survenue lors de l'analyse détaillée du script.";
        //     exit;
        // }

        // // La sortie de la commande est capturée dans le tableau $output
        // // Le texte complet du PDF est maintenant dans la variable $text
        // $text = implode("\n", $output);

        // // var_dump($text);die;

        // $this->_display("projectForm/detailedAnalysisForm");

    // }
}
