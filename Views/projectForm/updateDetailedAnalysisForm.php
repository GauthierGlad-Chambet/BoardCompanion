<main>

<h1>Modifier l'analyse détaillée</h1>

<form action="index.php" method="get">

        <!-- Conserver les paramètres controller et action -->
        <input type="hidden" name="controller" value="form">
        <?php if ($project->getIs_detailed() == 0 ) { ?>
            <input type="hidden" name="action" value="detailedAnalysis">
        <?php } else { ?>
            <input type="hidden" name="action" value="updateDetailedAnalysis">
        <?php } ?>

        <select name="project_id" id="">
            <?php foreach ($projects as $proj) : ?>
                <option value="<?= $proj->getId() ?>" <?= ($proj->getId() == $project->getId()) ? 'selected' : '' ?>>
                    <?= $proj->getName() ?>, <?= $proj->getStudio() ?>, Épisode n<sup>o</sup> <?= $proj->getEpisode_nb() ?> : "<?= $proj->getEpisode_title() ?>"
                </option> <?php endforeach; ?>
        </select>
        <input type="submit" value="Changer de projet">
</form>

<h2>Scènes extraites</h2>

<?php if (!empty($sequences)): ?>
    
    <form action="" method="POST">
        <input type="hidden" name="project_id" value="<?= htmlspecialchars($projectId) ?>">
        <?php foreach ($sequences as $index => $sequence): ?>

            <!-- Champ caché pour identifier la séquence à mettre à jour -->
            <input type="hidden" name="sequence_id_<?= $index ?>" value="<?= $sequence->getId() ?>">
       
            <div class="sequence-block">
                <h3>Séquence <?= $sequence->getNumber() ?> - <?= htmlspecialchars($sequence->getTitle()) ?></h3>
                <p><strong><?= $sequence->getLines_count() ?> lignes</strong></p>
                <ul>
                    <?php foreach (array_slice(json_decode($sequence->getScript(), true) ?? [], 0, 5) as $line): ?>
                        <li><?= htmlspecialchars($line) ?></li>
                    <?php endforeach; ?>
                    <li>…</li>
                </ul>
            </div>
            
            <p>Type de séquence :</p>
            <input type="radio" id="SequenceAction_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Action" <?= $sequence->getFk_type() == 1 ? 'checked' : '' ?> />
            <label for="SequenceAction_<?= $index ?>">Action</label>
            <input type="radio" id="SequenceComedie_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Comedie" <?= $sequence->getFk_type() == 2 ? 'checked' : '' ?> />
            <label for="SequenceComedie_<?= $index ?>">Comédie</label>
            <input type="radio" id="SequenceMixte_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Mixte" <?= $sequence->getFk_type() == 3 ? 'checked' : '' ?> />
            <label for="SequenceMixte_<?= $index ?>">Mixte</label>

            <p>Je m'en occupe :</p>
            <input type="radio" id="assigned_<?= $index ?>" name="is_assigned_<?= $index ?>" value="1" <?= $sequence->getIs_assigned() ? 'checked' : '' ?> />
            <label for="assigned_<?= $index ?>">Oui</label>
            <input type="radio" id="not_assigned_<?= $index ?>" name="is_assigned_<?= $index ?>" value="0" <?= !$sequence->getIs_assigned() ? 'checked' : '' ?> />
            <label for="not_assigned_<?= $index ?>">Non</label>
            <hr>
        <?php endforeach; ?>

        <input type="submit" name="submit_sequences" id="submit_sequences" value="Valider les séquences">
    </form>
<?php else: ?>
    <p>Aucune scène trouvée.</p>
<?php endif; ?>
</main>