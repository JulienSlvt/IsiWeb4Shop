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

            // Transfert de la commande 
            
            // On supprime l'utilisateur temporaire
            session_unset();

            // On définit les variables de session
            $_SESSION['id'] = $idClient;
            $_SESSION['user'] = $username;

            // On créer un cookie dans lequel on met l'id de connexion
            $this->createCookieSession();

            if ($this->isAdmin($username, $password)){
                $_SESSION['admin'] = true;
                echo "Vous êtes adiministrateur";
            }
        } else {
            header('Location: /Connexion/Erreur');
            exit();
        }
    }

    public function deconnection()
    {
        session_unset();
        $this->deleteCookieSession();
        $this->deleteCookieTemp();
        header('Location: /');
        exit();
    }

    private function usernameExists($username)
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

    public function createTempUser()
    {
        // On vérifie si un cookie de connexion existe
        if (isset($_COOKIE['temp'])){
            // On définit la variable temp
            $_SESSION['temp'] = $_COOKIE['temp'];

            // On allonge la durée du cookie
            $this->createCookieTemp();
            
        } elseif (isset($_COOKIE['id'])){
            // On définit la variable id Session
            $_SESSION['id'] = $_COOKIE['id'];

            // On alonge la durée du cookie
            $this->createCookieSession();
        }
    }

    private function createCookieSession()
    {
        // Créer un cookie d'une durée de 1 mois
        setcookie('id', session_id(), time() + 31 * 24 * 60 * 60 , '/');
    }

    private function deleteCookieSession()
    {
        if (isset($_COOKIE['id'])) {
            // Créer un cookie d'une durée de 1 mois
            setcookie('id','', time() - 31 * 24 * 60 * 60 , '/');
        }
    }

    private function createCookieTemp()
    {
        // Créer un cookie temp d'une durée de 1 mois
        setcookie('temp', true, time() + 31 * 24 * 60 * 60 , '/');
    }

    private function deleteCookieTemp()
    {
        if (isset($_COOKIE['temp'])) {
            // Supprime le cookie temp
            setcookie('temp', '', time() - 31 * 24 * 60 * 60 , '/');
        }
    }
}
