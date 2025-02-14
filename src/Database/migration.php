<?php

require_once 'database.php';

use App\Database\Database;
use PDO;

class Migration
{
    private PDO $db;
    private string $migrationsDir = __DIR__ . '/migrations/'; // Répertoire contenant les fichiers de migration

    /**
     * Constructeur : Initialise la connexion et s'assure que la table des migrations existe
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->ensureMigrationTable();
    }

    /**
     * Exécute toutes les migrations disponibles dans le dossier `migrations`
     */
    public function migrate(): void
    {
        $files = glob($this->migrationsDir . '*.php');
        foreach ($files as $file) {
            $this->executeMigration($file);
        }
        echo "Toutes les migrations ont été appliquées.\n";
    }

    /**
     * Applique uniquement la prochaine migration qui n'a pas encore été exécutée
     */
    public function next(): void
    {
        $files = glob($this->migrationsDir . '*.php');
        $lastMigration = $this->getLastMigration();
        foreach ($files as $file) {
            if (basename($file, '.php') > $lastMigration) {
                $this->executeMigration($file);
                echo "Migration " . basename($file) . " appliquée.\n";
                return;
            }
        }
        echo "Aucune autre migration disponible.\n";
    }

    /**
     * Annule la dernière migration exécutée
     */
    public function previous(): void
    {
        $lastMigration = $this->getLastMigration();
        if ($lastMigration) {
            require_once $this->migrationsDir . "$lastMigration.php";
            $className = str_replace('.php', '', $lastMigration);
            $migration = new $className();
            $migration->down();
            $this->db->exec("DELETE FROM migrations WHERE migration = '$lastMigration'");
            echo "Migration $lastMigration annulée.\n";
        } else {
            echo "Aucune migration disponible.\n";
        }
    }

    /**
     * Annule toutes les migrations appliquées et réinitialise la table `migrations`
     */
    public function reset(): void
    {
        $files = array_reverse(glob($this->migrationsDir . '*.php'));
        foreach ($files as $file) {
            require_once $file;
            $className = basename($file, '.php');
            $migration = new $className();
            $migration->down();
            $this->db->exec("DELETE FROM migrations WHERE migration = '$className'");
        }
        $this->db->exec("ALTER TABLE migrations AUTO_INCREMENT = 1;"); // Réinitialise l'auto-incrémentation
        echo "Toutes les migrations ont été annulées.\n";
    }

    /**
     * Exécute une migration spécifique
     */
    private function executeMigration(string $file): void
    {
        require_once $file;
        $className = basename($file, '.php');
        $migration = new $className();
        $migration->up(); // Exécute la migration
        $this->db->exec("INSERT INTO migrations (migration) VALUES ('$className')");
    }

    /**
     * Récupère la dernière migration appliquée
     */
    private function getLastMigration(): ?string
    {
        $stmt = $this->db->query("SELECT migration FROM migrations ORDER BY id DESC LIMIT 1");
        return $stmt->fetchColumn() ?: null;
    }

    /**
     * Vérifie si la table `migrations` existe, sinon la crée
     */
    private function ensureMigrationTable(): void
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }
}

$command = $argv[1] ?? null;
$migration = new Migration();

// Exécution de la commande en fonction de l'argument reçu
switch ($command) {
    case 'migrate':
        $migration->migrate();
        break;
    case 'next':
        $migration->next();
        break;
    case 'previous':
        $migration->previous();
        break;
    case 'reset':
        $migration->reset();
        break;
    default:
        echo "Commande inconnue. Utilisez migrate, next, previous, or reset.\n";
        break;
}
