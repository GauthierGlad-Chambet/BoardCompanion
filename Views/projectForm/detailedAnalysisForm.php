<main>

<h1>ANALYSE DÉTAILLÉE</h1>
   <!-- detailedAnalysisForm.php -->
<h2>Scènes extraites</h2>

<?php if (!empty($sequenceHeaders)): ?>
<form action="" method="POST">
    <!-- Champ caché pour transmettre l'ID du projet -->
    <input type="hidden" name="project_id" value="<?= htmlspecialchars($projectId) ?>">

  <?php  foreach ($sequenceHeaders as $index => $sequence): ?>
     <!-- Champ caché pour transmettre le titre de la séquence -->
    <input type="hidden" name="sequence_header_<?= $index ?>" value="<?= htmlspecialchars($sequence['header']) ?>">
        <div class="sequence-block">
            <h3>Séquence <?= $index + 1 ?> - <?= htmlspecialchars($sequence['header']) ?></h3>
            <p><strong>Ligne <?= $sequence['line_number'] ?></strong></p>
            <ul>
                <!-- Affichage des 5 premières lignes de la séquence pour un aperçu -->
                <?php foreach (array_slice($sequence['content'], 0, 5) as $line): ?>
                    <li><?= htmlspecialchars($line) ?></li>
                <?php endforeach; ?>
                <li>…</li>
            </ul>

            <!-- Champ caché pour transmettre le contenu de la séquence -->
            <input type="hidden" name="sequence_content_<?= $index ?>" value="<?= htmlspecialchars(json_encode($sequence['content'])) ?>">
        </div>
            <p>Type de séquence :</p>
            <input type="radio" id="SequenceAction_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Action" checked />
            <label for="SequenceAction_<?= $index ?>">Action</label>
            <input type="radio" id="SequenceComedie_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Comedie" />
            <label for="SequenceComedie_<?= $index ?>">Comédie</label>
            <input type="radio" id="SequenceMixte_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Mixte" />
            <label for="SequenceMixte_<?= $index ?>">Mixte</label>
            
            <p>Je m'en occupe :</p>
            <input type="radio" id="assigned_<?= $index ?>" name="is_assigned_<?= $index ?>" value="1" checked />
            <label for="assigned_<?= $index ?>">oui</label>
            <input type="radio" id="not_assigned_<?= $index ?>" name="is_assigned_<?= $index ?>" value="0" />
            <label for="not_assigned_<?= $index ?>">Non</label>
        <hr>
    <?php endforeach; ?>
    <input type="submit" name="submit_sequences" id="submit_sequences" value="Valider les séquences">
    </form>
<?php else: ?>
    <p>Aucune scène trouvée.</p>
<?php endif; ?>
</main>