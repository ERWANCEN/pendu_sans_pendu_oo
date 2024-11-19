<?php
session_start();
require_once 'autoload.php';


class Session
{


    // public function __construct(array $session)
    // {
    //     if ((isset($_POST['nouveauMot'])) || (!isset($_SESSION['motAleatoire']))) {
    //         session_unset(); // Supprime toutes les données de la session
    //         session_destroy(); // Détruit la session en cours
    //         session_start(); // Relance une session vide
    //         $motAleatoire = new MotAleatoire();
    //         $_SESSION['motADeviner'] = $motAleatoire->getMotADeviner();
    //         $_SESSION['nombreEssais'] = 5;
    //         $_SESSION['lettresTrouvees'] = [];
    //         $_SESSION['lettresProposees'] = [];
    //         $_SESSION['partieGagnee'] = false;
    //     } else {
    //         // $_SESSION['motADeviner'] = $motAleatoire->getMotADeviner();
    //         $_SESSION['nombreEssais'] = "???"; //doit être égal au nombre de vies restantes
    //         $_SESSION['lettresTrouvees'] = [];
    //         $_SESSION['lettresProposees'] = [];
    //     }
    //     extract($_SESSION);
    // }

    private int $_nombreEssais = 5;
    
    public function initialisation()
    {
        if (!isset($_SESSION['lettresProposees'])) {
            $_SESSION['lettresProposees'] = [];
        }
    
        if (!isset($_SESSION['lettresTrouvees'])) {
            $_SESSION['lettresTrouvees'] = [];
        }
    
        if (!isset($_SESSION['partieGagnee'])) {
            $_SESSION['partieGagnee'] = false;
        }
    
        if (!isset($_SESSION['premiereEtDerniereLettres'])) {
            $_SESSION['premiereEtDerniereLettres'] = [];
        }
    
        if (isset($_POST['nouveauMot']) || !isset($_SESSION['motAleatoire'])) {
            $numeroMotAleatoire = array_rand($trouverMot);
            $motAleatoire = $trouverMot[$numeroMotAleatoire];
            $_SESSION['motAleatoire'] = $motAleatoire;
            $_SESSION['essaisRestants'] = $nombreEssais;
            $_SESSION['lettresProposees'] = [];
            $_SESSION['lettresTrouvees'] = [];
            $_SESSION['premiereEtDerniereLettres'] = [];
            
            $premiereLettre = $motAleatoire[0];
            $derniereLettre = $motAleatoire[strlen($motAleatoire) - 1];
            $_SESSION['premiereEtDerniereLettres'][] = $premiereLettre;
            $_SESSION['premiereEtDerniereLettres'][] = $derniereLettre;
            
            $_SESSION['partieGagnee'] = false;
        } else {
            $motAleatoire = $_SESSION['motAleatoire'];
        }
    }
    
}