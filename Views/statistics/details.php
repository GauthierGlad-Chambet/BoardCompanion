<main id="page-details">
    <div class="page-container container-details">
        <h1>Statistiques</h1>
        <form class="form-select" action="index.php" method="get">
    
            <!-- Conserver les paramètres controller et action -->
            <input type="hidden" name="controller" value="statistics">
            <input type="hidden" name="action" value="details">
    
            <select name="project_id" id="">
                <?php foreach ($projects as $proj) : ?>
                    <option value="<?= $proj->getId() ?>" <?= ($proj->getId() == $project->getId()) ? 'selected' : '' ?>>
                        <?= $proj->getName() ?>, <?= $proj->getStudio() ?>, Épisode n<sup>o</sup> <?= $proj->getEpisode_nb() ?> : "<?= $proj->getEpisode_title() ?>"
                    </option> <?php endforeach; ?>
            </select>
        </form>
        <div class="container">
            <h3>Pages attribuées :</h3>
            <p><?= $project->getNb_assigned_pages() ?> pages assignées / <?= $project->getNb_total_pages() ?> pages totales</p>
        </div>
        <div class="container">
            <h3>Durée estimée pour boarder le projet :</h3>
            <p><?= $project->getEstimated_total_duration() ?> jours</p>
        </div>
        <div class="container">
        <h3>Temps moyen estimé par page (en fonction des types de séquences) :</h3>
        <p><?= $project->getAvg_duration_estimated_per_pages() ?> jours</p>
        <?php //si le projet est en cleaning, on affiche la durée estimée du cleaning
            if ($project->getIs_cleaning() === true) {
        ?>
        </div>
        <div class="container">
        <h3>Durée estimée du cleaning :</h3>
        <p><?=  $project->getEstimated_cleaning_duration() . " jours" ?></p>
        <?php } ?>
        <?php
        //si des séquences sont assignées au projet, on affiche les durées estimées par séquence
            if  ($sequences && count($sequences) > 0) {
        ?>
        </div>
        <div class="container details-sequences-container">
            <div class="open">
                <div></div>
                <h3>Durées estimées par séquence :</h3>
                <svg viewBox="-1.5 -1.5 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" id="Square-Alt-Arrow-Down--Streamline-Solar-Broken">
                    <path d="m28.125 19.6875 -5.625 5.625 -5.625 -5.625" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                    <path d="M41.25 22.5c0 8.838750000000001 0 13.2583125 -2.7459374999999997 16.0040625C35.7583125 41.25 31.338749999999997 41.25 22.5 41.25c-8.83884375 0 -13.258256249999999 0 -16.00411875 -2.7459374999999997C3.75 35.7583125 3.75 31.338749999999997 3.75 22.5c0 -8.83884375 0 -13.258256249999999 2.74588125 -16.00411875C9.241743750000001 3.75 13.66115625 3.75 22.5 3.75c8.838750000000001 0 13.2583125 0 16.0040625 2.74588125 1.825875 1.8257625000000002 2.4376875 4.3914 2.642625 8.50411875" stroke-linecap="round" stroke-width="3"></path>
                </svg>  
            </div>
            <ul>
                <?php foreach ($sequences as $sequence) {
                    if ($sequence->getTypeLabel() !== "indéterminé") {?>
                    <li> Séquence <?= $sequence->getNumber() ?> : <?= $sequence->getTitle() ?> (<?= $sequence->getTypeLabel() ?>): </br><b><?= $sequence->getDuration_estimated() ?>  heures</b></li>
                <?php }} ?>
            </ul>
            <?php }  ?>
        </div>
        <div class="container container-rythme-reco">
            <h3>Rythme recommandé pour respecter la deadline :</h3>
            <p><?= $project->getRecommended_pages_per_day() ?> pages / jour</p>
        </div>
        <p class="note">Calculs réalisés à partir de votre rythme constaté sur les précédents projets</p>
        <div class="button-lot">
            <a class="button" href="/BoardCompanion/modifier-projet?project_id=<?= $project->getId() ?>">Modifier les informations</a>
            <?php if(!$finalReport) { ?>
                <a class="button" href="/BoardCompanion/bilan-final?project_id=<?= $project->getId() ?>">Bilan final</a>
                </div>
                <?php } else { ?>
                <a class="button" href="/BoardCompanion/modifier-bilan-final?project_id=<?= $project->getId() ?>">Modifier le bilan final</a>
        </div>
        
        <hr>
        <!-- BILAN FINAL -->
        <h2 id="bilanFinal">BILAN FINAL</h2>
        <div class="container">
            <h3>Appréciation globale : </h3>
            <img src="Views/assets/img/<?= $finalReport->getAppreciationLabel() ?>" alt="Smiley symbolisant l'appréciation">
        </div>
        <div class="container">
            <h3>Durée totale du projet : </h3>
            <p><?= $finalReport->getTotal_duration() ?> jours</p>
        </div>
        <div class="container">
            <h3>Total de plans réalisés : </h3>
            <p><?= $finalReport->getNb_shots() ?></p>
        </div>
        <?php if ($project->getIs_cleaning() == 1) { ?>
        <div class="container">
            <h3>Durée du cleaning : </h3>
            <p><?= $finalReport->getCleaning_duration() ?> jours</p>
        </div>
            <?php } ?>
        <div class="container details-sequences-container">
            <div class="open">
                <div></div>
                <h3>Durées réelles par séquence :</h3>
                <svg viewBox="-1.5 -1.5 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" id="Square-Alt-Arrow-Down--Streamline-Solar-Broken">
                    <path d="m28.125 19.6875 -5.625 5.625 -5.625 -5.625" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                    <path d="M41.25 22.5c0 8.838750000000001 0 13.2583125 -2.7459374999999997 16.0040625C35.7583125 41.25 31.338749999999997 41.25 22.5 41.25c-8.83884375 0 -13.258256249999999 0 -16.00411875 -2.7459374999999997C3.75 35.7583125 3.75 31.338749999999997 3.75 22.5c0 -8.83884375 0 -13.258256249999999 2.74588125 -16.00411875C9.241743750000001 3.75 13.66115625 3.75 22.5 3.75c8.838750000000001 0 13.2583125 0 16.0040625 2.74588125 1.825875 1.8257625000000002 2.4376875 4.3914 2.642625 8.50411875" stroke-linecap="round" stroke-width="3"></path>
                </svg> 
            </div>
            <ul>
                <?php 
                    foreach ($sequences as $sequence) { 
                        if($sequence->getDuration_real() != 0 || $sequence->getDuration_real() != null) {
                ?>
                <li> Séquence <?= $sequence->getNumber() ?> : <?= $sequence->getTitle() ?> (<?= $sequence->getTypeLabel() ?>): </br> <b><?= $sequence->getDuration_real() ?> heures</b></li>
                <?php }} ?>
            </ul>
        </div>
        <div class="container">
            <h3>Commentaire : </h3>
            <p><?= $finalReport->getCommentary() ?></p>
        </div>
        <?php } ?> 
    
        <button class="bouttonSupprimer button">Supprimer le projet</button>
    </div>
    <div class="popup popupSuppr container" id="popupProjet">
        <p>Êtes-vous sûr de vouloir supprimer ce projet ? Cette action est irréversible.</p>
        <div>
            <button class="annulerSuppr button">Annuler</button>
            <form method="POST" action="/BoardCompanion/supprimer-projet">
                <input type="hidden" name="project_id" value="<?= $project->getId() ?>">
                <button class="button" type="submit">Supprimer le projet</button>
            </form>
        </div>
    </div>
    <?php if (!empty($_SESSION['success']['projetAjoute'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['projetAjoute'] ?></p>
    <?php } unset($_SESSION['success']['projetAjoute']); ?> 
    <?php if (!empty($_SESSION['success']['projetModifie'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['projetModifie'] ?></p>
    <?php } unset($_SESSION['success']['projetModifie']); ?>
    <?php if (!empty($_SESSION['success']['bilanFinal'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['bilanFinal'] ?></p>
    <?php } unset($_SESSION['success']['bilanFinal']); ?>
    <?php if (!empty($_SESSION['success']['bilanFinalModifie'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['bilanFinalModifie'] ?></p>
    <?php } unset($_SESSION['success']['bilanFinalModifie']); ?>
</main>