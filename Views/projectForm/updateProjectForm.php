<main>
    <h1>Modifier le Projet</h1>
    <form action="index.php" method="get">

        <!-- Conserver les paramètres controller et action -->
        <input type="hidden" name="controller" value="form">
        <input type="hidden" name="action" value="updateProject">

        <select name="project_id" id="">
            <?php foreach ($projects as $proj) : ?>
                <option value="<?= $proj->getId() ?>" <?= ($proj->getId() == $project->getId()) ? 'selected' : '' ?>>
                    <?= $proj->getName() ?>, <?= $proj->getStudio() ?>, Épisode n<sup>o</sup> <?= $proj->getEpisode_nb() ?> : "<?= $proj->getEpisode_title() ?>"
                </option> <?php endforeach; ?>
        </select>
        <input type="submit" value="Changer de projet">
    </form>
    <form action="" method="POST">
        <label for="name">Nom du Projet</label>
        <input type="text" name="name" id="name" required value="<?= $project->getName() ?>">
</br>
        <label for="studio">Nom du Studio</label>
        <input type="text" name="studio" id="studio" value="<?= $project->getStudio() ?>" required>
</br>
        <label for="episode_nb">Numéro d'épisode</label>
        <input type="text" name="episode_nb" id="episode_nb" pattern="[0-9]+" inputmode="numeric" minlength="3" value="<?= $project->getEpisode_nb() ?>" required>
        <p>(format : NumSaisonNumEpisode)</p>
</br>
        <label for="episode_title">Titre de l'épisode</label>
        <input type="text" name="episode_title" id="episode_title" value="<?= $project->getEpisode_title() ?>" required>
</br>
        <label for="nb_predec">Nombre de parties de prédecs</label>
        <input type="number" name="nb_predec" id="nb_predec" min="1" value="<?= $project->getNb_predec() ?>" required>
</br>
        <p>Je m'occupe seul du script</p>
        <input type="radio" id="alone" name="is_alone" value="1" <?php if ($project->getIs_alone() == true) echo"checked"; ?> />
        <label for="alone">Oui</label>
        <input type="radio" id="not_alone" name="is_alone" value="0" <?php if ($project->getIs_alone() == false) echo"checked"; ?> />
        <label for="not_alone">Non</label>
</br>
        <p>Je m'occupe du cleaning</p>
        <input type="radio" id="cleaning" name="is_cleaning" value="1" <?php if ($project->getIs_cleaning() == true) echo"checked"; ?> />
        <label for="cleaning">Oui</label>
        <input type="radio" id="no_cleaning" name="is_cleaning" value="0" <?php if ($project->getIs_cleaning() == false) echo"checked"; ?> />
        <label for="no_cleaning">Non</label>
</br>
        <p>Période de contrat</p>
        <label for="date_begin">Début</label>
        <input type="date" name="date_begin" id="date_begin" value="<?= $project->getDate_beginning() ?>" required>
        <label for="date_end">Fin</label>
        <input type="date" name="date_end" id="date_end" value="<?= $project->getDate_end() ?>" required>
</br>
        <p>Je veux modifier l'analyse détaillée du script</p>
        <input type="radio" id="script_detailed" name="script_detailed" value="1" <?php if ($project->getIs_detailed() == true) echo"checked"; ?> />
        <label for="details">Oui</label>
        <input type="radio" id="not_alone" name="script_detailed" value="0" <?php if ($project->getIs_detailed() == false) echo"checked"; ?>/>
        <label for="no_details">Non</label>
</br>
        <input type="submit" name="submit_new_project" id="submit_new_project" value="Valider">

    </form>
</main>