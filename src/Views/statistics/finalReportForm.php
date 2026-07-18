<main>
    <h1>Bilan Final</h1>
    <form class="form-select" action="index.php" method="get">

        <!-- Conserver les paramètres controller et action -->
        <input type="hidden" name="controller" value="statistics">
        <input type="hidden" name="action" value="finalReport">

        <select name="project_id" id="">
            <?php foreach ($projects as $proj) : ?>
                <option value="<?= $proj->getId() ?>" <?= ($proj->getId() == $project->getId()) ? 'selected' : '' ?>>
                    <?= $proj->getName() ?>, <?= $proj->getStudio() ?>, Épisode n<sup>o</sup> <?= $proj->getEpisode_nb() ?> : "<?= $proj->getEpisode_title() ?>"
                </option> <?php endforeach; ?>
        </select>
    </form>
    
    <form class="container form-finalReport"  action="" method="POST">

        <!-- Champ caché pour transmettre l'ID du projet -->
        <input type="hidden" name="project_id" value="<?= $_GET['project_id']; ?>">

        <fieldset <?php if (!empty($_SESSION['error']['appreciation'])) { ?> class="inputError" <?php } ?> >
            <legend for=""><h3>Appréciation globale :</h3></legend>
            <?php foreach ($arrAppreciations as $appreciationObj) : ?>
                <div>
                    <label class="customLabel radioLabel" for="appreciation_<?= $appreciationObj->getId() ?>">
                        <input type="radio" id="appreciation_<?= $appreciationObj->getId() ?>" name="appreciation" value="<?= $appreciationObj->getId() ?>" <?= ($appreciation == $appreciationObj->getId()) ? 'checked' : '' ?> required/>
                        <img class="checkmark-appreciation" src="Views/assets/img/<?= htmlspecialchars($appreciationObj->getLabel()) ?>" alt="Smiley symbolisant l'appréciation">
                    </label>
                </div>
            <?php endforeach; ?>
        </fieldset>
        <?php if (!empty($_SESSION['error']['appreciation'])) { ?>
                <p class="messageError"><?= $_SESSION['error']['appreciation'] ?></p>
        <?php } unset($_SESSION['error']['appreciation']); ?>
        <div>
            <label for="duree_totale_projet"><h3>Durée totale du projet (en jours) :</h3></label>
            <input <?php if (!empty($_SESSION['error']['duree_totale_projet'])) { ?> class="inputError" <?php } ?> id="duree_totale_projet" type="number"  name="duree_totale_projet" value="<?= $duree_totale_projet??'' ?>" step="0.1" min="0" required>
            <?php if (!empty($_SESSION['error']['duree_totale_projet'])) { ?>
                <p class="messageError"><?= $_SESSION['error']['duree_totale_projet'] ?></p>
            <?php } unset($_SESSION['error']['duree_totale_projet']); ?>
        </div>
        <div>
            <label for="total_plans"><h3>Total de plans réalisés :</h3></label>
            <input <?php if (!empty($_SESSION['error']['total_plans'])) { ?> class="inputError" <?php } ?> type="number" id="total_plans" name="total_plans" value="<?= $total_plans??'' ?>" min="0">
            <?php if (!empty($_SESSION['error']['total_plans'])) { ?>
                <p class="messageError"><?= $_SESSION['error']['total_plans'] ?></p>
            <?php } unset($_SESSION['error']['total_plans']); ?>
        </div>
        <div>
            <?php if ($project->getIs_cleaning() == 1) { ?>
            <label for="duree_cleaning"><h3>Durée du cleaning (en jours) :</h3></label>
            <input <?php if (!empty($_SESSION['error']['duree_cleaning'])) { ?> class="inputError" <?php } ?> type="number" id="duree_cleaning"  id="duree_cleaning" name="duree_cleaning" value="<?= $duree_cleaning??'' ?>" step="0.1" min="0">
            <?php if (!empty($_SESSION['error']['duree_cleaning'])) { ?>
                <p class="messageError"><?= $_SESSION['error']['duree_cleaning'] ?></p>
            <?php } unset($_SESSION['error']['duree_cleaning']); ?>
            <?php } ?>
        </div>
        
        <div class="container-sequences">
            <?php
            //si des séquences sont assignées au projet, on affiche les durées estimées par séquence
                if  ($sequences && count($sequences) > 0) {
            ?>
            <h3>Durée par séquence (en heures):</h3>
            <div class="all-sequences-finalReport">
                <?php foreach ($sequences as $sequence) { ?>
                    <label for="duree_sequence[<?= $sequence->getId();?>]">
                <b>Séquence <?= $sequence->getNumber() ?> :</b></br><?= $sequence->getTitle() ?> (<?= $sequence->getTypeLabel() ?>)
                    </label>
                    <input <?php if (!empty($_SESSION['error']['duree_sequence' . $sequence->getId()])) { ?> class="inputError" <?php } ?> type="number" id="duree_sequence[<?= $sequence->getId();?>]" name="duree_sequence[<?= $sequence->getId();?>]" value="<?= $duree_sequence[$sequence->getId()] ?? '' ?>" min="0">
                    <?php if (!empty($_SESSION['error']['duree_sequence' . $sequence->getId()])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['duree_sequence' . $sequence->getId()] ?></p>
                    <?php } unset($_SESSION['error']['duree_sequence' . $sequence->getId()]); ?>
                    <br>
                <?php }} ?>
            </div>
        </div>
        <div>
            <label for="commentaire"><h3>Commentaire :</h3></label>
            <textarea name="commentaire" id="commentaire" placeholder="Commentaire…"><?= $commentaire??'' ?></textarea>
        </div>
        <input class="button" type="submit" name="submit_final_report" id="submit_final_report" value="Valider">
    </form>

</main>