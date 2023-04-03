import{D as f,M as T,a as c}from"./DebouncedCurrencyInput-348e24f6.js";import{_ as v,r as M,o as l,c as r,a as t,w as m,v as h,e as C,F as b,d as _,t as p,p as I,f as D}from"./index-d78af730.js";const S={components:{DebouncedCurrencyInput:f},data(){return{colunas:["Código","Descrição","Imposto"],tipos:[],tipoSelecionado:{},tipoModal:{id_tipo:"",descricao:"",imposto:0},myModal:null}},mounted(){this.carregaTipos(),this.myModal=new T(document.getElementById("cadastroTipoProduto"),{keyboard:!1})},methods:{cliqueTipo(i,o){var d=document.getElementsByTagName("tr");Array.prototype.forEach.call(d,function(u){u.classList.remove("selected")}),i.target.parentNode.classList.add("selected"),this.tipoSelecionado=o},carregaTipos(){var i=document.getElementsByTagName("tr");Array.prototype.forEach.call(i,function(o){o.classList.remove("selected")}),this.tipoSelecionado={},c.get("http://localhost:8000/tipos").then(o=>{this.tipos=o.data}).catch(o=>{console.log(o)})},abrirAlterarTipo(){if(Object.keys(this.tipoSelecionado).length===0){alert("Selecione um tipo!");return}this.tipoModal=Object.assign({},this.tipoSelecionado),this.myModal.show()},abrirIncluirTipo(){this.tipoModal={id_tipo:"",descricao:"",imposto:0},this.myModal.show()},alterarTipo(){let i=this.validaCamposTipo(this.tipoModal.descricao,this.tipoModal.imposto);if(i!=""){alert(i);return}c.put("http://localhost:8000/tipos",this.tipoModal).then(o=>{this.myModal.hide(),alert("Tipo alterado com sucesso!"),this.carregaTipos()}).catch(o=>{console.log(o)})},validaCamposTipo(i,o){let d="";return i.trim()==""?d="Informe um descrição.":(!(o>=0)||o==null||o=="")&&(d="Informe um imposto."),d},incluirTipo(){let i=this.validaCamposTipo(this.tipoModal.descricao,this.tipoModal.imposto);if(i!=""){alert(i);return}c.post("http://localhost:8000/tipos",this.tipoModal).then(o=>{this.myModal.hide(),alert("Tipo incluido com sucesso!"),this.carregaTipos()}).catch(o=>{console.log(o)})},excluirTipo(){if(Object.keys(this.tipoSelecionado).length===0){alert("Selecione um tipo!");return}c.delete("http://localhost:8000/tipos",{params:{id:this.tipoSelecionado.id_tipo}}).then(i=>{this.myModal.hide(),alert("Tipo excluído com sucesso!"),this.carregaTipos()}).catch(i=>{console.log(i)})},formatarValor(i){return Number(i).toLocaleString("pt-br",{maximumFractionDigits:2,minimumFractionDigits:2})}}},n=i=>(I("data-v-6c886996"),i=i(),D(),i),k={class:"tipo-produto"},x={class:"modal fade",id:"cadastroTipoProduto","data-bs-backdrop":"static","data-bs-keyboard":"false",tabindex:"-1","aria-labelledby":"cadastroTipoProdutoLabel","aria-hidden":"true"},F={class:"modal-dialog"},V={class:"modal-content"},L=n(()=>t("div",{class:"modal-header"},[t("h1",{class:"modal-title fs-5",id:"cadastroTipoProdutoLabel"},"Cadastro Tipo Produto"),t("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"})],-1)),w={class:"modal-body"},B={class:"row"},E={class:"col-12"},N=n(()=>t("label",{for:"inputCodigo"},"Código",-1)),P={class:"col-12"},A=n(()=>t("label",{for:"inputDescricao"},"Descrição",-1)),O={class:"col-12"},j=n(()=>t("label",{for:"inputImposto"},"Imposto",-1)),U={class:"modal-footer"},q=n(()=>t("button",{type:"button",class:"btn btn-danger","data-bs-dismiss":"modal"},"Cancelar",-1)),G=n(()=>t("h3",null,"Tipos",-1)),R={id:"gridTipos",class:"table table-default border"},z={scope:"col"},H=["onClick"];function J(i,o,d,u,a,s){const y=M("DebouncedCurrencyInput");return l(),r("div",k,[t("div",x,[t("div",F,[t("div",V,[L,t("div",w,[t("div",B,[t("div",E,[N,m(t("input",{id:"inputCodigo",type:"text",class:"form-control","onUpdate:modelValue":o[0]||(o[0]=e=>a.tipoModal.id_tipo=e),disabled:""},null,512),[[h,a.tipoModal.id_tipo]])]),t("div",P,[A,m(t("input",{id:"inputDescricao",type:"text",class:"form-control","onUpdate:modelValue":o[1]||(o[1]=e=>a.tipoModal.descricao=e)},null,512),[[h,a.tipoModal.descricao]])]),t("div",O,[j,C(y,{id:"inputImposto",class:"form-control",modelValue:a.tipoModal.imposto,"onUpdate:modelValue":o[2]||(o[2]=e=>a.tipoModal.imposto=e),value:a.tipoModal.imposto,options:{currency:"BRL",currencyDisplay:"hidden",valueRange:{max:999999},precision:2,hideCurrencySymbolOnFocus:!1,hideGroupingSeparatorOnFocus:!1,hideNegligibleDecimalDigitsOnFocus:!1,autoDecimalDigits:!0,useGrouping:!0,accountingSign:!1}},null,8,["modelValue","value"])])])]),t("div",U,[q,a.tipoModal.id_tipo>0?(l(),r("button",{key:0,onClick:o[3]||(o[3]=(...e)=>s.alterarTipo&&s.alterarTipo(...e)),type:"button",class:"btn btn-success"},"Confirmar")):(l(),r("button",{key:1,type:"button",onClick:o[4]||(o[4]=(...e)=>s.incluirTipo&&s.incluirTipo(...e)),class:"btn btn-success"},"Confirmar"))])])])]),G,t("table",R,[t("thead",null,[t("tr",null,[(l(!0),r(b,null,_(a.colunas,e=>(l(),r("th",z,p(e),1))),256))])]),t("tbody",null,[(l(!0),r(b,null,_(a.tipos,e=>(l(),r("tr",{onClick:g=>s.cliqueTipo(g,e)},[t("td",null,p(e.id_tipo),1),t("td",null,p(e.descricao),1),t("td",null,p(s.formatarValor(e.imposto)),1)],8,H))),256))])]),t("button",{onClick:o[5]||(o[5]=(...e)=>s.abrirIncluirTipo&&s.abrirIncluirTipo(...e)),type:"button",class:"btn btn-success me-3"}," Incluir "),t("button",{onClick:o[6]||(o[6]=(...e)=>s.abrirAlterarTipo&&s.abrirAlterarTipo(...e)),type:"button",class:"btn btn-primary me-3"}," Alterar "),t("button",{onClick:o[7]||(o[7]=(...e)=>s.excluirTipo&&s.excluirTipo(...e)),type:"button",class:"btn btn-danger"}," Excluir ")])}const W=v(S,[["render",J],["__scopeId","data-v-6c886996"]]);export{W as default};
