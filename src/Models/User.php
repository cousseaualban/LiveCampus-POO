<?php
namespace App\Models;
use App\Database\Database;
use PDO;
use PDOException;

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users_table WHERE email = :email LIMIT 1";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $result = $statement->fetchAll();
        if (count($result) == 0) return null;
        return $result[0];
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users_table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser(string $id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM users_table WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur lors de la suppression de la page : " . $e->getMessage());
        }
    }
}
