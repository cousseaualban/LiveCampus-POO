<?php
namespace App\Controllers;

use App\Models\Structure;

class HomeController
{
    public function index()
    {
        $structureModel = new Structure();

        $structure = $structureModel->getStructure();

        $headerContent = $structure['header'];
        $footerContent = $structure['footer'];
        $title = "Accueil"; 

        require_once __DIR__ . '/../Views/home.php';
    }
}
