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
                <input id="inputValor" @beforeinput="formatMoney($event, $el)" v-mask="'################'" type="text" class="form-control" v-model="produtoModal.valor">
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

    <table class="table border">
      <thead>
        <tr>
          <th v-for="coluna in colunas" scope="col">{{ coluna }}</th>
        </tr>
      </thead>
      <tbody>
        <tr @click="cliqueProduto($event, produto)" v-for="produto in produtos">
          <td>{{ produto.id_produto }}</td>
          <td>{{ produto.descricao }}</td>
          <td>{{ produto.valor }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Button trigger modal -->
    <button @click="abrirIncluirProduto" type="button" class="btn btn-success me-3">
      Incluir
    </button>

    <button @click="abrirAlterarProduto" type="button" class="btn btn-primary">
      Alterar
    </button>
  </div>
</template>

<script type="text/javascript">
  import { Modal } from 'bootstrap'
  import axios from 'axios';
  export default {
   components: {

   },
   data() {
    return {
      colunas: [
        "Código",
        "Descrição",
        "Valor"
      ],
      produtos: [
        {
          id_produto: 1,
          descricao: "teste",
          valor: 0.5,
          cod_tipo: 1
        },
        {
          id_produto: 2,
          descricao: "teste 2",
          valor: 343.5,
          cod_tipo: 2
        }
      ],
      produtoSelecionado: {},
      produtoModal: {
        id_produto: "",
        descricao: "",
        valor: "",
        cod_tipo: 0
      },
      tipos: [],
    }
   },
   mounted() {
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

      var myModal = new Modal(document.getElementById('cadastroProduto'), {
        keyboard: false
      });

      myModal.show();
    },
    abrirIncluirProduto() {
      this.produtoModal = {};

      var myModal = new Modal(document.getElementById('cadastroProduto'), {
        keyboard: false
      });

      myModal.show();
    },
    formatMoney(evt, el) {
      console.log(evt)
      console.log(el)
    },
    alterarProduto() {

    },
    incluirProduto() {

    }
   }
  }
</script>

<style scoped>

</style>
