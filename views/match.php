<?php
require_once 'controllers/MatchController.php';

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=meetic', 'root', 'ROOT', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer l'ID utilisateur depuis une requête GET par exemple
$userId = $_GET['user_id'] ?? 1;

$matchController = new MatchController($pdo);
$matches = $matchController->getMatchesForUser($userId);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matchs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <a href="profil.php">Mon Profil</a> | 
        <a href="logout.php">Se Déconnecter</a>
    <h1>Résultats de vos matchs</h1>
    
    <?php if (!empty($matches)): ?>
        <ul>
            <?php foreach ($matches as $match): ?>
                <li>
                    <strong>Pseudo :</strong> <?= htmlspecialchars($match['pseudo']) ?><br>
                    <strong>Prénom :</strong> <?= htmlspecialchars($match['firstname']) ?><br>
                    <strong>Ville :</strong> <?= htmlspecialchars($match['city']) ?><br>
                    <strong>Age :</strong> <?= $match['age'] ?> ans
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun match trouvé pour le moment.</p>
    <?php endif; ?>
</body>
</html>


