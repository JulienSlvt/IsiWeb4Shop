<?php

use App\Controllers\Routeur;

define('ROOT',__DIR__);

require_once ROOT . '/vendor/autoload.php';

session_start();
// Si on est pas connecté l'id session est automatiquement -1
if (!isset($_SESSION['id'])){
    $_SESSION['id'] = -1;
}

$app = new Routeur;
$app->start();