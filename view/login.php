<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Connexion' ?></title>
    <style>
        body {
            font-family: Arial;
            background: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 400px;
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
            background: #2196F3;
            color: white;
            border: none;
        }
        button:hover {
            background: #1976D2;
        }
    </style>
</head>
<body>
    <form action="index.php?controller=auth&action=login" method="POST">
        <h2>Connexion</h2>

        <?php if (!empty($errors)): ?>
            <div style="background:#ffe0e0; padding:1rem; border-radius:8px; color:#c00; margin-bottom:1rem;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Email" value="<?= $_POST['email'] ?? '' ?>" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>

        <p style="margin-top:1rem;">
            <a href="index.php?controller=user&action=register">Pas encore de compte ? Inscription</a><br>
            <a href="index.php?controller=user&action=home">← Retour à l'accueil</a>
        </p>
    </form>
</body>
</html>
