<?php

namespace App\Controllers;
use App\Models\Name;

class PageTestController
{
    public function index()
    {
        echo 'Ici est la PageTest';
    }

    public function test0(array $params)
    {
        echo var_dump($params);
    }

    public function test1()
    {
        $name_instance  = new Name;
        $noms = $name_instance ->getNames();
        echo '<br>' . implode('<br>' , $noms);
    }

    public function test2()
    {
        $joueur_instance = new Name;
        $joueurs = $joueur_instance->getJoueurs();
        require_once ROOT . '/Views/PageTest2.php';
    }

    public function test3(array $params){
        $joueur_instance = new Name;
        $joueurs = $joueur_instance->getJoueur($params[0]);
        require_once ROOT . '/Views/PageTest3.php';
    }
}
