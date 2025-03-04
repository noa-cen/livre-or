<?php
require_once(__DIR__ . "/../controllers/UtilisateurController.php"); 

class Utilisateur extends DatabaseConnection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function inscription($utilisateur, $mdp)
    {
        $query = "SELECT login FROM user WHERE login = :login";
        $stmt = $this->getPdo()->prepare($query);
        $stmt->execute(["login" => $utilisateur]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION["errorMessage"] = "Un compte existe déjà avec ce nom d'utilisateur.";
            return false;
        }

        $mdpProtege = password_hash($mdp, PASSWORD_DEFAULT);

        $query = "INSERT INTO user(login, password, role) VALUES (:login, :password, :role)";
        $stmt = $this->getPdo()->prepare($query);
        if ($stmt->execute([":login" => $utilisateur, ":password" => $mdpProtege, ":role" => "user"])) {
            return true;
        } else {
            $_SESSION["errorMessage"] = "Erreur lors de l'inscription.";
        }
    }

    public function connexion($utilisateur, $mdp)
    {
        $query = "SELECT * FROM user WHERE login = :login";
        $stmt = $this->getPdo()->prepare($query);
        $stmt->execute(["login" => $utilisateur]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $user["password"])) {
            return $user;
        } 
        return false;
    }

    public function modification($nouveauUtilisateur, $ancienMdp, $nouveauMdp, $user_id) 
    {
        $query = "SELECT password FROM user WHERE id = :id";
        $stmt = $this->getPdo()->prepare($query);
        $stmt->execute(["id" => $user_id]);
        $password = $stmt->fetch(PDO::FETCH_COLUMN);

        if (password_verify($ancienMdp, $password)) {
            $query = "UPDATE user SET login = :login, password = :password WHERE id = :id";
            $stmt = $this->getPdo()->prepare($query);
            
            if (!empty($nouveauMdp)) {
                $nouveauMdpProtege = password_hash($nouveauMdp, PASSWORD_DEFAULT);

                $params = [
                    ":login" => $nouveauUtilisateur,
                    ":password" => $nouveauMdpProtege,
                    ":id" => $user_id
                ];
            } else {
                $params = [
                    ":login" => $nouveauUtilisateur,
                    ":password" => $password,
                    ":id" => $user_id
                ];
            }
 
            $modif = $stmt->execute($params);
            return $modif;
        }
        else {
            $_SESSION["errorMessage"] = "Le mot de passe est incorrect.";
        }
    }
}