<?php

$pageTitle = "Me connecter";
require_once(__DIR__ . "/header.php");

$utilisateur = $mdp = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim whitespace from the email and password inputs
    $utilisateur = trim($_POST["utilisateur"]);
    $mdp = $_POST["mdp"];

    $utilisateurController = new UtilisateurController;
    $loggedInUser = $utilisateurController->connexionUtilisateur($utilisateur, $mdp);

    if ($loggedInUser) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }        
        // Set session variables with user data
        $_SESSION["id"] = $loggedInUser["id"];
        $_SESSION["utilisateur"] = $loggedInUser["login"];
        $_SESSION["successMessage"] = "Bienvenue " . $_SESSION["utilisateur"] . " !";
        header("Location: ajout-commentaire.php");
        exit();
    } else {
        $errors["connexion"] = "Email ou mot de passe incorrect.";
    }
}
?>

<main>
    <?php if (isset($_SESSION["successMessage"])) : ?>
        <p class="message success"><?php echo $_SESSION["successMessage"] ; ?></p>
        <?php unset($_SESSION["successMessage"]); ?>
    <?php endif; ?>

    <?php if (!empty($errors)) : ?>
        <p class="message error"><?= htmlspecialchars($errors["connexion"]); ?></p>
    <?php endif; ?>

    <form action="" method="POST" class="form">

        <h2>Me connecter !</h2>
        
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

            <input type="submit" value="Se connecter" class="button marron">

            <a href="./inscription.php">Pas encore de compte ? C'est par ici !</a>
        </section>
    </form>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>