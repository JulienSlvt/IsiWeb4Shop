<?php

namespace App\Models;

class Adresse extends Model
{

    public function newAdresse($forname, $surname, $add1, $add2, $add3, $postcode, $phone, $email)
    {
        // Obtenez le prochain ID d'adresse
        $adresseId = $this->incrementAdresseId();

        // Requête SQL pour insérer une nouvelle adresse
        $sql = "INSERT INTO delivery_addresses (id, forname, surname, add1, add2, add3, postcode, phone, email) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Paramètres de la requête
        $params = [
            $adresseId,
            $forname,
            $surname,
            $add1,
            $add2,
            $add3,
            $postcode,
            $phone,
            $email
        ];

        // Exécution de la requête
        $this->executerRequete($sql, $params);

        // Retourner l'ID de l'adresse nouvellement créée
        return $adresseId;
    }

    public function getAdressId($forname, $surname, $add1, $add2, $add3, $postcode, $phone, $email)
    {
        // Requête SQL pour obtenir l'ID de l'adresse existante
        $sql = "SELECT id FROM delivery_addresses 
                WHERE forname = ? AND surname = ? AND add1 = ? AND add2 = ? AND add3 = ? AND postcode = ? AND phone = ? AND email = ?";

        // Paramètres de la requête
        $params = [
            $forname,
            $surname,
            $add1,
            $add2,
            $add3,
            $postcode,
            $phone,
            $email
        ];

        // Exécution de la requête
        $resultat = $this->executerRequete($sql, $params);

        // Récupération de l'ID de l'adresse
        $row = $resultat->fetch();

        // Si l'adresse existe, retourner son ID
        if ($row) {
            return $row['id'];
        } else {
            // Si l'adresse n'existe pas, créer une nouvelle adresse
            $adresseId = $this->newAdresse($forname, $surname, $add1, $add2, $add3, $postcode, $phone, $email);

            // Retourner l'ID de la nouvelle adresse
            return $adresseId;
        }
    }


    public function incrementAdresseId()
    {
        $sql = "SELECT MAX(id) AS derniereAdresseId FROM delivery_addresses";
        $resultat = $this->executerRequete($sql);

        // Récupérer la valeur
        $row = $resultat->fetch();

        // Vérifier si des données sont retournées
        if ($row) {
            return $row['derniereAdresseId'] + 1;
        } else {
            // Aucune valeur trouvée (par exemple, si la table est vide)
            return 1;
        }
    }
}
