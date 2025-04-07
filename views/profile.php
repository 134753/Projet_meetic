<?php
session_start();
require_once 'controllers/UserController.php';

// Connexion à la base de données (ajuste les paramètres)
try {
    $pdo = new PDO("mysql:host=localhost;dbname=meetic", "root", "ROOT");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Création du contrôleur en lui passant l'objet PDO
    $controller = new UserController($pdo);
    
    // Utilisation de la méthode getUserById
    $user = $controller->getUserById(41); // Par exemple, l'ID de l'utilisateur est 41
    
    // Afficher l'utilisateur ou d'autres actions
    print_r($user);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
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

