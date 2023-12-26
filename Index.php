<?php

use App\Controllers\Routeur;
use App\Models\Connexion;

define('ROOT',__DIR__);

require_once ROOT . '/vendor/autoload.php';

session_start();

// Si on est pas connecté l'id session est automatiquement -1
if (!isset($_SESSION['id'])){
    $user = new Connexion;
    $user->createTempUser();
}

$app = new Routeur;
$app->start();