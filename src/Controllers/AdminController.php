<?php

namespace App\Controllers;
use App\Models\Admin;
use App\Models\Panier;

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
            $produit = new Admin;
            $produit->ajouterProduit($cat_name, $name, $description, $image, $price);
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

                // On se redirige sur la page des commandes
                header('Location: /Admin/GererCommandes');
                exit();
            }
            header('Location: /');
            exit();
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
    
}