<?php
require_once(__DIR__ . "/../models/Utilisateur.php"); 

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

        if ($result !== true) {
            return $errors["connexion"] = "Erreur lors de la création du quiz.";
        }
    }

    public function creationUtilisateur($utilisateur, $mdp, $mdpVerifie)
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

        $user = new Utilisateur;
        $result = $user->inscription($utilisateur, $mdp);

        if ($result === true) {
            $_SESSION["successMessage"] = "Votre compte a été créé avec succès !";
            header("Location: login.php");
            exit();
        }
    }

    public function modificationUtilisateur($nouveauUtilisateur, $nouveauMdp, $nouveauMdpVerifie, 
    $user_id)
    {
        $errors = [];

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
        $edit = $user->modification($nouveauUtilisateur, $nouveauMdp, $user_id);

        if ($edit === true) {
            $_SESSION["utilisateur"] = $nouveauUtilisateur;
            $_SESSION["successMessage"] = "Votre compte a été modifié avec succès !";
            header("Location: editUser.php");
            exit();
        } else {
            return $errors["modification"] = "Erreur lors de la modification du nom d'utilisateur.";
        }
    }
}