<h2>💑 Vos matchs mutuels</h2>

<?php if (empty($matches)): ?>
    <p>Vous n'avez pas encore de match mutuel. Continuez à swiper !</p>
<?php else: ?>
    <ul>
        <?php foreach ($matches as $match): ?>
            <li>
                <strong><?= htmlspecialchars($match['pseudo']) ?></strong> —
                <?= htmlspecialchars($match['firstname']) ?> de <?= htmlspecialchars($match['city']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<ul>
<?php foreach ($matches as $match): ?>
    <li>
        <strong><?= htmlspecialchars($match['pseudo']) ?></strong> —
        <?= htmlspecialchars($match['firstname']) ?> de <?= htmlspecialchars($match['city']) ?>
        <?php if ($match['unread'] > 0): ?>
            <span style="color: red;">🔔 <?= $match['unread'] ?> nouveau(x) message(s)</span>
        <?php endif; ?>
        - <a href="index.php?controller=user&action=chat&match_id=<?= $match['id'] ?>">💬 Discuter</a>
    </li>
<?php endforeach; ?>
</ul>


<a href="index.php?controller=user&action=chat&match_id=<?= $match['id'] ?>">💬 Discuter</a>
<p><a href="index.php?controller=user&action=home">⬅️ Retour à l'accueil</a></p>
