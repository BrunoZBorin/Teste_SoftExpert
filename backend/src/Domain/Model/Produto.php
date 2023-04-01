<?php

namespace Teste\Pdo\Domain\Model;

class Produto
{
    private ?int $id_produto;
    private string $descricao;
    private float $valor;
    private Tipo $tipo;

    public function setIdProduto($id_produto){
        $this->id_produto = $id_produto;
     }
     public function getIdProduto(){
        return $this->id_produto;
     }

     public function setDescricao($descricao){
        $this->descricao = $descricao;
     }
     public function getDescricao(){
        return $this->descricao;
     }

     public function setValor($valor){
        $this->valor = $valor;
     }
     public function getValor(){
        return $this->valor;
     }

     public function setTipoId(Tipo $tipo){
        $this->tipo = $tipo;
     }
     public function getTipoId(){
        return $this->tipo;
     }
}
