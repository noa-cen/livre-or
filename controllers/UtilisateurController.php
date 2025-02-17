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
        $errors = [];

        if (strlen($mdp) < 8 || !preg_match("/[A-Za-z]/", $mdp) || !preg_match("/[0-9]/", 
        $mdp)) {
            $errors["mdp"] = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une 
            lettre et un chiffre.";
        }

        // Check if the password and its verification match
        if ($mdp !== $mdpVerifie) {
            $errors["mdpVerifie"] = "Les mots de passe ne correspondent pas.";
        }

        if (!empty($errors)) {
            return $errors;
        }

        // Définition du code secret attendu pour l'administration
        $codeSecretAttendu = "votreCodeSecret"; // à définir

        // Vérification du code secret pour déterminer le type de compte
        if ($codeSecret === $codeSecretAttendu) {
            // Inscription en tant qu'administrateur
            $compte = new Administrateur();
        } else {
            // Inscription en tant qu'utilisateur standard
            $compte = new Utilisateur();
        }

        $result = $compte->inscription($utilisateur, $mdp);

        if ($result === true) {
            $_SESSION["successMessage"] = "Votre compte a été créé avec succès !";
            header("Location: connexion.php");
            exit();
        }
    }

    public function modificationUtilisateur($nouveauUtilisateur, $ancienMdp, $nouveauMdp, 
    $nouveauMdpVerifie, $user_id)
    {
        $errors = [];

        if ($ancienMdp === $nouveauMdp) {
            $errors["ancienMdp"] = "Le nouveau mot de passe doit être différent de l'ancien.";
        }

        if (strlen($nouveauMdp) < 8 || !preg_match("/[A-Za-z]/", $nouveauMdp) || !preg_match("/[0-9]/", 
        $nouveauMdp)) {
            $errors["nouveauMdp"] = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une 
            lettre et un chiffre.";
        }

        // Check if the password and its verification match
        if ($nouveauMdp !== $nouveauMdpVerifie) {
            $errors["nouveauMdpVerifie"] = "Les mots de passe ne correspondent pas.";
        }

        if (!empty($errors)) {
            return $errors;
        }

        $user = new Utilisateur;
        $edit = $user->modification($nouveauUtilisateur, $ancienMdp, $nouveauMdp, $user_id);

        if ($edit === true) {
            $_SESSION["utilisateur"] = $nouveauUtilisateur;
            $_SESSION["successMessage"] = "Votre compte a été modifié avec succès !";
            header("Location: profil.php");
            exit();
        } else {
            return $errors["modification"] = "Erreur lors de la modification du nom d'utilisateur.";
        }
    }
}