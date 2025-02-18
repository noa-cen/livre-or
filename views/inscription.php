<?php

$pageTitle = "Créer mon compte";
require_once(__DIR__ . "/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $utilisateur = htmlspecialchars(trim($_POST["utilisateur"]));
    $mdp = $_POST["mdp"];
    $mdpVerifie = $_POST["mdpVerifie"];
    $codeSecret = isset($_POST["codeSecret"]) ? trim($_POST["codeSecret"]) : "";

    $utilisateurController = new UtilisateurController;
    $result = $utilisateurController->creationUtilisateur($utilisateur, $mdp, $mdpVerifie, $codeSecret);

    if ($result === true) {
        echo "Inscription réussie !";
    } else {
        return $errors;
    }
}

?>

<main>
    <form action="" method="POST" class="form">
        <h2>Créer votre compte</h2>
        
        <section class="form-body">
            <?php if (!empty($errors["utilisateur"])) : ?>
                <p class="message error"><?php echo $errors["utilisateur"]; ?></p>
            <?php endif; ?>

            <article class="form-items">
                <label for="utilisateur">Nom d'utilisateur: </label>
                <input type="text" id="utilisateur" name="utilisateur" placeholder="Nom d'utilisateur" 
                required>
            </article>

            <?php if (!empty($errors["mdp"])) : ?>
                <p class="message error"><?php echo $errors["mdp"];?></p>
            <?php endif; ?>

            <article class="form-items">
                <label for="mdp">Mot de passe:</label>
                <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" 
                required>
            </article>

            <?php if (!empty($errors["mdpVerifie"])) : ?>
                <p class="message error"><?php echo $errors["mdpVerifie"]; ?></p>
            <?php endif; ?>

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