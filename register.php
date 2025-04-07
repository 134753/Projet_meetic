<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO user (pseudo, firstname, lastname, birthdate, city, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$pseudo, 'Test', 'User', '2000-01-01', 'City', $email, $password]);
    
    echo "Inscription réussie!";
}
?>

<form method="POST" action="register.php">
    <h2>Inscription</h2>
    Pseudo: <input type="text" name="pseudo" required>
    Prénom: <input type="text" name="firstname" required>
    Nom: <input type="text" name="lastname" required>
    Date de naissance: <input type="date" name="birthdate" required>
    Ville: <input type="text" name="city" required>
    Email: <input type="email" name="email" required>
    Mot de passe: <input type="password" name="password" required>
    <button type="submit">S'inscrire</button>
</form>
<a href="views/login.php">Se connecter</a>
