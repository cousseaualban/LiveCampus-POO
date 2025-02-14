<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/auth.css" type="text/css" />
</head>

<body>
    <div class="container">
        <h2>Connexion</h2>
        <form id="loginForm" action="../../public/index.php?do=auth" method="POST">
            <input type="text" id="name" name="name" placeholder="Nom d'utilisateur * " required>
            <input type="password" id="password" name="password" placeholder="Mot de passe *" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>

</html>