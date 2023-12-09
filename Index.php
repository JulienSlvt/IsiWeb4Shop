<?php

use App\Controllers\Routeur;

define('ROOT',__DIR__);

require_once ROOT . '/vendor/autoload.php';

session_start();

$app = new Routeur;
$app->start();