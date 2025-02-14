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
        <?= $content ?? '' ?>
    </main>

    <?= isset($footerContent) ? $footerContent : '' ?>
</body>
</html>
