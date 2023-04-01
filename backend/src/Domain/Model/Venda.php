<?php

namespace Teste\Pdo\Domain\Model;

class Venda
{
    private ?int $id_venda;
    private date $data_venda;
    private float $valor_total;
    private float $imposto_total;

    private array $items;

    public function setIdVenda($id_venda){
        $this->id_venda = $id_venda;
     }
     public function getIdVenda(){
        return $this->id_venda;
     }

     public function setDataVenda($data_venda){
        $this->data_venda = $data_venda;
     }
     public function getDataVenda(){
        return $this->data_venda;
     }

     public function setValorTotal($valor_total){
        $this->valor_total = $valor_total;
     }
     public function getValorTotal(){
        return $this->valor_total;
     }

     public function setImpostoTotal($imposto_total){
        $this->imposto_total = $imposto_total;
     }
     public function getImpostoTotal(){
        return $this->imposto_total;
     }

     public function addItems(ItensVenda $item)
     {
        $this->items[] = $item;
     }   
     
     public function getItems()
     {
        return $this->items;
     }
}
