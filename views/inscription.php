<?php

$pageTitle = "Créer mon compte";
require_once(__DIR__ . "/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utilisateur = htmlspecialchars(trim($_POST["utilisateur"]));
    $mdp = $_POST["mdp"];
    $mdpVerifie = $_POST["mdpVerifie"];
    $codeSecret = isset($_POST["codeSecret"]) ? trim($_POST["codeSecret"]) : "";

    $utilisateurController = new UtilisateurController;
    $result = $utilisateurController->creationUtilisateur($utilisateur, $mdp, $mdpVerifie, $codeSecret);
}
?>

<main>
    <form action="" method="POST" class="form">
        <h2>Créer votre compte</h2>

        <?php if (isset($_SESSION["errorMessage"])) : ?>
            <p class="message error"><?php echo $_SESSION["errorMessage"] ; ?></p>
            <?php unset($_SESSION["errorMessage"]); ?>
        <?php endif; ?>

            <article class="form-items">
                <label for="utilisateur">Nom d'utilisateur: </label>
                <input type="text" id="utilisateur" name="utilisateur" placeholder="Nom d'utilisateur" 
                required>
            </article>

            <article class="form-items">
                <label for="mdp">Mot de passe:</label>
                <input type="password" id="mdp" name="mdp" required
                placeholder="8 caractères minimum dont une lettre et un chiffre">
            </article>

            <article class="form-items">
                <label for="mdpVerifie">Confirmer le mot de passe:</label>
                <input type="password" id="mdpVerifie" name="mdpVerifie" 
                placeholder="Confirmer le mot de passe" required>
            </article>

            <article class="form-items">
                <label for="codeSecret">Code d'invitation (optionnel) :</label>
                <input type="text" id="codeSecret" name="codeSecret" 
                placeholder="Code d'invitation (optionnel)">
            </article>

            <input type="submit" value="Créer" class="boutton marron">
        </section>
    </form>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>