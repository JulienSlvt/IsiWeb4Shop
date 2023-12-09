<?php

namespace App\Controllers;

class PanierController
{
    public function index()
    {
        $twig = new Twig;
        $twig->afficherpage('Panier');
    }
}