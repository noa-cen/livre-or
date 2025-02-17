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
        $query = "SELECT utilisateur FROM user WHERE utilisateur = :utilisateur";
        $stmt = $this->getPdo()->prepare($query);
        $stmt->execute(["utilisateur" => $utilisateur]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return $errors["utilisateur"] = "Un compte existe déjà avec ce nom d'utilisateur.";
        }

        $mdpProtege = password_hash($mdp, PASSWORD_DEFAULT);

        $query = "INSERT INTO user(utilisateur, mdp) VALUES (:utilisateur, :mdp)";
        $stmt = $this->getPdo()->prepare($query);
        if ($stmt->execute([":utilisateur" => $utilisateur, ":mdp" => $mdpProtege])) {
            return true;
        } else {
            return $errors["inscription"] = "Erreur lors de l'inscription.";
        }
    }

    public function connexion($utilisateur, $mdp)
    {
        $query = "SELECT * FROM user WHERE utilisateur = :utilisateur";
        $stmt = $this->getPdo()->prepare($query);
        $stmt->execute(["utilisateur" => $utilisateur]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $utilisateur["mdp"])) {
            return $user;
        } 
        return false;
    }

    public function modification($nouveauUtilisateur, $nouveauMdp, $user_id) {
        $query = "UPDATE user SET utilisateur = :utilisateur, mdp = :mdp, WHERE id = :id";
        $stmt = $this->getPdo()->prepare($query);
        
        $nouveauMdpProtege = password_hash($nouveauMdp, PASSWORD_DEFAULT);

        $params = [
            ":username" => $nouveauUtilisateur,
            ":mdp" => $nouveauMdpProtege,
            ":id" => $user_id
        ];
    
        $modif = $stmt->execute($params);
        return $modif;
    }
}