<?php
class Commentaire {
    private $pdo;

    // Le constructeur reçoit l'objet DatabaseConnection et récupère le PDO
    public function __construct($db) {
        $this->pdo = $db->getPdo();
    }

    // Ajoute un commentaire dans la base
    public function ajouterCommentaire($id_user, $comment) {
        $sql = "INSERT INTO comment (id_user, comment, date) VALUES (:id_user, :comment, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':comment' => $comment
        ]);
    }

    // Récupère les commentaires en les joignant avec le login de l'utilisateur, triés du plus récent au plus ancien
    public function recupererCommentaires($limit, $offset) {
        $sql = "SELECT c.comment, c.date, u.login
                FROM comment AS c
                INNER JOIN user AS u ON c.id_user = u.id
                ORDER BY c.date DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compte le nombre total de commentaires
    public function compterCommentaires() {
        $sql = "SELECT COUNT(*) as total FROM comment";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
