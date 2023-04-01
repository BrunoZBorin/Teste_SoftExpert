<?php

namespace Teste\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    
    public static function createConnection(): PDO
    {
        $endereco = 'localhost';
        $banco = 'teste_softexpert';
        $usuario = 'postgres';
        $senha = 'admin';

        $connection = new PDO("pgsql:host=$endereco;port=5432;dbname=$banco", $usuario, $senha);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }
}
