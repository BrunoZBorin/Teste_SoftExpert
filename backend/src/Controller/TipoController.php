<?php

declare(strict_types=1);

namespace Teste\Pdo\Controller;

use Teste\Pdo\Domain\Model\Tipo;
use PDO;

class TipoController
{
    public function __construct(private PDO $pdo)
    {
    }
    public function add($tipo)
    {
        $t = json_decode($tipo);
        $lastId = 1;
        $sql = 'SELECT COALESCE(MAX(id_tipo), 0) AS LastID FROM tipos';
        $statement = $this->pdo->prepare($sql);
        try
        {
            $statement->execute();
        }
        catch(\PDOException $e)
        {
            return $e->getMessage();
        }
        
        if($tip = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            $lastId = $tip['lastid'] + 1;
        }

        $sql = 'INSERT INTO tipos (id_tipo, descricao, imposto) VALUES (:id_tipo, :descricao, :imposto)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id_tipo', $lastId);
        $statement->bindValue(':descricao', $t->descricao);
        $statement->bindValue(':imposto', $t->imposto);
        
        try
        {
            $result = $statement->execute();
        }
        catch(\PDOException $e)
        {
            return $e->getMessage();
        }
        return $result;
    }

    public function remove($params)
    {
        $sql = 'DELETE FROM tipos WHERE id_tipo = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $params['id']);
        try
        {
            $result = $statement->execute();
        }
        catch(\PDOException $e)
        {
            return $e->getMessage();
        }
        return $result;
    }

    public function update($tipo)
    {
        $t = json_decode($tipo);
        $sql = "UPDATE tipos SET
                  descricao = :descricao,
                  imposto = :imposto
              WHERE id_tipo = :id_tipo;";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id_tipo', $t->id_tipo);
        $statement->bindValue(':descricao', $t->descricao);
        $statement->bindValue(':imposto', $t->imposto);
        try
        {
            $result = $statement->execute();
        }
        catch(\PDOException $e)
        {
            return $e->getMessage();
        }
        return $result;
    }

    /**
     * @return Tipo[]
     */
    public function all()
    {
        $sth = $this->pdo->prepare("SELECT * FROM tipos ORDER BY ID_TIPO;");
        $sth->execute();
        try
        {
            $result = $sth->fetchAll();
        }
        catch(\PDOException $e)
        {
            return $e->getMessage();
        }
        return $result; 
    }

}
