<?php

namespace App\Controllers;
use App\Models\Compte;

class CompteController
{
    public function index()
    {
        if ($_SESSION['id']){
            $model = new Compte;
            $compte = $model->getCustomer();
            if (!$compte){
                $model->createEmptyCustomer($_SESSION['id']);
                $compte = $model->getCustomer();
            }

            $twig = new Twig;
            $twig->afficherpage('Compte','index',['compte' => $compte]);
        } else {
            // Rediriger si on est pas connecté
            header('Location: /');
            exit();
        }
    }

    public function ModifierCompte()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire POST
            $forname = $_POST['firstname'] ?? '';
            $surname = $_POST['lastname'] ?? '';
            $add1 = $_POST['add1'] ?? '';
            $add2 = $_POST['add2'] ?? '';
            $city = $_POST['city'] ?? '';
            $postcode = $_POST['postcode'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';

            // Vérifier si les valeurs sont définies
            if (!empty($forname) && !empty($surname) && !empty($add1) && !empty($city) && !empty($postcode) && !empty($phone) && !empty($email)) {
                // Obtenez l'ID de la session
                $customer_id = $_SESSION['id'];

                // Instancier le modèle Compte
                $model = new Compte;

                // Appeler la fonction modifieCustomer du modèle
                $model->modifieCustomer($customer_id, $forname, $surname, $add1, $add2, $city, $postcode, $phone, $email, 1);

                // Rediriger vers une autre page après la modification
                header('Location: /Compte');
                exit();
            }
            // Cas où on utilise pas la méthode POST
            header('Location: /');
            exit();
        }
    }
}