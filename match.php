<?php
require_once 'controllers/MatchController.php';

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=meetic', 'root', 'ROOT', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$userId = $_GET['user_id'] ?? 1;

// Passer la connexion PDO au constructeur
$matchController = new MatchController($pdo);
$matches = $matchController->getMatchesForUser($userId);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des matchs</title>
</head>
<body>
        <a href="profile.php">Mon Profil</a> | 
        <a href="logout.php">Se Déconnecter</a>
    <h1>Vos matchs</h1>
    <ul>
        <?php if (!empty($matches)): ?>
            <?php foreach ($matches as $match): ?>
                <li>
                    <strong>Pseudo :</strong> <?= htmlspecialchars($match['pseudo']) ?><br>
                    <strong>Prénom :</strong> <?= htmlspecialchars($match['firstname']) ?><br>
                    <strong>Ville :</strong> <?= htmlspecialchars($match['city']) ?><br>
                    <strong>Âge :</strong> <?= $match['age'] ?> ans
                </li>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun match trouvé pour le moment.</p>
        <?php endif; ?>
    </ul>
</body>
</html>

