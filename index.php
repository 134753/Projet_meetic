<?php
require_once 'controllers/AuthController.php';
require_once 'db.php';

// Redirection vers la page de connexion par défaut
$authController = new AuthController($pdo);
$authController->login();
?>


