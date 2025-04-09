<?php
require_once 'core/Controller.php';
require_once 'model/User.php';

class AuthController extends Controller {
    public function login() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $errors[] = "Veuillez remplir tous les champs.";
            } else {
                $userModel = new User();
                $user = $userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'pseudo' => $user['pseudo'],
                        'email' => $user['email']
                    ];
                    header("Location: index.php?controller=user&action=home");
                    exit;
                } else {
                    $errors[] = "Identifiants incorrects.";
                }
            }
        }

        $this->render('login', [
            'title' => 'Connexion',
            'errors' => $errors
        ]);
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?controller=user&action=home");
        exit;
    }
}
