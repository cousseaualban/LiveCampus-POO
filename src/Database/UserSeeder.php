<?php

require_once 'database.php';
use App\Database\Database;

if ($argc !== 5) {
    die("Création d'un utilisateur : php UserSeeder.php <name> <email> <password> <role>\n");
}

$name = $argv[1];
$email = $argv[2];
$password = $argv[3];
$role = $argv[4];

$validRoles = ['admin', 'standard'];
if (!in_array($role, $validRoles)) {
    die("Erreur : Le rôle à saisir doit être 'admin' ou 'standard'.\n");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo = Database::getInstance();

    $stmt = $pdo->prepare("SELECT id FROM users_table WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        die("Erreur : Cet email est déjà utilisé.\n");
    }

    $stmt = $pdo->prepare("INSERT INTO users_table (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $hashedPassword, $role]);

    echo "Utilisateur '$name' créé avec succès avec le rôle '$role' !\n";
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage() . "\n");
}
?>
