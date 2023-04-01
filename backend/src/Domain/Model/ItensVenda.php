<?php

namespace Teste\Pdo\Domain\Model;

class ItensVenda
{
    private ?int $id_item_venda;
    private float $quantidade;
    private Venda $venda;
    private Produto $produto;

    public function __construct(Venda $venda, Produto $produto)
    {
        $this->venda = $venda;
        $this->produto = $produto;
    }

    public function getProduto()
    {
        return $this->produto;
    }

}
