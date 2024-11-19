<?php
// ===== ResetSession.php =====
require_once 'autoload.php';

// Fonction pour réinitialiser la session
class ResetSession
{
    public function __construct()
    {
        $this->resetSession();
    }

    public function resetSession()
    {
        // Démarrer la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vider les données de session
        session_unset();

        // Détruire la session
        session_destroy();

        // Démarrer une nouvelle session
        session_start();
    }
}