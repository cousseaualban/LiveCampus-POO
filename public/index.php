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

switch ($do) {
    case 'home':  // Afficher la page d'accueil
        require $baseDir . 'Controllers/HomeController.php';
        $homeController = new homeController();
        $homeController->index();
        break;
    case 'create':
        require $baseDir . 'Views/create.php';
        break;
}