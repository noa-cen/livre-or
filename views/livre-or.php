<?php
session_start();
$pageTitle = "Livre d'Or";

require_once '../models/Commentaire.php';
require_once (__DIR__ . "/../views/header.php");


// Instanciation de la connexion à la BDD
$db = new DatabaseConnection();
$commentaire = new Commentaire($db);

// Gestion de la pagination
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

// Récupération des commentaires et du nombre total
$commentaires = $commentaire->recupererCommentaires($limit, $offset);
$totalCommentaires = $commentaire->compterCommentaires();
$totalPages = ceil($totalCommentaires / $limit);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"])) {
    $id = $_POST["id"];
    $admin = new Administrateur;
    $result = $admin->supprimerCommentaire($id);
    header("Location: livre-or.php");
    exit();

    if ($result == false) {
        return $error = "Il y a eu un problème lors de la suppression du commentaire.";
    }
}
?>

<main>
    <h2>Livre d'or</h2>
    <?php foreach ($commentaires as $com): ?>
        <div class="commentaire">
            <p>
                <strong><?= htmlspecialchars($com['login']) ?></strong> a écrit le <?= date('d/m/Y', strtotime($com['date'])) ?> :
            </p>
            <p><?= nl2br(htmlspecialchars($com['comment'])) ?></p>
            <?php if (isset($_SESSION["id"]) && $_SESSION["admin"] == 1) : ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $com["id"] ?>">
                    <input type="submit" value="Supprimer" name="supprimer" class="delete">
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" <?= ($i === $page) ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>
    </div>

    <?php if (isset($_SESSION['id'])): ?>
        <a href="ajout-commentaire.php">Ajouter un commentaire</a>
    <?php endif; ?>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>