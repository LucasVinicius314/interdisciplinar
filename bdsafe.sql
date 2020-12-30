CREATE DATABASE jequiti;
USE jequiti;

CREATE TABLE categoria (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(45) NOT NULL
);

CREATE TABLE fornecedor (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cnpj VARCHAR(45) NOT NULL,
  razao_social VARCHAR(45) NOT NULL,
  nome_fantasia VARCHAR(45) NOT NULL
);

CREATE TABLE usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL,
  senha VARCHAR(45) NOT NULL,
  avatar VARCHAR(45) NOT NULL
);

CREATE TABLE log (
  id int AUTO_INCREMENT PRIMARY KEY,
  data DATETIME NOT NULL DEFAULT current_timestamp,
  descricao VARCHAR(500) NOT NULL
);

CREATE TABLE produto (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo_barra VARCHAR(100) NOT NULL,
  nome VARCHAR(45) NOT NULL,
  quantidae_estoque INT NOT NULL,
  preco_compra DECIMAL(10, 2) NOT NULL,
  preco_venda DECIMAL(10, 2) NOT NULL,
  volume INT NOT NULL,
  unidade_medida VARCHAR(45) NOT NULL,
  categoria_id INT NOT NULL,
  FOREIGN KEY (categoria_id) REFERENCES categoria (id),
  fornecedor_id INT NOT NULL,
  FOREIGN KEY (fornecedor_id) REFERENCES fornecedor (id)
);

CREATE TABLE compra (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo_barra VARCHAR(100) NOT NULL,
  nome VARCHAR(45) NOT NULL,
  quantidade_vendida INT NOT NULL,
  preco_venda DECIMAL(10, 2) NOT NULL,
  volume REAL NOT NULL,
  unidade_medida VARCHAR(45) NOT NULL,
  data DATETIME,
  usuario_id INT NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuario (id),
  categoria_id INT NOT NULL,
  FOREIGN KEY (categoria_id) REFERENCES categoria (id),
  fornecedor_id INT NOT NULL,
  FOREIGN KEY (fornecedor_id) REFERENCES fornecedor (id)
);

CREATE TABLE venda (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo_barra VARCHAR(100) NOT NULL,
  nome VARCHAR(45) NOT NULL,
  quantidade_comprada INT NOT NULL,
  preco_compra DECIMAL(10, 2) NOT NULL,
  volume REAL NOT NULL,
  unidade_medida VARCHAR(45) NOT NULL,
  data DATETIME,
  usuario_id INT NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuario (id),
  categoria_id INT NOT NULL,
  FOREIGN KEY (categoria_id) REFERENCES categoria (id),
  fornecedor_id INT NOT NULL,
  FOREIGN KEY (fornecedor_id) REFERENCES fornecedor (id)
);

-- triggers
/*
DROP trigger IF EXISTS `fornecedor_AFTER_INSERT`;
delimiter $$
CREATE trigger `fornecedor_AFTER_INSERT` after INSERT ON `fornecedor` for each row begin
	insert INTO `log` (descricao) VALUES (concat(
		'insert INTO fornecedor', '\n',
    'cnpj: ', new.cnpj, '\n',
    'razao_social: ', new.razao_social, '\n',
    'nome_fantasia: ', new.nome_fantasia
	));
end
$$
delimiter ;

drop trigger IF exists `categoria_AFTER_INSERT`;
delimiter $$
create TRIGGER `categoria_AFTER_INSERT` after insert on `categoria` for each row begin
	insert into `log` (descricao) values (concat(
		'insert into categoria', '\n',
    'nome: ', new.nome
	));
end
$$
delimiter ;

drop trigger IF exists `produto_AFTER_INSERT`;
delimiter $$
create trigger `produto_AFTER_INSERT` after insert on `produto` for each row begin
	insert into `log` (descricao) values (concat(
		'insert into produto', '\n',
    'codigo_barra: ', new.codigo_barra, '\n',
    'nome: ', new.nome, '\n',
    'volume: ', new.volume, '\n',
    'unidade_medida: ', new.unidade_medida, '\n',
    'categoria_id: ', new.categoria_id, '\n',
    'fornecedor_id: ', new.fornecedor_id
	));
end
$$
delimiter ;

drop trigger IF exists `transacao_AFTER_INSERT`;
delimiter $$
create trigger `transacao_AFTER_INSERT` after insert on `transacao` for each row begin
	insert into `log` (descricao) values (concat(
		'insert into transacao', '\n',
    'tipo: ', new.tipo, '\n',
    'data: ', new.data, '\n',
    'quantidade: ', new.quantidade, '\n',
    'preco: ', new.preco, '\n',
    'produto_id: ', new.produto_id, '\n',
    'usuario_id: ', new.usuario_id
	));
end
$$
delimiter ;
*/
-- views
/*
drop view IF exists `ver_produto`;
create view `ver_produto` as
select
  `p`.*,
  (coalesce((select sum(quantidade) from transacao where produto_id = `p`.id and tipo = 'compra'), 0) - coalesce((select sum(quantidade) from transacao where produto_id = `p`.id and tipo = 'venda'), 0)) as `quantidade`,
  `c`.`nome` as `categoria`,
  `f`.`cnpj` as `cnpj`,
  `f`.`razao_social` as `razao_social`,
  `f`.`nome_fantasia` as `nome_fantasia`
from `produto` `p`
join `fornecedor` `f` on((`p`.`fornecedor_id` = `f`.`id`))
join `categoria` `c` on((`p`.`categoria_id` = `c`.`id`));

drop view IF exists `ver_transacao`;
create view `ver_transacao` as
select
  `t`.*,
  `p`.`nome` as `pnome`,
  `p`.`codigo_barra`
from `transacao` `t`
join `produto` `p` on((`t`.`produto_id` = `p`.`id`));


insert into categoria (nome) values
('Bebidas'),
('Gelados');

insert into fornecedor (cnpj, razao_social, nome_fantasia) values
('1234', 'Coca Cola', 'Coca Cola'),
('5678', 'Pepsi', 'Pepsi');

insert into produto (codigo_barra, nome, volume, unidade_medida, categoria_id, fornecedor_id) values
('1234', 'Coca Cola', '600', 'ml', '1', '2'),
('1235', 'Pepsi', '600', 'ml', '1', '2');

select * from categoria;
select * from fornecedor;
select * from log;
select * from produto;
select * from transacao;
select * from ver_produto;
select * from ver_transacao;
*/