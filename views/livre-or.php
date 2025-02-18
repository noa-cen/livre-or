<?php
session_start();
$pageTitle = "Livre d'Or";

require_once '../models/DatabaseConnection.php';
require_once '../models/Commentaire.php';
require_once (__DIR__ . "/../views/header.php");

// Instanciation de la connexion à la BDD
$db = new DatabaseConnection();
$commentaire = new Commentaire($db);

// Paramètres de pagination
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

// Récupération du mot-clé de recherche (s'il est renseigné)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Si un mot-clé est fourni, on effectue une recherche, sinon on récupère tous les commentaires
if (!empty($search)) {
    $commentaires = $commentaire->rechercherCommentaires($search, $limit, $offset);
    $totalCommentaires = $commentaire->compterCommentairesRecherche($search);
} else {
    $commentaires = $commentaire->recupererCommentaires($limit, $offset);
    $totalCommentaires = $commentaire->compterCommentaires();
}

$totalPages = ceil($totalCommentaires / $limit);

// Suppression d'un commentaire (pour admin)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"])) {
    $id = $_POST["id"];
    $admin = new Administrateur;
    $result = $admin->supprimerCommentaire($id);
    header("Location: livre-or.php");
    exit();

    if ($result == false) {
        $error = "Il y a eu un problème lors de la suppression du commentaire.";
    }
}
?>

<main>
    <h2><?= htmlspecialchars($pageTitle) ?></h2>
    
    <!-- Barre de recherche -->
    <form action="livre-or.php" method="GET">
        <input type="text" name="search" placeholder="Rechercher par mot-clé, date ou utilisateur" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Rechercher</button>
    </form>
    
    <?php foreach ($commentaires as $com): ?>
        <div class="commentaire">
            <p>
                <strong><?= htmlspecialchars($com['login']) ?></strong> a écrit le <?= date('d/m/Y', strtotime($com['date'])) ?> :
            </p>
            <p><?= nl2br(htmlspecialchars($com['comment'])) ?></p>
            <?php if (isset($_SESSION["id"]) && $_SESSION["admin"] == 1) : ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($com["id"]) ?>">
                    <input type="submit" value="Supprimer" name="supprimer" class="delete">
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <!-- Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" <?= ($i === $page) ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>
    </div>

    <?php if (isset($_SESSION['id'])): ?>
        <a href="ajout-commentaire.php">Ajouter un commentaire</a>
    <?php endif; ?>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>
