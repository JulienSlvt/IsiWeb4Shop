<?php

namespace App\Controllers;
use App\Models\Admin;
use App\Models\Panier;
use App\Models\Produit;

class AdminController extends PanierController
{

    public function index()
    {
        $model = new Admin;
        if ($model->isAdmin()){
            $twig = new Twig;
            $twig->afficherpage('Admin');
        } else {
            // On gère le cas où ce n'est pas un administrateur qui accède à cette page 
            header('Location: /');
            exit();
        }
    }

    public function GererCommandes()
    {
        $model = new Admin;
        if ($model->isAdmin()){

            $orders = new Panier;
            $orders = $orders->getOrders();
            $twig = new Twig;
            $twig->afficherpage('Admin','Commandes',['orders' => $orders]);
        } else {
            // On gère le cas où ce n'est pas un administrateur qui accède à cette page 
            header('Location: /');
            exit();
        }
    }

    public function GererQuantites()
    {
        $model = new Admin;
        if ($model->isAdmin()){

            $products = new Produit;
            $products = $products->getProduits();

            $twig = new Twig;
            $twig->afficherpage('Admin','Produits',['produits' => $products]);
        } else {
            // On gère le cas où ce n'est pas un administrateur qui accède à cette page 
            header('Location: /');
            exit();
        }
    }

    public function modifierQuantites()
    {
        $model = new Admin;
        if ($model->isAdmin()){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Récupérer les données du formulaire POST
                $product_id = $_POST['product_id'] ?? '';
                $quantity = $_POST['quantity'] ?? '';

                // On modifie la quantité
                $produit = new Produit;
                $produit->modifierQuantite($product_id,$quantity);

                // On se redirige vers gererQuantites
                header('Location: /Admin/GererQuantites');
                exit();
            }
            // On gère le cas où ce n'est pas la methode post qui est utilisée
            header('Location: /');
            exit();
        } else {
            // On gère le cas où ce n'est pas un administrateur qui accède à cette page 
            header('Location: /');
            exit();
        }
    }

    public function AjoutProduit()
    {
        $model = new Admin;
        if ($model->isAdmin()){
            $twig = new Twig;
            $twig->afficherpage('Admin','Ajout');
        } else {
            // On gère le cas où ce n'est pas un administrateur qui accède à cette page 
            header('Location: /');
            exit();
        }
    }

    public function ajouterProduit()
    {
        $model = new Admin;
        if ($model->isAdmin()){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les paramètres du formulaire
            $cat_name = $_POST['cat_name'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $_POST['image'] ?? '';
            $price = $_POST['price'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $produit = new Admin;
            $produit->ajouterProduit($cat_name, $name, $description, $image, $price, $quantity);
        }

        header('Location: /');
        exit();
    } else {
        // On gère le cas où ce n'est pas un administrateur qui accède à cette page 
        header('Location: /');
        exit();
    }
    }

    public function validerCommande()
    {
        $model = new Admin;
        if ($model->isAdmin()){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Récupérez les paramètres du formulaire
                $order_id = $_POST['order_id'] ?? '';
                $produit = new Admin;
                $produit->validerCommande($order_id);

                // // On se redirige sur la page des commandes
                // header('Location: /Admin/GererCommandes');
                // exit();
            } else {
                header('Location: /');
                exit();
            }
        } else {
            // On gère le cas où ce n'est pas un administrateur qui accède à cette page 
            header('Location: /');
            exit();
        }
    }

    public function supprimerCommande()
    {
        $model = new Admin;
        if ($model->isAdmin()){

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Récupérez les paramètres du formulaire
                $order_id = $_POST['order_id'] ?? '';
                $produit = new Admin;
                $produit->supprimerCommande($order_id);

                // On se redirige sur la page des commandes
                header('Location: /Admin/GererCommandes');
                exit();
            }

            // On gère le cas où la commande n'est pas retrouvée
            header('Location: /');
            exit();
        } else {
            // On gère le cas où ce n'est pas un administrateur qui accède à cette page 
            header('Location: /');
            exit();
        }
    }

    public function voirPanier($params = null)
    {
        $model = new Admin;
        if ($model->isAdmin() || $params = null){
            
            // Instanciez votre modèle
            $model = new Panier();  // Remplacez VotreModel par le nom réel de votre modèle

            $itemsInCart = $model->getPanier($params[0]);

            // Calculez le total du panier
            $totalCartPrice = 0;
            foreach ($itemsInCart as $item) {
                $totalCartPrice += $item['price'] * $item['orderquantity'];
            }

            // Chargez la vue Twig en passant les données nécessaires
            $twig = new Twig;
            $twig->afficherpage('Admin','VoirPanier',
            [
                'itemsInCart' => $itemsInCart,
                'totalCartPrice' => $totalCartPrice,
            ]);
        } else {
            // On gère le cas où ce n'est pas un administrateur qui accède à cette page 
            header('Location: /');
            exit();
        }
    }
    
}