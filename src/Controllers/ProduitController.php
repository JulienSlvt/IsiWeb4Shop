<?php

namespace App\Controllers;
use App\Models\Admin;
use App\Models\Produit;

class ProduitController
{
    public function index()
    {
        // Instancier le modèle Produit
        $produitModel = new Produit();

        // Récupérer tous les produits
        $produits = $produitModel->getProduits();

        // Charger la vue Twig
        $twig = new Twig;
        $twig->afficherpage('Produit','index',['produits' => $produits]);
    }

    public function Details($params = null)
    {
        if ($params != null){
        $product_id = $params[0];
        $modele = new Produit;
        $produit = $modele->getProductById($product_id);
        $twig = new Twig;
        $twig->afficherpage('Produit','Details',['produit' => $produit]);
    } else {
        header('Location: /Produit/Categorie');
        exit();
    }
    }
    public function Categorie($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les paramètres du formulaire
            $cat_name = $_POST['cat_name'];

            // On transforme un espace dans la catégorie par un _
            $cat_name = str_replace(' ', '_', $cat_name);
            
            // On redirige à la page sans la méthode POST
            header('Location: /Produit/Categorie/' . $cat_name);
            exit();
            
        }
        
        if ($params == null){
            $twig = new Twig;
            $twig->afficherpage('Produit','CategorieVide');
        } else {
            // On récupère le nom de la catégorie
            $cat_name = $params[0];

            // On transforme _ dans la catégorie par un espace
            $cat_name = str_replace('_', ' ', $cat_name);

            $liste = new Produit;
            $produits = $liste->getProduitByCategorie($cat_name);
            $cat_name = $params[0];
            // Charger la vue Twig
            $twig = new Twig;
            $twig->afficherpage('Produit','Categorie',['produits' => $produits, 'categorie' => $cat_name]);
        }
    }
}