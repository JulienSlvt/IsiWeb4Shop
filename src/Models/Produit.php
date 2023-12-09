<?php

namespace App\Models;
use PDO;

class Produit extends Model
{

    public function getProduits()
    {
        $categories = $this->getCategories();
        foreach ($categories as $categorie){
            $produits[$categorie] = $this->getProduitByCategorie($categorie); // Utilisez la fonction getProduitByCategorie
        }
        if (isset($produits)){
            return $produits;
        }
    }
    


    public function getCategories()
{
    $sql = "SELECT name FROM categories";
    return $this->executerRequete($sql)->fetchAll(PDO::FETCH_COLUMN);
}


    public function getProduitByCategorie($cat_name)
{
    // Vérifiez si la catégorie est fournie
    if (!empty($cat_name)) {
        // Utilisez une requête préparée pour éviter l'injection SQL
        $sql = "SELECT * FROM products WHERE cat_id = ?";
        $parametres = [$this->getCatId($cat_name)];

        // Exécutez la requête préparée avec les paramètres
        return $this->executerRequete($sql, $parametres)->fetchAll();
    } else {
        // Redirigez si la catégorie n'est pas fournie
        header('Location: /Produit/'); // Ajoutez l'URL de redirection appropriée
        exit();
    }
}

    public function ajouterProduit($cat_name, $name, $description, $image, $price) 
    {
        if (!$this->categorieExiste($cat_name)){
            $this->ajouterCategorie($cat_name);
        }
        // Exemple d'insertion d'un utilisateur dans la table 'logins'
            $sql = "INSERT INTO products (cat_id, name, description, image, price) VALUES (?, ?, ?, ?, ?)";
            $parametres = [$this->getCatId($cat_name), $name, $description, $image, $price];
    
            $this->executerRequete($sql, $parametres);
            header('Location: /Produit');
            exit();

        }


    // Retourne la valeur d'id de la catégorie et en créer une nouvelle si elle n'existe pas encore
    public function ajouterCategorie($name)
    {
        // Utilisez une requête préparée pour insérer une nouvelle catégorie
        $sql = "INSERT IGNORE INTO categories (name) VALUES (?)";
        $parametres = [$name];

        // Exécutez la requête préparée avec les paramètres
        $this->executerRequete($sql, $parametres);
    }

    public function getCatId($name)
    {
        // Utilisez une requête pour récupérer l'ID de la catégorie
        $sqlRecupererId = "SELECT id FROM categories WHERE name = ?";
        $parametresRecupererId = [$name];
        $resultatRecupererId = $this->executerRequete($sqlRecupererId, $parametresRecupererId);

        // Retournez l'ID de la catégorie
        $categorie = $resultatRecupererId->fetch(PDO::FETCH_ASSOC);
        return $categorie ? $categorie['id'] : -1;
    }
    public function categorieExiste($name)
    {
        // Utilisez une requête pour vérifier si la catégorie existe
        $sqlVerifierExistence = "SELECT COUNT(*) AS count FROM categories WHERE name = ?";
        $parametresVerifierExistence = [$name];
        $resultatVerifierExistence = $this->executerRequete($sqlVerifierExistence, $parametresVerifierExistence);

        // Récupérez le nombre de lignes correspondant à la requête
        $count = $resultatVerifierExistence->fetch(PDO::FETCH_ASSOC)['count'];

        // Retournez vrai si la catégorie existe, faux sinon
        return $count > 0;
}




}