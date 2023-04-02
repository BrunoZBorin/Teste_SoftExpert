<?php

namespace Teste\Pdo\Testes;
use PHPUnit\Framework\TestCase;
use Teste\Pdo\Domain\Model\ItensVenda;
use Teste\Pdo\Domain\Model\Venda;
use Teste\Pdo\Domain\Model\Produto;
use Teste\Pdo\Domain\Model\Tipo;


class VendasTest extends TestCase
{
    public function testaValorTotal()
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
    public function testaValorImpostos()
    {
        $venda = new Venda();
        
        $produto1 = new Produto();
        $produto2 = new Produto();
        $tipo1 = new Tipo();
        $tipo2 = new Tipo();
        $tipo1->setImposto(100);
        $tipo2->setImposto(200);
        $produto1->setTipo($tipo1);
        $produto2->setTipo($tipo2);

        $item1 = new ItensVenda($venda, $produto1);
        $item2 = new ItensVenda($venda, $produto2);
        $venda->addItems($item1);
        $venda->addItems($item2);
        $items = $venda->getItems();

        $valor_total = 0;
        foreach($items as $item)
        {
            $valor_total += $item->getProduto()->getTipo()->getImposto();
        }

        $this->assertEquals($valor_total, 300 );
        
    }
    
}