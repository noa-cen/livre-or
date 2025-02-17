<?php

$pageTitle = "Créer mon compte";
require_once(__DIR__ . "/../header.php");

$errors = [];
$utilisateur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize the form input values
    $utilisateur = htmlspecialchars(trim($_POST["utilisateur"]));
    $mdp = $_POST["mdp"];
    $mdpVerifie = $_POST["mdpVerifie"];

    // Register the user using the userController
    $result = $utilisateurController->creationUtilisateur($utilisateur, $mdp, $mdpVerifie);
    
    if ($result !== true) { 
        $errors[] = $result; 
    }
}

?>

<main>
    <form action="" method="POST" class="form">
        <h2>Créer mon compte</h2>
        
        <section class="form-body">
            <?php if (!empty($errors["utilisateur"])) : ?>
                <p class="message error"><?php echo $errors["utilisateur"]; ?></p>
            <?php endif; ?>

            <article class="form-items">
                <label for="utilisateur">Nom d'utilisateur: </label>
                <input type="text" id="utilisateur" name="utilisateur" placeholder="Nom d'utilisateur" 
                required value="<?= htmlspecialchars($utilisateur); ?>">
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
                <label for="mdpVerifie">Vérifier le mot de passe:</label>
                <input type="password" id="mdpVerifie" name="mdpVerifie" 
                placeholder="Vérifier le mot de passe" required>
            </article>

            <input type="submit" value="Créer mon compte" class="button jump">
        </section>
    </form>
</main>

<?php require_once(__DIR__ . "/../footer.php"); ?>