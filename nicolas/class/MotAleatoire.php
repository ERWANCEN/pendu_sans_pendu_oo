<?php
// ===== MotAleatoire.php =====
require_once 'autoload.php';

class MotAleatoire
{
    private array $_trouverMot = ['SEMILLANT', 'COLLINAIRE', 'DAMASQUINE', 'CHASUBLE', 'HIEMALE', 'EXHAUSTEUR', 'PERCLUS', 'PETRICHOR', 'IMMARCESCIBLE', 'CALLIPYGE', 'OBJURGATION', 'DYSTOPIE', 'PENDRILLON', 'ASSUETUDE', 'VERBATIM', 'BERGAMASQUE', 'ANONCHALIR', 'COMPENDIEUX'];
    private string $_motAleatoire = "";
    private array $_motAleatoireSplit = [];
    private string $_motAffiche = "";

    public function __construct($mot = null)
    {
        if ($mot) {
            $this->_motAleatoire = $mot;
        } else {
            $this->setMotAleatoire();
        }
        $this->_motAleatoireSplit = str_split($this->_motAleatoire);
        $this->setMotAffiche();
    }

    public function setMotAleatoire()
    {
        $this->_motAleatoire = $this->_trouverMot[array_rand($this->_trouverMot)];
    }

    public function getMotAleatoire()
    {
        return $this->_motAleatoire;
    }

    public function setMotAffiche()
    {
        $this->_motAffiche = "";
        $longueur = count($this->_motAleatoireSplit);
        
        for ($i = 0; $i < $longueur; $i++) {
            $lettre = $this->_motAleatoireSplit[$i];
            if ($i === 0 || $i === ($longueur - 1)) {
                $this->_motAffiche .= "<span class='text-success fw-bold'>{$lettre}</span> ";
            } else {
                $this->_motAffiche .= "_ ";
            }
        }
    }

    public function setLettresTrouvees(array $lettresTrouvees)
    {
        $this->_motAffiche = "";
        foreach ($this->_motAleatoireSplit as $index => $lettre) {
            if ($index === 0 || $index === count($this->_motAleatoireSplit) - 1) {
                $this->_motAffiche .= "<span class='text-success fw-bold'>{$lettre}</span> ";
            } elseif (in_array($lettre, $lettresTrouvees)) {
                $this->_motAffiche .= "<span class='text-primary fw-bold'>{$lettre}</span> ";
            } else {
                $this->_motAffiche .= "_ ";
            }
        }
    }

    public function getMotAffiche()
    {
        return $this->_motAffiche;
    }
}
