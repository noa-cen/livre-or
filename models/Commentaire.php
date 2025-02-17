<?php

class Commentaire {
    private $pdo;

    public function __construct(DatabaseConnection $db) {
        $this->pdo = $db->getPdo();
    }

    public function ajouterCommentaire($id_user, $comment) {
        $sql = "INSERT INTO comment (id_user, comment, date) VALUES (:id_user, :comment, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':comment' => $comment
        ]);
    }

    public function recupererCommentaires(int $limit, int $offset): array {
        $sql = "SELECT comment.*, user.login FROM comment 
                JOIN user ON comment.id_user = user.id 
                ORDER BY date DESC 
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function compterCommentaires(): int {
        $sql = "SELECT COUNT(*) FROM comment";
        return $this->pdo->query($sql)->fetchColumn();
    }
}   
?>
