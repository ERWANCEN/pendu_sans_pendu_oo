<?php
require_once 'autoload.php';

class CompletionMot extends MotAleatoire
{


    public function setCompletion()
    {

    }

    public function getCompletion()
    {
        return $this->_motAleatoireSplit;
    }
}