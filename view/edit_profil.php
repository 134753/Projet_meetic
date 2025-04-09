
<h2>Modifier mon profil</h2>

<?php if (!empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<form method="POST">
    <label>Prénom :</label><br>
    <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" required><br><br>

    <label>Nom :</label><br>
    <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" required><br><br>

    <label>Ville :</label><br>
    <input type="text" name="city" value="<?= htmlspecialchars($user['city']) ?>" required><br><br>

    <label>Genre :</label><br>
    <?php foreach ($genres as $genre): ?>
        <label>
            <input type="radio" name="genre" value="<?= $genre['id'] ?>" <?= $userGenre === $genre['name'] ? 'checked' : '' ?>>
            <?= htmlspecialchars($genre['name']) ?>
        </label><br>
    <?php endforeach; ?>

    <br><label>Hobbies :</label><br>
    <?php foreach ($hobbies as $hobby): ?>
        <label>
            <input type="checkbox" name="hobbies[]" value="<?= $hobby['id'] ?>" 
                <?= in_array($hobby['name'], $userHobbies) ? 'checked' : '' ?>>
            <?= htmlspecialchars($hobby['name']) ?>
        </label><br>
    <?php endforeach; ?>

    <hr>
    <h3>Changer mon mot de passe</h3>

    <label>Ancien mot de passe :</label><br>
    <input type="password" name="old_password"><br><br>

    <label>Nouveau mot de passe :</label><br>
    <input type="password" name="new_password"><br><br>

    <label>Confirmer le nouveau mot de passe :</label><br>
    <input type="password" name="confirm_password"><br><br>


    <br>
    <input type="submit" value="Enregistrer les modifications">
</form>

<br>
<p><a href="index.php?controller=user&action=profil">⬅ Retour au profil</a></p>
