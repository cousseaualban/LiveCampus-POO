<?php

namespace App\Controllers;

use App\Models\Structure;

class StructureController
{
    private $structureModel;

    /**
     * Constructeur : initialise le modèle Structure
     */
    public function __construct()
    {
        $this->structureModel = new Structure();
    }

    /**
     * Fonction qui gère l'affichage et la modification de la structure du site
     */
    public function index()
    {
        // Récupération des données actuelles de la structure (header et footer)
        $structure = $this->structureModel->getStructure();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des nouvelles valeurs du header et du footer
            $header = $_POST['header'] ?? '';
            $footer = $_POST['footer'] ?? '';

            // Mise à jour de la structure avec les nouvelles valeurs
            $this->structureModel->updateStructure($header, $footer);

            header("Location: ?do=structure");
            exit;
        }

        // Définition des variables pour la vue
        $title = "Modifier la structure";
        $headerContent = $structure['header'];
        $footerContent = $structure['footer'];

        ob_start();
        require_once __DIR__ . '/../Views/structure.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/home.php';
    }
}
