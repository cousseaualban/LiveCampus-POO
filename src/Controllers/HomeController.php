<?php

namespace App\Controllers;

use App\Models\Structure;

class HomeController
{

    /**
     * Fonction qui gère l'affichage de la page d'accueil
     */
    public function index()
    {
        $structureModel = new Structure();

        // Récupération des données de structure (header, footer, etc.)
        $structure = $structureModel->getStructure();

        $headerContent = $structure['header'];
        $footerContent = $structure['footer'];
        $title = "Accueil";

        require_once __DIR__ . '/../Views/home.php';
    }
}
