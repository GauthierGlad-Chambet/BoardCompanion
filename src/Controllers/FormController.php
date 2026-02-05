<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Entities\Project;
use GauthierGladchambet\BoardCompanion\Entities\Sequence;
use GauthierGladchambet\BoardCompanion\Models\ProjectModel;
use GauthierGladchambet\BoardCompanion\Models\SequenceModel;


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

            // Récupérer l'identifiant utilisateur de la session ou la valeur par défaut 1 si non défini.
            $userId = $_SESSION['user']['id'];
            $project->setUser($userId);

            try {
                $newProjectModel = new ProjectModel();
                $idProject = $newProjectModel->addProject($project);
                $project->setId($idProject);

                // Commpte le nombre de pages du PDF et l'ajoute à l'entité Project
                if (isset($scriptFilePath)) {
                    // Utilisation de smalot/pdfparser pour extraire les détails du PDF, notamment le nombre de pages
                    try {
                        // Créer une instance du parser et analyser le fichier PDF
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile($project->getScriptFilePath());
                        $metaData = $pdf->getDetails();
                        if (isset($metaData['Pages'])) {
                            $project->setNbTotalPages(intval($metaData['Pages'])-1);
                            $newProjectModel->updateNbPagesProject($project);
                        }
                    } catch (\Exception $e) {
                        echo "Erreur lors de la lecture du PDF : " . htmlspecialchars($e->getMessage());
                        exit;
                    }
                }

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

    // Nettoyage du texte extrait du PDF pour supprimer les en-têtes, pieds de page, autres éléments répétitifs, numéros en trop, caractères spéciaux, ...
    public function cleanPDF($text) {
        $lines = explode("\n", $text);
        
        // Séparer les lignes courtes et longues
        $longLines = [];
        
        // Identifier les lignes longues et les stocker avec leur index
        foreach ($lines as $index => $line) {
            $trimmedLine = trim($line);
            if (empty($trimmedLine)) continue;
            
            if (strlen($trimmedLine) > 15) { // Seuil de longueur pour considérer une ligne comme "longue"
                $longLines[$index] = $trimmedLine;
            }
        }
        
        // Détecter uniquement les lignes LONGUES similaires
        $linesToRemove = [];
        $similarGroups = $this->findSimilarLongLines($longLines);
        // Seules les lignes longues qui se répètent plus de 2 fois sont considérées comme des éléments à supprimer
        $threshold = 2;
        
        // Marquer les indices des lignes longues similaires qui dépassent le seuil pour suppression
        foreach ($similarGroups as $group) {
            if (count($group) > $threshold) {
                $linesToRemove = array_merge($linesToRemove, $group);
            }
        }
        
        // Construire le texte nettoyé
        $cleanedLines = [];
        foreach ($lines as $index => $line) {
            $trimmedLine = trim($line);
            
            // Ignorer les lignes vides
            if (empty($trimmedLine)) continue;
            
            // Ignorer uniquement si c'est une ligne longue marquée pour suppression
            if (in_array($index, $linesToRemove)) continue;
            
            // Garder TOUTES les lignes courtes (même répétitives)
            $cleanedLines[] = $line;
        }

        $text = implode("\n", $cleanedLines);

        // Supprimer tous les astérisques
        $text = str_replace('*', '', $text);

        // Suppression des lignes type "1    1", "14   14"
        $text = preg_replace('/^(\d+)\s+\1\s*$/m', '', $text);

        // Nettoyer les lignes vides multiples
        $text = preg_replace('/\n\s*\n+/', "\n\n", $text);

        // Supprimer les espaces en début et fin de texte
        return trim($text);
    }


    // Trouver les groupes de lignes longues similaires
    private function findSimilarLongLines($longLines) {
        $groups = [];
        $processed = [];
        
        // Obtenir les indices des lignes longues
        $indices = array_keys($longLines);
        
        // Comparer chaque ligne longue avec les autres pour trouver des groupes de lignes similaires
        foreach ($indices as $i) {

            // Si cette ligne a déjà été traitée dans un groupe, la sauter
            if (isset($processed[$i])) continue;
            
            $line1 = $longLines[$i];
            $similarIndices = [$i];
            
            // Comparer avec toutes les autres lignes longues
            foreach ($indices as $j) {
                if ($i === $j || isset($processed[$j])) continue;
                
                $line2 = $longLines[$j];
                
                // Calculer la similarité
                if ($this->areLinesimilar($line1, $line2)) {
                    $similarIndices[] = $j;
                    $processed[$j] = true;
                }
            }
            
            // Si ce groupe de lignes similaires contient plus d'une ligne, le conserver
            if (count($similarIndices) > 1) {
                $groups[] = $similarIndices;
            }
            
            $processed[$i] = true;
        }
        
        return $groups;
    }

    // Déterminer si deux lignes sont similaires en utilisant une combinaison de normalisation et de calcul de similarité
                                                    // $threshold indique le pourcentage de similarité requis
    private function areLinesimilar($line1, $line2, $threshold = 0.9) {
        
        // Méthode 2 : Calculer le pourcentage de similarité
        similar_text($line1, $line2, $percent);
        
        return ($percent / 100) >= $threshold;
    }

    // Extraction des séquences à partir du texte nettoyé, en se basant sur les mots-clés "INT.", "EXT.", "I/E" et en récupérant les 8 lignes suivantes
    public function extractSequences($text) {
        $lines = explode("\n", $text);
        $extracts = [];
        $keywords = ['INT.', 'EXT.', 'I/E', 'SEQ'];

        $currentSequence = null;

        // Parcourir chaque ligne du texte
        for ($i = 0; $i < count($lines); $i++) {
            $line = trim($lines[$i]);

            // Vérifier si la ligne contient un des mots-clés
            $isKeywordLine = false;
            foreach ($keywords as $keyword) {
                if (stripos($line, $keyword) !== false) {
                    $isKeywordLine = true;
                    break;
                }
            }

            // Si la ligne contient un mot-clé, démarrer une nouvelle séquence
            if ($isKeywordLine) {
                // Si une séquence est en cours, la terminer
                if ($currentSequence) {
                    $currentSequence['line_count'] = count($currentSequence['content']);
                    $extracts[] = $currentSequence;
                }

                // Démarrer une nouvelle séquence
                $currentSequence = [
                    'keyword' => $keyword,
                    'line_number' => $i + 1,
                    'header' => $line,
                    'content' => []
                ];
            } elseif ($currentSequence) {
                // Ajouter la ligne à la séquence en cours
                if (!empty($line)) {
                    $currentSequence['content'][] = $line;
                }
            }
        }

        // Ajouter la dernière séquence si elle existe
        if ($currentSequence) {
            $currentSequence['line_count'] = count($currentSequence['content']);
            $extracts[] = $currentSequence;
        }

        return $extracts;
    }

    // Récupère les séquences assignées depuis la bdd, compte le nombre total de lignes et
    // calcule combien ça représente de pages en supposant qu'une page contient 33 lignes en moyenne
    public function countAssignedPages(int $projectId) {
            $sequenceModel = new SequenceModel();
            $assignedSequences = $sequenceModel->findSequencesByProjectId($projectId);
                $totalLines = 0;
                foreach ($assignedSequences as $seq) {
                    $scriptContent = json_decode($seq['script'], true);
                    if (is_array($scriptContent)) {
                        $totalLines += count($scriptContent);
                    }
                }
                $totalAssignedPages = ceil($totalLines / 33); // En supposant 33 lignes par page

            return $totalAssignedPages;   
    }

    // Fonction d'estimation du temps de cleaning : si is_cleaning est true,
    // alors on estime que le temps de cleaning est égal à ???? 

    // Fonction d'estimation de la durée total pour boarder le projet
    // Si pas d'analyse détaillée on prend en paramètre nb_total_pages de la bdd,
    // sinon on prend en paramètre nb_assigned_pages
    //on calcule ????

    // Fonction de pages/jour recommandées
    


                
    // Affichage du formulaire d'analyse détaillée, en passant le texte extrait et les en-têtes de scènes à la vue
    public function detailedAnalysis(){
        require_once __DIR__ . '/../../vendor/autoload.php';

        $scriptPath = new ProjectModel();
        $scriptPath = $scriptPath->findLastScriptPath();

        if (!$scriptPath || !file_exists($scriptPath)) {
            echo "Fichier PDF introuvable.";
            exit;
        }

        if (isset($_POST['submit_sequences'])) {
            // Récupérer l'ID du projet
            $projectId = $_POST['project_id'] ?? null;
            if (!$projectId) {
                echo "ID du projet manquant.";
                exit;
            }

            // Traiter les données du formulaire ici
            foreach ($_POST as $key => $value) {
                // Identifier les champs de type de séquence en utilisant le préfixe "typeSequence_"
                if (strpos($key, 'typeSequence_') === 0) {
                    // Extraire l'index de la séquence à partir du nom du champ
                    $index = str_replace('typeSequence_', '', $key);
                    $typeSequence = $value;
                    $isAssigned = (int) ($_POST['is_assigned_' . $index] ?? 0);

                    // Récupérer le contenu de la séquence
                    $sequenceContent = $_POST['sequence_content_' . $index] ?? '[]';
                    $sequenceContent = json_decode($sequenceContent, true);

                    // Convertir le contenu en JSON pour le stockage
                    $sequenceContentJson = json_encode($sequenceContent);

                    // Enregistrer ces informations dans la base de données
                    $sequence = new Sequence();
                    $sequence->setType($typeSequence);
                    $sequence->setIsAssigned($isAssigned);
                    $sequence->setScript($sequenceContentJson); // Stocker en tant que JSON
                    $sequence->setProject($projectId);

                    $sequenceModel = new SequenceModel();
                    $sequenceModel->addSequence($sequence);
                }
            }
            
                $project = new Project();
                $project->setId($projectId);
                $project->setNbAssignedPages($this->countAssignedPages($projectId));
                
                $projectModel = new ProjectModel();
                $projectModel->updateNbPagesAssignedProject($project);

            header("Location: index.php");
        } else {
            // Utilisation de smalot/pdfparser pour extraire le texte du PDF
        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($scriptPath);
            $text = $pdf->getText();

            // Nettoyage du texte pour supprimer les éléments répétitifs, les numéros en trop, les caractères spéciaux, etc.
            $text = $this->cleanPDF($text);

            // Extraction des séquences
            $sequences = $this->extractSequences($text);

            // Récupérer l'ID du dernier projet ajouté
            $projectModel = new ProjectModel();
            $projectId = $projectModel->findLastProjectId();

            // Passer à la vue
            $data = [
                'extractedText' => $text,
                'sequenceHeaders' => $sequences,
                'projectId' => $projectId
            ];
            $this->_display("projectForm/detailedAnalysisForm", true, $data);
        } catch (\Exception $e) {
            echo "Erreur : " . $e->getMessage();
            exit;
        }
        }
    }

}
