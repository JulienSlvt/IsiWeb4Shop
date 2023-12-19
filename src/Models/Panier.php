<?php

namespace App\Models;
use PDO;
class Panier extends Model
{
    public function ajouterAuPanier($product_id, $quantite)
    {
        if (isset($_SESSION['id'])){
            // Créer une commende si elle existe pas 
            $this->ajoutOrder($_SESSION['id']);

            // On récupère le numéro de commande
            $order = $this->getOrderForCustomer($_SESSION['id']);
        } else {
            // Créer une commende si elle existe pas 
            $this->ajoutOrder();

            // On récupère le numéro de commande
            $order = $this->getOrderForCustomer();
        }

        $order_id = $order['id'];

        // Mets à jour total de la table orders
        $this->addTotalPrice($order_id,$product_id,$quantite);

        // Vérifier si le produit est déjà dans le panier
        $existingItem = $this->getCartItem($order_id, $product_id);

        if ($existingItem) {
            // Si le produit est déjà dans le panier, mettre à jour la quantité et bloquer la quantité max à 500
            $newQuantite = min(500, $existingItem['quantity'] + $quantite);
            $this->modifierQuantiteDansPanier($order_id, $product_id, $newQuantite);
        } else {
            // Si le produit n'est pas dans le panier, l'ajouter
            $this->ajouterNouvelItemAuPanier($order_id, $product_id, $quantite);
        }
    }

    private function addTotalPrice($order_id, $product_id, $quantite)
    {
        // On récupère total
        $sql = "SELECT total FROM orders WHERE id = ?";
        $params = [$order_id];

        // Execution de la requete SQL
        $resultat = $this->executerRequete($sql, $params);
        $total = $resultat->fetch(PDO::FETCH_ASSOC)['total'];

        // On récupère le produit
        $prod = new Produit;
        $produit = $prod->getProductById($product_id);

        // On redéfinie total
        $total = $total + $quantite * $produit['price'];
        $sql = "UPDATE orders SET `total` = ? WHERE id = ?";
        $params = [$total, $order_id];

        // On éxecute la requete SQL
        $resultat = $this->executerRequete($sql, $params);
    }

