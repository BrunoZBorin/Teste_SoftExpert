<template>
  
  <div class="produto">
    <!-- Modal -->
    <div class="modal fade" id="cadastroProduto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cadastroProdutoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="cadastroProdutoLabel">Cadastro Produto</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <label for="inputCodigo">Código</label>
                <input id="inputCodigo" type="text" class="form-control" v-model="produtoModal.id_produto" disabled>
              </div>
              <div class="col-12">
                <label for="inputDescricao">Descrição</label>
                <input id="inputDescricao" type="text" class="form-control" v-model="produtoModal.descricao">
              </div>
              <div class="col-12">
                <label for="selectTipo">Tipo</label>
                <select id="selectTipo" class="form-select" v-model="produtoModal.cod_tipo">
                  <option value="0" selected></option>
                  <option v-for="tipo in tipos" :value="tipo.id_tipo">{{ tipo.descricao }}</option>
                </select>
              </div>
              <div class="col-12">
                <label for="inputValor">Valor</label>
                <DebouncedCurrencyInput 
                  id="inputValor" 
                  class="form-control"
                  v-model="produtoModal.valor"
                  :value="produtoModal.valor"
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
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
            <button v-if="produtoModal.id_produto > 0" @click="alterarProduto" type="button" class="btn btn-success">Confirmar</button>
            <button v-else type="button" @click="incluirProduto" class="btn btn-success">Confirmar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Fim Modal -->

    <h3>Produtos</h3>

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

    <!-- Button trigger modal -->
    <button @click="abrirIncluirProduto" type="button" class="btn btn-success me-3">
      Incluir
    </button>

    <button @click="abrirAlterarProduto" type="button" class="btn btn-primary me-3">
      Alterar
    </button>

    <button @click="excluirProduto" type="button" class="btn btn-danger">
      Excluir
    </button>
  </div>
</template>

<script type="text/javascript">
  import { Modal } from 'bootstrap'
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
      produtos: [],
      produtoSelecionado: {},
      produtoModal: {
        id_produto: "",
        descricao: "",
        valor: 0.00,
        cod_tipo: 0
      },
      tipos: [],
      myModal: null
    }
   },
   mounted() {
    this.carregaProdutos();

    this.myModal = new Modal(document.getElementById('cadastroProduto'), {
      keyboard: false
    });

    this.carregaTipos();
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
    carregaTipos() {
      axios.get('http://localhost:8000/tipos')
      .then((response) => {
        this.tipos = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    },
    abrirAlterarProduto() {
      if (Object.keys(this.produtoSelecionado).length === 0) {
        alert("Selecione um produto!");
        return;
      }

      this.produtoModal = Object.assign({}, this.produtoSelecionado);

      this.myModal.show();
    },
    abrirIncluirProduto() {
      this.produtoModal = {
        id_produto: "",
        descricao: "",
        valor: 0.00,
        cod_tipo: 0
      };

      this.myModal.show();
    },
    alterarProduto() {
      let erro = this.validaCamposProduto(
        this.produtoModal.descricao,
        this.produtoModal.cod_tipo,
        this.produtoModal.valor
      );

      if (erro != "") {
        alert(erro);
        return;
      }

      axios.put('http://localhost:8000/produtos', this.produtoModal)
      .then((response) => {
        this.myModal.hide();
        alert("Produto alterado com sucesso!");
        this.carregaProdutos();
      })
      .catch((error) => {
        console.log(error);
      });
    },
    validaCamposProduto(descricao, cod_tipo, valor) {
      let erro = "";

      if (descricao.trim() == "") {
        erro = "Informe um descrição.";
      } else if (!(cod_tipo > 0)) {
        erro = "Informe um tipo.";
      } else if (
        !(valor > 0) || 
        valor == null || 
        valor == ""
      ) {
        erro = "Informe um valor.";
      }

      return erro;
    },
    incluirProduto() {
      let erro = this.validaCamposProduto(
        this.produtoModal.descricao,
        this.produtoModal.cod_tipo,
        this.produtoModal.valor
      );

      if (erro != "") {
        alert(erro);
        return;
      }

      axios.post('http://localhost:8000/produtos', this.produtoModal)
      .then((response) => {
        this.myModal.hide();
        alert("Produto incluido com sucesso!");
        this.carregaProdutos();
      })
      .catch((error) => {
        console.log(error);
      });
    },
    excluirProduto() {
      if (Object.keys(this.produtoSelecionado).length === 0) {
        alert("Selecione um produto!");
        return;
      }

      axios.delete('http://localhost:8000/produtos', { params: { id: this.produtoSelecionado.id_produto } })
      .then((response) => {
        this.myModal.hide();
        alert("Produto excluído com sucesso!");
        this.carregaProdutos();
      })
      .catch((error) => {
        console.log(error);
      });
    },
    formatarValor(valor) {
      let valorFormatado = Number(valor).toLocaleString('pt-br', { maximumFractionDigits: 2, minimumFractionDigits: 2 });
      return valorFormatado;
    },
   }
  }
</script>

<style scoped>

</style>
