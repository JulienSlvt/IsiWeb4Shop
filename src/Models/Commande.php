<?php

namespace App\Models;
use PDO;

class Commande extends Model
{

    public function getCommandeForCustomer($customer_id)
    {
        // Requête SQL pour récupérer les détails de la commande avec status = 0
        $sql = "SELECT o.*, p.*, oi.quantity
                FROM orderitems oi
                JOIN products p ON oi.product_id = p.id
                JOIN orders o ON oi.order_id = o.id
                WHERE o.customer_id = ? AND o.status = 0";

        // Paramètres pour la requête
        $params = [$customer_id];

        // Exécution de la requête
        $resultat = $this->executerRequete($sql, $params);

        // Récupération des résultats sous forme de tableau associatif
        $commandeDetails = $resultat->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les détails de la commande
        return $commandeDetails;
    }

    public function getCommandesForCustomer($customer_id)
    {
        // Requête SQL pour récupérer les détails des commandes
        $sql = "SELECT o.*, p.*, oi.quantity
                FROM orderitems oi
                JOIN products p ON oi.product_id = p.id
                JOIN orders o ON oi.order_id = o.id
                WHERE o.customer_id = ?";

        // Paramètres pour la requête
        $params = [$customer_id];

        // Exécution de la requête
        $resultat = $this->executerRequete($sql, $params);

        // Récupération des résultats sous forme de tableau associatif
        $commandeDetails = $resultat->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les détails de la commande
        return $commandeDetails;
    }

    public function passerCommande()
    {
        $model = new Panier;
        $order = $model->getOrderForCustomer($_SESSION['id']);
        $order_id = $order['id'];
        $this->modifierStatus($order_id, 1);
    }

    public function payerCommande()
    {
        $model = new Panier;
        $order = $model->getOrderForCustomer($_SESSION['id']);
        $order_id = $order['id'];
        $this->modifierStatus($order_id, 2);
    }

    public function modifierStatus($order_id, $nouveauStatus) {
        // Vérifier si la commande existe
        if ($this->commandeExiste($order_id)) {
            // Mettre à jour le champ "status" de la commande
            $sql = "UPDATE orders SET `status` = ? WHERE `id` = ?";
            $params = [$nouveauStatus, $order_id];
            $this->executerRequete($sql, $params);
            return true; // La mise à jour a réussi
        } else {
            return false; // La commande n'existe pas
        }
    }

    public function modifierPaiement($order_id, $paiement) {
        // Vérifier si la commande existe
        if ($this->commandeExiste($order_id)) {
            // Mettre à jour le champ "status" de la commande
            $sql = "UPDATE orders SET `payment_type` = ? WHERE `id` = ?";
            $params = [$paiement, $order_id];
            $this->executerRequete($sql, $params);
            return true; // La mise à jour a réussi
        } else {
            return false; // La commande n'existe pas
        }
    }

    public function modifierAdresse($order_id, $adresseId) {
        // Vérifier si la commande existe
        if ($this->commandeExiste($order_id)) {
            // Mettre à jour le champ "status" de la commande
            $sql = "UPDATE orders SET `delivery_add_id` = ? WHERE `id` = ?";
            $params = [$adresseId, $order_id];
            $this->executerRequete($sql, $params);
            return true; // La mise à jour a réussi
        } else {
            return false; // La commande n'existe pas
        }
    }

    private function commandeExiste($order_id) {
        $sql = "SELECT COUNT(*) FROM orders WHERE `id` = ?";
        $params = [$order_id];
        $resultat = $this->executerRequete($sql, $params);
        $count = $resultat->fetchColumn();
        return $count > 0;
    }
}