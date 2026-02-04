<main>


   <!-- detailedAnalysisForm.php -->
<h2>Scènes extraites</h2>

<?php if (!empty($sceneHeaders)):
    foreach ($sceneHeaders as $index => $scene): ?>
        <div class="scene-block">
            <h3>Séquence <?= $index + 1 ?> - <?= htmlspecialchars($scene['header']) ?></h3>
            <p><strong>Ligne <?= $scene['line_number'] ?></strong></p>
            <ul>
                <?php foreach ($scene['content'] as $line): ?>
                    <li><?= htmlspecialchars($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucune scène trouvée.</p>
<?php endif; ?>
</main>