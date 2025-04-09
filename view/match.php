
<h2>💘 Suggestions de profils</h2>

<?php if (!$suggestion): ?>
    <p>Plus de suggestions pour le moment.</p>
<?php else: ?>
    <p><strong><?= htmlspecialchars($suggestion['pseudo']) ?></strong> - <?= htmlspecialchars($suggestion['firstname']) ?> (<?= htmlspecialchars($suggestion['city']) ?>)</p>

    <form method="post" action="index.php?controller=user&action=match">
        <input type="hidden" name="matched_user_id" value="<?= $suggestion['id'] ?>">
        <button type="submit">❤️ Liker</button>
    </form>

    <form method="get" action="index.php">
        <input type="hidden" name="controller" value="user">
        <input type="hidden" name="action" value="match">
        <button type="submit">❌ Passer</button>
    </form>
<?php endif; ?>

<p><a href="index.php?controller=user&action=home">⬅️ Retour à l'accueil</a></p>
