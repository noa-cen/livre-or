<?php
class Commentaire {
    private $pdo;

    // Le constructeur reçoit l'objet DatabaseConnection et récupère le PDO
    public function __construct($db) {
        $this->pdo = $db->getPdo();
    }

    // Ajoute un commentaire 
    public function ajouterCommentaire($id_user, $comment) {
        $sql = "INSERT INTO comment (id_user, comment) VALUES (:id_user, :comment)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_user' => $id_user,
            ':comment' => $comment
        ]);
    }

    // Récupère les commentaires en les joignant avec le login de l'utilisateur, triés du plus récent au plus ancien
    public function recupererCommentaires($limit, $offset) {
        $sql = "SELECT c.id, c.comment, c.date, u.login
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
    
    // Récupère les commentaires correspondant à un mot-clé (dans le commentaire, la date ou le login)
    public function rechercherCommentaires($keyword, $limit, $offset) {
        $sql = "SELECT c.id, c.comment, c.date, u.login
                FROM comment AS c
                INNER JOIN user AS u ON c.id_user = u.id
                WHERE c.comment LIKE :keyword OR u.login LIKE :keyword OR c.date LIKE :keyword
                ORDER BY c.date DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':keyword', '%'.$keyword.'%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compte le nombre total de commentaires correspondant à une recherche (pr la pagination)
    
    public function compterCommentairesRecherche($keyword) {
        $sql = "SELECT COUNT(*) as total
                FROM comment AS c
                INNER JOIN user AS u ON c.id_user = u.id
                WHERE c.comment LIKE :keyword OR u.login LIKE :keyword OR c.date LIKE :keyword";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':keyword', '%'.$keyword.'%', PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
