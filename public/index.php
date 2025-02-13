<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
// Chemin de base
$baseDir = __DIR__ . '/../';

// Inclure manuellement tous les fichiers nécessaires
require_once $baseDir . 'Database/Database.php';
require_once $baseDir . 'src/Models/Page.php';
require_once $baseDir . 'src/Controllers/HomeController.php';
require_once $baseDir . 'src/Controllers/PageController.php';
require_once $baseDir . 'src/controllers/AuthController.php';

// Utilisation des namespaces
use App\Controllers\HomeController;
use App\Controllers\PageController;
use App\Database\Database;

$do = 'home';
$action = null;

$pdo = Database::getInstance();


if (isset($_GET['do'])) {
    $do = $_GET['do'];
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($do) {
    case 'home':
        $homeController = new HomeController();
        $homeController->index();
        break;

    case 'auth':
        $controller = new AuthController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $password = $_POST['password'] ?? '';
            $controller->login($name, $password);   
        } else {
            require $baseDir . 'src/Views/auth.php';
        }
        break;

    case 'page':
        $controller = new PageController();
        if ($action === 'delete') {
            $controller->delete();
        } elseif ($action === 'edit') {
            $controller->edit();
        } elseif ($action === 'create') {
            $controller->create();
        } elseif ($action === 'show') {
            $controller->show();
        } else {
            $controller->pagesList();
        }
        break;

    default:
        echo "Page introuvable";
        break;
}
