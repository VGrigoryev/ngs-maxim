<?php
require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/config/db.php');

use Jacwright\RestServer\RestServer;
use vgrigoryev\controllers\ProductsController;

$server = new RestServer('debug');

$server->addClass(ProductsController::class);

$server->handle();