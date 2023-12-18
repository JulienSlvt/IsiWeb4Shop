<?php

namespace App\Controllers;
use App\Models\Commande;
use App\Models\Compte;
use App\Models\Model;
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

    public function Adresse()
    {
        $model = new Compte;
        $compte = $model->getCustomer();
        if (!$compte){
            $model->createEmptyCustomer($_SESSION['id']);
            $compte = $model->getCustomer();
        }

        // On récupère la commande en cours
        $model = new Panier;
        $commande = $model->getOrderForCustomer($_SESSION['id']);

        $twig = new Twig;
        // On vérifie s'il y a une commande en cours
        if ($commande)
        {
            $twig->afficherpage('Commande','Adresse',['compte' => $compte]);
        } else {
            // On redirige vers la page de commande s'il n'y a pas de commande
            header('Location: /Commande');
            exit();
        }
    }

    public function Commander()
    {
        // On récupère la commande en cours
        $model = new Panier;
        $commande = $model->getOrderForCustomer($_SESSION['id']);

        // On vérifie s'il y a une commande en cours
        if ($commande)
        {
            // On regarde si tous les champs nécessaires à la livraison sont complétés
            $model = new Compte;
            $test = $model->champsCompletes($_SESSION['id']);
            if ($test){
                // On passe la commande
                $commande = new Commande;
                $commande->passerCommande();
                header('Location: /');
                exit();
            } else {
                // Si les champs ne sont pas completés
                header('Location: /Commande/Adresse');
                exit();
            }
        } else {
            // S'il n'y a pas de commande
            header('Location: /');
            exit();
        }
    }

    public function ModifierCompte()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire POST
            $forname = $_POST['firstname'] ?? '';
            $surname = $_POST['lastname'] ?? '';
            $add1 = $_POST['add1'] ?? '';
            $add2 = $_POST['add2'] ?? '';
            $city = $_POST['city'] ?? '';
            $postcode = $_POST['postcode'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';

            // Vérifier si les valeurs sont définies
            if (!empty($forname) && !empty($surname) && !empty($add1) && !empty($city) && !empty($postcode) && !empty($phone) && !empty($email)) {
                // Obtenez l'ID de la session
                $customer_id = $_SESSION['id'];

                // Instancier le modèle Compte
                $model = new Compte;

                // Appeler la fonction modifieCustomer du modèle
                $model->modifieCustomer($customer_id, $forname, $surname, $add1, $add2, $city, $postcode, $phone, $email, 1);

                // Rediriger vers une autre page après la modification
                header('Location: /Commande/Commander');
                exit();
            }
            // Cas où on utilise pas la méthode POST
            header('Location: /');
            exit();
        }
    }
}