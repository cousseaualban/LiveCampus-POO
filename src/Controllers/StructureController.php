<?php
namespace App\Controllers;
use App\Models\Structure;

class StructureController {
    private $structureModel;

    public function __construct() {
        $this->structureModel = new Structure();
    }

    public function index() {
        $structure = $this->structureModel->getStructure();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $header = $_POST['header'] ?? '';
            $footer = $_POST['footer'] ?? '';
            $this->structureModel->updateStructure($header, $footer);

            header("Location: ?do=structure");
            exit;
        }

        $title = "Modifier la structure"; 
        $headerContent = $structure['header'];
        $footerContent = $structure['footer']; 

        ob_start();
        require_once __DIR__ . '/../Views/structure.php';
        $content = ob_get_clean();  

        require_once __DIR__ . '/../Views/home.php'; 
    }
}
