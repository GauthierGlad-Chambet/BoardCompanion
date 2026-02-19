<main>
    <h1>Bilan Final</h1>
    <form action="index.php" method="get">

        <!-- Conserver les paramètres controller et action -->
        <input type="hidden" name="controller" value="statistics">
        <input type="hidden" name="action" value="finalReport">

        <select name="project_id" id="">
            <?php foreach ($Projects as $proj) : ?>
                <option value="<?= $proj->getId() ?>" <?= ($proj->getId() == $project->getId()) ? 'selected' : '' ?>>
                    <?= $proj->getName() ?>, <?= $proj->getStudio() ?>, Épisode n<sup>o</sup> <?= $proj->getEpisode_nb() ?> : "<?= $proj->getEpisode_title() ?>"
                </option> <?php endforeach; ?>
        </select>
        <input type="submit" value="Changer de projet">
    </form>
    
    <form action="" method="POST">

        <!-- Champ caché pour transmettre l'ID du projet -->
        <input type="hidden" name="project_id" value="<?= $_GET['project_id']; ?>">

        <fieldset>
            <legend for=""><h3>Appréciation globale :</h3></legend>
            <?php foreach ($arrAppreciations as $appreciation) : ?>
                <div>
                    <input type="radio" id="1" name="appreciation" value="<?= $appreciation->getId() ?>" required />
                    <label for="appreciation_<?= $appreciation->getId() ?>">
                        <?= htmlspecialchars($appreciation->getLabel()) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </fieldset>

        <label for="duree_totale_projet"><h3>Durée totale du projet (en jours):</h3></label>
        <input type="number" step="0.1" min="0" name="duree_totale_projet" required>

        <label for="total_plans"><h3>Total de plans réalisés :</h3></label>
        <input type="number" min="0" name="total_plans">

        <label for="duree_cleaning"><h3>Durée du cleaning :</h3></label>
        <input type="number" step="0.1" min="0" name="duree_cleaning">
        
        <?php
        //si des séquences sont assignées au projet, on affiche les durées estimées par séquence
            if  ($sequences && count($sequences) > 0) {
        ?>
        <h3>Durée par séquence (en heures) :</h3>
        <?php foreach ($sequences as $sequence) { ?>
            <label for="duree_sequence[<?= $sequence->getId();?>]">
                Séquence <?= $sequence->getNumber() ?> : <?= $sequence->getTitle() ?> (<?= $sequence->getTypeLabel() ?>)
            </label>
            <input type="number" min="0" name="duree_sequence[<?= $sequence->getId();?>]">
            <br>
        <?php }} ?>
        
        <label for="commentaire"><h3>Commentaire :</h3></label>
        <textarea name="commentaire" placeholder="Commentaire…"></textarea>

        <input type="submit" name="submit_final_report" id="submit_final_report" value="Valider">

    </form>

</main>