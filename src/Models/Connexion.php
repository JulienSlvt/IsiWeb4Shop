<?php

namespace App\Models;
use App\Models\Model;
use PDO;

class Connexion extends Model
{
    public function connecteUtilisateur($username, $password)
    {
        // Vérifier si le compte existe
        $idClient = $this->getIdClientParIdentifiants($username, $password);
        if ($idClient !== false) {
            // Démarrer la session si le compte existe
            $this->supTempUser();
            $_SESSION['id'] = $idClient;
            $_SESSION['user'] = $username;
            if ($this->isAdmin($username, $password)){
                $_SESSION['admin'] = true;
                echo "Vous êtes adiministrateur";
            }
        } else {
            header('Location: /Connexion/Erreur');
        exit();
        }
    }

    private function isAdmin($username, $password)
    {
        // Vérifiez si les données nécessaires sont présentes
        if (!empty($username) && !empty($password)) {
            // Utilisez une requête pour vérifier si les informations d'administration sont valides
            $sqlVerifierAdmin = "SELECT COUNT(*) AS count FROM admin WHERE username = ? AND password = ?";
            $parametresVerifierAdmin = [$username, sha1($password)]; // Note: Utilisation de sha1 pour illustrer, vous devriez utiliser des méthodes de hachage sécurisées en production
            $resultatVerifierAdmin = $this->executerRequete($sqlVerifierAdmin, $parametresVerifierAdmin);
    
            // Récupérez le nombre de lignes correspondant à la requête
            $count = $resultatVerifierAdmin->fetch(PDO::FETCH_ASSOC)['count'];
    
            // Retournez vrai si les informations d'administration sont valides, faux sinon
            return $count > 0;
        } else {
            // Nom d'utilisateur ou mot de passe non fourni
            return false;
        }
    }
    

    private function getIdClientParIdentifiants($username, $password)
    {
        // Vérifier les identifiants dans la table 'logins'
        $sql = "SELECT `customer_id` FROM logins WHERE `username` = ? AND `password` = ?";
        $params = array($username, sha1($password));

        $resultat = $this->executerRequete($sql, $params);

        if ($resultat->rowCount() > 0) {
            $row = $resultat->fetch(PDO::FETCH_ASSOC);
            return $row['customer_id'];
        } else {
            return false;
        }
    }
    public function newTempUser()
{
    $sql = "SELECT MIN(customer_id) AS min_customer_id FROM logins;";
    $resultat = $this->executerRequete($sql);
    $row = $resultat->fetch(PDO::FETCH_ASSOC);
    
    // Vérifier si le résultat est NULL (table vide)
    if ($row['min_customer_id'] === null) {
        // Retourner une valeur par défaut pour le cas où la table est vide
        return 0;
    }

    // Sinon, retourner le résultat décrémenté
    return $row['min_customer_id'] - 1;
}


    public function createTempUser()
    {
        // Exemple d'insertion d'un utilisateur dans la table 'logins'
        $sql = "INSERT INTO logins (`customer_id`) VALUES ( ? )";
        $params = [$this->newTempUser()];
        $_SESSION['id'] = $params;
        $_SESSION['temp'] = true;
        $this->executerRequete($sql, $params);
    }

    private function supTempUser()
    {
    if (isset($_SESSION['tmp'])) {
        // Exemple de suppression d'un utilisateur dans la table 'logins'
        $sql = "DELETE FROM logins WHERE customer_id = ?";
        $params = [$_SESSION['id']];

        // Exécuter la requête pour supprimer l'utilisateur temporaire
        $this->executerRequete($sql, $params);

        // Supprimer également le bool de temp de la session
        unset($_SESSION['temp']);
        unset($_SESSION['id']);
    }
    }

}
