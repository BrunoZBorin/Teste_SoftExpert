<template>
  <div id="venda">
    <!-- Modal Produtos -->
    <div class="modal fade" id="listagemProdutos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="listagemProdutosLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="listagemProdutosLabel">Selecione um produto</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <table class="table table-default border">
                <thead>
                  <tr>
                    <th v-for="coluna in colunas" scope="col">{{ coluna }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr @click="cliqueProduto($event, produto)" v-for="produto in produtos">
                    <td>{{ produto.id_produto }}</td>
                    <td>{{ produto.descricao }}</td>
                    <td>{{ formatarValor(produto.valor) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" @click="setProduto" class="btn btn-success">Confirmar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Fim Modal -->

    <!-- Modal Vendas -->
    <div class="modal modal-lg fade" id="listagemVendas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="listagemVendasLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="listagemVendasLabel">Vendas</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <table class="table table-default border">
                <thead>
                  <tr>
                    <th v-for="coluna in colunasVendas" scope="col">{{ coluna }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="venda in vendas">
                    <td>{{ venda.id_venda }}</td>
                    <td>{{ formatarData(venda.data_venda) }}</td>
                    <td>{{ formatarValor(venda.imposto_total) }}</td>
                    <td>{{ formatarValor(venda.valor_total) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>
    <!-- Fim Modal -->

    <div class="row">
      <div class="col-5">
        <h5>Itens venda</h5>
      </div>
      <div class="col-1">
      </div>
      <div class="col-6">
        <h5>Incluir Produto</h5>
      </div>
    </div>
    <div class="row">
      <div id="containerProdutos" class="col-5">
        <table class="table border">
          <thead>
            <tr>
              <th v-for="coluna in colunasItens" scope="col">{{ coluna }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(produto, index) in itensVenda">
              <td>{{ produto.id_produto }}</td>
              <td>{{ produto.descricao }}</td>
              <td>{{ formatarValor(produto.valor) }}</td>
              <td>{{ formatarValor(produto.quantidade) }}</td>
              <td>{{ formatarValor(produto.quantidade * produto.valor) }}</td>
              <td>{{ formatarValor((produto.quantidade * produto.valor) * (produto.imposto / 100)) }}</td>
              <td @click="excluirItem(index)" id="excluirItem" style="color: red; font-weight: bold;">x</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-1">
      </div>
      <div class="col-6">
        <div class="row">
          <div class="col-2">
            <label for="inputCodigo">Cód.</label>
            <div class="input-group mb-3">
              <button style="width: 30px;margin: 0px;padding: 4px;" class="btn btn-primary" type="button" id="button-addon1" @click="abrirModalProdutos">&#128269;</button>
              <input id="inputCodigo" type="text" class="form-control" aria-describedby="button-addon1" v-model="produto.id_produto" disabled>
            </div>
          </div>
          <div class="col-5">
            <label for="inputDescricao">Descrição</label>
            <input id="inputDescricao" type="text" class="form-control" v-model="produto.descricao" disabled>
          </div>
          <div class="col-2">
            <label for="inputValor">Valor</label>
            <input id="inputValor" type="text" class="form-control" :value="formatarValor(produto.valor)" disabled>
          </div>
          <div class="col-2">
            <label for="inputQuantidade">Qtd.</label>
            <DebouncedCurrencyInput 
              id="inputQuantidade" 
              class="form-control"
              v-model="produto.quantidade"
              :value="produto.quantidade"
              :options="{
                'currency': 'BRL',
                'currencyDisplay': 'hidden',
                'valueRange': {
                  'max': 999999
                },
                'precision': 2,
                'hideCurrencySymbolOnFocus': false,
                'hideGroupingSeparatorOnFocus': false,
                'hideNegligibleDecimalDigitsOnFocus': false,
                'autoDecimalDigits': true,
                'useGrouping': true,
                'accountingSign': false
              }"
            />
          </div>
          <div class="col-1">
            <label></label>
            <button @click="incluirItem" type="button" class="btn btn-success">
              ✓
            </button>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-6">
            <label for="inputTotalImpostos">Total Impostos</label>
            <input id="inputTotalImpostos" type="text" class="form-control" :value="formatarValor(totalImpostos)" disabled>
          </div>
          <div class="col-6">
            <label for="inputTotalCompra">Total Compra</label>
            <input id="inputTotalCompra" type="text" class="form-control" :value="formatarValor(totalCompra)" disabled>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12">
            <button @click="finalizarVenda" type="button" class="btn btn-success btn-large">
              Finalizar Venda
            </button>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-6">
            <button @click="cancelarVenda" type="button" class="btn btn-warning text-white btn-large">
              Cancelar Venda
            </button>
          </div>
          <div class="col-6">
            <button @click="abrirModalVendas" type="button" class="btn btn-primary btn-large">
              Vendas
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
  import { Modal } from 'bootstrap';
  import axios from 'axios';
  import DebouncedCurrencyInput from "../components/DebouncedCurrencyInput.vue";
  export default {
   components: {
    DebouncedCurrencyInput
   },
   data() {
    return {
      colunas: [
        "Código",
        "Descrição",
        "Valor"
      ],
      colunasItens: [
        "Cód.",
        "Descrição",
        "Valor",
        "Qtd.",
        "V. Total",
        "Imposto",
        ""
      ],
      produtos: [],
      produtoSelecionado: {},
      produto: {
        id_produto: "",
        descricao: "",
        valor: "",
        quantidade: 1.00,
        imposto: 0
      },
      itensVenda: [],
      modalProdutos: null,
      totalImpostos: 0,
      totalCompra: 0,
      modalVendas: null,
      colunasVendas: [
        "Código",
        "Data",
        "Imposto",
        "Valor Total"
      ],
      vendas: []
    }
   },
   mounted() {
    this.modalProdutos = new Modal(document.getElementById('listagemProdutos'), {
      keyboard: false
    });

    this.modalVendas = new Modal(document.getElementById('listagemVendas'), {
      keyboard: false
    });
   },
   methods: {
    cliqueProduto(evt, produto) {
      var elements = document.getElementsByTagName("tr");
      Array.prototype.forEach.call(elements, function(element) {
        element.classList.remove("selected");
      });

      evt.target.parentNode.classList.add("selected");
      
      this.produtoSelecionado = produto;
    },
    carregaProdutos() {
      var elements = document.getElementsByTagName("tr");
      Array.prototype.forEach.call(elements, function(element) {
        element.classList.remove("selected");
      });
      this.produtoSelecionado = {};

      axios.get('http://localhost:8000/produtos')
      .then((response) => {
        this.produtos = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    },
    abrirModalProdutos() {
      var elements = document.getElementsByTagName("tr");
      Array.prototype.forEach.call(elements, function(element) {
        element.classList.remove("selected");
      });
      this.produtoSelecionado = {};

      this.carregaProdutos();

      this.modalProdutos.show();
    },
    abrirModalVendas() {
      this.carregaVendas();

      this.modalVendas.show();
    },
    setProduto() {
      this.produto = {
        id_produto: this.produtoSelecionado.id_produto,
        descricao: this.produtoSelecionado.descricao,
        valor: this.produtoSelecionado.valor,
        quantidade: 1.00,
        imposto: this.produtoSelecionado.imposto
      };

      this.modalProdutos.hide();
    },
    validaCamposItem(id_produto, quantidade) {
      let erro = "";

      if (!(id_produto > 0)) {
        erro = "Informe um produto.";
      } else if (!(quantidade > 0)) {
        erro = "Informe uma quantidade válida.";
      }

      return erro;
    },
    incluirItem() {
      let erro = this.validaCamposItem(
        this.produto.id_produto,
        this.produto.quantidade
      );

      if (erro != "") {
        alert(erro);
        return;
      }

      this.itensVenda.push(this.produto);

      this.produto = {
        id_produto: "",
        descricao: "",
        valor: "",
        quantidade: 1.00,
        imposto: 0
      }

      this.totalizaVenda();
    },
    excluirItem(index) {
      let itens = [];

      for (var i in this.itensVenda) {
        if (index != i) {
          itens.push(this.itensVenda[i])
        }
      }

      this.itensVenda = itens;

      this.totalizaVenda();
    },
    totalizaVenda() {
      let totalImpostos = 0;
      let totalProdutos = 0;

      this.itensVenda.forEach((item) => {
        totalProdutos += Number(item.quantidade) * Number(item.valor);
        totalImpostos += (Number(item.quantidade) * Number(item.valor)) * (Number(item.imposto) / 100);
      });

      this.totalImpostos = totalImpostos;
      this.totalCompra = totalProdutos + totalImpostos;
    },
    formatarValor(valor) {
      let valorFormatado = Number(valor).toLocaleString('pt-br', { maximumFractionDigits: 2, minimumFractionDigits: 2 });
      return valorFormatado;
    },
    formatarData(data) {
      data = data.substring(0, 10);

      let dataFormatada = data.split('-')[2] + "/" + data.split('-')[1] + "/" + data.split('-')[0];

      return dataFormatada;
    },
    finalizarVenda() {
      if (!(this.itensVenda.length > 0)) {
        alert("Inclua ao menos um item ao pedido.");
        return;
      }

      let body = {
        itens: this.itensVenda,
        imposto_total:  this.totalImpostos,
        valor_total:this.totalCompra

      };

      axios.post('http://localhost:8000/vendas', body)
      .then((response) => {
        console.log(response)
        alert("Venda finalizada com sucesso!");
        this.cancelarVenda();
      })
      .catch((error) => {
        console.log(error);
      });
    },
    cancelarVenda() {
      this.itensVenda = [];
      this.totalCompra = 0;
      this.totalImpostos = 0;
    },
    carregaVendas() {
      axios.get('http://localhost:8000/vendas')
      .then((response) => {
        this.vendas = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    },
   }
  }
</script>

<style scoped>
  #venda {
    margin: 5px!important;
  }

  #containerProdutos {
    background-color: rgba(145, 145, 145, 0.5);
    height: 70vh;
    overflow-x: hidden;
  }
  
  table {
    margin-top: 10px;
    margin-bottom: 10px;
    background-color: white;
  }

  #excluirItem {
    cursor: pointer;
  }

  .btn-large {
    width: 100%;
  }
</style>
