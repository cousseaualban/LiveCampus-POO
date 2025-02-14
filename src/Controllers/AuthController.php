<?php

namespace App\Controllers;

use PDO;

class AuthController
{

    private $pdo;

    // Constructeur : initialise la connexion à la base de données
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * Fonction de connexion (login)
     */
    public function login()
    {
        $name = $_POST['name'];
        $password = $_POST['password'];

        // Vérification que les champs ne sont pas vides

        if (empty($name) || empty($password)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }
        // Requête pour récupérer l'utilisateur correspondant au nom saisi

        $stmt = $this->pdo->prepare("SELECT * FROM users_table WHERE name = :name");
        $stmt->execute([':name' => $name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérification du mot de passe avec password_verify()

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

    /**
     * Fonction de déconnexion (logout)
     */
    public function logout()
    {
        // Suppression des données de session
        session_unset();
        session_destroy();
        header('Location: index.php?do=home');
    }
}
