<?php 
$title = "Création de page";
ob_start();
?>
<form action="?do=page&action=create" method="POST">
    <label>Nom de la page :</label>
    <input type="text" name="title" required>
    
    <label>URL de la page :</label>
    <input type="text" name="url" required>
    
    <label>Contenu (HTML) :</label>
    <textarea name="content" rows="10" cols="50" placeholder="Écrivez votre HTML ici..."></textarea>

    <label>Utilisateur :</label>
    <input type="text" name="user" required>
    
    <button type="submit">Enregistrer</button>
</form>
<a href="?do=page">Retour à la liste</a>

<?php 
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/projet/LIVECAMPUS-POO/src/Views/home.php';
?>



