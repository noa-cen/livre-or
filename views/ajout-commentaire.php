<?php
$pageTitle = "Ajout de Commentaire";
require_once '../models/DatabaseConnection.php';
require_once '../models/Commentaire.php';
require_once (__DIR__ . "/header.php");

// Instancier la connexion à la BDD et la classe Commentaire
$db = new DatabaseConnection();
$commentaire = new Commentaire($db);

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['commentaire'])) {
    if ($commentaire->ajouterCommentaire($_SESSION['id'], $_POST['commentaire'])) {
        header("Location: livre-or.php");
        exit();
    } else {
        $message = "Erreur lors de l'ajout du commentaire.";
    }
}

?>

<main>
    <?php if (isset($_SESSION["successMessage"])) : ?>
        <p class="message success"><?php echo $_SESSION["successMessage"] ; ?></p>
        <?php unset($_SESSION["successMessage"]); ?>
    <?php endif; ?>

    <h2>Ajouter un commentaire</h2>
    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <textarea name="commentaire" required></textarea>
        <button type="submit">Envoyer</button>
    </form>
    <a href="livre-or.php">Retour au livre d'or</a>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>