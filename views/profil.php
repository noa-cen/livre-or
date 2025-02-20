<?php

$pageTitle = "Modifier mon compte";
require_once(__DIR__ . "/header.php");

$utilisateurController = new UtilisateurController;

if (isset($_SESSION["utilisateur"])) {
    $user_id = $_SESSION["id"]; 
    $utilisateur = $_SESSION["utilisateur"]; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nouveauUtilisateur = htmlspecialchars(trim($_POST["utilisateur"]));
    $ancienMdp = $_POST["ancienMdp"];
    $nouveauMdp = $_POST["mdp"];
    $nouveauMdpVerifie = $_POST["mdpVerifie"];

    $result = $utilisateurController->modificationUtilisateur($nouveauUtilisateur, $ancienMdp, $nouveauMdp, 
    $nouveauMdpVerifie, $user_id);
}
?>

<main>
    <?php if (isset($_SESSION["successMessage"])) : ?>
        <p class="message success"><?php echo $_SESSION["successMessage"]; ?></p>
        <?php unset($_SESSION["successMessage"]); ?>
    <?php endif; ?>

    <form action="" method="POST" class="form">
        <h2>Modifier mon compte !</h2>

        <?php if (isset($_SESSION["errorMessage"])) : ?>
            <p class="message error"><?php echo $_SESSION["errorMessage"] ; ?></p>
            <?php unset($_SESSION["errorMessage"]); ?>
        <?php endif; ?>
        
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

            <article class="form-items">
                <label for="mdp">Nouveau mot de passe: (optionnel)</label>
                <input type="password" id="mdp" name="mdp" 
                placeholder="8 caractères minimum dont une lettre et un chiffre">
            </article>

            <article class="form-items">
                <label for="mdpVerifie">Confirmer le mot de passe:</label>
                <input type="password" id="mdpVerifie" name="mdpVerifie" 
                placeholder="Confirmer le mot de passe">
            </article>

            <input type="submit" value="Modifier" name="modifier" class="boutton marron">
        </section>        
    </form>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>