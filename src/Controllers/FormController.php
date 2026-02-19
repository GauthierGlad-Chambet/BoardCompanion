<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController; 
use GauthierGladchambet\BoardCompanion\Entities\Project;
use GauthierGladchambet\BoardCompanion\Entities\Sequence;
use GauthierGladchambet\BoardCompanion\Models\ProjectModel;
use GauthierGladchambet\BoardCompanion\Models\SequenceModel;
use GauthierGladchambet\BoardCompanion\Models\UserModel;
use GauthierGladchambet\BoardCompanion\Models\UserStatByTypeModel;


class FormController extends MotherController {

    public function newProject() {

    //Check si l'utilisateur est connecté, sinon renvoie à la page login
    if (empty($_SESSION)) {
        header("Location: index.php?controller=user&action=login");
    }

    $flag = false;
        
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
            $project->setEpisode_nb($episodeNb);
            $project->setEpisode_title($episodeTitle);
            $project->setDate_beginning($dateBegin);
            $project->setDate_end($dateEnd);
            $project->setNb_predecs(intval($nbPredecs));
            $project->setIs_cleaning($isCleaning);
            $project->setIs_alone($isAlone);

            if (isset($scriptFilePath)) {
                $project->setScript_path($scriptFilePath);
            }

            if (isset($templateFilePath)) {
                $project->setTemplate_path($templateFilePath);
            }

            // Récupérer l'identifiant utilisateur de la session ou la valeur par défaut 1 si non défini.
            $userId = $_SESSION['user']['id'];
            $project->setFk_user($userId);

            try {
                $newProjectModel = new ProjectModel();
                $idProject = $newProjectModel->addProject($project);
                $project->setId($idProject); // Assigner l'ID généré à l'entité Project pour les étapes suivantes
                $project->getEstimated_cleaning_duration();
                

                // Commpte le nombre de pages du PDF et l'ajoute à l'entité Project
                if (isset($scriptFilePath)) {
                    // Utilisation de smalot/pdfparser pour extraire les détails du PDF, notamment le nombre de pages
                    try {
                        // Créer une instance du parser et analyser le fichier PDF
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile($project->getScript_path());
                        $metaData = $pdf->getDetails();
                        if (isset($metaData['Pages'])) {
                            $project->setNb_total_pages(intval($metaData['Pages'])-1);
                            $project->setNb_assigned_pages(intval($metaData['Pages'])-1);
                            $newProjectModel->updateNbPagesProject($project);
                            
                            $project->setEstimated_total_duration($this->estimateTotalDuration($project, $flag));
                            $newProjectModel->updateTotalDurationProject($project);

                            $project->setRecommended_pages_per_day($this->estimateRecommendedPagesPerDay($project, $flag));
                            $newProjectModel->updateRecommendedPagesPerDayProject($project);

                        }
                    } catch (\Exception $e) {
                        echo "Erreur lors de la lecture du PDF : " . htmlspecialchars($e->getMessage());
                        exit;
                    }
                }

                echo "Projet ajouté avec succès.";
                if($script_detailed === 'oui'){
                    header("Location: index.php?controller=form&action=detailedAnalysis");
                } else {
                    header("Location: index.php?controller=statistics&action=dashboard");
                }
            } catch (\Exception $e) {
                echo "Erreur lors de l'ajout du projet : " . htmlspecialchars($e->getMessage());
                exit;
            }

            
        }
        
