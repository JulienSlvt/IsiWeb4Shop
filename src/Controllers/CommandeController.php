<?php

namespace App\Controllers;
use App\Models\Commande;
use App\Models\Panier;

class CommandeController
{
    public function index()
    {
        // On récupère l'ensemble des commandes faites pas l'utilisateur
        $model = new Panier;
        $commandes = $model->getOrdersForCustomer($_SESSION['id']);
        $twig = new Twig;
        $twig->afficherpage('Commande','index',
        [
            'commandes' => $commandes,
        ]);
    }

    public function Commander()
    {
        $commande = new Commande;
        $commande->passerCommande();
        header('Location: /Panier');
        exit();
    }
    public function modifierCompte()
    {

    }
}