<?php
use App\Database\Database;

class pages_table {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function up() {
        $this->db->exec("
            DROP TABLE IF EXISTS page_table;

            CREATE TABLE page_table (
                id CHAR(36) PRIMARY KEY DEFAULT (UUID()), 
                title VARCHAR(100) NOT NULL,
                url VARCHAR(191) UNIQUE NOT NULL,
                content TEXT NOT NULL,
                user_id CHAR(36) DEFAULT (UUID()) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at DATE NULL,
                CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
            );
        ");
    }

    public function down() {
        $this->db->exec("DROP TABLE IF EXISTS page_table;");
    }
}
?>
