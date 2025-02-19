<?php
require_once(__DIR__ . "/../controllers/UtilisateurController.php"); 

class Administrateur extends Utilisateur
{
    public function inscription($utilisateur, $mdp)
    {
        $query = "SELECT login FROM user WHERE login = :login";
        $stmt = $this->getPdo()->prepare($query);
        $stmt->execute(["login" => $utilisateur]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return $errors["utilisateur"] = "Un compte existe déjà avec ce nom d'utilisateur.";
        }

        $mdpProtege = password_hash($mdp, PASSWORD_DEFAULT);

        $query = "INSERT INTO user(login, password, role) VALUES (:login, :password, :role)";
        $stmt = $this->getPdo()->prepare($query);
        if ($stmt->execute([":login" => $utilisateur, ":password" => $mdpProtege, 
        ":role" => "moderateur"])) {
            return true;
        } else {
            return $errors["inscription"] = "Erreur lors de l'inscription.";
        }
    }

    public function supprimerCommentaire($id)
    {
        $query = "DELETE FROM comment WHERE id = :id";
        $stmt = $this->getPdo()->prepare($query);
        if ($stmt->execute([":id" => $id])) {
            return true;
        }
        else {
            return false;
        }
    }
}