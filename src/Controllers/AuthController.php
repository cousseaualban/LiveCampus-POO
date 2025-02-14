<?php
namespace App\Controllers;

use PDO;

class AuthController
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function login()
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        if (empty($name) || empty($password)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM users_table WHERE name = :name");
        $stmt->execute([':name' => $name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
                header('Location: index.php?do=home');
                exit;
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Aucun utilisateur trouvé avec ce nom.";
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?do=auth');
    }
}
