<?php 
$title = "La page web";
ob_start();
?>

<h2><?= htmlspecialchars($page['title']) ?></h2>
<p><?= $page['content'] ?></p>
<a href="?do=page&action=edit&id=<?= $page['id'] ?>">Modifier</a>
<a href="?do=page">Retour à la liste</a>
<?php 
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Projet-POO/src/Views/home.php';
?>