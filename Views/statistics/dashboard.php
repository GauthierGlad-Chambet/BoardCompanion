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
            <?php foreach ($projects as $project) : ?>
            <tr>
                <td><?= $project->getName() ?></td>
                <td><?= $project->getStartDate()->format('d/m/Y') ?> - <?= $project->getDeadline()->format('d/m/Y') ?></td>
                <td><?= $project->getPages() ?></td> <td><?= $project->getEstimatedTime() ?> heures</td>
                <td><?= $project->getRecommendedPace() ?> pages/jour</td>
                <td><?= $project->getAppreciation() ?></td>
                <td><a href="index.php?controller=statistics&action=details&id=<?= $project->getId() ?>">Voir les détails</a></td>
            </tr> <?php endforeach; ?>
        </tbody>
    </table>
</main>