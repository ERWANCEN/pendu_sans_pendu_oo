<?php
require_once 'autoload.php';

class Proposition
{

    public function __construct(array $post, array $session)
    {
        // $proposition = "";
        // $positionsLettresDansMot = [];

        // echo '<div style=width:500px;height:10px;background:red;></div>';
        // echo '<pre>';
        // print_r($post);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($session);
        // echo '</pre>';

        // extract($post);
        // extract($session);
        
        // echo '<pre>';
        // print_r($proposition);
        // echo '</pre>';

        // echo '<pre>';
        // print_r($motADeviner);
        // echo '</pre>';

        // foreach ($motADeviner as $key => $value) 
        // {
        //     echo $key;
        //     echo $value;
        //     if ($motADeviner[$key] == $proposition)
        //     {
        //         $positionsLettresDansMot[] = $key;
        //         echo $key;
        //     }
        // }

        // echo '<pre>';
        // print_r($positionsLettresDansMot);
        // echo '</pre>';

        $this->setProposition();

    }

    public function setProposition()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proposition'])) {
            $proposition = strtoupper($_POST['proposition']);
        
            if (strlen($proposition) > 1) {
                if ($proposition == $motAleatoire) {
                    $_SESSION['partieGagnee'] = true;
                    $success = "Bravo ! Vous avez trouvé le bon mot !";
                    $_SESSION['lettresTrouvees'] = str_split($motAleatoire);
                } else {
                    $_SESSION['essaisRestants']--;
                    $error = "Le mot proposé est incorrect. Il vous reste " . $_SESSION['essaisRestants'] . " essais.";
                }
            } elseif (strlen($proposition) === 0) {
                $error = "Veuillez entrer votre proposition.";
            } else {
                if (in_array($proposition, $_SESSION['lettresProposees'])) {
                    $_SESSION['essaisRestants']--;
                    $error = "Lettre déjà proposée. Vies restantes : " . $_SESSION['essaisRestants'];
                } else {
                    $_SESSION['lettresProposees'][] = $proposition;
                    if (strpos($motAleatoire, $proposition) !== false) {
                        $_SESSION['lettresTrouvees'][] = $proposition;
                    } else {
                        $_SESSION['essaisRestants']--;
                        $error = "La lettre proposée n'est pas dans le mot recherché. Il vous reste " . $_SESSION['essaisRestants'] . " essais.";
                    }
                }
            }
        
            if (in_array($proposition, $_SESSION['premiereEtDerniereLettres'])) {
                if (strpos($motAleatoire, $proposition) !== false && !in_array($proposition, $_SESSION['lettresTrouvees'])) {
                    $_SESSION['lettresTrouvees'][] = $proposition;
                } else {
                    $_SESSION['essaisRestants']--;
                    $error = "La lettre proposée est déjà affichée. Il vous reste " . $_SESSION['essaisRestants'] . " essais.";
                }
            } else {
                if (strpos($motAleatoire, $proposition) !== false) {
                    $_SESSION['lettresTrouvees'][] = $proposition;
                } else {
                    $_SESSION['essaisRestants']--;
                    $error = "La lettre proposée n'est pas dans le mot recherché. Il vous reste " . $_SESSION['essaisRestants'] . " essais.";
                }
            }
        }
    }
}

