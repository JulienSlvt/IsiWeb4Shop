<?php

namespace App\Models;

use App\Models\Model;

class Inscription extends Model
{
    public function inscrireUtilisateur($username, $password)
    {
        // Vérifiez si les données nécessaires sont présentes
        if (!empty($username) && !empty($password)) {
            // Exemple d'insertion d'un utilisateur dans la table 'logins'
            $sql = "INSERT INTO logins (`customer_id`, `username`, `password`) VALUES (" . $this->incrementCustomerId(). ", ?, ?)";
            $params = array($username, sha1($password));

            $this->executerRequete($sql, $params);
            echo "Inscription réussie !";
        } else {
            echo "Veuillez fournir un nom d'utilisateur et un mot de passe.";
        }
    }

    public function incrementCustomerId()
    {
        $sql = "SELECT MAX(customer_id) AS dernierCustomerId FROM logins";
        $resultat = $this->executerRequete($sql);

        // Récupérer la valeur
        $row = $resultat->fetch();

        // Vérifier si des données sont retournées
        if ($row) {
            return $row['dernierCustomerId'] + 1;
        } else {
            // Aucune valeur trouvée (par exemple, si la table est vide)
            return 0;
        }
    }

}
