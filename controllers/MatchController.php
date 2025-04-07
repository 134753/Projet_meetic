<?php

require_once 'models/MatchModel.php';
require_once 'db.php';

class MatchController {
    private $matchModel;

    public function __construct($pdo) {
        $this->matchModel = new MatchModel($pdo);
    }

    public function getMatchesForUser($userId) {
        try {
            $matches = $this->matchModel->getMatches($userId);
            
            if (empty($matches)) {
                echo "Aucun match trouvé.";
            } else {
                foreach ($matches as $match) {
                    echo "Pseudo : {$match['pseudo']}, Prénom : {$match['firstname']}, Ville : {$match['city']}<br>";
                }
            }
        } catch (Exception $e) {
            echo "Erreur lors de la récupération des matchs : " . $e->getMessage();
        }
    }
}


