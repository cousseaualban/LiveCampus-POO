<?php 
$title = $subtitle = "Liste des pages";
ob_start();
?>

<h2><?= htmlspecialchars($page['title']) ?></h2>
<p><?= $page['content'] ?></p>
<a href="?do=page">Retour à la liste</a>
<?php 
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Projet-Poo/src/Views/home.php';
?>