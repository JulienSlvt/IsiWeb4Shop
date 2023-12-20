<?php

namespace App\Controllers;
use App\Models\Adresse;
use App\Models\Commande;
use App\Models\Compte;
use App\Models\Model;
use App\Models\Panier;
use App\Models\Produit;

class CommandeController
{
    public function index()
    {
        // On récupère l'ensemble des commandes faites pas l'utilisateur
        $model = new Panier;
        if (isset($_SESSION['id'])){
            $commandes = $model->getOrdersForCustomer($_SESSION['id']);
        } else {
            $commandes = $model->getOrdersForCustomer();
        }
        $twig = new Twig;
        $twig->afficherpage('Commande','index',
        [
            'commandes' => $commandes,
        ]);
    }

    public function Adresse()
    {
        if (isset($_SESSION['id'])){
            $model = new Compte;
            $compte = $model->getCustomer();
            if (!$compte){
                $model->createEmptyCustomer($_SESSION['id']);
                $compte = $model->getCustomer();
            }

            // On récupère la commande en cours
            $model = new Panier;
            $commande = $model->getOrderForCustomer($_SESSION['id']);

            // On vérifie s'il y a une commande en cours
            if ($commande)
            {
                $twig = new Twig;
                $twig->afficherpage('Commande','Adresse',['compte' => $compte]);
            } else {
                // On redirige vers la page de commande s'il n'y a pas de commande
                header('Location: /Commande');
                exit();
            }
        } else {
            // On récupère la commande en cours
            $model = new Panier;
            $commande = $model->getOrderForCustomer();

            // On vérifie s'il y a une commande en cours
            if ($commande)
            {
                $twig = new Twig;
                $twig->afficherpage('Commande','Adresse');
            } else {
                // On redirige vers la page de commande s'il n'y a pas de commande
                header('Location: /Commande');
                exit();
            }
        }
    }

    public function Commander()
    {
        if (isset($_SESSION['id'])){
            // On récupère la commande en cours
            $model = new Panier;
            $commande = $model->getOrderForCustomer($_SESSION['id']);
            // On vérifie s'il y a une commande en cours
            if ($commande && $commande['total'] > 0)
            {
                // On récupère customer_id
                $customer_id = $_SESSION['id'];
                
                // On regarde si tous les champs nécessaires à la livraison sont complétés
                $model = new Compte;
                $test = $model->champsCompletes($customer_id);
                if ($test){

                    // On récupère l'id de la commande
                    $model = new Panier;
                    $order_id = $commande['id'];
                    
                    // On passe la commande
                    $model = new Commande;
                    $model->passerCommande();

                    // On récupère le customer
                    $model = new Compte;
                    $customer = $model->getCustomer();

                    // On entre la nouvelle adresse dans la table si elle n'existe pas 
                    $model = new Adresse;
                    $adresseId = $model->getAdressId($customer['forname'], $customer['surname'], $customer['add1'], $customer['add2'], $customer['add3'], $customer['postcode'], $customer['phone'], $customer['email']);

                    // On modifie l'adresseId de la commande
                    $model = new Commande;
                    $model->modifierAdresse($order_id,$adresseId);

                    // On redirige vers la page de paiement
                    header('Location: /Commande/ModifierPaiement');
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
        } else {
            // On récupère la commande en cours
            $model = new Panier;
            $commande = $model->getOrderForCustomer();

            // On vérifie s'il y a une commande en cours
            if ($commande && $commande['total'] > 0)
            {
                // On récupère l'id de la commande
                $model = new Panier;
                $order_id = $commande['id'];
                
                // On passe la commande
                $model = new Commande;
                $model->passerCommande();

                // On redirige vers la page de paiement
                header('Location: /Commande/ModifierPaiement');
                exit();
            } else {
                // S'il n'y a pas de commande
                header('Location: /');
                exit();
            }
        }
    }

    public function AjouterAdresse()
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

            $model = new Panier;
            $order = $model->getOrderForCustomer();

            $model = new Adresse;
            $add_id = $model->getAdressId($forname, $surname, $add1, $add2, $city, $postcode, $phone, $email);
            $model->setAdress($order['id'], $add_id);
            
            // Rediriger vers une autre page après la modification
            header('Location: /Commande/Commander');
            exit();
        }
        // Cas où on utilise pas la méthode POST
        header('Location: /Commande/Adresse');
        exit();
    }

    public function ModifierAdresse()
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
        header('Location: /Commande/Adresse');
        exit();
    }

    public function Payer()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // On récupère le moyen de paiement
            $paiement = $_POST['paiement'] ?? '';
            // On récupère la commande à payer
            $model = new Panier;
            if (isset($_SESSION['id'])){
                $commande = $model->getOrderForCustomerPayer($_SESSION['id']);
            } else {
                $commande = $model->getOrderForCustomerPayer();
            }
            // On vérifie s'il y a une commande à payer
            if ($commande)
            {
                // On récupère l'id de la commande
                $model = new Panier;
                $order_id = $commande['id'];
                
                // On paye la commande
                $commande = new Commande;
                $commande->payerCommande($order_id);

                // On modifie payment_type dans la table orders
                $commande->modifierPaiement($order_id,$paiement);


                $encrypted = $commande->setOrderCripte($order_id);

                $twig = new Twig;
                $twig->afficherpage('Commande','Commande',['encrypted' => $encrypted]);

            } else {
                // S'il n'y a pas de commande
                header('Location: /');
                exit();
            }
        } else {
            // Si la méthode post n'est pas utilisée
            header('Location: /');
            exit();
        }
    }

    public function ModifierPaiement()
    {
        // On récupère la commande à payer
        $model = new Panier;
        if (isset($_SESSION['id'])){
            $commande = $model->getOrderForCustomerPayer($_SESSION['id']);
        } else {
            $commande = $model->getOrderForCustomerPayer();
        }

        // On vérifie s'il y a une commande à payer
        if ($commande)
        {
            // On récupère le panier à payer 
            $panier = new Panier;
            $items = $panier->getProduitsAvecQuantitePayer($commande);
            
            // On récupère le moyen de paiement déjà inscrit
            $paiement = $commande['payment_type'];

            // On récupère le total à payer
            $total = $commande['total'];

            $twig = new Twig;
            $twig->afficherpage('Commande','Paiement',['paiements' => ['Cheque', 'Espece', 'Carte', 'Paypal'],'paiementuser' => $paiement, 'itemsInCart' => $items, 'total' => $total]);
        } else {
            // S'il n'y a pas de commande à payer
            header('Location: /');
            exit();
        }
    }

    public function Acceder($params = null)
    {
        if ($params != null)
        {
            $crypter = new Commande;
            $order_id = $crypter->getOrderCripte($params[0]);

            $model = new Panier;
            $commande = $model->getOrderById($order_id);

            // Affiche la page commande
            $twig = new Twig;
            $twig->afficherpage('Commande','Commande',['commande' => $commande]);
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $order_id = $_POST['order_id'] ?? '';
                header('Location: /Commande/Acceder/' . $order_id);
                exit();
            }
            // Affiche la page commande
            $twig = new Twig;
            $twig->afficherpage('Commande','Commande');
        }
    }
}
