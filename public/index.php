<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$baseDir = __DIR__ . '/../';

require_once $baseDir . './vendor/autoload.php';
use App\Controllers\HomeController;
use App\Controllers\StructureController;
use App\Controllers\PageController;
use App\Controllers\AuthController;
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

if (!isset($_SESSION['user']) && $do !== 'auth') {
    header('Location: index.php?do=auth');
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
    case 'structure':
        $controller = new StructureController();
        $controller->index();
        break;
        
    default:
        echo "Page introuvable";
        break;
}
