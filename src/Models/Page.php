<?php
require_once __DIR__ . '/../../Database/database.php';

class Page {
    private $db; 

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Récupérer toutes les pages 
    public function getAllPages()
    {
        $stmt = $this->db->query("SELECT * FROM table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une page en fonction de son identifiant id
    public function getPageById(string $id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM table WHERE id = :id");
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
                INSERT INTO table (title, url, content, user, created_at, updated_at)
                VALUES (:title, :url, :content, :user, :created_at, :updated_at)
            ";
            $stmt = $this->db->prepare($query);
            $createdAt = new DateTime(); 
            $updatedAt = null; 
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':createdAt', $createdAt);
            $stmt->bindParam(':updatedAt', $updatedAt);

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
                UPDATE table 
                SET title = :title, url = :url, content = :content, user = :user, updated_at = :updatedAt
                WHERE id = :id
            ";
            $stmt = $this->db->prepare($query);
            $updatedAt = new DateTime(); 
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':updatedAt', $updatedAt);
        } catch (PDOException $e) {
            die("Erreur lors de la modification de la page : " . $e->getMessage());
        }
    }

    // Supprimer une page
    public function deletePage(string $id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM table WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur lors de la suppression de la page : " . $e->getMessage());
        }
    }
}
?>