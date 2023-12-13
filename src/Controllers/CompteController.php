<?php

namespace App\Controllers;

class CompteController
{
    public function index()
    {
        $twig = new Twig;
        
        $twig->afficherpage('Compte');
    }

    public function ModifierCompte()
    {

    }
    
}