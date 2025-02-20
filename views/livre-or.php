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

// Suppression d'un commentaire (pour modérateur)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"])) {
    $id = $_POST["id"];
    $moderateur = new Administrateur;
    $result = $moderateur->supprimerCommentaire($id);
    header("Location: livre-or.php");
    exit();

    if ($result == false) {
        $error = "Il y a eu un problème lors de la suppression du commentaire.";
    }
}
?>

<main>
    <section class="form">
        <h2 class="livre">Livre d'Or</h2>
        
        <form action="livre-or.php" method="GET" class="form-recherche">
            <input type="text" name="search" placeholder="Rechercher par mot-clé, date ou utilisateur" 
            value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="boutton marron"><i 
            class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        
            <section class="commentaires-container">
                <?php foreach ($commentaires as $com): ?>
                <article class="commentaire">
                    <p class="auteur">Par <span class="bold"><?= htmlspecialchars($com['login']) 
                    ?></span>, écrit le <span class="italic"><?= date('d/m/Y', strtotime($com['date'])) 
                    ?></span> :</p>
                    <p><?= nl2br(htmlspecialchars($com['comment'])) ?></p>
                    <?php if (isset($_SESSION["id"]) && $_SESSION["role"] == "moderateur") : ?>
                        <form method="POST" class="form-delete">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($com["id"]) ?>">
                            <button type="submit" name="supprimer" class="delete"
                            onclick="return confirm('Attention, toute suppression est définitive !')"><i 
                            class="fa-solid fa-trash"></i></button>
                        </form>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>

            </section>
       
        <article class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" <?= ($i === $page) ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>
        </article>

        <a href="<?php echo isset($_SESSION['id']) ? 'ajout-commentaire.php' : 'connexion.php'; ?>" 
        class="boutton marron droite">Remplir le livre d'or</a>
    </section>
</main>

<?php require_once(__DIR__ . "/footer.php"); ?>
