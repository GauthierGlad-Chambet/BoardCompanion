<main>
    <h1>Statistiques</h1>
    <h2>
        <?= $project->getName() ?>, <?= $project->getStudio() ?>, Épisode n<sup>o</sup><?= $project->getEpisode_nb() ?> : "<?= $project->getEpisode_title() ?>"
    </h2>
    <h3>Pages attribuées :</h3>
    <p><?= $project->getNb_assigned_pages() ?> pages assignées / <?= $project->getNb_total_pages() ?> pages totales</p>
    <h3>Durée estimée pour boarder le projet :</h3>
    <p><?= $project->getEstimated_total_duration() ?> heures</p>
    <h3>Temps moyen estimé par page (en fonction des types de séquences) :</h3>
    <p>FONCTION A CREER</p>
    <?php //si le projet est en cleaning, on affiche la durée estimée du cleaning
        if ($project->getIs_cleaning() === 1) {
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
            <li><?= $sequence->getId() ?> (<?= $sequence->getType() ?>): <?= $sequence->getDuration_estimated() ?> jours</li>
        <?php } ?>
    </ul>
    <?php }  ?>
</main>