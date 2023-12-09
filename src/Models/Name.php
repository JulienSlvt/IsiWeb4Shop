<?php

namespace App\Models;

use PDO;
use PDOException;

class Name extends Model
{
    public function getNames()
    {
        $sql = "SELECT nom FROM JOUEURS";
        $resultats = $this->executerRequete($sql);
        $noms = $resultats->fetchAll(PDO::FETCH_COLUMN);
        return $noms;
    }

    public function getJoueurs()
    {
        $sql = "SELECT * FROM JOUEURS";
        $resultats = $this->executerRequete($sql);
        
        // Vérifiez si la requête s'est exécutée correctement
        if ($resultats === false) {
            throw new PDOException("Erreur lors de l'exécution de la requête.");
        }
    
        // Utilisez fetchAll avec PDO::FETCH_ASSOC pour obtenir un tableau associatif
        $joueurs = $resultats->fetchAll(PDO::FETCH_ASSOC);
    
        // Vérifiez si fetchAll a réussi
        if ($joueurs === false) {
            throw new PDOException("Erreur lors de la récupération des joueurs.");
        }
    
        return $joueurs;
    }

    public function getJoueur(String $nom)
    {
        $sql = "SELECT * FROM JOUEURS WHERE nom = '" . $nom . "';";
        $resultats = $this->executerRequete($sql);
        
        // Vérifiez si la requête s'est exécutée correctement
        if ($resultats === false) {
            throw new PDOException("Erreur lors de l'exécution de la requête.");
        }
        // Utilisez fetchAll avec PDO::FETCH_ASSOC pour obtenir un tableau associatif
        $joueurs = $resultats->fetchAll(PDO::FETCH_ASSOC);
    
        // Vérifiez si fetchAll a réussi
        if ($joueurs === false) {
            throw new PDOException("Erreur lors de la récupération des joueurs.");
        }
    
        return $joueurs;
    }
}