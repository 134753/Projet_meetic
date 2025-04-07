<?php
require_once 'models/UserModel.php';
require_once 'db.php';

class AuthController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new UserModel($pdo);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->loginUser($email, $password);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header('Location: match.php');
                exit;
            } else {
                echo "Identifiants incorrects";
            }
        }

        require 'views/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = $_POST['pseudo'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $birthdate = $_POST['birthdate'];
            $city = $_POST['city'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->registerUser($pseudo, $firstname, $lastname, $birthdate, $city, $email, $password)) {
                header('Location: index.php');
                exit;
            } else {
                echo "Erreur lors de l'inscription.";
            }
        }

        require 'views/register.php';
    }
}
?>
