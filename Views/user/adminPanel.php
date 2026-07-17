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
                    <th>Supprimer compte</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allUsers as $user):?>
                    <form method="POST" action="/BoardCompanion/admin-supprimer-compte">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                        <tr>
                            <td><?php echo htmlspecialchars($user['id'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($user['pseudo'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($user['avg_pages_per_day'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($user['avg_cleaning_duration'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($user['avg_shots_per_page'] ?? ''); ?></td>
                            
                            <td>
                                <?php if ($user['admin'] == '1') { ?>
                                    <button class="bouttonSupprimer button" id="disable">
                                <?php } else { ?>
                                    <button class="bouttonSupprimer button">
                                <?php } ?>
                                <svg class="adminPanelButton" viewBox="-1.5 -1.5 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" id="Trash-Bin-Minimalistic--Streamline-Solar-Broken">
                                    <path d="M17.19496875 7.5c0.7722 -2.18473125 2.85571875 -3.75 5.30484375 -3.75 2.4493125 0 4.5328125 1.56526875 5.304937499999999 3.75" stroke-linecap="round" stroke-width="3"></path>
                                    <path d="M38.4376875 11.25H6.5625" stroke-linecap="round" stroke-width="3"></path>
                                    <path d="M34.4503125 28.8733125c-0.331875 4.9779375 -0.49781250000000005 7.4670000000000005 -2.1196875 8.98425C30.708750000000002 39.375 28.21425 39.375 23.22525 39.375h-1.4501249999999999c-4.989 0 -7.4835 0 -9.10539375 -1.5174375 -1.62189375 -1.51725 -1.78783125 -4.0063125 -2.1196875 -8.98425L9.68765625 15.9375m25.62496875 0 -0.375 5.625" stroke-linecap="round" stroke-width="3"></path>
                                    <path d="m17.8125 20.625 0.9375 9.375" stroke-linecap="round" stroke-width="3"></path>
                                    <path d="m27.1875 20.625 -0.9375 9.375" stroke-linecap="round" stroke-width="3"></path>
                                </svg>
                                </button>
                            </td>
                        </tr>
                    </form>
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
                    <th>Supprimer projet</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allProjectsAllUsers as $project):?>
                    <form method="POST" action="/BoardCompanion/admin-supprimer-projet">
                        <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id']) ?>">
                        <input type="hidden" name="fk_user" value="<?= htmlspecialchars($project['fk_user']) ?>">
                        <tr>
                            <td><?= htmlspecialchars($project['name'] ?? ''); ?></td>
                            <td class="textNoWrap">du <?= htmlspecialchars($project['date_beginning'] ?? ''); ?><br>au <?= htmlspecialchars($project['date_end'] ?? ''); ?></td>
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
                            <td><button class="bouttonSupprimer button">
                                    <svg class="adminPanelButton" viewBox="-1.5 -1.5 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" id="Trash-Bin-Minimalistic--Streamline-Solar-Broken">
                                        <path d="M17.19496875 7.5c0.7722 -2.18473125 2.85571875 -3.75 5.30484375 -3.75 2.4493125 0 4.5328125 1.56526875 5.304937499999999 3.75" stroke-linecap="round" stroke-width="3"></path>
                                        <path d="M38.4376875 11.25H6.5625" stroke-linecap="round" stroke-width="3"></path>
                                        <path d="M34.4503125 28.8733125c-0.331875 4.9779375 -0.49781250000000005 7.4670000000000005 -2.1196875 8.98425C30.708750000000002 39.375 28.21425 39.375 23.22525 39.375h-1.4501249999999999c-4.989 0 -7.4835 0 -9.10539375 -1.5174375 -1.62189375 -1.51725 -1.78783125 -4.0063125 -2.1196875 -8.98425L9.68765625 15.9375m25.62496875 0 -0.375 5.625" stroke-linecap="round" stroke-width="3"></path>
                                        <path d="m17.8125 20.625 0.9375 9.375" stroke-linecap="round" stroke-width="3"></path>
                                        <path d="m27.1875 20.625 -0.9375 9.375" stroke-linecap="round" stroke-width="3"></path>
                                    </svg>
                                    </button>
                                </td>
                        </tr>
                    </form>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun projet trouvé.</p>
    <?php endif; ?>
    <?php if (!empty($_SESSION['success']['CompteSupprime'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['CompteSupprime'] ?></p>
    <?php } unset($_SESSION['success']['CompteSupprime']); ?>
    <?php if (!empty($_SESSION['success']['ProjetSupprime'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['ProjetSupprime'] ?></p>
    <?php } unset($_SESSION['success']['ProjetSupprime']); ?>
    <?php if (!empty($_SESSION['error']['errorDeleteAccount'])) { ?>
        <p class="messageErrorPopup"><?= $_SESSION['error']['errorDeleteAccount'] ?></p>
    <?php } unset($_SESSION['error']['errorDeleteAccount']); ?>
</main>