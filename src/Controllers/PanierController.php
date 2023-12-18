<?php

namespace App\Controllers;
use App\Models\Panier;

class PanierController
{
    public function index()
    {
        // Instanciez votre modèle
        $model = new Panier();  // Remplacez VotreModel par le nom réel de votre modèle

        $itemsInCart = $model->getProduitsAvecQuantite();
        
        // Calculez le total du panier
        $totalCartPrice = 0;
        foreach ($itemsInCart as $item) {
            $totalCartPrice += $item['price'] * $item['quantity'];
        }

        // Chargez la vue Twig en passant les données nécessaires
        $twig = new Twig;
        $twig->afficherpage('Panier','index',
        [
            'itemsInCart' => $itemsInCart,
            'totalCartPrice' => $totalCartPrice,
        ]);
    }

    public function AjoutPanier()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les paramètres du formulaire
            $product_id = $_POST['produit'] ?? '';
            $quantite = $_POST['quantite'] ?? '';
            $connexion = new Panier;
            $connexion->ajouterAuPanier($product_id,$quantite);
        }

        header('Location: /Produit');
        exit();
    }

    public function ModifierQuantite()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les paramètres du formulaire
            $product_id = $_POST['produit'] ?? '';
            $quantite = $_POST['quantite'] ?? '';

            // On récupère l'id de commande
            $model = new Panier;
            $order = $model->getOrderForCustomer($_SESSION['id']);
            $order_id = $order['id'];

            // On modifie la quantité dans le panier
            $connexion = new Panier;
            $connexion->modifierQuantiteDansPanier($order_id,$product_id,$quantite);
        }
        header('Location: /Panier');
        exit();
    }

    public function deleteProduitDuPanier()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les paramètres du formulaire
            $product_id = $_POST['produit'] ?? '';

            // On récupère l'id de commande
            $model = new Panier;
            $order = $model->getOrderForCustomer($_SESSION['id']);
            $order_id = $order['id'];

            $connexion = new Panier;
            $connexion->deleteProduct($order_id,$product_id,0);
        }
        header('Location: /Panier');
        exit();

    }
}