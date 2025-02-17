<?php

$pageTitle = "Livre d'or - Accueil";
require_once(__DIR__ . "/views/header.php");

?>

<main>
    <section class="home">
        <article class="text">
            <h2>Chers invité.es,</h2>
            <p>Merci du fond du cœur d’être présents pour célébrer ce jour si spécial avec nous. 
                Votre amour, vos sourires et votre présence illuminent cette journée unique.</p>
            <p>Nous avons créé ce livre d’or numérique pour que chacun puisse laisser un mot, 
                un souvenir, un vœu ou même une anecdote. Ce sera un trésor de souvenirs que 
                nous chérirons toute notre vie.</p>
            <p>Prenez un instant pour partager un message qui nous accompagnera longtemps après 
                cette magnifique journée.</p>

            <article class="button blanc">
                <a href="./views/livre-or.php" 
                aria-label="Accéder à la page livre d'or">Voir le livre d'or</a>
            </article>
            <article class="button marron">
                <a href="./views/connexion.php" 
                aria-label="Accéder à la page d'ajout de commentaire">Remplir le livre d'or</a>
            </article>
        </article>
    </section>
</main>

<?php require_once(__DIR__ . "/views/footer.php"); ?>