    public function getItemsInCart()
    {
        if (isset($_SESSION['id'])){
            $sql = "SELECT * FROM orderitems WHERE `order_id` = ? AND 'status' = 0";
            $params = [$_SESSION['id']];

            $resultat = $this->executerRequete($sql, $params);

            return $resultat->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT * FROM orderitems WHERE `order_id` = ? AND 'status' = 0";
            $params = [$this->getOrderForCustomer()['id']];

            $resultat = $this->executerRequete($sql, $params);

            return $resultat->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    // Supposons que vous ayez une table "products" avec une structure similaire à celle que vous avez fournie

    public function getProductsInCart($cartItems)
    {
        // Vérifiez si des articles sont présents dans le panier
        if (!empty($cartItems)) {
            // Utilisez une requête préparée avec une clause IN pour obtenir les produits correspondants
            $placeholders = rtrim(str_repeat('?, ', count($cartItems)), ', ');
            $sql = "SELECT * FROM products WHERE id IN ($placeholders) AND 'status' = 0";
            
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
        if (!empty($product_id)) {
            if (isset($_SESSION['id'])) {
                // On récupère l'id de la commande 
                $order_id = $this->getOrderForCustomer($_SESSION['id'])['id'];
            } else {
                // On récupère l'id de la commande 
                $order_id = $this->getOrderForCustomer()['id'];
            }
            
            // Utilisez une requête préparée pour obtenir la quantité du produit dans la commande
            $sql = "SELECT quantity FROM orderitems WHERE order_id = ? AND product_id = ?";
            $parametres = [$order_id, $product_id];

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
            // On récupère l'id de commande
            $order = $this->getOrderForCustomer($_SESSION['id']);

            if (!$order){
                $this->ajoutOrder($_SESSION['id']);
                $order = $this->getOrderForCustomer($_SESSION['id']);
            }
        } else {
            // On récupère l'id de commande
            $order = $this->getOrderForCustomer();

            if (!$order){
                $this->ajoutOrder();
                $order = $this->getOrderForCustomer();
            }
        }

        // On récupère l'id de la commande
        $order_id = $order['id'];

        // Utilisez une requête préparée avec une jointure pour obtenir tous les produits avec leurs quantités dans la commande
        $sql = "SELECT p.*, oi.quantity
                FROM orderitems oi
                JOIN products p ON oi.product_id = p.id
                JOIN orders o ON oi.order_id = o.id
                WHERE oi.order_id = ? AND o.status = 0";
        $parametres = [$order_id];

        // Exécutez la requête préparée avec les paramètres
        $resultat = $this->executerRequete($sql, $parametres);

        // Retournez un tableau associatif résultant avec tous les produits
        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduitsAvecQuantitePayer($order)
    {
        // On récupère l'id de la commande
        $order_id = $order['id'];

        // Utilisez une requête préparée avec une jointure pour obtenir tous les produits avec leurs quantités dans la commande
        $sql = "SELECT p.*, oi.quantity
                FROM orderitems oi
                JOIN products p ON oi.product_id = p.id
                JOIN orders o ON oi.order_id = o.id
                WHERE oi.order_id = ? AND o.status = 1";
        $parametres = [$order_id];

        // Exécutez la requête préparée avec les paramètres
        $resultat = $this->executerRequete($sql, $parametres);

        // Retournez un tableau associatif résultant avec tous les produits
        return $resultat->fetchAll(PDO::FETCH_ASSOC);
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
        // On récupère la quantité présente dans le panier 
        $quantitePanier = $this->getQuantite($product_id);

        // On mets a jour total
        $this->addTotalPrice($order_id,$product_id,$quantite - $quantitePanier);

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

    public function deleteProduct($order_id, $product_id, $quantite)
    {

        // On récupère la quantité présente dans le panier 
        $quantitePanier = $this->getQuantite($product_id);

        // On mets a jour total
        $this->addTotalPrice($order_id,$product_id,$quantite - $quantitePanier);

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


    public function ajoutOrder($customer_id = null)
    {
        if ($customer_id != null){
            // Vérifier si une commande existe déjà pour le client
            // Il faudra modifier ou creer une autre fonction pour vérifier l'ata de la commande
            $existingOrder = $this->getOrderForCustomer($customer_id);
            if (!$existingOrder) {
                // Si aucune commande n'existe, ajouter une nouvelle ligne
                $sql = "INSERT INTO orders (`customer_id`, `registered`, `delivery_add_id`, `payment_type`, `date`, `status`, `session`, `total`) 
                        VALUES (?, ?, 0, 0, NOW(), 0, ? , 0.0)";
                // On regarde si le compte est connecté et non pas temporaire
                if (isset($_SESSION["user"])){
                    $params = [$_SESSION['id'],1 , session_id()];
                } else {
                    $params = [$_SESSION['id'],0 , session_id()];
                }

                // Exécuter la requête d'insertion
                $this->executerRequete($sql, $params);
            }
        } else {
            // On récupère la commande de la personne non connectée
            $existingOrder = $this->getOrderForCustomer();
            if (!$existingOrder) {
                // Si aucune commande n'existe, ajouter une nouvelle ligne
                $sql = "INSERT INTO orders (`customer_id`, `registered`, `delivery_add_id`, `payment_type`, `date`, `status`, `session`, `total`) 
                        VALUES (0, 0, 0, 0, NOW(), 0, ? , 0.0)";

                // On rentre en seul champs l'id de session
                $params = [session_id()];

                // Exécuter la requête d'insertion
                $this->executerRequete($sql, $params);
            }
        }
    }
    

    public function ajoutOrderTemp()
    {
        if (isset($_SESSION["Temp"])){
            // Si aucune commande n'existe, ajouter une nouvelle ligne
            $sql = "INSERT INTO orders (`customer_id`,`registered`, `delivery_add_id`, `payment_type`, `date`, `status`, `session`, `total`) 
                    VALUES (0, 0, 0, 0, NOW(), 0, ? , 0.0)";
            $params = [session_id()];

            // Exécuter la requête d'insertion
            $this->executerRequete($sql, $params);
        }
    }

    public function getOrdersForCustomer($customer_id = null)
    {
        if ($customer_id = null){
            // Récupérer toutes les commandes pour le client
            $sql = "SELECT * FROM orders WHERE `customer_id` = ?";
            $params = [$customer_id];

            // Exécuter la requête de sélection
            $resultat = $this->executerRequete($sql, $params);

            // Retourner toutes les lignes (ou un tableau vide si aucune commande n'est trouvée)
            return $resultat->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Récupérer toutes les commandes pour le client
            $sql = "SELECT * FROM orders WHERE `session` = ?";
            $params = [session_id()];

            // Exécuter la requête de sélection
            $resultat = $this->executerRequete($sql, $params);

            // Retourner toutes les lignes (ou un tableau vide si aucune commande n'est trouvée)
            return $resultat->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getOrders()
    {
        // Récupérer toutes les commandes
        $sql = "SELECT * FROM orders";

        // Exécuter la requête de sélection
        $resultat = $this->executerRequete($sql);

        // Retourner toutes les lignes (ou un tableau vide si aucune commande n'est trouvée)
        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderForCustomer($customer_id = null)
    {
        if ($customer_id != null){
            // Récupérer la commande existante pour le client avec un statut égal à 0
            $sql = "SELECT * FROM orders WHERE `customer_id` = ? AND `status` = 0 LIMIT 1";
            $params = [$customer_id];

            // Exécuter la requête de sélection
            $resultat = $this->executerRequete($sql, $params);

            // Retourner la première ligne (ou false si aucune commande n'est trouvée)
            return $resultat->fetch(PDO::FETCH_ASSOC);
        } else {
            // Récupérer la commande existante pour la session avec un statut égal à 0
            $sql = "SELECT * FROM orders WHERE `session` = ? AND `status` = 0 LIMIT 1";
            $params = [session_id()];

            // Exécuter la requête de sélection
            $resultat = $this->executerRequete($sql, $params);

            // Retourner la première ligne (ou false si aucune commande n'est trouvée)
            return $resultat->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getOrderForCustomerPayer($customer_id = null)
    {

        if ($customer_id != null){
            // Récupérer la commande existante pour le client avec un statut égal à 1
            $sql = "SELECT * FROM orders WHERE `customer_id` = ? AND `status` = 1 LIMIT 1";
            $params = [$customer_id];

            // Exécuter la requête de sélection
            $resultat = $this->executerRequete($sql, $params);

            // Retourner la première ligne (ou false si aucune commande n'est trouvée)
            return $resultat->fetch(PDO::FETCH_ASSOC);
        } else {
            // Récupérer la commande existante pour la session avec un statut égal à 1
            $sql = "SELECT * FROM orders WHERE `session` = ? AND `status` = 1 LIMIT 1";
            $params = [session_id()];

            // Exécuter la requête de sélection
            $resultat = $this->executerRequete($sql, $params);

            // Retourner la première ligne (ou false si aucune commande n'est trouvée)
            return $resultat->fetch(PDO::FETCH_ASSOC);
        }
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
        } else {
            // Utilisez une requête DELETE pour supprimer les éléments du panier associés à l'ID de commande actuel
            $sql = "DELETE FROM orderitems WHERE order_id = ?";
            $parametres = [$this->getOrderForCustomer()['id']];

            // Exécutez la requête préparée avec les paramètres
            $this->executerRequete($sql, $parametres);
        }
    }
}