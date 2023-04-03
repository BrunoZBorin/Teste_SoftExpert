<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

$pdo = \Teste\Pdo\Infrastructure\Persistence\ConnectionCreator::createConnection();


use \Teste\Pdo\Config\Routes;

$routes = require_once __DIR__ . './config/routes.php';

$url = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];
$info = $_SERVER["PATH_INFO"];
$body = file_get_contents('php://input');
$queryString = parse_url($url, PHP_URL_QUERY);
$params = null;
if(isset($queryString))
    parse_str($queryString, $params);


$routes = new Routes();

$routes->DirecionaRota($info, $method, $body, $params);

