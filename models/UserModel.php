<?php
class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function registerUser($pseudo, $firstname, $lastname, $birthdate, $city, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO user (pseudo, firstname, lastname, birthdate, city, email, password) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$pseudo, $firstname, $lastname, $birthdate, $city, $email, $hashedPassword]);
    }

    public function loginUser($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMatchingUsers($currentUserId)
    {
        $stmt = $this->pdo->query("SELECT * FROM user WHERE id != $currentUserId LIMIT 10");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

