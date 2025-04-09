<?php

require_once 'core/Model.php';

class User extends Model
{
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO user (pseudo, firstname, lastname, birthdate, city, email, password)
            VALUES (:pseudo, :firstname, :lastname, :birthdate, :city, :email, :password)
        ");

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        return $stmt->execute([
            'pseudo'     => $data['pseudo'],
            'firstname'  => $data['firstname'],
            'lastname'   => $data['lastname'],
            'birthdate'  => $data['birthdate'],
            'city'       => $data['city'],
            'email'      => $data['email'],
            'password'   => $hashedPassword
        ]);
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllHobbies()
    {
        $stmt = $this->db->query("SELECT * FROM hobby");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllGenres()
    {
        $stmt = $this->db->query("SELECT * FROM genre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserGenre($userId)
    {
        $stmt = $this->db->prepare("
            SELECT genre.name 
            FROM user_genre 
            JOIN genre ON genre.id = user_genre.id_genre 
            WHERE user_genre.id_user = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn(); // retourne juste le nom du genre
    }

    public function getUserHobbies($userId)
    {
        $stmt = $this->db->prepare("
            SELECT hobby.name 
            FROM user_hobby 
            JOIN hobby ON hobby.id = user_hobby.id_hobby 
            WHERE user_hobby.id_user = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // retourne un tableau de noms de hobbies
    }

    public function updateProfile($data)
    {
        $stmt = $this->db->prepare("
            UPDATE user SET firstname = :firstname, lastname = :lastname, city = :city
            WHERE id = :id
        ");
        return $stmt->execute($data);
    }

    public function updateUserHobbies($userId, $hobbyIds)
    {
        // Supprime les anciens
        $this->db->prepare("DELETE FROM user_hobby WHERE id_user = ?")->execute([$userId]);

        // Ajoute les nouveaux
        foreach ($hobbyIds as $hobbyId) {
            $stmt = $this->db->prepare("INSERT INTO user_hobby (id_user, id_hobby) VALUES (?, ?)");
            $stmt->execute([$userId, $hobbyId]);
        }
    }

    public function updateUserGenre($userId, $genreId)
    {
        $this->db->prepare("DELETE FROM user_genre WHERE id_user = ?")->execute([$userId]);

        if ($genreId) {
            $stmt = $this->db->prepare("INSERT INTO user_genre (id_user, id_genre) VALUES (?, ?)");
            $stmt->execute([$userId, $genreId]);
        }
    }

    public function updatePassword($userId, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE user SET password = ? WHERE id = ?");
        return $stmt->execute([$hashed, $userId]);
    }

    public function getSuggestions($userId)
    {
        // Récupère le genre de l'utilisateur
        $stmt = $this->db->prepare("
            SELECT id_genre FROM user_genre WHERE id_user = ?
        ");
        $stmt->execute([$userId]);
        $userGenre = $stmt->fetchColumn();

        if (!$userGenre) return [];

        // Récupère les suggestions avec hobbies communs + genre différent
        $stmt = $this->db->prepare("
            SELECT DISTINCT u.id, u.pseudo, u.firstname, u.city
            FROM user u
            JOIN user_genre ug ON u.id = ug.id_user
            JOIN user_hobby uh ON u.id = uh.id_user
            WHERE ug.id_genre != ?
            AND uh.id_hobby IN (
                SELECT id_hobby FROM user_hobby WHERE id_user = ?
            )
            AND u.id != ?
        ");
        $stmt->execute([$userGenre, $userId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveMatch($userId, $matchedUserId)
    {
        $stmt = $this->db->prepare("INSERT IGNORE INTO `match` (id_user, id_matched_user) VALUES (?, ?)");
        return $stmt->execute([$userId, $matchedUserId]);
    }

    public function getNextSuggestion($userId)
    {
        // Récupère le genre de l'utilisateur
        $stmt = $this->db->prepare("SELECT id_genre FROM user_genre WHERE id_user = ?");
        $stmt->execute([$userId]);
        $userGenre = $stmt->fetchColumn();

        if (!$userGenre) return null;

        // Récupère le prochain utilisateur qui :
        // - a un genre différent
        // - a au moins 1 hobby en commun
        // - n’a pas déjà été matché par l'utilisateur
        $stmt = $this->db->prepare("
            SELECT DISTINCT u.id, u.pseudo, u.firstname, u.city
            FROM user u
            JOIN user_genre ug ON u.id = ug.id_user
            JOIN user_hobby uh ON u.id = uh.id_user
            WHERE ug.id_genre != ?
            AND uh.id_hobby IN (
                SELECT id_hobby FROM user_hobby WHERE id_user = ?
            )
            AND u.id NOT IN (
                SELECT id_matched_user FROM `match` WHERE id_user = ?
            )
            AND u.id != ?
            LIMIT 1
        ");
        $stmt->execute([$userGenre, $userId, $userId, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMutualMatches($userId)
    {
        $stmt = $this->db->prepare("
            SELECT u.id, u.pseudo, u.firstname, u.city
            FROM user u
            WHERE u.id IN (
                SELECT m1.id_matched_user
                FROM `match` m1
                JOIN `match` m2
                ON m1.id_user = m2.id_matched_user
                AND m1.id_matched_user = m2.id_user
                WHERE m1.id_user = ?
            )
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMatchById($userId, $matchId)
    {
        // Vérifie s'il y a un match réciproque
        $stmt = $this->db->prepare("
            SELECT u.* FROM user u
            JOIN `match` m1 ON u.id = m1.id_matched_user
            JOIN `match` m2 ON u.id = m2.id_user
            WHERE m1.id_user = ? AND m2.id_matched_user = ? AND u.id = ?
        ");
        $stmt->execute([$userId, $userId, $matchId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMessages($userId, $matchId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM message
            WHERE (sender_id = ? AND receiver_id = ?)
            OR (sender_id = ? AND receiver_id = ?)
            ORDER BY created_at ASC
        ");
        $stmt->execute([$userId, $matchId, $matchId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendMessage($senderId, $receiverId, $content)
    {
        $stmt = $this->db->prepare("
            INSERT INTO message (sender_id, receiver_id, content)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$senderId, $receiverId, $content]);
    }


    public function getMutualMatchesWithNotifications($userId)
    {
        $stmt = $this->db->prepare("
            SELECT u.id, u.pseudo, u.firstname, u.city,
                (SELECT COUNT(*) FROM message
                 WHERE sender_id = u.id AND receiver_id = ? AND is_read = FALSE) AS unread
            FROM user u
            WHERE u.id IN (
                SELECT m1.id_matched_user
                FROM `match` m1
                JOIN `match` m2
                  ON m1.id_user = m2.id_matched_user
                 AND m1.id_matched_user = m2.id_user
                WHERE m1.id_user = ?
            )
        ");
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDb()
    {
        return $this->db;
    }

    
}
