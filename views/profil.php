<?php

$pageTitle = "Modifier mon compte";
require_once(__DIR__ . "/header.php");

$errors = [];
$utilisateurController = new UtilisateurController;

// If the session has a username, retrieve the user ID, username from the session
if (isset($_SESSION["utilisateur"])) {
    $user_id = $_SESSION["id"]; 
    $utilisateur = $_SESSION["utilisateur"]; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize the form input values
    $nouveauUtilisateur = htmlspecialchars(trim($_POST["utilisateur"]));
    $ancienMdp = $_POST["ancienMdp"];
    $nouveauMdp = $_POST["mdp"];
    $nouveauMdpVerifie = $_POST["mdpVerifie"];

    // Register the user using the userController
    $result = $utilisateurController->modificationUtilisateur($nouveauUtilisateur, $ancienMdp, $nouveauMdp, 
    $nouveauMdpVerifie, $user_id);
    
    if ($result !== true) { 
        $errors[] = $result; 
    }
}
?>

<main>
    <?php if (!empty($edit) && is_array($edit)): ?>
        <?php foreach ($edit as $errors): ?>
            <p class="message error"><?php echo $errors; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($_SESSION["successMessage"])) : ?>
        <p class="message success"><?php echo $_SESSION["successMessage"]; ?></p>
        <?php unset($_SESSION["successMessage"]); ?>
    <?php endif; ?>

    <form action="" method="POST" class="form">
        <h2>Modifier mon compte !</h2>
        
        <section class="form-body">
            <article class="form-items">
                <label for="utilisateur">Nom d'utilisateur: </label>
                <input type="text" id="utilisateur" name="utilisateur" placeholder="Nom d'utilisateur" 
                required value="<?= htmlspecialchars($utilisateur) ?>">
            </article>

            <article class="form-items">
                <label for="ancienMdp">Ancien mot de passe:</label>
                <input type="password" id="ancienMdp" name="ancienMdp" placeholder="Ancien mot de passe" 
                required>
            </article>

            <?php if (!empty($errors["mdp"])) : ?>
                <p class="message error"><?php echo $errors["mdp"];?></p>
            <?php endif; ?>

            <article class="form-items">
                <label for="mdp">Nouveau mot de passe:</label>
                <input type="password" id="mdp" name="mdp" placeholder="Nouveau mot de passe">
            </article>

            <?php if (!empty($errors["mdpVerifie"])) : ?>
                <p class="message error"><?php echo $errors["mdpVerifie"]; ?></p>
            <?php endif; ?>

            <article class="form-items">
                <label for="mdpVerifie">Confirmer le mot de passe:</label>
                <input type="password" id="mdpVerifie" name="mdpVerifie" 
                placeholder="Confirmer le mot de passe">
            </article>

            <input type="submit" value="Modifier" name="modifier" class="button marron">
        </section>        
    </form>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>