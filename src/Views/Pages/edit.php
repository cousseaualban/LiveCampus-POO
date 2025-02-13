<?php
$title = "Modifier la page";
ob_start();
?>

<form action="?do=page&action=edit&id=<?= htmlspecialchars($page['id']) ?>" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($page['id']) ?>"> 

    <label for="title">Titre :</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($page['title']) ?>" required>

    <label for="url">URL :</label>
    <input type="text" id="url" name="url" value="<?= htmlspecialchars($page['url']) ?>" required>

    <label for="content">Contenu :</label>
    <textarea id="content" name="content" rows="5"><?= htmlspecialchars($page['content']) ?></textarea>

    <label for="user">Utilisateur :</label>
    <input type="text" id="user" name="user" value="<?= htmlspecialchars($page['user']) ?>" required>

    <button type="submit">Modifier</button>
</form>
<a href="?do=page">Retour à la liste</a>

<?php 
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/projet/LIVECAMPUS-POO/src/Views/home.php';
?>
