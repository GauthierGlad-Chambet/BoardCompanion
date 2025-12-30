<?php
    $name               =trim($_POST['name']??'');    //trim remove invisibles characters like spaces, before and after the text
    $studio             =trim($_POST['studio']??'');
    $episodeNb          =trim($_POST['episode_nb']??'');
    $episodeTitle       =trim($_POST['episode_title']??'');
    $dateBegin          =$_POST['date_begin']??'';
    $dateEnd            =$_POST['date_end']??'';
    $nbPredecs          =$_POST['nb_predec']??'';
    $isCleaning         =$_POST['is_cleaning']??'';
    $isAlone            =$_POST['is_alone']??'';



    //if script field existe, and no error during upload
    if (isset($_FILES['script']) && $_FILES['script']['error'] === 0) {

        // application/pdf is the official MIME type for PDF
        $allowedTypes = ['application/pdf'];
        //if the type of the file is correct, continue, if not stop it with and error msg
        if (!in_array($_FILES['script']['type'], $allowedTypes)) {
            die('Le fichier doit être un PDF.');
        }


        //get the original name of the file
        $originalName = $_FILES['script']['name'];

        //PATHINFO_EXTENSION collect the extension of the file
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);

        //uniqid generate a unique number just after 'script_', concatenate with the extension of the file
        $newFileName = uniqid('script_') . '.' . $extension;

        //to construct the real path for the file, starting by the current directory
        $uploadDir = __DIR__ . '/../../uploads/scripts/';

        // the place where the file will be saved
        $destination = $uploadDir . $newFileName;

        //move_uploaded_file move the file from the temporary place to the destination
        move_uploaded_file($_FILES['script']['tmp_name'], $destination);
        $scriptFilePath    =realpath($destination);
    }

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
    
?>

<main>
    <h1>Nouveau Projet</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Nom du Projet</label>
        <input type="text" name="name" id="name" required>
</br>
        <label for="studio">Nom du Studio</label>
        <input type="text" name="studio" id="studio" required>
</br>
        <label for="episode_nb">Numéro d'épisode</label>
        <input type="text" name="episode_nb" id="episode_nb" pattern="[0-9]+" inputmode="numeric" minlength="3" required>
        <p>(format : NumSaisonNumEpisode)</p>
</br>
        <label for="episode_title">Titre de l'épisode</label>
        <input type="text" name="episode_title" id="episode_title" required>
</br>
        <label for="nb_predec">Nombre de parties de prédecs</label>
        <input type="number" name="nb_predec" id="nb_predec" min="1" required>
</br>
        <p>Je m'occupe seul du script</p>
        <input type="radio" id="alone" name="is_alone" value="oui" checked />
        <label for="alone">Oui</label>
        <input type="radio" id="not_alone" name="is_alone" value="non" />
        <label for="not_alone">Non</label>
</br>
        <p>Je m'occupe du cleaning</p>
        <input type="radio" id="cleaning" name="is_cleaning" value="oui" checked />
        <label for="alone">Oui</label>
        <input type="radio" id="not_alone" name="is_cleaning" value="non" />
        <label for="no_cleaning">Non</label>
</br>
</br>
        <label for="script">Script (.pdf)</label>
        <input type="file" name="script" id="script" accept=".pdf" required>
</br>
        <label for="template">Fichier de template (.sbbkp ou .psd)</label>
        <input type="file" name="template" id="template" accept=".sbbkp, .psd" required>
</br>
        <p>Période de contrat</p>
        <label for="date_begin">Début</label>
        <input type="date" name="date_begin" id="date_begin" required>
        <label for="date_end">Fin</label>
        <input type="date" name="date_end" id="date_end" required>
</br>
        <p>Je veux une analyse du script détaillée</p>
        <input type="radio" id="script_detailed" name="script_detailed" value="oui" checked />
        <label for="details">Oui</label>
        <input type="radio" id="not_alone" name="script_detailed" value="non" />
        <label for="no_details">Non</label>
</br>
        <input type="submit" name="submit_new_project" id="submit_new_project" value="Valider">

    </form>
</main>