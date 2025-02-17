<?php

require_once (__DIR__ . "/../models/DatabaseConnection.php") ;
require_once (__DIR__ . "/../models/Session.php");

$connexion = new DatabaseConnection; 
$pdo = $connexion->getPdo();

$session = new Session;
$session->startSession();
if (isset($_GET["action"]) && $_GET["action"] === "logout") {
    $session->logOut();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Livre d'or">
    <meta name="keywords" content="HTML, CSS, PHP">
    <meta name="author" content="Noa Cengarle, Armelle Pouzioux, Vladimir Gorbachev">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/ecde10fa93.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Henny+Penny&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
    
    <link rel="stylesheet" href="/livre-or/assets/style.css">
    
    <link rel="icon" href="/quiznight-PHP/assets/img/favicon.ico">
    <title><?php echo $pageTitle; ?></title>

</head>
<body>
<header>
    <nav class="navbar">

        <article class="My Website">
            <a href="../index.php" 
            aria-label="Accéder à l'accueil du site"><h1>ACCUEIL</h1></a>
        </article>

        <article class="nav-link">
            <ul>
                <li><a href= "/../livre-or/views/livre-or.php" aria-label="Voir le livre d'or"> Commentaires</a></li>
                <li><a href= "/../livre-or/views/ajout-commentaire.php" aria-label="Voir le livre d'or"> Laisser un mot doux</a></li>
                <?php if (isset($_SESSION["username"])) : ?>
                    <li><a href="#" 
                aria-label="Accéder à mon compte"><?php echo $_SESSION["username"] ?></a></li>
                <li class="connection"><a href="?action=logout" 
                aria-label="Me déconnecter">Me déconnecter</a></li>
                <?php else: ?>
                    <li class="connection"><a href="views/user_login.php"
                aria-label="Accéder à me connecter">Me connecter</a></li>
                <?php endif; ?>
            </ul>
        </article>

    </nav>
</header>