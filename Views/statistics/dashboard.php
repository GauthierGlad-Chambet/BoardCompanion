<main>
    <h1>Tableau de bord</h1>
    <table>
        <thead>
            <td>Nom du projet</td>
            <td>Dates</td>
            <td>Pages attribuées</td>
            <td>Durée nécessaire estimée</td>
            <td>Rythme recommandé</td>
            <td>Appréciation</td>
            <td>Statistiques détaillés</td>
        </thead>
        <tbody>
            <?php foreach ($projects as $project) : ?>
            <tr>
                <td><?= $project->getName() ?></td>
                <td>
                    du <?= $project->getDate_beginningFormatted() ?>
                    <br>
                    au <?= $project->getDate_endFormatted() ?>
                    <br>
                    (
                    <?=  $project->getDuree() ?> jours
                    )
                </td>
                <td><?= $project->getNb_assigned_pages() ?></td>
                <td><?= $project->getEstimated_total_duration() ?> jours</td>
                <td><?= $project->getRecommended_pages_per_day() ?> pages/jour</td>
                <td>
                    <?php if($project->getAppreciation_label() == "Non renseigné") { ?>
                        <p>Non renseigné</p>
                    <?php } else { ?>
                        <img src="Views/assets/img/<?= $project->getAppreciation_label() ?>" alt="Smiley symbolisant l'appréciation">
                    <?php } ?>
                </td>
                <td><a class="button" href="index.php?controller=statistics&action=details&project_id=<?= $project->getId() ?>">Voir les détails</a></td>
            </tr> <?php endforeach; ?>
        </tbody>
    </table>


    <div class="dashboard-mobile">
        <?php foreach ($projects as $project) : ?>
            <div class="container dashboard-mobile-section">
                <div>
                    <h2>Projet : <?= $project->getName() ?> 
                    <p class="note">
                        (du <?= $project->getDate_beginningFormatted() ?> au <?= $project->getDate_endFormatted()?>)</p>
                    </p>
                </div>
                <div>
                    <p><?= $project->getNb_assigned_pages() ?> pages attribuées | <?= $project->getEstimated_total_duration() ?> jours estimés</p>
                </div>
                <p>Rythme recommandé : <?= $project->getRecommended_pages_per_day() ?> pages/jour</p>
                <a class="button" href="index.php?controller=statistics&action=details&project_id=<?= $project->getId() ?>">Détails</a>
            </div>
        <?php endforeach; ?>   
    </div>
</main>