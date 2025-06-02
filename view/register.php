<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Inscription' ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }
       
        input, button {
            display: block;
            width: 100%;
            margin-bottom: 1rem;
            padding: 0.7rem;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: #E91E63;
            color: white;
            border: none;
        }
        button:hover {
            background: #d81b60;
        }
    </style>
</head>

<body>
    <form action="index.php?controller=user&action=register" method="POST">
        <h2>Inscription</h2>

        <?php if (!empty($errors)): ?>
            <div style="background:#ffe0e0; padding:1rem; border-radius:8px; color:#c00; margin-bottom:1rem;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <input type="text" name="pseudo" placeholder="Pseudo" value="<?= $_POST['pseudo'] ?? '' ?>" required>
        <input type="text" name="firstname" placeholder="Prénom" value="<?= $_POST['firstname'] ?? '' ?>" required>
        <input type="text" name="lastname" placeholder="Nom" value="<?= $_POST['lastname'] ?? '' ?>" required>
        <input type="date" name="birthdate" value="<?= $_POST['birthdate'] ?? '' ?>" required>
        <input type="text" name="city" placeholder="Ville" value="<?= $_POST['city'] ?? '' ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= $_POST['email'] ?? '' ?>" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <label for="hobbies">Vos hobbies :</label>
        <div style="margin-bottom: 1rem;">
            <?php foreach ($hobbies ?? [] as $hobby): ?>
                <label style="display: block;">
                    <input type="checkbox" name="hobbies[]" value="<?= $hobby['id'] ?>"
                        <?= in_array($hobby['id'], $_POST['hobbies'] ?? []) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($hobby['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>
        <label for="genre">Genre :</label>
        <div style="margin-bottom: 1rem;">
            <?php foreach ($genres ?? [] as $genre): ?>
                <label style="margin-right: 1rem;">
                    <input type="radio" name="genre" value="<?= $genre['id'] ?>"
                        <?= (($_POST['genre'] ?? '') == $genre['id']) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($genre['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>


        <button type="submit">Créer un compte</button>
    </form>

    <p style="margin-top:1rem;">
        <a href="index.php?controller=user&action=home">← Retour à l'accueil</a><br>
        <a href="index.php?controller=auth&action=login">Déjà un compte ? Se connecter</a>
    </p>

</body>

</html>
