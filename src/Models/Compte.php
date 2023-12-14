<?php

namespace App\Models;
use PDO;

class Compte extends Model
{
    public function getcustomers()
    {
        // Requête SQL pour récupérer les données de la table delivery_addresses
        $sql = "SELECT * FROM customers WHERE ";
        
        // Exécution de la requête
        $resultat = $this->executerRequete($sql);

        // Récupération des données
        $donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les données
        return $donnees;
    }

    public function getCustomer()
    {
        //  On récupère l'id du customer qui est stockée dans la variable de session id
        $customerId = $_SESSION['id'];

        // Requête SQL pour récupérer un client par son ID
        $sql = "SELECT * FROM customers WHERE id = ?";

        // Exécution de la requête avec l'ID en paramètre
        $resultat = $this->executerRequete($sql, [$customerId]);

        // Récupération des données
        $customer = $resultat->fetch(PDO::FETCH_ASSOC);

        return $customer;
    }

    public function modifieCustomer($customer_id, $forname, $surname, $add1, $add2, $add3, $postcode, $phone, $email, $registered)
    {
        // Requête SQL pour mettre à jour un client existant
        $sql = "UPDATE customers 
                SET forname = ?, surname = ?, add1 = ?, add2 = ?, add3 = ?, postcode = ?, phone = ?, email = ?, registered = ?
                WHERE id = ?";

        // Paramètres de la requête
        $params = [$forname, $surname, $add1, $add2, $add3, $postcode, $phone, $email, $registered, $customer_id];

        // Exécution de la requête
        $this->executerRequete($sql, $params);
    }


    public function createEmptyCustomer()
    {
        // ID récupéré à partir de la session
        $id = $_SESSION['id'];

        // Requête SQL pour insérer un nouveau client avec des valeurs par défaut ou vides
        $sql = "INSERT INTO customers (id, forname, surname, add1, add2, add3, postcode, phone, email, registered) 
                VALUES (?, '', '', '', '', '', '', '', '', 0)";

        // Paramètres de la requête
        $params = [$id];

        // Exécution de la requête
        $this->executerRequete($sql, $params);
    }

}