<?php
require_once '../models/DatabaseConnection.php';
require_once '../models/Commentaire.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// Instancier la connexion à la BDD et la classe Commentaire
$db = new DatabaseConnection();
$commentaire = new Commentaire($db);

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['commentaire'])) {
    if ($commentaire->ajouterCommentaire($_SESSION['user_id'], $_POST['commentaire'])) {
        header("Location: livre-or.php");
        exit();
    } else {
        $message = "Erreur lors de l'ajout du commentaire.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un commentaire</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Ajouter un commentaire</h1>
    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <textarea name="commentaire" required></textarea>
        <button type="submit">Envoyer</button>
    </form>
    <a href="livre-or.php">Retour au livre d'or</a>
</body>
</html>
