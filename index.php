<?php
require_once 'config/database.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';
require_once 'core/View.php';

// Routing très simple (à améliorer plus tard)
$controller = $_GET['controller'] ?? 'user';
$action = $_GET['action'] ?? 'home';

$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = 'controller/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $ctrl = new $controllerName();
    if (method_exists($ctrl, $action)) {
        $ctrl->$action();
    } else {
        echo "Action '$action' introuvable.";
    }
} else {
    echo "Contrôleur '$controllerName' introuvable.";
}
