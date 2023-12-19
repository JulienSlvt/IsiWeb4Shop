<?php

namespace App\Models;

class Admin extends Model
{
    public function isAdmin()
    {
        if (isset($_SESSION['admin']))
            return true;
        return false;
    }

    public function ajouterProduit($cat_name, $name, $description, $image, $price) 
    {
        $produit = new Produit;
        if (!$produit->categorieExiste($cat_name)){
            $produit->ajouterCategorie($cat_name);
        }
        // Exemple d'insertion d'un utilisateur dans la table 'logins'
        $sql = "INSERT INTO products (cat_id, name, description, image, price) VALUES (?, ?, ?, ?, ?)";
        $parametres = [$produit->getCatId($cat_name), $name, $description, $image, $price];

        $this->executerRequete($sql, $parametres);
        header('Location: /Admin');
        exit();

    }

    public function validerCommande($order_id)
    {
        $commande = new Commande;

        // Vérifier si la commande existe
        if ($commande->commandeExiste($order_id)) {
            
            // Valider la commande en mettant à jour le statut à 10
            $commande->modifierStatus($order_id, 10);

        }
    }

    public function supprimerCommande($order_id)
    {
        $commande = new Commande;
        // Vérifier si la commande existe
        if ($commande->commandeExiste($order_id)) {
            // Supprimer la commande et les éléments associés
            $this->supprimerElementsCommande($order_id);

            // Supprimer la commande elle-même
            $sql = "DELETE FROM orders WHERE `id` = ?";
            $params = [$order_id];
            $this->executerRequete($sql, $params);
        }
    }

    private function supprimerElementsCommande($order_id)
    {
        // Supprimer les éléments associés à la commande
        $sql = "DELETE FROM orderitems WHERE `order_id` = ?";
        $params = [$order_id];
        $this->executerRequete($sql, $params);
    }
}