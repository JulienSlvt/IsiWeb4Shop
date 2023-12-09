<?php

namespace App\Controllers;

class ErrorController
{
    public function index()
    {
        $this->pageInexistante();
    }

    public function pageInexistante()
    {
        require_once ROOT . '/Views/erreur404.php';
    }

    public function missingParameter()
    {
        echo "Parametre manquant";
        require_once ROOT . '/Views/erreur404.php';
    }
}