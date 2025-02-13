<?php
// require_once __DIR__ . '/../../Database/database.php';
namespace App\Models;
use App\Database\Database;
use PDO;
use PDOException;
use DateTime;

class Page {
    private $db; 

    public function __construct()
    {
        $this->db= Database::getInstance();
    }

    // Récupérer toutes les pages 
    public function getAllPages()
    {
        $stmt = $this->db->query("SELECT * FROM page");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une page en fonction de son identifiant id
    public function getPageById(string $id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM page WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération de la page : " . $e->getMessage());
        }
    }

    // Créer une nouvelle page
    public function createPage(string $title, string $url, $content, $user)
    {
        try {
            $query = "
                INSERT INTO page (id, title, url, content, user, created_at, updated_at)
                VALUES (:id, :title, :url, :content, :user, :created_at, :updated_at)
            ";
            $stmt = $this->db->prepare($query);
            $dateTime = new DateTime(); 
            $createdAt = $dateTime->format('Y-m-d H:i:s'); 
            $updatedAt = null; 
            $id = $this->genererUuid();

            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':created_at', $createdAt); 
            $stmt->bindParam(':updated_at', $updatedAt); 

            $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur lors de l'ajout de la page : " . $e->getMessage());
        }
    }


    // Modifier la page
    public function updatePage(string $id, string $title, string $url, $content, $user)
    {
        try {
            $query = "
                UPDATE page 
                SET title = :title, url = :url, content = :content, user = :user, updated_at = :updated_at
                WHERE id = :id
            ";
            $stmt = $this->db->prepare($query);
            $updatedAt = (new DateTime())->format('Y-m-d H:i:s');   
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':updated_at', $updatedAt);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur lors de la modification de la page : " . $e->getMessage());
        }
    }

    // Supprimer une page
    public function deletePage(string $id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM page WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur lors de la suppression de la page : " . $e->getMessage());
        }
    }
        // Générer un UUID
    private function genererUuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
?>