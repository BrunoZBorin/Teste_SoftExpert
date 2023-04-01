<?php

declare(strict_types=1);

namespace Teste\Pdo\Controller;

use PDO;

class VendaController
{
    public function __construct(private PDO $pdo)
    {
    }
    public function add($venda)
    {
        $this->pdo->beginTransaction();
        $v = json_decode($venda);
        $lastId = 1;
        $sql = 'SELECT MAX(id_venda) AS LastID FROM vendas';
        $statement = $this->pdo->prepare($sql);
        try
        {
            $statement->execute();
        }
        catch(\PDOException $e)
        {
            return $e->getMessage();
        }
        if($vend = $statement->fetch(\PDO::FETCH_ASSOC))
        {   
            $lastId = $vend['lastid'] + 1;
        }
        foreach($venda->itens as $item)
        {
            $lastitemid = 1;
            $sql_i = 'SELECT MAX(id_item_venda) AS lastitemid FROM itens_venda';
            $statement_i = $this->pdo->prepare($sql_i);
            try
            {
                $statement_i->execute();
            }
            catch(\PDOException $e)
            {
                return $e->getMessage();
            }
            if($itv = $statement_i->fetch(\PDO::FETCH_ASSOC))
            {   
                $lastitemid = $itv['lastitemid'] + 1;
            }
            $sql_i = 'INSERT INTO itens_venda (id_item_venda, quantidade, id_venda, id_produto) VALUES (:id_item_venda, :quantidade, :id_venda, :id_produto)';
            $statement_i = $this->pdo->prepare($sql_i);
            $statement_i->bindValue(':id_item_venda', $lastitemid);
            $statement_i->bindValue(':quantidade', $item->quantidade);
            $statement_i->bindValue(':id_venda', $lastId);
            $statement_i->bindValue(':id_produto', $item->id_produto);
            
            try
            {
                $result = $statement_i->execute();
            }
            catch(\PDOException $e)
            {
                $this->pdo->rollBack();
                return $e->getMessage();
            }
        }
        $sql = 'INSERT INTO vendas (id_venda, data_venda, imposto_total) VALUES (:id_venda, :data_venda, :imposto_total)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id_venda', $lastId);
        $statement->bindValue(':data_venda', $venda->data_venda);
        $statement->bindValue(':imposto_total', $venda->imposto_total);
        
        try
        {
            $result = $statement->execute();
        }
        catch(\PDOException $e)
        {
            $this->pdo->rollBack();
            return $e->getMessage();
        }
        return $result;
    }

    public function remove(int $id)
    {
        $sql = 'DELETE FROM vendas WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);

        return $statement->execute();
    }

    /**
     * @return Venda[]
     */
    public function all()
    {
        $vendaList = $this->pdo
            ->query('SELECT * FROM vendas;')
            ->fetchAll(\PDO::FETCH_ASSOC);
        
        return $vendaList;
        
    }

}
