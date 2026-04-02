<main>
    <h1>Modifier l'analyse detaillee</h1>
    <form class="form-select" action="index.php" method="get">
        <!-- Conserver les paramètres controller et action -->
        <input type="hidden" name="controller" value="form">
        <?php if ($project->getIs_detailed() == 0) { ?>
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
        <!-- <input class="button" type="submit" value="Changer de projet"> -->
    </form>
    <div class="container" id="container-detailed-analysis">
        <p class="explication"><b>Vous pouvez analyser chaque séquence ci-dessous. Rien n'est obligatoire : complétez uniquement celles que vous souhaitez.</b></p>
        <?php if (!empty($sequences)): ?>
            <form action="" method="POST">
                <div class="all-sequences-container">
                    <input type="hidden" name="project_id" value="<?= htmlspecialchars($projectId) ?>">
                    <?php foreach ($sequences as $index => $sequence): ?>

                        <!-- Champ caché pour identifier la séquence à mettre à jour -->
                        <input type="hidden" name="sequence_id_<?= $index ?>" value="<?= $sequence->getId() ?>">
                        <h3>Séquence <?= $sequence->getNumber() ?> : </br> <?= htmlspecialchars($sequence->getTitle()) ?></h3>
                        <p class="note"><?= $sequence->getLines_count() ?> lignes</p>
                        <div>
                            <div class="container-sequence">
                                <ul>
                                    <?php foreach (array_slice(json_decode($sequence->getScript(), true) ?? [], 0, 5) as $line): ?>
                                        <li><?= htmlspecialchars($line) ?></li>
                                    <?php endforeach; ?>
                                    <li>…</li>
                                </ul>
                            </div>
    
                            <div class="container-sequence-radio">
                                <div>
                                    <p>Type de séquence :</p>
                                    <label class="customLabel radioLabel" for="SequenceAction_<?= $index ?>">Action
                                        <input type="radio" id="SequenceAction_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Action" <?= $sequence->getFk_type() == 1 ? 'checked' : '' ?> />
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="customLabel radioLabel" for="SequenceComedie_<?= $index ?>">Comédie
                                        <input type="radio" id="SequenceComedie_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Comedie" <?= $sequence->getFk_type() == 2 ? 'checked' : '' ?> />
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="customLabel radioLabel" for="SequenceMixte_<?= $index ?>">Mixte
                                        <input type="radio" id="SequenceMixte_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Mixte" <?= $sequence->getFk_type() == 3 ? 'checked' : '' ?> />
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="hidden" for="SequenceNA_<?= $index ?>">Inderterminé
                                        <input type="radio" id="SequenceNA_<?= $index ?>" name="typeSequence_<?= $index ?>" value="Indetermine" <?= $sequence->getFk_type() == 4 ? 'checked' : '' ?> />
                                        <span class="checkmark"></span>
                                    </label>
                                    <?php if (!empty($_SESSION['error']['type'. $index])) { ?>
                                        <p class="messageError"><?= $_SESSION['error']['type'. $index] ?></p>
                                    <?php } unset($_SESSION['error']['type'. $index]); ?>
                                </div>
                                <div>
                                    <p>Je m'en occupe :</p>
                                    <div class="container-occupe">
                                        <label class="customLabel radioLabel" for="assigned_<?= $index ?>">Oui
                                            <input type="radio" id="assigned_<?= $index ?>" name="is_assigned_<?= $index ?>" value="1" <?= $sequence->getIs_assigned() ? 'checked' : '' ?> />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="customLabel radioLabel" for="not_assigned_<?= $index ?>">Non
                                            <input type="radio" id="not_assigned_<?= $index ?>" name="is_assigned_<?= $index ?>" value="0" <?= !$sequence->getIs_assigned() ? 'checked' : '' ?> />
                                            <span class="checkmark"></span>
                                        </label>
                                        <?php if (!empty($_SESSION['error']['is_assigned'. $index])) { ?>
                                            <p class="messageError"><?= $_SESSION['error']['is_assigned'. $index] ?></p>
                                        <?php } unset($_SESSION['error']['is_assigned'. $index]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?php endforeach; ?>
                    </div>
                <input class="button" type="submit" name="submit_sequences" id="submit_sequences" value="Valider les séquences">
            </form>
        <?php else: ?>
            <p>Aucune scène trouvée.</p>
        <?php endif; ?>
    </div>
</main>