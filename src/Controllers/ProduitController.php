<?php

namespace App\Controllers;
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

    public function Ajout()
    {
        $twig = new Twig;
        $twig->afficherpage('Produit','Ajout');
    }

    
    public function Categorie($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupérez les paramètres du formulaire
            $cat_name = $_POST['cat_name'] ?? '';
            header('Location: /Produit/Categorie/' . $cat_name);
            exit();
            
        }

        $liste = new Produit;
        $produits = $liste->getProduitByCategorie($params[0]);
        $cat_name = $params[0];
        // Charger la vue Twig
        $twig = new Twig;
        $twig->afficherpage('Produit','Categorie',['produits' => $produits, 'categorie' => $cat_name]);
        
    }

    public function ajouterProduit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les paramètres du formulaire
            $cat_name = $_POST['cat_name'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $_POST['image'] ?? '';
            $price = $_POST['price'] ?? '';
            $produit = new Produit;
            $produit->ajouterProduit($cat_name, $name, $description, $image, $price);
        }

        header('Location: /');
        exit();
    }

}