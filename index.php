<?php

date_default_timezone_set('America/Bahia');
use Infrastructure\Utils\CorsHandler;

//se você está debugando o projeto, lembrese de colocar no arquivo de constantes IS_DEV = true;
require_once 'constants.php';
require_once 'src/Infrastructure/Utils/debugger.php';
require_once 'autoload.php';

$corsHandler = new CorsHandler();
$corsHandler->handleCors();

$app = new App();
$app->handleRequest();

