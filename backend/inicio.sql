CREATE DATABASE teste_softexpert;

CREATE TABLE public.tipos (
  id_tipo integer NOT NULL,
  imposto numeric(9, 2) NULL,
  descricao character varying(255) NULL,
  PRIMARY KEY (id_tipo)
);

CREATE TABLE public.produtos (
  id_produto integer NOT NULL,
  cod_tipo integer NULL,
  descricao character varying(255) NULL,
  valor numeric(9, 2) NULL,
  PRIMARY KEY (id_produto),
  CONSTRAINT fk_cod_tipo
      FOREIGN KEY(cod_tipo) 
	  REFERENCES tipos(id_tipo)
	  ON DELETE CASCADE
);

CREATE TABLE public.vendas (
  id_venda integer NOT NULL,
  data_venda timestamp without time zone NOT NULL,
  valor_total numeric(9, 2) NULL,
  imposto_total numeric(9, 2) NULL,
  PRIMARY KEY (id_venda)
);


CREATE TABLE public.itens_venda (
  id_item_venda integer NOT NULL,
  quantidade numeric(9, 2) NULL,
  id_venda integer NULL,
  id_produto integer NULL,
  PRIMARY KEY (id_item_venda),
  CONSTRAINT fk_id_venda
      FOREIGN KEY(id_venda) 
	  REFERENCES vendas(id_venda)
	  ON DELETE CASCADE,
  CONSTRAINT fk_id_produto
      FOREIGN KEY(id_produto) 
	  REFERENCES produtos(id_produto)
	  ON DELETE CASCADE
);

