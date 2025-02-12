<?php 
$title = "Création de page";
ob_start();
?>
<form action="createPage.php" method="POST">
    <label>Nom de la page :</label>
    <input type="text" name="title" required>
    
    <label>URL de la page :</label>
    <input type="text" name="url" required>
    
    <label>Contenu (HTML) :</label>
    <textarea name="content" rows="10" cols="50" placeholder="Écrivez votre HTML ici..."></textarea>
    
    <button type="submit">Enregistrer</button>
</form>

<?php 
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/projet/LIVECAMPUS-POO/src/Views/home.php';
?>



