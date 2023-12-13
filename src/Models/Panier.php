<?php

namespace App\Models;
use PDO;
class Panier extends Model
{
    public function ajouterAuPanier($product_id, $quantite)
    {

        $this->ajoutOrder($_SESSION['id']);

        // Récupérer l'order_id à partir de la session
        $order_id = $_SESSION['id'];

        // Vérifier si le produit est déjà dans le panier
        $existingItem = $this->getCartItem($order_id, $product_id);

        if ($existingItem) {
            // Si le produit est déjà dans le panier, mettre à jour la quantité
            $newQuantite = $existingItem['quantity'] + $quantite;
            $this->modifierQuantiteDansPanier($order_id, $product_id, $newQuantite);
        } else {
            // Si le produit n'est pas dans le panier, l'ajouter
            $this->ajouterNouvelItemAuPanier($order_id, $product_id, $quantite);
        }
    }

    public function getItemsInCart()
    {
        $sql = "SELECT * FROM orderitems WHERE `order_id` = ?";
        $params = [$_SESSION['id']];

        $resultat = $this->executerRequete($sql, $params);

        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }
    // Supposons que vous ayez une table "products" avec une structure similaire à celle que vous avez fournie

    public function getProductsInCart($cartItems)
    {
        // Vérifiez si des articles sont présents dans le panier
        if (!empty($cartItems)) {
            // Utilisez une requête préparée avec une clause IN pour obtenir les produits correspondants
            $placeholders = rtrim(str_repeat('?, ', count($cartItems)), ', ');
            $sql = "SELECT * FROM products WHERE id IN ($placeholders)";
            
            // Paramètres à utiliser dans la requête
            $parametres = $cartItems;

            // Exécutez la requête préparée avec les paramètres
            return $this->executerRequete($sql, $parametres)->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Retournez une liste vide si le panier est vide
            return [];
        }
    }

    public function getQuantite($product_id)
    {
        // Vérifiez si l'ID du produit et l'ID de la commande sont fournis
        if (!empty($product_id) && isset($_SESSION['id'])) {
            // Utilisez une requête préparée pour obtenir la quantité du produit dans la commande
            $sql = "SELECT quantity FROM orderitems WHERE order_id = ? AND product_id = ?";
            $parametres = [$_SESSION['id'], $product_id];

            // Exécutez la requête préparée avec les paramètres
            $resultat = $this->executerRequete($sql, $parametres);

            // Retournez la quantité si le produit est trouvé, sinon, retournez 0
            return $resultat->rowCount() > 0 ? $resultat->fetch(PDO::FETCH_ASSOC)['quantity'] : 0;
        } else {
            // Retournez une valeur par défaut (0) si les données nécessaires ne sont pas fournies
            return 0;
        }
    }


    public function getProduitsAvecQuantite()
    {
        // Vérifiez si l'ID de la commande est fourni
        if (isset($_SESSION['id'])) {
            // Utilisez une requête préparée avec une jointure pour obtenir tous les produits avec leurs quantités dans la commande
            $sql = "SELECT p.*, oi.quantity
                    FROM orderitems oi
                    JOIN products p ON oi.product_id = p.id
                    WHERE oi.order_id = ?";
            $parametres = [$_SESSION['id']];

            // Exécutez la requête préparée avec les paramètres
            $resultat = $this->executerRequete($sql, $parametres);

            // Retournez un tableau associatif résultant avec tous les produits
            return $resultat->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Retournez null si l'ID de la commande n'est pas fourni
            return null;
        }
    }

    private function getCartItem($order_id, $product_id)
    {
        // Récupérer l'élément du panier existant
        $sql = "SELECT * FROM orderitems WHERE `order_id` = ? AND `product_id` = ? LIMIT 1";
        $params = [$order_id, $product_id];

        // Exécuter la requête de sélection
        $resultat = $this->executerRequete($sql, $params);

        // Retourner la première ligne (ou false si l'élément n'est pas trouvé)
        return $resultat->fetch(PDO::FETCH_ASSOC);
    }

    public function modifierQuantiteDansPanier($order_id, $product_id, $quantite)
    {
        if ($quantite != 0){
            // Mettre à jour la quantité de l'élément dans le panier
            $sql = "UPDATE orderitems SET `quantity` = ? WHERE `order_id` = ? AND `product_id` = ?";
            $params = [$quantite, $order_id, $product_id];

            // Exécuter la requête de mise à jour
            $this->executerRequete($sql, $params);
        } else {
            $this->deleteProduct($order_id, $product_id, $quantite);
        }
    }

    private function deleteProduct($order_id, $product_id, $quantite)
    {
        if ($quantite != 0) {
            // Mettre à jour la quantité de l'élément dans le panier
            $sql = "UPDATE orderitems SET `quantity` = ? WHERE `order_id` = ? AND `product_id` = ?";
            $params = [$quantite, $order_id, $product_id];

            // Exécuter la requête de mise à jour
            $this->executerRequete($sql, $params);
        } else {
            // Supprimer l'élément du panier
            $sql = "DELETE FROM orderitems WHERE `order_id` = ? AND `product_id` = ?";
            $params = [$order_id, $product_id];

            // Exécuter la requête de suppression
            $this->executerRequete($sql, $params);
        }
    }


    

    private function ajouterNouvelItemAuPanier($order_id, $product_id, $quantite)
    {
        // Ajouter un nouvel élément au panier
        $sql = "INSERT INTO orderitems (`order_id`, `product_id`, `quantity`) VALUES (?, ?, ?)";
        $params = [$order_id, $product_id, $quantite];

        // Exécuter la requête d'insertion
        $this->executerRequete($sql, $params);
    }


    public function ajoutOrder($customer_id)
    {
        // Vérifier si une commande existe déjà pour le client
        $existingOrder = $this->getOrderForCustomer($customer_id);

        if (!$existingOrder) {
            // Si aucune commande n'existe, ajouter une nouvelle ligne
            $sql = "INSERT INTO orders (`customer_id`, `registered`, `delivery_add_id`, `payment_type`, `date`, `status`, `session`, `total`) 
                    VALUES (?, 0, 0, 0, NOW(), 0, ? , 0.0)";
            $params = [$_SESSION['id'], $_SESSION['id']];

            // Exécuter la requête d'insertion
            $this->executerRequete($sql, $params);
        } 
    }

    private function getOrderForCustomer($customer_id)
    {
        // Récupérer la commande existante pour le client
        $sql = "SELECT * FROM orders WHERE `customer_id` = ? LIMIT 1";
        $params = [$customer_id];

        // Exécuter la requête de sélection
        $resultat = $this->executerRequete($sql, $params);

        // Retourner la première ligne (ou false si aucune commande n'est trouvée)
        return $resultat->fetch(PDO::FETCH_ASSOC);
    }

    public function supPanier()
    {
        // Vérifiez si l'ID de commande est défini dans la session
        if (isset($_SESSION['id'])) {
            // Utilisez une requête DELETE pour supprimer les éléments du panier associés à l'ID de commande actuel
            $sql = "DELETE FROM orderitems WHERE order_id = ?";
            $parametres = [$_SESSION['id']];

            // Exécutez la requête préparée avec les paramètres
            $this->executerRequete($sql, $parametres);
        }
    }
}