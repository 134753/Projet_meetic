<h2>💬 Discussion avec <?= htmlspecialchars($matchUser['pseudo']) ?></h2>

<div style="max-height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
    <?php foreach ($messages as $message): ?>
        <p>
            <strong><?= $message['sender_id'] == $_SESSION['user']['id'] ? 'Vous' : htmlspecialchars($matchUser['pseudo']) ?>:</strong>
            <?= htmlspecialchars($message['content']) ?>
            <br><small><?= $message['created_at'] ?></small>
        </p>
    <?php endforeach; ?>
</div>

<form method="post" style="margin-top: 15px;">
    <textarea name="content" rows="3" style="width: 100%;" placeholder="Écrivez un message..."></textarea>
    <button type="submit">📤 Envoyer</button>
</form>

<p><a href="index.php?controller=user&action=matches">⬅️ Retour à mes matchs</a></p>
