<?php
require_once(__DIR__ . "/../models/Utilisateur.php"); 
require_once(__DIR__ . "/../models/Administrateur.php"); 

class UtilisateurController extends DatabaseConnection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function connexionUtilisateur($utilisateur, $mdp)
    {
        $user = new Utilisateur;
        $result = $user->connexion($utilisateur, $mdp);

        if ($result === false) {
            return false;
        }
        return $result;
    }

    public function creationUtilisateur($utilisateur, $mdp, $mdpVerifie, $codeSecret)
    {
        if (strlen($mdp) < 8 || !preg_match("/[A-Za-z]/", $mdp) || !preg_match("/[0-9]/", 
        $mdp)) {
            $_SESSION["errorMessage"] = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une 
            lettre et un chiffre.";
        }

        if ($mdp !== $mdpVerifie) {
            $_SESSION["errorMessage"] = "Les mots de passe ne correspondent pas.";
        }

        if (!isset($_SESSION["errorMessage"])) {
            $codeSecretAttendu = "votreCodeSecret"; // à définir

            if ($codeSecret === $codeSecretAttendu) {
                // Inscription en tant que modérateur
                $compte = new Administrateur();
            } else {
                // Inscription en tant qu'utilisateur
                $compte = new Utilisateur();
            }

            $result = $compte->inscription($utilisateur, $mdp);

            if ($result === true) {
                $_SESSION["successMessage"] = "Votre compte a été créé avec succès !";
                header("Location: connexion.php");
                exit();
            }
            else {
                return false;
            }
        }
    }

    public function modificationUtilisateur($nouveauUtilisateur, $ancienMdp, $nouveauMdp, 
    $nouveauMdpVerifie, $user_id)
    {
        if (!empty($nouveauMdp) || !empty($nouveauMdpVerifie)) {
            if ($ancienMdp === $nouveauMdp) {
                $_SESSION["errorMessage"] = "Le nouveau mot de passe doit être différent de l'ancien.";
            }
            
            if (strlen($nouveauMdp) < 8 || !preg_match("/[A-Za-z]/", $nouveauMdp) || !preg_match("/[0-9]/", 
            $nouveauMdp)) {
                $_SESSION["errorMessage"] = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une 
                lettre et un chiffre.";
            }

            // Check if the password and its verification match
            if ($nouveauMdp !== $nouveauMdpVerifie) {
                $_SESSION["errorMessage"] = "Les mots de passe ne correspondent pas.";
            }
        }

        if (!isset($_SESSION["errorMessage"])) {
            $user = new Utilisateur;
            $edit = $user->modification($nouveauUtilisateur, $ancienMdp, $nouveauMdp, $user_id);

            if ($edit === true) {
                $_SESSION["utilisateur"] = $nouveauUtilisateur;
                $_SESSION["successMessage"] = "Votre compte a été modifié avec succès !";
                header("Location: profil.php");
                exit();
            }
            else {
                return false;
            }
        }
    }
}