<main id="new-project-page">
    <h1>Modifier le Projet</h1>
    <form class="form-select" action="index.php" method="get">

        <!-- Conserver les paramètres controller et action -->
        <input type="hidden" name="controller" value="form">
        <input type="hidden" name="action" value="updateProject">

        <select name="project_id" id="">
            <?php foreach ($projects as $proj) : ?>
                <option value="<?= $proj->getId() ?>" <?= ($proj->getId() == $project->getId()) ? 'selected' : '' ?>>
                    <?= $proj->getName() ?>, <?= $proj->getStudio() ?>, Épisode n<sup>o</sup> <?= $proj->getEpisode_nb() ?> : "<?= $proj->getEpisode_title() ?>"
                </option> <?php endforeach; ?>
        </select>
    </form>
    <form class="container" id="newProject-form" action="" method="POST">
        <div>
                <div>
                        <label for="name">Nom du Projet :</label>
                        <input <?php if (!empty($_SESSION['error']['name'])) { ?> class="inputError" <?php } ?> type="text" name="name" id="name" value="<?= ($name !== '')? $name : $project->getName() ?>" required>
                        <?php if (!empty($_SESSION['error']['name'])) { ?>
                                <p class="messageError"><?= $_SESSION['error']['name'] ?></p>
                        <?php } unset($_SESSION['error']['name']); ?>
                </div>
                <div>
                        <label for="studio">Nom du Studio :</label>
                        <input <?php if (!empty($_SESSION['error']['studio'])) { ?> class="inputError" <?php } ?> type="text" name="studio" id="studio" value="<?= ($studio !== '')? $studio : $project->getStudio() ?>" required>
                        <?php if (!empty($_SESSION['error']['studio'])) { ?>
                                <p class="messageError"><?= $_SESSION['error']['studio'] ?></p>
                        <?php } unset($_SESSION['error']['studio']); ?>
                </div>
                <div>
                        <label for="episode_nb">Numéro d'épisode :</label>
                        <input <?php if (!empty($_SESSION['error']['episode_nb'])) { ?> class="inputError" <?php } ?> type="text" name="episode_nb" id="episode_nb" pattern="[0-9]+" inputmode="numeric" minlength="3" value="<?= ($episode_nb !== '')? $episode_nb : $project->getEpisode_nb() ?>" required>
                        <p class="note">(format : NumSaisonNumEpisode)</p>
                        <?php if (!empty($_SESSION['error']['episode_nb'])) { ?>
                                <p class="messageError"><?= $_SESSION['error']['episode_nb'] ?></p>
                        <?php } unset($_SESSION['error']['episode_nb']); ?>
                </div>
                <div>
                        <label for="episode_title">Titre de l'épisode :</label>
                        <input <?php if (!empty($_SESSION['error']['episode_title'])) { ?> class="inputError" <?php } ?> type="text" name="episode_title" id="episode_title" value="<?= ($episode_title !== '')? $episode_title : $project->getEpisode_title() ?>" required>
                        <?php if (!empty($_SESSION['error']['episode_title'])) { ?>
                                <p class="messageError"><?= $_SESSION['error']['episode_title'] ?></p>
                        <?php } unset($_SESSION['error']['episode_title']); ?>
                </div>
                <div>
                        <label for="nb_predec">Nombre de parties de prédecs :</label>
                        <input <?php if (!empty($_SESSION['error']['nb_predec'])) { ?> class="inputError" <?php } ?> type="number" name="nb_predec" id="nb_predec" min="1" value="<?= ($nb_predec !== '')? $nb_predec : $project->getNb_predec() ?>" required>
                         <?php if (!empty($_SESSION['error']['nb_predec'])) { ?>
                                <p class="messageError"><?= $_SESSION['error']['nb_predec'] ?></p>
                        <?php } unset($_SESSION['error']['nb_predec']); ?>
                </div>
        </div>
        <div>
                <div class="block-radio">
                        <p>Je m'occupe seul du script :</p>
                        <div>
                                <label class="customLabel radioLabel" for="alone">Oui
                                        <input type="radio" id="alone" name="is_alone" value="1" <?= ($is_alone == '1') ? 'checked'  : (($project->getIs_alone() == true)? 'checked' : ''); ?> />
                                        <span class="checkmark"></span>
                                </label>
                                <label class="customLabel radioLabel" for="not_alone">Non
                                        <input type="radio" id="not_alone" name="is_alone" value="0" <?= ($is_alone == '0') ? 'checked' : (($project->getIs_alone() == false)? 'checked' : ''); ?> />
                                        <span class="checkmark"></span>
                                </label>
                        </div>
                        <?php if (!empty($_SESSION['error']['is_alone'])) { ?>
                                 <p class="messageError"><?= $_SESSION['error']['is_alone'] ?></p>
                         <?php } unset($_SESSION['error']['is_alone']); ?>
                </div>
                <div class="block-radio">
                        <p>Je m'occupe du cleaning :</p>
                        <div>
                                <label class="customLabel radioLabel" for="cleaning">Oui
                                        <input type="radio" id="cleaning" name="is_cleaning" value="1" <?=  ($is_cleaning == '1') ? 'checked' : (($project->getIs_cleaning() == true) ? 'checked' : ''); ?> />
                                        <span class="checkmark"></span>
                                </label>
                                <label class="customLabel radioLabel" for="no_cleaning">Non
                                        <input type="radio" id="no_cleaning" name="is_cleaning" value="0" <?= ($is_cleaning == '0') ? 'checked' : (($project->getIs_cleaning() == false) ? 'checked' : ''); ?> />
                                        <span class="checkmark"></span>
                                </label>
                        </div>
                         <?php if (!empty($_SESSION['error']['is_cleaning'])) { ?>
                                 <p class="messageError"><?= $_SESSION['error']['is_cleaning'] ?></p>
                         <?php } unset($_SESSION['error']['is_cleaning']); ?>
        
                </div>
                <div class="block-dates">
                        <p>Période de contrat :</p>
                        <label for="date_begin">Début
                                <input <?php if (!empty($_SESSION['error']['date_begin'])) { ?> class="inputError" <?php } ?> type="date" name="date_begin" id="date_begin" value="<?= ($date_begin !== '')? $date_begin : $project->getDate_beginning() ?>" required>
                        </label>
                        <label for="date_end">Fin
                                <input <?php if (!empty($_SESSION['error']['date_begin'])) { ?> class="inputError" <?php } ?> type="date" name="date_end" id="date_end" value="<?= ($date_end !== '')? $date_end : $project->getDate_end() ?>" required>
                        </label>
                        <?php if (!empty($_SESSION['error']['date_begin'])) { ?>
                                <p class="messageError"><?= $_SESSION['error']['date_begin'] ?></p>
                        <?php } unset($_SESSION['error']['date_begin']); ?>
                </div>
                <div class="block-radio">
                        <p>Je veux modifier l'analyse détaillée du script :</p>
                        <div>
                                <label class="customLabel radioLabel" for="details">Oui
                                        <input type="radio" id="details" name="script_detailed" value="1" <?= ($script_detailed == '1') ? 'checked' : (($project->getIs_detailed() == true) ? 'checked' : ''); ?> />
                                        <span class="checkmark"></span>
                                </label>
                                <label class="customLabel radioLabel" for="no_details">Non
                                        <input type="radio" id="no_details" name="script_detailed" value="0" <?= ($script_detailed == '0') ? 'checked' : (($project->getIs_detailed() == false) ? 'checked' : ''); ?>/>
                                        <span class="checkmark"></span>
                                </label>
                        </div>
                        <?php if (!empty($_SESSION['error']['script_detailed'])) { ?>
                                 <p class="messageError"><?= $_SESSION['error']['script_detailed'] ?></p>
                        <?php } unset($_SESSION['error']['script_detailed']); ?>
                </div>
                <div>
                        <input class="button" type="submit" name="submit_new_project" id="submit_new_project" value="Valider">
                </div>
        </div>
    </form>
</main>