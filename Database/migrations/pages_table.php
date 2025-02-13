<?php

class pages_table {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function up() {
        $this->db->exec("
            DROP TABLE IF EXISTS page_table;

            CREATE TABLE page_table (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(100) NOT NULL,
                url VARCHAR(191) UNIQUE NOT NULL,
                content TEXT NOT NULL,
                user_id INT NOT NULL,
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
