<?php

namespace App\Models;
use PDO;
use PDOException;
abstract class Model
{
    public function getBdd()
    {
        $host = 'localhost';
        $dbname = 'isiweb';
        $user = 'root';
        $password = '';

        try {
            // Création de l'objet PDO
            $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);

            // Définir le mode d'erreur sur l'exception
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
        } catch (PDOException $e) {
            // En cas d'erreur de connexion
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        return $bdd;
    }

    protected function executerRequete($sql, $params = null) {
        
        if ($params == null) {
            $resultat = $this->getBdd()->query($sql); // exécution directe
        } else {
            $resultat = $this->getBdd()->prepare($sql); // requête préparée
            $resultat->execute($params);
        }
        return $resultat;
    } 
}