<?php
session_start();

require_once '../models/DatabaseConnection.php';
require_once '../models/Commentaire.php';

// Instanciation de la connexion à la BDD
$db = new DatabaseConnection();
$commentaire = new Commentaire($db);

// Gestion de la pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

// Récupération des commentaires et du nombre total
$commentaires = $commentaire->recupererCommentaires($limit, $offset);
$totalCommentaires = $commentaire->compterCommentaires();
$totalPages = ceil($totalCommentaires / $limit);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Livre d'or</h1>
    <?php foreach ($commentaires as $com): ?>
        <div class="commentaire">
            <p>
                <strong><?= htmlspecialchars($com['login']) ?></strong> a écrit le <?= date('d/m/Y', strtotime($com['date'])) ?> :
            </p>
            <p><?= nl2br(htmlspecialchars($com['comment'])) ?></p>
        </div>
    <?php endforeach; ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" <?= ($i === $page) ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="ajout-commentaire.php">Ajouter un commentaire</a>
    <?php endif; ?>
</body>
</html>
