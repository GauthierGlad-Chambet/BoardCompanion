<main id="page-details">
    <div class="page-container">
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
        <div class="container">
            <h3>Durées estimées par séquence :</h3>
            <ul>
                <?php foreach ($sequences as $sequence) { ?>
                    <li> Séquence <?= $sequence->getNumber() ?> : <?= $sequence->getTitle() ?> (<?= $sequence->getTypeLabel() ?>): </br><b><?= $sequence->getDuration_estimated() ?>  heures</b></li>
                <?php } ?>
            </ul>
            <?php }  ?>
        </div>
        <div class="container container-rythme-reco">
            <h3>Rythme recommandé pour respecter la deadline :</h3>
            <p><?= $project->getRecommended_pages_per_day() ?> pages / jour</p>
        </div>
        <p class="note">Calculs réalisés à partir de votre rythme constaté sur les précédents projets</p>
        <div class="button-details">
            <a class="button" href="index.php?controller=form&action=updateProject&project_id=<?= $project->getId() ?>">Modifier les informations</a>
            <?php if(!$finalReport) { ?>
                <a class="button" href="index.php?controller=statistics&action=finalReport&project_id=<?= $project->getId() ?>">Bilan final</a>
                </div>
                <?php } else { ?>
                <a class="button" href="index.php?controller=statistics&action=updateFinalReport&project_id=<?= $project->getId() ?>">Modifier le bilan final</a>
        </div>
        
        <hr>
        <!-- BILAN FINAL -->
        <h2 id="bilanFinal">BILAN FINAL</h2>
        <div class="container">
            <h3>Appréciation globale : </h3>
            <p><?= $finalReport->getAppreciationLabel() ?></p>
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
        <div class="container">
            <h3>Durées réelles par séquence :</h3>
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
            <form method="POST" action="index.php?controller=statistics&action=deleteProject">
                <input type="hidden" name="project_id" value="<?= $project->getId() ?>">
                <button class="button" type="submit">Supprimer le projet</button>
            </form>
        </div>
    </div>


</main>