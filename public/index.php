<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$baseDir = __DIR__ . '/../Database/';
session_start();

require_once $baseDir . 'database.php';
$pdo = Database::getInstance();

$do = 'home';
$action = null;

if (isset($_GET['do'])) {
    $do = $_GET['do'];
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($do) {
    case 'home': 
        require $baseDir . 'Controllers/HomeController.php';
        $homeController = new homeController();
        $homeController->index();
        break;
    case 'page':
        require $baseDir . 'Controllers/PageController.php';
        $controller = new PageController();
        if ($action === 'delete') {
            $controller->delete();
        } elseif ($action === 'edit') {
            $controller->edit();
        } elseif ($action === 'create') {
            $controller->create();
        } else {
            $controller->pagesList();
        }
        break;
}