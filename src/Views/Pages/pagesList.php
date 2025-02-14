<?php 
$title = $subtitle = "Liste des pages";
ob_start();
?>
<table>
    <thead>
        <tr>
            <th>Action</th>
            <th>Titre</th>
            <th>Création</th>
            <th>Modifiée</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pages as $page): ?>
            <tr>
                <td>
                    <a href="?do=page&action=show&id=<?= $page['id'] ?>">
                        <?= htmlspecialchars($page['title']) ?>
                    </a>
                </td>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                <td>
                    <a href="?do=page&action=edit&id=<?= $page['id'] ?>">Modifier</a>
                    <a href="?do=page&action=delete&id=<?= $page['id'] ?>" onclick="return confirm('Supprimer cette page ?');">Supprimer</a>
                </td>
            <?php elseif (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'standard'):?>
                    <td>
                        <a href="?do=page&action=edit&id=<?= $page['id'] ?>">Modifier</a>
                    </td>
            <?php endif; ?>
                <td><p><?= $page['created_at']?></p></td>
                <td><p><?= $page['updated_at']?></p></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (isset($_SESSION['user'])) : ?> 
<a href="?do=page&action=create">Créer une nouvelle page</a>
<?php endif; 
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Projet-POO/src/Views/home.php';
?>