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

    public function getProductById($id)
    {
        // Vérifiez si l'ID du produit est fourni
        if (!empty($id)) {
            // Utilisez une requête préparée pour éviter l'injection SQL
            $sql = "SELECT * FROM products WHERE id = ?";
            $parametres = [$id];

            // Exécutez la requête préparée avec les paramètres
            $resultat = $this->executerRequete($sql, $parametres);

            // Retournez la première ligne (ou false si le produit n'est pas trouvé)
            return $resultat->fetch(PDO::FETCH_ASSOC);
        } else {
            // Redirigez ou gérez l'erreur en conséquence (par exemple, ID de produit non valide)
            // Vous pouvez personnaliser la gestion des erreurs selon vos besoins
            header('Location: /Produit/');
            exit();
        }
    }

    public function getProductsById($id_products)
    {
        // Vérifiez si l'ID du produit est fourni
        if (!empty($id)) {

            // Utilisez une requête préparée pour éviter l'injection SQL
            $sql = "SELECT * FROM products WHERE id = ?";
            $parametres = [$id];

            // Exécutez la requête préparée avec les paramètres
            $resultat = $this->executerRequete($sql, $parametres);

            // Retournez la première ligne (ou false si le produit n'est pas trouvé)
            return $resultat->fetch(PDO::FETCH_ASSOC);
        } else {
            // Redirigez ou gérez l'erreur en conséquence (par exemple, ID de produit non valide)
            // Vous pouvez personnaliser la gestion des erreurs selon vos besoins
            header('Location: /Produit/');
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
            header('Location: /Admin');
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

    public function modifierQuantite($product_id, $new_quantity)
    {
        // Vérifiez si l'ID du produit est fourni
        if (!empty($product_id)) {
            // Utilisez une requête préparée pour éviter l'injection SQL
            $sql = "UPDATE `products` SET `quantity` = ? WHERE `id` = ?";
            $parametres = [$new_quantity, $product_id];

            // Exécutez la requête préparée avec les paramètres
            $this->executerRequete($sql, $parametres);

            // Vous pouvez ajouter une logique supplémentaire si nécessaire, par exemple, gérer la réussite ou l'échec de la mise à jour
            return true;
        } else {
            // Redirigez ou gérez l'erreur en conséquence (par exemple, ID de produit non valide)
            // Vous pouvez personnaliser la gestion des erreurs selon vos besoins
            return false;
        }
    }

    public function modifierQuantiteOrder($order_id)
    {
        // Vérifiez si l'ID de la commande est fourni
        if (!empty($order_id)) {
            $produits_id = $this->getProduitsId($order_id);
            foreach ($produits_id as $product_id)
            {
                echo var_dump($product_id);
                $newQuantite = ($this->getQuantiteProduit($product_id) - $this->getQuantite($product_id, $order_id));
                if ($newQuantite >= 0){
                    $this->modifierQuantite($product_id,$newQuantite);
                } else {
                    // On gère le cas ou la validation est impossible
                    header('Location: /Error/Validation');
                    exit();
                }
            }
            return true;
        } else {
            // Redirigez ou gérez l'erreur en conséquence (par exemple, ID de commande non valide)
            // Vous pouvez personnaliser la gestion des erreurs selon vos besoins
            return false;
        }
    }

    public function getProduitsId($order_id)
    {
        $sql = "SELECT product_id FROM orderitems WHERE order_id = ?";
        $params = [$order_id];

        // Exécutez la requête préparée avec les paramètres
        $resultat = $this->executerRequete($sql, $params);

        // Retournez tous les résultats sous forme de tableau associatif
        $rows = $resultat->fetchAll(PDO::FETCH_ASSOC);

        // Parcourez le tableau pour récupérer tous les IDs
        $productIds = [];
        foreach ($rows as $row) {
            $productIds[] = $row['product_id'];
        }

        return $productIds;
    }


    public function getQuantiteProduit($product_id)
    {
            
        // Utilisez une requête préparée pour obtenir la quantité du produit dans la commande
        $sql = "SELECT quantity FROM products WHERE id = ?";
        $parametres = [$product_id];

        // Exécutez la requête préparée avec les paramètres
        $resultat = $this->executerRequete($sql, $parametres);

        // Retournez la quantité si le produit est trouvé, sinon, retournez 0
        return $resultat->rowCount() > 0 ? $resultat->fetch(PDO::FETCH_ASSOC)['quantity'] : 0;
    }

    public function getQuantite($product_id, $order_id)
    {
            
        // Utilisez une requête préparée pour obtenir la quantité du produit dans la commande
        $sql = "SELECT quantity FROM orderitems WHERE order_id = ? AND product_id = ?";
        $parametres = [$order_id, $product_id];

        // Exécutez la requête préparée avec les paramètres
        $resultat = $this->executerRequete($sql, $parametres);

        // Retournez la quantité si le produit est trouvé, sinon, retournez 0
        return $resultat->rowCount() > 0 ? $resultat->fetch(PDO::FETCH_ASSOC)['quantity'] : 0;
    }


}