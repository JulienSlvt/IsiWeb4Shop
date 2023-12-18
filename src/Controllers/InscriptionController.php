<?php

namespace App\Controllers;
use App\Models\Inscription;



class InscriptionController
{

    public function index()
    {
        $twig = new Twig;
        $twig->afficherpage('Inscription');
    }

    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les paramètres du formulaire
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $inscription = new Inscription;
            $inscription->inscrireUtilisateur($username, $password);
        }

        header('Location: /');
        exit();
    }

    public function erreur()
    {
        $twig = new Twig;
        $twig->afficherpage('Inscription','erreur');
    }
}