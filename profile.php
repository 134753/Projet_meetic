<?php
session_start();
require_once 'controllers/UserController.php';
require_once 'db.php'; // fichier où tu initialises la connexion PDO

$userId = 41; // ou récupéré dynamiquement via session ou requête GET
$userController = new UserController($pdo); // Passe $pdo correctement ici
$userData = $userController->getUserById($userId);

// Vérification de la connexion utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=meetic', 'root', 'ROOT', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des informations utilisateur
$userController = new UserController($pdo);
$userId = $_SESSION['user_id'];
$user = $userController->getUserById($userId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= htmlspecialchars($user['firstname']) ?></title>
</head>
<body>
    <h1>Bienvenue sur votre profil, <?= htmlspecialchars($user['firstname']) ?>!</h1>

    <p><strong>Pseudo :</strong> <?= htmlspecialchars($user['pseudo']) ?></p>
    <p><strong>Prénom :</strong> <?= htmlspecialchars($user['firstname']) ?></p>
    <p><strong>Ville :</strong> <?= htmlspecialchars($user['city']) ?></p>
    <p><strong>Âge :</strong> <?= $user['age'] ?> ans</p>

    <a href="logout.php">Se déconnecter</a>
</body>
</html>