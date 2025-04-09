<?php
class Database {
    public static function connect() {
        try {
            return new PDO('mysql:host=localhost;dbname=meetic;charset=utf8', 'root', 'ROOT');
        } catch (PDOException $e) {
            die('Erreur DB : ' . $e->getMessage());
        }
    }
}
