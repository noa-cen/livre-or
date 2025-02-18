<?php

require_once __DIR__ . "/../models/DatabaseConnection.php";
require_once __DIR__ . "/../models/Session.php";
require_once __DIR__ . "/../controllers/UtilisateurController.php";

$connexion = new DatabaseConnection; 
$pdo = $connexion->getPdo();

$session = new Session;
$session->startSession();
if (isset($_GET["action"]) && $_GET["action"] === "logout") {
    $session->logOut();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Livre d'or de Marie et Clara">
    <meta name="keywords" content="HTML, CSS, PHP">
    <meta name="author" content="Noa Cengarle, Armelle Pouzioux, Vladimir Gorbachev">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/ecde10fa93.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dawning+of+a+New+Day&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dawning+of+a+New+Day&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="/livre-or/assets/style.css?v=<?php echo time(); ?>">
    <link rel="icon" href="/livre-or/assets/img/favicon.ico" type="image/x-icon">
    <title><?php echo $pageTitle; ?></title>

</head>
<body>
<header>
    <nav class="navbar">

        <a href="/livre-or/index.php" aria-label="Accéder à l'accueil"><h1>Marie <span>&</span> Clara</h1></a>

        <article class="nav-link">
            <ul>
                <?php if (isset($_SESSION["utilisateur"])) : ?>
                    <li><a href="/livre-or/views/livre-or.php" 
                    aria-label="Accéder à la page livre d'or" class="boutton blanc">Voir le livre d'or</a></li>
                    <li><a href="/livre-or/views/profil.php" 
                    aria-label="Accéder à mon compte" class="boutton blanc"><?php echo $_SESSION['utilisateur']?></a></li>
                    <li class="connection"><a href="?action=logout"
                        aria-label="Me déconnecter" class="boutton blanc">Me déconnecter</a></li>
                        <?php else :?>
                            <li><a href="/livre-or/views/connexion.php" 
                            aria-label="Accéder à la page connexion" class="boutton blanc">Se connecter</a></li>  
                <?php endif; ?>
            </ul>
        </article>
    </nav>
</header>