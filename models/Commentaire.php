<?php

class Commentaire {
    private int $id;
    private string $comment;
    private int $id_user;
    private string $date;
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterCommentaire(int $id_user, string $comment): bool {
        $sql = "INSERT INTO comment (comment, id_user, date) VALUES (:comment, :id_user, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['comment' => $comment, 'id_user' => $id_user]);
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
