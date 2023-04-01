<?php

namespace Teste\Pdo\Testes;
use PHPUnit\Framework\TestCase;
use Teste\Pdo\Domain\Model\ItensVenda;
use Teste\Pdo\Domain\Model\Venda;
use Teste\Pdo\Domain\Model\Produto;


class VendasTest extends TestCase
{
    public function teste1()
    {
        $venda = new Venda();
        $venda->setValorTotal(1000);
        $produto = new Produto();
        $produto->setValor(500);

        $item1 = new ItensVenda($venda, $produto);
        $item2 = new ItensVenda($venda, $produto);
        $venda->addItems($item1);
        $venda->addItems($item2);
        $items = $venda->getItems();

        $valor_total = 0;
        foreach($items as $item)
        {
            $valor_total += $item->getProduto()->getValor();
        }

        $this->assertEquals($valor_total, $venda->getValorTotal() );
        
    }
    
}