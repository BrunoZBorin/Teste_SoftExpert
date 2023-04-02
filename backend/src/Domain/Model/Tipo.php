<?php

namespace Teste\Pdo\Domain\Model;

class Tipo
{
    private ?int $id_tipo;
    private float $imposto;
    private string $descricao;

    public function setIdTipo($id_tipo){
        $this->id_tipo = $id_tipo;
     }
     public function getIdTipo(){
        return $this->id_tipo;
     }

     public function setImposto($imposto){
        $this->imposto = $imposto;
     }
     public function getImposto(){
        return $this->imposto;
     }

     public function setDescricao($descricao){
        $this->descricao = $descricao;
     }
     public function getDescricao(){
        return $this->descricao;
     }
}
