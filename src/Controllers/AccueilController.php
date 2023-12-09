<?php

namespace App\Controllers;
use App\Controllers\Twig;
class AccueilController
{
    public function index()
    {
        $twig = new Twig;
        $twig->afficherpage('Accueil');
    }
}