        $this->_display("projectForm/newProjectForm");
        
    }

    // Affichage du formulaire d'analyse détaillée, en passant le texte extrait et les en-têtes de scènes à la vue
    public function detailedAnalysis(){

        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
        }

        $flag = true;

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
                    
                    // Si le type de séquence est "action" insérer 1
                    if ($value === 'Action') {
                        $typeSequence = 1;
                    } elseif ($value === 'Comedie') {
                        $typeSequence = 2;
                    } else {
                        $typeSequence = 3;
                    }

                    $isAssigned = (int) ($_POST['is_assigned_' . $index] ?? 0);

                    //récupérer le titre de la séquence
                    $sequenceHeader = $_POST['sequence_header_' . $index] ?? 'Séquence sans titre';

                    // Récupérer le contenu de la séquence
                    $sequenceContent = $_POST['sequence_content_' . $index] ?? '[]';
                    $sequenceContent = json_decode($sequenceContent, true);

                    // Convertir le contenu en JSON pour le stockage
                    $sequenceContentJson = json_encode($sequenceContent);

                    // Enregistrer ces informations dans la base de données
                    $sequence = new Sequence();
                    $sequence->setNumber($index + 1);
                    $sequence->setTitle($sequenceHeader);
                    $sequence->setFk_type($typeSequence);
                    $sequence->setIs_assigned($isAssigned);
                    $sequence->setScript($sequenceContentJson); // Stocker en tant que JSON
                    $sequence->setLines_count(count($sequenceContent)); // Stocker le nombre de lignes de la séquence
                    $sequence->setDuration_estimated($this->estimateDurationBySequence($sequence)); // Estimer la durée de boarding de la séquence
                    $sequence->setFk_project($projectId);

                    $sequenceModel = new SequenceModel();
                    $sequenceModel->addSequence($sequence);
                }
            }

                $project = new Project();
                $project->setId($projectId);

                //récupérer les attributs du projets en bdd en fonction de l'ID
                $projectModel = new ProjectModel();
                $projectData = $projectModel->getProjectById($projectId);

                $project->setIs_cleaning($projectData['is_cleaning']);
                $project->setNb_total_pages($projectData['nb_total_pages']);
                $project->setDate_beginning($projectData['date_beginning']);
                $project->setDate_end($projectData['date_end']);

                $project->setNb_assigned_pages($this->countAssignedPages($projectId));
                $project->setEstimated_cleaning_duration($this->estimateCleaningDuration($project));
                $project->setEstimated_total_duration($this->estimateTotalDuration($project, $flag));
                $project->setRecommended_pages_per_day($this->estimateRecommendedPagesPerDay($project, $flag));
                
                $projectModel->updateNbPagesAssignedProject($project);
                $projectModel->updateAvgCleaningProject($project);
                $projectModel->updateTotalDurationProject($project);
                $projectModel->updateRecommendedPagesPerDayProject($project);
                

            header("Location: index.php?controller=statistics&action=details&project_id=" . $project->getId());
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
        // Seules les lignes longues qui se répètent plus de 3 fois sont considérées comme des éléments à supprimer
        $threshold = 3;
        
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

            // Vérifier si la ligne commence par un des mots-clés
            $isKeywordLine = false;

            // foreach ($keywords as $keyword) {
            //     if (stripos($line, $keyword) !== false) {
            //         $isKeywordLine = true;
            //         break;
            //     }
            
            foreach ($keywords as $keyword) {
                if (preg_match('/^\s*' . preg_quote($keyword, '/') . '/i', $line)) {
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
            $assignedSequences = $sequenceModel->findAllSequencesByProjectId($projectId);
                $totalLines = 0;
                foreach ($assignedSequences as $seq) {
                    $sequence = New Sequence();
                    // On ne compte que les lignes des séquences assignées
                    if (isset($seq['is_assigned']) && $seq['is_assigned'] == 1) {
                    $sequence->setLines_count($seq['lines_count']);
                    $totalLines += $sequence->getLines_count();
                    }
                }
                $totalAssignedPages = round(($totalLines / 33),1); // En moyenne 33 lignes par page, arrondi à 1 décimale pour plus de lisibilité

            return $totalAssignedPages;   
    }


    // Fonction d'estimation du temps de cleaning :
    // si is_cleaning est true on multiplie le nombre de pages assignées par avg_cleaning_duration de l'utilisateur
    public function estimateCleaningDuration(Project $project) {
        if ($project->getIs_cleaning()) {
            // Récupérer les informations de l'utilisateur à partir de la base de données en fonction de son ID en session
            $userModel = new UserModel();
            $userData = $userModel->findById($_SESSION['user']['id']);

            // Estimation du temps de cleaning en fonction du nombre de pages assignées
            $assignedPages = $project->getNb_assigned_pages();
            $cleaningDuration = $assignedPages * ($userData['avg_cleaning_duration']); // de base, 0.2 jour par  par page assignée
            return $cleaningDuration;
        }
        return 0; // Pas de cleaning nécessaire
    }


    // Fonction d'estimation de la durée total pour boarder le projet
    public function estimateTotalDuration(Project $project, bool $flag) {
        // Récupérer les informations de l'utilisateur à partir de la base de données en fonction de son ID en session
            $userModel = new UserModel();
            $userData = $userModel->findById($_SESSION['user']['id']);
        if($flag === true){
            $pagesDuration = $project->getNb_assigned_pages() / $userData['avg_pages_per_day'];
        } else {
            $pagesDuration = $project->getNb_total_pages() / $userData['avg_pages_per_day'];
        }
        return $pagesDuration;
    }


    // Fonction d'estimation du nombre de jours recommandés pour boarder le projet, en fonction du nombre de pages totales ou du nombre de pages assignées, du temps de cleaning estimé et de la durée du projet
    public function estimateRecommendedPagesPerDay(Project $project, bool $flag)
    {
        $interval = $project->getDuree();
        if($flag === true){
            $recommandation = ($project->getNb_assigned_pages() + $project->getEstimated_cleaning_duration()) / $interval;
        } else {
            $recommandation = ($project->getNb_total_pages() + $project->getEstimated_cleaning_duration()) / $interval;
        }
        return $recommandation;
    }

    // Fonction d'estimation du temps de boarding d'une séquence en fonction de son type et de son nombre de lignes
    public function estimateDurationBySequence(Sequence $sequence) {
        // Récupérer les informations de l'utilisateur à partir de la base de données en fonction de son ID en session
        $userStatByTypeModel = new UserStatByTypeModel();
        $userStatByTypeData = $userStatByTypeModel->findByUserIdAndType($_SESSION['user']['id'], $sequence->getFk_type());
        
        $nb_lines = $sequence->getLines_count();

        $nbPagesPerSequence = ceil($nb_lines / 33); // En moyenne 33 lignes par page
        $durationInDays = $nbPagesPerSequence / $userStatByTypeData[0]['avg_pages_per_day'];
        $durationInHours = $durationInDays * 8; // Convertir en heures, en supposant 8 heures de travail par jour
        
        return round($durationInHours, 2); // Arrondir à 2 décimales pour plus de lisibilité
        }

}
