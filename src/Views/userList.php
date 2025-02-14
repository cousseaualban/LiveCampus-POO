<?php 
$title = $subtitle = "Liste des utilisateurs";
ob_start();
?>
<table>
    <thead>
        <tr>
            <th>Action</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
               <td>
                    <a href="?do=user&action=delete&id=<?= $user['id'] ?>" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
               </td>
               <td><?= $user['name'] ?></td>
               <td><?= $user['email'] ?></td>
               <td><?= $user['role'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Projet-Poo/src/Views/home.php';
?>