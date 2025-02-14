<?php
$title = $title ?? "Accueil";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <link rel="stylesheet" href="./css/auth.css" type="text/css" />
    </head>
<body>
    <?= isset($headerContent) ? $headerContent : '' ?>

    <main class="main-content">
        <h1 class="main-title"><?= htmlspecialchars($title) ?></h1>
        <div>
        <?php if (isset($_SESSION['user'])) :?>
            <a href="?do=auth&action=logout">Se déconnecter</a>
        <?php elseif (!isset($_SESSION['user']) && (!isset($_GET['do']) || $_GET['do'] !== 'auth')) : ?>
            <a href="?do=auth" class="nav-link">Se connecter</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == "admin") :?>
            <a href="?do=structure" class="nav-link">Structure</a>
        <?php endif; ?>
        </div>
        <?= $content ?? '' ?>
    </main>

    <?= isset($footerContent) ? $footerContent : '' ?>
</body>
</html>
