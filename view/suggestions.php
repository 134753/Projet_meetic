
<?php if (empty($suggestions)): ?>
    <p>Aucun profil correspondant trouvé pour le moment 😢</p>
<?php else: ?>
    <h2>Suggestions de profils compatibles</h2>
    <ul>
        <?php foreach ($suggestions as $s): ?>
            <li>
                <strong><?= htmlspecialchars($s['pseudo']) ?></strong> —
                <?= htmlspecialchars($s['firstname']) ?> de <?= htmlspecialchars($s['city']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p><a href="index.php?controller=user&action=home">⬅️ Retour à l'accueil</a></p>
