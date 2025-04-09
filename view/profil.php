
<h2>Mon profil</h2>

<p><strong>Pseudo :</strong> <?= htmlspecialchars($user['pseudo']) ?></p>
<p><strong>Nom :</strong> <?= htmlspecialchars($user['firstname']) ?> <?= htmlspecialchars($user['lastname']) ?></p>
<p><strong>Date de naissance :</strong> <?= htmlspecialchars($user['birthdate']) ?></p>
<p><strong>Ville :</strong> <?= htmlspecialchars($user['city']) ?></p>
<p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
<p><strong>Genre :</strong> <?= htmlspecialchars($genre) ?></p>
<p><strong>Hobbies :</strong> <?= implode(', ', array_map('htmlspecialchars', $hobbies)) ?></p>

<br>

<a href="index.php?controller=user&action=editProfil">✏️ Modifier mon profil</a> 
<p><a href="index.php?controller=user&action=home">🏠 Revenir à l'accueil</a></p>
<p><a href="index.php?controller=auth&action=logout">Se déconnecter</a></p>
