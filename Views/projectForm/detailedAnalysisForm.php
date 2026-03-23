<main>

<h1>Analyse detaillee</h1>

<p>
<?php echo "{$project->getName()}, {$project->getStudio()}, Épisode n<sup>o</sup> {$project->getEpisode_nb()} : {$project->getEpisode_title()}"?>
</p>

<h2>Scènes extraites</h2>
<div class="container" >
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
                <div class="containerSequence">
                    <ul>
                        <!-- Affichage des 5 premières lignes de la séquence pour un aperçu -->
                        <?php foreach (array_slice($sequence['content'], 0, 5) as $line): ?>
                            <li><?= htmlspecialchars($line) ?></li>
                            <?php endforeach; ?>
                            <li>…</li>
                        </ul>
                    </div>

                <!-- Champ caché pour transmettre le contenu de la séquence -->
                <input type="hidden" name="sequence_content_<?= $index ?>" value="<?= htmlspecialchars(json_encode($sequence['content'])) ?>">
            </div>
                <p>Type de séquence :</p>
                <label class="customLabel radioLabel" for="SequenceAction_<?= $index ?>">Action
                    <input type="radio" id="SequenceAction_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Action" checked />
                            
                </label>
                <label class="customLabel radioLabel" for="SequenceComedie_<?= $index ?>">Comédie
                    <input type="radio" id="SequenceComedie_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Comedie" />

                </label>
                <label class="customLabel radioLabel" for="SequenceMixte_<?= $index ?>">Mixte
                    <input type="radio" id="SequenceMixte_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Mixte" />
                    <span class="checkmark"></span>
                </label>
                
                <p>Je m'en occupe :</p>
                <label class="customLabel radioLabel" for="assigned_<?= $index ?>">Oui
                    <input type="radio" id="assigned_<?= $index ?>" name="is_assigned_<?= $index ?>" value="1" checked />
                    <span class="checkmark"></span>
                </label>
                <label class="customLabel radioLabel" for="not_assigned_<?= $index ?>">Non
                    <input type="radio" id="not_assigned_<?= $index ?>" name="is_assigned_<?= $index ?>" value="0" />
                    <span class="checkmark"></span>
                </label>
            <hr>
        <?php endforeach; ?>
        <input type="submit" name="submit_sequences" id="submit_sequences" value="Valider les séquences">
    </form>
    <?php else: ?>
    <p>Aucune scène trouvée.</p>
<?php endif; ?>
</div>
</main>