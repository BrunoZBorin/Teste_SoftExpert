<?php

declare(strict_types=1);

namespace Teste\Pdo\Controller;

use Teste\Pdo\Domain\Model\Produto;
use PDO;

class ProdutoController
{
    public function __construct(private PDO $pdo)
    {
    }

    public function add($produto)
    {
        $p = json_decode($produto);
        $lastId = 1;
        $sql = 'SELECT MAX(id_produto) AS LastID FROM produtos';
        $statement = $this->pdo->prepare($sql);
        try
        {
            $statement->execute();
        }
        catch(\PDOException $e)
        {
            return $e->getMessage();
        }
        
        if($prod = $statement->fetch(\PDO::FETCH_ASSOC))
        {   
            $lastId = $prod['lastid'] + 1;
        }
        
        $sql = 'INSERT INTO produtos (id_produto, descricao, valor, cod_tipo) VALUES (:id_produto, :descricao, :valor, :cod_tipo)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id_produto', $lastId);
        $statement->bindValue(':descricao', $p->descricao);
        $statement->bindValue(':valor', $p->valor);
        $statement->bindValue(':cod_tipo', $p->cod_tipo);
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
        $sql = 'DELETE FROM produtos WHERE id_produto = ?';
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

    public function update($produto)
    {
        $p = json_decode($produto);
        $sql = "UPDATE produtos SET
                  descricao = :descricao,
                  valor = :valor,
                  cod_tipo = :cod_tipo
              WHERE id_produto = :id_produto;";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id_produto',$p->id_produto);
        $statement->bindValue(':descricao', $p->descricao);
        $statement->bindValue(':valor', $p->valor);
        $statement->bindValue(':cod_tipo', $p->cod_tipo);
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
     * @return Produto[]
     */
    public function all()
    {
        $sth = $this->pdo->prepare("SELECT 
            p.*, 
            t.imposto 
        FROM produtos p 
        INNER JOIN tipos t ON (t.id_tipo = p.cod_tipo) 
        ORDER BY p.id_produto;");
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
