<?php

namespace App\Models;
use PDO;

class Compte extends Model
{
    public function getDeliveryAddresses()
    {
        // Requête SQL pour récupérer les données de la table delivery_addresses
        $sql = "SELECT * FROM delivery_addresses WHERE ";
        
        // Exécution de la requête
        $resultat = $this->executerRequete($sql);

        // Récupération des données
        $donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les données
        return $donnees;
    }
}