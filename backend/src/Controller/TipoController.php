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
        $sql = 'SELECT MAX(id_tipo) AS LastID FROM tipos';
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
            $lastId = $tip['lastid'];
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

    public function remove(int $id)
    {
        $sql = 'DELETE FROM tipos WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);

        return $statement->execute();
    }

    public function update($tipo)
    {
        $t = json_decode($tipo);
        $sql = "UPDATE tipos SET
                  descricao = :descricao,
                  imposto = :imposto
              WHERE id_produto = :id_produto;";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id_tipo', $t->id_tipo);
        $statement->bindValue(':descricao', $t->descricao);
        $statement->bindValue(':imposto', $t->imposto);
        return $statement->execute();
    }

    /**
     * @return Tipo[]
     */
    public function all()
    {
        $tipoList = $this->pdo
            ->query('SELECT * FROM tipos;')
            ->fetchAll(\PDO::FETCH_ASSOC);
        
        return $tipoList;
    }

}
