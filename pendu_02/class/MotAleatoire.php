<?php
require_once 'autoload.php';

class MotAleatoire
{
    private array $_trouverMot = ['SEMILLANT', 'COLLINAIRE', 'DAMASQUINE', 'CHASUBLE', 'HIEMALE', 'EXHAUSTEUR', 'PERCLUS', 'PETRICHOR', 'IMMARCESCIBLE', 'CALLIPYGE', 'OBJURGATION', 'DYSTOPIE', 'PENDRILLON', 'ASSUETUDE', 'VERBATIM', 'BERGAMASQUE', 'ANONCHALIR', 'COMPENDIEUX'];

    private string $_motAleatoire = "";

    private string $_motAffiche = "";

    private string $_success = "";

    private string $_error = "";

    private array $_motAleatoireSplit = [];

    private array $_lettresTrouvees = [];

    private array $_lettresProposees = [];

    private array $_premiereEtDerniereLettre = [];

    private int $_longueurMotAleatoire;

    private int $_essaisRestants = 5;

    private bool $_partieGagnee = false;





    public function __construct($mot = null)
    {
        if ($mot !== null) {
            $this->_motAleatoire = $mot; // Utiliser le mot fourni
        } else {
            $this->setMotAleatoire(); // Générer un nouveau mot
        }
        $this->setPremiereEtDerniereLettre();
        $this->setMotAffiche();
        $this->setEssaisRestants();
    }





    public function setMotAleatoire()
    {
        $this->_motAleatoire = strtoupper($this->_trouverMot[array_rand($this->_trouverMot)]);
    }

    public function getMotAleatoire()
    {
        return $this->_motAleatoire;
    }





    public function setPremiereEtDerniereLettre()
    {
        $this->_longueurMotAleatoire = iconv_strlen($this->_motAleatoire);

        $this->_premiereEtDerniereLettre[] = $this->_motAleatoire[0];
        $this->_premiereEtDerniereLettre[] = $this->_motAleatoire[$this->_longueurMotAleatoire - 1];
    }

    public function getPremiereEtDerniereLettre()
    {
        return $this->_premiereEtDerniereLettre;
    }





    public function lettresTrouvees(string $proposition)
    {
        if (!isset($_SESSION['lettresTrouvees'])) {
            $_SESSION['lettresTrouvees'] = [];
        }

        $proposition = strtoupper(trim($proposition));
        $this->_motAleatoire = strtoupper($this->_motAleatoire);
        $this->_motAleatoireSplit = str_split($this->_motAleatoire);

        if (in_array($proposition, $this->_motAleatoireSplit) && !in_array($proposition, $this->_lettresTrouvees)) {
            $_SESSION['lettresTrouvees'][] = $proposition;
        } elseif (!in_array($proposition, $this->_motAleatoireSplit)) {
            $this->_error = "La lettre proposée n'est pas dans le mot.";
        } elseif (in_array($proposition, $this->_lettresTrouvees)) {
            $this->_error = "La lettre a déjà été proposée.";
        } else {
            $this->_error = "Problème au niveau de la méthode 'lettresTrouvees'";
        }

        $this->_lettresTrouvees = $_SESSION['lettresTrouvees'];
    }





    public function verifierLettre(string $proposition, array $session)
    {
        // echo '<pre>';
        // print_r($session);
        // echo '</pre>';

        $this->_longueurMotAleatoire = iconv_strlen($this->_motAleatoire);

        $this->_motAleatoireSplit = str_split($this->_motAleatoire);

        $proposition = strtoupper($proposition);

        // $this->_essaisRestants = 5;
    
        if (strlen($proposition) > 1) {
            if ($proposition == $_SESSION['motAleatoire']) {
                $this->$_partieGagnee = true;
                $this->_success = "Bravo ! Vous avez trouvé le bon mot !";
                $this->_lettresTrouvees = str_split($_SESSION['motAleatoire']);
                $_SESSION['lettresTrouvees'] = str_split($_SESSION['motAleatoire']);
            } else {
                $this->_essaisRestants--;
                $this->_error = "Le mot proposé est incorrect. Il vous reste " . $this->_essaisRestants . " essais.";
            }
        } elseif (strlen($proposition) === 0) {
            $this->_error = "Veuillez entrer votre proposition.";
        } else {
            if (in_array($proposition, $this->_lettresProposees)) {
                $this->_essaisRestants--;
                $this->_error = "Lettre déjà proposée. Vies restantes : " . $this->_essaisRestants;
            } else {
                $this->_lettresProposees[] = $proposition;
                if (strpos($proposition, $_SESSION['motAleatoire']) !== false) {
                    $this->_lettresTrouvees[] = $proposition;
                    $_SESSION['lettresTrouvees'][] = $proposition;
                } else {
                    $this->_essaisRestants--;
                    $this->_error = "La lettre proposée n'est pas dans le mot recherché. Il vous reste " . $this->_essaisRestants . " essais.";
                }
            }
        }
        
        // if (in_array($proposition, $this->_premiereEtDerniereLettre)) {
        //     if (strpos($this->_motAleatoire, $proposition) !== false && !in_array($proposition, $this->_lettresTrouvees)) {
        //         $this->_lettresTrouvees[] = $proposition;
        //         $_SESSION['lettresTrouvees'][] = $proposition;
        //     } else {
        //         $this->_essaisRestants--;
        //         $this->_error = "La lettre proposée est déjà affichée. Il vous reste " . $this->_essaisRestants . " essais.";
        //     }
        // } else {
        //     if (strpos($this->_motAleatoire, $proposition) !== false) {
        //         $this->_lettresTrouvees[] = $proposition;
        //         $_SESSION['lettresTrouvees'][] = $proposition;
        //     } else {
        //         $this->_essaisRestants--;
        //         $this->_error = "La lettre proposée n'est pas dans le mot recherché. Il vous reste " . $this->_essaisRestants . " essais.";
        //     }
        // }



        

        echo "Mot aléatoire : $this->_motAleatoire\n";

        echo "Lettres proposées : " . implode(", ", $this->_lettresProposees) . "\n";
        echo "Lettres trouvées : " . implode(", ", $this->_lettresTrouvees) . "\n";

        if (!in_array($proposition, $this->_lettresTrouvees)) {
            $this->_lettresTrouvees[] = $proposition;
            echo "Lettre ajoutée : $proposition\n";
        }
    }


    


