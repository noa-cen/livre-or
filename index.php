<?php

$pageTitle = "Livre d'or - Accueil";
require_once(__DIR__ . "/views/header.php");

?>

<main>
    <section class="home">
        <article class="text">
            <h2>Chers invité.es,</h2>
            <p><b>Merci du fond du cœur</b> d’être présents pour célébrer ce jour si spécial avec nous. 
                Votre amour, vos sourires et votre présence illuminent cette journée unique.</p>
            <p>Nous avons créé ce <b>livre d’or numérique</b> pour que chacun puisse laisser un mot, 
                un souvenir, un vœu ou même une anecdote. Ce sera un trésor de souvenirs que 
                nous chérirons toute notre vie.</p>
            <p>Prenez un instant pour partager un message qui nous accompagnera longtemps après 
                cette magnifique journée.</p>

            <article class="bouton">
                <a href="./views/livre-or.php" 
                aria-label="Accéder à la page livre d'or" class="button blanc">Voir le livre d'or</a>
                
                <?php if(!isset($_SESSION["id"])): ?>
                <a href="./views/connexion.php" 
                aria-label="Accéder à la page d'ajout de commentaire" 
                class="button marron">Remplir le livre d'or</a>
                <?php else: ?>
                <a href="./views/ajout-commentaire.php" 
                aria-label="Accéder à la page d'ajout de commentaire" 
                class="button marron">Remplir le livre d'or</a>
                <?php endif; ?>
            </article>
        </article>
    </section>
</main>

<?php require_once(__DIR__ . "/views/footer.php"); ?>