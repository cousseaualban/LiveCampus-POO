<?php 
$title = "Connexion";
ob_start();
?>
    <div class="container">
        <form id="loginForm" action="?do=auth&action=login" method="POST">
            <input type="text" id="name" name="name" placeholder="Nom d'utilisateur * " required>
            <input type="password" id="password" name="password" placeholder="Mot de passe *" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
    <?php 
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Projet-POO/src/Views/home.php';
?>