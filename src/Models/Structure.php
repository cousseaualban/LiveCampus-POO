<?php
namespace App\Models;

use App\Database\Database;
use PDO;

class Structure
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Récupérer la structure (header/footer)
    public function getStructure(): array
    {
        $stmt = $this->db->query("SELECT * FROM structure_table LIMIT 1");
        $structure = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$structure) {
            $defaultHeader = '<header>
                <nav>
                    <a href="?do=home">Accueil</a>
                    <a href="?do=page">Pages</a>
                    <a href="?do=structure">Structure</a>
                </nav>
            </header>';
            $defaultFooter = '<footer><p>@2025 - LiveCampus-POO</p></footer>';

            $this->db->prepare("INSERT INTO structure_table (header, footer) VALUES (:header, :footer)")
                ->execute([':header' => $defaultHeader, ':footer' => $defaultFooter]);

            return $this->getStructure();
        }

        return $structure;
    }

    // Modifier la structure
    public function updateStructure(string $header, string $footer): void
    {
        // Préparer et exécuter la requête pour mettre à jour la structure
        $stmt = $this->db->prepare("UPDATE structure_table SET header = :header, footer = :footer");
        $stmt->execute([
            ':header' => $header,
            ':footer' => $footer
        ]);
    }
}
