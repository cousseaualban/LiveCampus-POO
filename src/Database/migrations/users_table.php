<?php
use App\Database\Database;

class Users_table {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function up() {
        $this->db->exec("
            DROP TABLE IF EXISTS users_table;

            CREATE TABLE users_table (
                id CHAR(36) PRIMARY KEY DEFAULT (UUID()), 
                name VARCHAR(100) NOT NULL,
                email VARCHAR(191) UNIQUE NOT NULL,
                password VARCHAR(100) NOT NULL,
                role ENUM('admin', 'standard') NOT NULL DEFAULT 'standard',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }

    public function down() {
        $this->db->exec("DROP TABLE IF EXISTS users_table;");
    }
}
?>
