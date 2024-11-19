<?php
require_once 'autoload.php';

class MotAleatoire
{
    /**
     * Propriété privée de type 'array'
     * Contient le tableau des mots
     *
     * @var array
     */
    private array $_trouverMot = ['SEMILLANT', 'COLLINAIRE', 'DAMASQUINE', 'CHASUBLE', 'HIEMALE', 'EXHAUSTEUR', 'PERCLUS', 'PETRICHOR', 'IMMARCESCIBLE', 'CALLIPYGE', 'OBJURGATION', 'DYSTOPIE', 'PENDRILLON', 'ASSUETUDE', 'VERBATIM', 'BERGAMASQUE', 'ANONCHALIR', 'COMPENDIEUX'];

    /**
     * Propriété privée de type 'string'
     * Va contenir le mot aléatoirement choisi
     *
     * @var string
     */
    private string $_motAleatoire = "";

    /**
     * Propriété protégée qui va contenir le mot aléatoire une fois éclaté
     * Chaque lettre du mot aléatoire sera une valeur
     *
     * @var array
     */
    protected array $_motAleatoireSplit = [];

    /**
     * Propriété qui va recevoir le mot aléatoire caché par des '_'
     *
     * @var string
     */
    protected string $_motAleatoireCache = "";

    /**
     * Propriété qui contiendra la longueur du mot aléatoirement choisi
     *
     * @var integer
     */
    private int $_longueurMotAleatoire;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->setMotADeviner();
    }

    /**
     * Méthode qui va permettre de récupérer le mot aléatoire et de cacher toutes ses lettres sauf la première et la dernière
     *
     * @return void
     */
    public function setMotADeviner()
    {
        $this->_motAleatoire = $this->_trouverMot[array_rand($this->_trouverMot)];
        // echo $this->_motAleatoire;

        $this->_motAleatoireSplit = str_split($this->_motAleatoire);
        // echo '<pre>';
        // print_r($this->_motAleatoireSplit);
        // echo '</pre>';

        $this->_longueurMotAleatoire = iconv_strlen($this->_motAleatoire);
        $i = 0;
        while ($i < $this->_longueurMotAleatoire)
        {
            if ($i === 0 || $i === ($this->_longueurMotAleatoire - 1))
            {
                if ($i === 0)
                {
                    $this->_motAleatoireCache .= $this->_motAleatoireSplit[$i] . " ";
                } else {
                    $this->_motAleatoireCache .= $this->_motAleatoireSplit[$i];
                }
            } else {
                $this->_motAleatoireCache .= "_ ";
            }
            $i++;
        }
        return $this->_motAleatoireCache;
    }

    /**
     * méthode qui va permettre d'afficher le mot caché
     *
     * @return void
     */
    public function getMotADeviner()
    {
        return $this->_motAleatoireSplit;
    }

    public function getMotCache()
    {
        return $this->_motAleatoireCache;
    }
}