<main>
    <h1>Tableau de bord</h1>
    <table>
        <th>
            <td>Nom du projet</td>
            <td>Dates</td>
            <td>Pages attribuées</td>
            <td>Durée nécessaire estimée</td>
            <td>Rythme recommandé</td>
            <td>Appréciation</td>
            <td>Statistiques détaillés</td>
        </th>
        <tbody>
            <?php foreach ($arrProjects as $project) : ?>
            <tr>
                <td></td>
                <td><?= $project->getName() ?></td>
                <td>
                    <?= $project->getDate_beginning() ?>
                    <br>
                    <?= $project->getDate_end() ?>
                    <br>
                    (
                    <?=  $project->getDuree() ?> jours
                    )
                </td>
                <td><?= $project->getNb_assigned_pages() ?></td>
                <td><?= $project->getEstimated_total_duration() ?> heures</td>
                <td><?= $project->getRecommended_pages_per_day() ?> pages/jour</td>
                <td>
                    <?= $project->getAppreciation_label() ?></td>
                <td><a href="index.php?controller=statistics&action=details&id=<?= $project->getId() ?>">Voir les détails</a></td>
            </tr> <?php endforeach; ?>
        </tbody>
    </table>
</main>