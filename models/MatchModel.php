<?php

class MatchModel {

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function getMatches($userId) {
        $query = "
            SELECT u.id, u.pseudo, u.firstname, u.lastname, u.city, u.birthdate
            FROM user u
            JOIN user_genre ug ON ug.id_user = u.id
            JOIN user_hobby uh ON uh.id_user = u.id
            WHERE ug.id_genre != (
                SELECT id_genre FROM user_genre WHERE id_user = :userId
                )
            AND uh.id_hobby IN (
                SELECT id_hobby FROM user_hobby WHERE id_user = :userId
                )
            AND ABS(YEAR(u.birthdate) - (
                SELECT YEAR(birthdate) FROM user WHERE id = :userId
                )) <= 5
            AND u.city = (
                SELECT city FROM user WHERE id = :userId
                )
            AND u.id != :userId
                GROUP BY u.id
                ORDER BY u.firstname
            ";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>
