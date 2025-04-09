<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Accueil' ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 2rem;
            text-align: center;
        }
        h1 {
            color: #E91E63;
        }
        a {
            display: inline-block;
            margin-top: 1rem;
            text-decoration: none;
            color: #333;
            padding: 0.5rem 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #fff;
        }
        a:hover {
            background: #E91E63;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
    ?>

    <h1>Bienvenue sur Meetic</h1>

    <?php if (isset($_SESSION['user'])): ?>
        <p>Bonjour, <?= htmlspecialchars($_SESSION['user']['pseudo']) ?> !</p>
        <a href="index.php?controller=user&action=profil">👤 Voir mon profil</a> 
        <a href="index.php?controller=user&action=match">🎯 Faire des rencontres</a>
        <a href="index.php?controller=user&action=suggestions">💘 Suggestions de profils</a>|
        <a href="index.php?controller=auth&action=logout">🚪 Se déconnecter</a>
    <?php else: ?>
        <a href="index.php?controller=auth&action=login">🔐 Connexion</a> |
        <a href="index.php?controller=user&action=register">📝 Inscription</a>
    <?php endif; ?>



</body>
</html>
