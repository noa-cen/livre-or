<?php

class Session
{
    // Start a session if it's not already started
    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Check if the user is logged in, otherwise redirect to the login page
    public function checkUserLogin() 
    {
        if (!isset($_SESSION["id"])) {
            header("Location: ../views/connexion.php");
            exit();
        }
    }

    // Log out the user by clearing the session and redirecting to the homepage
    public function logOut()
    {
        session_unset(); 
        session_destroy(); 
        header("Location: /livre-or/index.php");
        exit();
    }
}