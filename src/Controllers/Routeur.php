<?php

namespace App\Controllers;

use App\Controllers\ErrorController;
class Routeur
{

    public function start()
    {
        // On retire le 'trailing slash éventuel de l'URL
        // On récupère l'URL
        $uri = $_SERVER['REQUEST_URI'];

        // On vérifie que uri n'est pas vide et se termine par un / 
        if (!empty($uri) && $uri[-1] === "/" && $uri != '/') {

            // On enlève le /
            $uri = substr($uri, 0, -1);

            // On envoie un code de redirection permanente
            http_response_code(301);
        
            // On redirige vers l'URL sans le /
            header('Location: ' . $uri);
            exit();
        }
        
        // On gère les paramètres d'URL
        // p=controleur/methode/parametres
        // On sépare les paramètres dans un tableau

        // On utilise la fonction isset pour vérifier si la clé "p" existe
        $params = isset($_GET['p']) ? explode('/', $_GET['p']) : [];

        // On teste si on a au moins un paramètre
        if (!empty($params[0])) {
            // On a au moins un paramètre one récupère le nom du controleur à instancier
            // On met une majuscule en 1 ère lettre
            // On ajoute le namespace complet avant et on ajoute controleur après

            $controllerName = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

            // Vérifiez si la classe du contrôleur existe
            if (class_exists($controllerName)) {
                // Instanciez le contrôleur
                $controller = new $controllerName;

            } else {
                // La classe du contrôleur n'existe pas
                $controller = new ErrorController;
                $controller->missingParameter();
            }
        
            // On récupère le 2eme paramètre d'URL
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)){
                
                // Si il reste des paramètres on les passe à la méthode
                (isset($params[0])) ? $controller->$action($params) : $controller->$action();
            } else {
                $controller = new ErrorController;
                $controller->pageInexistante();
            }
        } else {
            // On n'a pas de paramètres. On instancie et on appelle le contrôleur par défaut
            $controller = new AccueilController;
            $controller->index();
        }
    }
}
