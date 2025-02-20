<?php

$pageTitle = "Me connecter";
require_once(__DIR__ . "/header.php");

$utilisateur = $mdp = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utilisateur = trim($_POST["utilisateur"]);
    $mdp = $_POST["mdp"];

    $utilisateurController = new UtilisateurController;
    $utilisateurConnecte = $utilisateurController->connexionUtilisateur($utilisateur, $mdp);

    if ($utilisateurConnecte) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }        
        $_SESSION["id"] = $utilisateurConnecte["id"];
        $_SESSION["utilisateur"] = $utilisateurConnecte["login"];
        $_SESSION["role"] = $utilisateurConnecte["role"];
        $_SESSION["successMessage"] = "Bienvenue " . $_SESSION["utilisateur"] . " !";
        header("Location: ajout-commentaire.php");
        exit();
    } else {
        $_SESSION["errorMessage"] = "Email ou mot de passe incorrect.";
    }
}
?>

<main>
    <?php if (isset($_SESSION["successMessage"])) : ?>
        <p class="message success"><?php echo $_SESSION["successMessage"] ; ?></p>
        <?php unset($_SESSION["successMessage"]); ?>
    <?php endif; ?>

    <form action="" method="POST" class="form">
        <h2>Connectez-vous</h2>

        <?php if (isset($_SESSION["errorMessage"])) : ?>
            <p class="message error"><?php echo $_SESSION["errorMessage"] ; ?></p>
            <?php unset($_SESSION["errorMessage"]); ?>
        <?php endif; ?>
        
        <section class="form-body">
            <article class="form-items">
                <label for="utilisateur">Nom d'utilisateur :</label>
                <input type="text" id="utilisateur" name="utilisateur" placeholder="Nom d'utilisateur" 
                required value="<?= htmlspecialchars($utilisateur); ?>">
            </article>

            <article class="form-items">
                <label for="mdp">Mot de passe:</label>
                <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" required>
            </article>

            <input type="submit" value="Se connecter" class="boutton marron">

            <a href="./inscription.php">Pas encore de compte ? C'est par ici !</a>
        </section>
    </form>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>