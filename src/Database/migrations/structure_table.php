<?php
use App\Database\Database;

class structure_table {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function up() {
        $this->db->exec("
            DROP TABLE IF EXISTS structure_table;

            CREATE TABLE structure_table (
                id CHAR(36) PRIMARY KEY DEFAULT (UUID()), 
                header TEXT NOT NULL,
                footer TEXT NOT NULL
            );
        ");
    }

    public function down() {
        $this->db->exec("DROP TABLE IF EXISTS structure_table;");
    }
}
?>
