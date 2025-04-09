<?php
require_once 'core/Controller.php';
require_once 'model/User.php';

class UserController extends Controller
{
    public function home()
    {
        session_start();

        $pseudo = isset($_SESSION['user']['pseudo']) ? $_SESSION['user']['pseudo'] : null;

        $this->render('home', [
            'title' => 'Accueil',
            'pseudo' => $pseudo
        ]);
    }


    public function register()
    {
        $errors = [];
        $userModel = new User(); // 👈 nécessaire partout

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $required = ['pseudo', 'firstname', 'lastname', 'birthdate', 'city', 'email', 'password'];
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    $errors[] = "Le champ '$field' est obligatoire.";
                }
            }

            // Email déjà utilisé
            if (empty($errors)) {
                if ($userModel->findByEmail($_POST['email'])) {
                    $errors[] = "Un compte existe déjà avec cet email.";
                }
            }

            if (empty($errors)) {
                // Création de l'utilisateur
                $success = $userModel->create($_POST);
                if (!$success) {
                    echo "❌ Erreur lors de la création de l'utilisateur<br>";
                    print_r($userModel->db->errorInfo());
                    die();
                } else {
                    echo "✅ Utilisateur enregistré<br>";
                }


                // Récupération de l'utilisateur créé
                $user = $userModel->findByEmail($_POST['email']);

                // Enregistrement des hobbies
                if ($user && !empty($_POST['hobbies'])) {
                    foreach ($_POST['hobbies'] as $hobbyId) {
                        $stmt = $userModel->db->prepare("INSERT INTO user_hobby (id_user, id_hobby) VALUES (?, ?)");
                        $stmt->execute([$user['id'], $hobbyId]);
                    }
                }

                // Enregistrement du genre
                if ($user && isset($_POST['genre'])) {
                    $stmt = $userModel->db->prepare("INSERT INTO user_genre (id_user, id_genre) VALUES (?, ?)");
                    $stmt->execute([$user['id'], $_POST['genre']]);
                }

               header("Location: index.php?controller=user&action=home");
               exit;
            }
        }

        // Affichage du formulaire
        $hobbies = $userModel->getAllHobbies();
        $genres = $userModel->getAllGenres();

        $this->render('register', [
            'title' => 'Inscription',
            'errors' => $errors,
            'hobbies' => $hobbies,
            'genres' => $genres
        ]);
    }
    
    public function profil()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $userModel = new User();
        $userId = $_SESSION['user']['id'];
        $user = $userModel->findById($userId);
        $genre = $userModel->getUserGenre($userId);
        $hobbies = $userModel->getUserHobbies($userId);

        $this->render('profil', [
            'title' => 'Mon profil',
            'user' => $user,
            'genre' => $genre,
            'hobbies' => $hobbies
        ]);
    }

    public function editProfil()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $userModel = new User();
        $userId = $_SESSION['user']['id'];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'city' => $_POST['city'],
                'id' => $userId
            ];

            $userModel->updateProfile($data);

            // MAJ hobbies
            $userModel->updateUserHobbies($userId, $_POST['hobbies'] ?? []);

            // MAJ genre
            $userModel->updateUserGenre($userId, $_POST['genre'] ?? null);

            if (!empty($_POST['old_password']) || !empty($_POST['new_password']) || !empty($_POST['confirm_password'])) {
                if (empty($_POST['old_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
                    $errors[] = "Tous les champs du mot de passe doivent être remplis.";
                } else {
                    $currentUser = $userModel->findById($userId);
            
                    if (!password_verify($_POST['old_password'], $currentUser['password'])) {
                        $errors[] = "L'ancien mot de passe est incorrect.";
                    } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
                        $errors[] = "Les nouveaux mots de passe ne correspondent pas.";
                    } else {
                        $userModel->updatePassword($userId, $_POST['new_password']);
                    }
                }
            }
            

            header("Location: index.php?controller=user&action=profil");
            exit;
        }

        $user = $userModel->findById($userId);
        $genres = $userModel->getAllGenres();
        $hobbies = $userModel->getAllHobbies();
        $userGenre = $userModel->getUserGenre($userId);
        $userHobbies = $userModel->getUserHobbies($userId);

        $this->render('edit_profil', [
            'title' => 'Modifier mon profil',
            'user' => $user,
            'genres' => $genres,
            'hobbies' => $hobbies,
            'userGenre' => $userGenre,
            'userHobbies' => $userHobbies,
            'errors' => $errors
        ]);
        
    }

    public function suggestions()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $userModel = new User();
        $suggestedUsers = $userModel->getSuggestions($_SESSION['user']['id']);

        $this->render('suggestions', [
            'title' => 'Suggestions de profils',
            'suggestions' => $suggestedUsers
        ]);
    }

    public function match()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $userModel = new User();

        // Si l'utilisateur a cliqué sur "like"
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matched_user_id'])) {
            $userModel->saveMatch($userId, $_POST['matched_user_id']);
        }

        // Récupère le prochain profil à suggérer
        $suggestion = $userModel->getNextSuggestion($userId);

        $this->render('match', [
            'title' => 'Faire des rencontres',
            'suggestion' => $suggestion
        ]);
    }



}
