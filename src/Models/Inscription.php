<?php

namespace App\Models;

use App\Models\Model;
    use PDO;

class Inscription extends Model
{
    public function inscrireUtilisateur($username, $password)
    {
        if (!empty($username) && !empty($password)) {

            // On test si le nom d'utilisateur existe déja
            $test = $this->usernameExists($username);
            if (!$test){
                // On génère le nouvel id 
                $new_id = $this->incrementCustomerId();
                echo var_dump($new_id);

                // Exemple d'insertion d'un utilisateur dans la table 'logins'
                $sql = "INSERT INTO logins (`customer_id`, `username`, `password`) VALUES (" . $new_id . ", ?, ?)";
                $params = array($username, sha1($password));

                $this->executerRequete($sql, $params);

                $model = new Compte;
                $model->createEmptyCustomer($new_id);

            
                
            } else {
                echo "Veuillez fournir un nom d'utilisateur et un mot de passe.";
            }
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

    public function usernameExists($username)
    {
        // Requête SQL pour vérifier si le nom d'utilisateur existe déjà
        $sql = "SELECT COUNT(*) AS count FROM logins WHERE username = ?";
        $params = [$username];

        // Exécution de la requête
        $result = $this->executerRequete($sql, $params);

        // Récupération du nombre de lignes correspondant à la requête
        $count = $result->fetch(PDO::FETCH_ASSOC)['count'];

        // Retourne vrai si le nom d'utilisateur existe déjà, faux sinon
        return $count > 0;
    }

}
