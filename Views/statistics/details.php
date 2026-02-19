<main>
    <h1>Statistiques</h1>
    <form action="index.php" method="get">

        <!-- Conserver les paramètres controller et action -->
        <input type="hidden" name="controller" value="statistics">
        <input type="hidden" name="action" value="details">

        <select name="project_id" id="">
            <?php foreach ($Projects as $proj) : ?>
                <option value="<?= $proj->getId() ?>" <?= ($proj->getId() == $project->getId()) ? 'selected' : '' ?>>
                    <?= $proj->getName() ?>, <?= $proj->getStudio() ?>, Épisode n<sup>o</sup> <?= $proj->getEpisode_nb() ?> : "<?= $proj->getEpisode_title() ?>"
                </option> <?php endforeach; ?>
        </select>
        <input type="submit" value="Changer de projet">
    </form>
    <h3>Pages attribuées :</h3>
    <p><?= $project->getNb_assigned_pages() ?> pages assignées / <?= $project->getNb_total_pages() ?> pages totales</p>
    <h3>Durée estimée pour boarder le projet :</h3>
    <p><?= $project->getEstimated_total_duration() ?> jours</p>
    <h3>Temps moyen estimé par page (en fonction des types de séquences) :</h3>
    <p>FONCTION A CREER</p>
    <?php //si le projet est en cleaning, on affiche la durée estimée du cleaning
        if ($project->getIs_cleaning() === true) {
    ?>
    <h3>Durée estimée du cleaning :</h3>
    <p><?=  $project->getEstimated_cleaning_duration() . " jours" ?></p>
    <?php } ?>
    <?php
    //si des séquences sont assignées au projet, on affiche les durées estimées par séquence
        if  ($sequences && count($sequences) > 0) {
    ?>
    <h3>Durées estimées par séquence :</h3>
    <ul>
        <?php foreach ($sequences as $sequence) { ?>
            <li> Séquence <?= $sequence->getNumber() ?> : <?= $sequence->getTitle() ?> (<?= $sequence->getTypeLabel() ?>): <?= $sequence->getDuration_estimated() ?> heures</li>
        <?php } ?>
    </ul>
    <?php }  ?>
    <h3>Rythme recommandé pour respecter la deadline :</h3>
    <p><?= $project->getRecommended_pages_per_day() ?> pages / jour</p>
    <p>Calculs réalisés à partir de votre rythme constaté sur les précédents projets</p>
    <a href="">Modifier les informations</a>

    <?php if(!$finalReport) { ?>
        <a href="index.php?controller=statistics&action=finalReport&project_id=<?= $project->getId() ?>">Formulaire de fin de projet</a>
    <?php } else { ?>           
    <hr>

    <!-- BILAN FINAL -->
     <h2 id="bilanFinal">BILAN FINAL</h2>
    <h3>Appréciation globale : <?= $finalReport->getAppreciationLabel() ?></h3>
    <p></p>

    <h3>Durée totale du projet : <?= $finalReport->getTotal_duration() ?> jours</h3>
    <p></p>

    <h3>Total de plans réalisés : <?= $finalReport->getNb_shots() ?></h3>
    <p></p>

    <h3>Durée du cleaning : <?= $finalReport->getCleaning_duration() ?> jours</h3>
    <p></p>

    <h3>Durées réelles par séquence :</h3>
    <ul>
        <?php foreach ($sequences as $sequence) { ?>
            <li> Séquence <?= $sequence->getNumber() ?> : <?= $sequence->getTitle() ?> (<?= $sequence->getTypeLabel() ?>): <?= $sequence->getDuration_real() ?> heures</li>
        <?php } ?>
    </ul>

    <h3>Commentaire : <?= $finalReport->getCommentary() ?></h3>
    
    <?php } ?> 


</main>