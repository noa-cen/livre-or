<?php
$pageTitle = "Un petit mot pour Marie & Clara ";

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

    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="" method="post" class=form>
    <h2>Un petit mot pour Marie & Clara </h2>
        <textarea name="commentaire" required></textarea>
        <button type="submit" class="boutton marron">Envoyer</button>
    </form>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>