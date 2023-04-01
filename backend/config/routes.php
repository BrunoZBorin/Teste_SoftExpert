<?php

declare(strict_types=1);

namespace Teste\Pdo\Config;
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

use Teste\Pdo\Controller\ProdutoController;
use Teste\Pdo\Controller\TipoController;


class Routes
{
    public function DirecionaRota($url, $method, $body, $params)
    {
        $pdo = \Teste\Pdo\Infrastructure\Persistence\ConnectionCreator::createConnection();
        $produtoController = new ProdutoController($pdo);
        $tipoController = new TipoController($pdo);
        
        switch($url)
        {
            case "/produtos":
                if($method == "GET")
                {
                    $response = $produtoController->all();
                }
                else if($method == "POST")
                {
                    $response = $produtoController->add($body);
                }
                else if($method == "PUT")
                {
                    $response = $produtoController->update($body);
                }
                else if($method == "DELETE")
                {
                    $response = $produtoController->remove($params);
                }
                break;
            case "/tipos":
                if($method == "GET")
                {
                    $response = $tipoController->all();
                }
                else if($method == "POST")
                {
                    $response = $tipoController->add($body);
                }
                break;
            case "/vendas":
                if($method == "GET")
                {
                    $response = $tipoController->all();
                }
                else if($method == "POST")
                {
                    $response = $tipoController->add($body);
                }
                break;
        }

        echo json_encode($response);

    }
}
