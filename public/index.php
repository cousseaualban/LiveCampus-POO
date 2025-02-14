<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$baseDir = __DIR__ . '/../';

// Chargement automatique des classes via Composer
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

// Redirection vers la page d'accueil si l'utilisateur n'est pas connecté et tente d'accéder à une autre page
if (!isset($_SESSION['user']) && $do !== 'page' && $do !== 'home' && $do !== 'auth') {
    header('Location: index.php?do=home');
}

// Gestion des différentes pages via un switch
switch ($do) {
        // Affichage de la page d'accueil via le contrôleur HomeController
    case 'home':
        $homeController = new HomeController();
        $homeController->index();
        break;

        // Gestion de l'authentification (connexion/déconnexion)
    case 'auth':
        $controller = new AuthController($pdo);
        if ($action === 'login') {
            $controller->login();
        } elseif ($action === 'logout') {
            $controller->logout();
        }
        require_once $baseDir . './src/Views/auth.php';
        break;

    case 'page':
        // Gestion des pages (CRUD)
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
        // Gestion de la structure du site via le contrôleur StructureController
        $controller = new StructureController();
        $controller->index();
        break;

    default:
        echo "Page introuvable";
        break;
}
