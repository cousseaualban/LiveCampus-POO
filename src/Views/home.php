<?php 
$title = $title ?? "Accueil";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveCampus-POO</title>
</head>
<body> 
    <header>
        <h1><?= htmlspecialchars($title)?></h1>
        <nav>
            <a href="?do=home">Accueil</a>
            <a href="?do=page">Pages</a>
        </nav>
    </header>   
    
    <main>
        <?= $content ?? '' ?>
    </main>

    <footer>
        <p>@2025 - LiveCampus-POO</p>
    </footer>
</body>
</html>