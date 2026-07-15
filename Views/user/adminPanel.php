<main>
    <h1>Administration</h1>

    <?php if (!empty($allUsers) && is_array($allUsers)): ?>
        <h2>Utilisateurs</h2>
        <table> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Avg pages/day</th>
                    <th>Avg cleaning</th>
                    <th>Avg shots/page</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allUsers as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['pseudo'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['avg_pages_per_day'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['avg_cleaning_duration'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['avg_shots_per_page'] ?? ''); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun utilisateur trouvé.</p>
    <?php endif; ?>

    <?php if (!empty($allProjectsAllUsers) && is_array($allProjectsAllUsers)): ?>
        <h2>Tous les projets</h2>
        <table> 
            <thead>
                <tr>
                    <th>Nom du projet</th>
                    <th>Dates</th>
                    <th>Pages attribuées</th>
                    <th>Durée nécessaire estimée</th>
                    <th>Rythme recommandé</th>
                    <th>Appréciation</th>
                    <th>Utilisateur</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allProjectsAllUsers as $project): ?>
                    <tr>
                        <td><?= htmlspecialchars($project['name'] ?? ''); ?></td>
                        <td>du <?= htmlspecialchars($project['date_beginning'] ?? ''); ?><br>au <?= htmlspecialchars($project['date_end'] ?? ''); ?></td>
                        <td><?= htmlspecialchars($project['nb_assigned_pages'] ?? ''); ?></td>
                        <td><?= htmlspecialchars($project['estimated_total_duration'] ?? ''); ?> jours</td>
                        <td><?= htmlspecialchars($project['recommended_pages_per_day'] ?? ''); ?> pages/jour</td>
                        <td>
                            <?php if (!empty($project['appreciation_label']) && $project['appreciation_label'] !== 'Non renseigné'): ?>
                                <img src="/BoardCompanion/Views/assets/img/<?= htmlspecialchars($project['appreciation_label']); ?>" alt="Smiley appréciation">
                            <?php else: ?>
                                <span>Non renseigné</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars(($project['user_pseudo'] ?? '') . ' (' . ($project['user_email'] ?? '') . ')'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun projet trouvé.</p>
    <?php endif; ?>

</main>