    public function setMotAffiche()
    {
        $this->_longueurMotAleatoire = iconv_strlen($this->_motAleatoire);

        $this->_motAleatoireSplit = str_split(trim($this->_motAleatoire));

        $this->_motAffiche = "";

        print_r($this->_lettresTrouvees); // Doit contenir les lettres trouvées
        print_r($this->_premiereEtDerniereLettre);

        for ($i = 0; $i < $this->_longueurMotAleatoire; $i++) {
            if ($i === 0) {
                $this->_motAffiche .= $this->_premiereEtDerniereLettre[0] . ' ';
            } elseif ($i === $this->_longueurMotAleatoire - 1) {
                $this->_motAffiche .= $this->_premiereEtDerniereLettre[1];
            } elseif (in_array($this->_motAleatoireSplit[$i], $this->_lettresTrouvees)) {
                $this->_motAffiche .= '<span style="color: orange;">' . $this->_motAleatoireSplit[$i] . '</span> ';
            } else {
                $this->_motAffiche .= '_ ';
            }
        }

        
    }

    public function getMotAffiche()
    {
        return $this->_motAffiche;
    }





    public function getSuccess()
    {
        return $this->_success;
    }





    public function getError()
    {
        return $this->_error;
    }





    public function setLettresTrouvees()
    {
        if (in_array($proposition, $this->_premiereEtDerniereLettre)) {
            if (strpos($this->_motAleatoire, $proposition) !== false && !in_array($proposition, $this->_lettresTrouvees)) {
                $this->_lettresTrouvees[] = $proposition;
                $_SESSION['lettresTrouvees'][] = $proposition;
            } else {
                $this->_essaisRestants--;
                $this->_error = "La lettre proposée est déjà affichée. Il vous reste " . $this->_essaisRestants . " essais.";
            }
        } else {
            if (strpos($this->_motAleatoire, $proposition) !== false) {
                $this->_lettresTrouvees[] = $proposition;
                $_SESSION['lettresTrouvees'][] = $proposition;
            } else {
                $this->_essaisRestants--;
                $this->_error = "La lettre proposée n'est pas dans le mot recherché. Il vous reste " . $this->_essaisRestants . " essais.";
            }
        }
    }

    public function getLettresTrouvees()
    {
        return $this->_lettresTrouvees;
    }

    // public function setLettresProposees(string $proposition)
    // {
    //     $this->_lettresProposees[] = $proposition;
    // }





    

    public function lettresProposees(string $proposition)
    {
        // Si la session 'lettresProposees' n'existe pas, initialisez-la
        if (!isset($_SESSION['lettresProposees'])) {
            $_SESSION['lettresProposees'] = [];
        }

        $proposition = strtoupper(trim($proposition));
        $this->_motAleatoire = strtoupper($this->_motAleatoire);

        // Ajoutez la nouvelle proposition à la session
        if (iconv_strlen($proposition > 1) && $proposition === $this->_motAleatoire) {
            $this->_success = "<p>Bravo ! Vous avez bien trouvé le mot " . $this->_motAleatoire . "</p>";
        } elseif (in_array($proposition, $_SESSION['lettresProposees'])) {
            $this->_error = "<p>Vous avez déjà proposé cette lettre. Vous perdez un essai.</p>";
        } else {
            $_SESSION['lettresProposees'][] = $proposition;
        }
        
        // Mettez aussi à jour la propriété interne (optionnel)
        $this->_lettresProposees = $_SESSION['lettresProposees'];
    }

    // public function getLettresProposees()
    // {
    //     return $this->_lettresProposees;
    // }





    public function setEssaisRestants()
    {
        $this->_essaisRestants = 5;
    }

    public function getEssaisRestants()
    {
        return $this->_essaisRestants;
    }




    
    
}