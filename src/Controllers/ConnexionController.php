<?php

namespace App\Controllers;
use App\Models\Connexion;

class ConnexionController
{
    public function index()
    {
        $twig = new Twig;
        $twig->afficherpage('Connexion');
    }

    public function erreur()
    {
        $twig = new Twig;
        $twig->afficherpage('Connexion','erreur');
    }
    public function connexion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les paramètres du formulaire
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $connexion = new Connexion;
            $connexion->connecteUtilisateur($username,$password);
        }

        header('Location: /');
        exit();
    }

    public function deconnexion()
    {
        $deco = new Connexion;
        $deco->deconnection();
    }
}