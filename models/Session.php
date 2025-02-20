<?php

class Session
{
    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function checkUserLogin() 
    {
        if (!isset($_SESSION["id"])) {
            header("Location: ../views/connexion.php");
            exit();
        }
    }

    public function deconnexion()
    {
        session_unset(); 
        session_destroy(); 
        header("Location: /livre-or/index.php");
        exit();
    }
}