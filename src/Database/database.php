<?php

namespace App\Database;

use PDO;
use PDOException;
use Exception;

ini_set('display_errors', 1);
error_reporting(E_ALL);

class Database
{
    private static $instance = null;
    private $pdo;
    private $db = 'mysql:host=localhost;dbname=poo;charset=utf8mb4';
    private $username = 'root';
    private $pwd = '';

    /**
     * Constructeur privé pour empêcher l'instanciation directe (Singleton)
     */
    private function __construct()
    {
        try {
            $this->pdo = new PDO($this->db, $this->username, $this->pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion : " . $e->getMessage());
        }
    }

    /**
     * Méthode statique pour récupérer l'instance unique de la connexion
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}
