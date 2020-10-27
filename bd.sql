drop database if exists jequiti;
create database jequiti;
use jequiti;

-- tables

drop table if exists `categoria`;
create table `categoria` (
  `id` int auto_increment primary key,
  `nome` varchar(45) not null
);

drop table if exists `fornecedor`;
create table `fornecedor` (
  `id` int auto_increment primary key,
  `cnpj` varchar(45) not null,
  `razao_social` varchar(45) not null,
  `nome_fantasia` varchar(45) not null
);

drop table if exists `log`;
create table `log` (
  `id` int auto_increment primary key,
  `data` datetime not null default current_timestamp,
  `descricao` varchar(500) not null
);

drop table if exists `produto`;
create table `produto` (
  `id` int auto_increment primary key,
  `codigo_barra` varchar(100) not null,
  `nome` varchar(45) not null,
  `quantidade_estoque` int(11) not null,
  `preco_compra` double not null,
  `preco_venda` double not null,
  `volume` int(11) not null,
  `unidade_medida` varchar(45) not null,
  `categoria_id` int(11) not null,
  foreign key (`categoria_id`) references `categoria` (`id`),
  `fornecedor_id` int(11) not null,
  foreign key (`fornecedor_id`) references `fornecedor` (`id`)
);

-- triggers

drop trigger if exists `fornecedor_AFTER_INSERT`;
delimiter $$
create trigger `fornecedor_AFTER_INSERT` after insert on `fornecedor` for each row begin
	insert into `log` (descricao) values (concat(
		'insert into fornecedor', '\n',
    'cnpj: ', new.cnpj, '\n',
    'razao_social: ', new.razao_social, '\n',
    'nome_fantasia: ', new.nome_fantasia
	));
end
$$
delimiter ;

drop trigger if exists `categoria_AFTER_INSERT`;
delimiter $$
create TRIGGER `categoria_AFTER_INSERT` after insert on `categoria` for each row begin
	insert into `log` (descricao) values (concat(
		'insert into categoria', '\n',
    'nome: ', new.nome
	));
end
$$
delimiter ;

drop trigger if exists `produto_AFTER_INSERT`;
delimiter $$
create trigger `produto_AFTER_INSERT` after insert on `produto` for each row begin
	insert into `log` (descricao) values (concat(
		'insert into produto', '\n',
    'codigo_barra: ', new.codigo_barra, '\n',
    'nome: ', new.nome, '\n',
    'quantidade_estoque: ', new.quantidade_estoque, '\n',
    'preco_compra: ', new.preco_compra, '\n',
    'preco_venda: ', new.preco_venda, '\n',
    'volume: ', new.volume, '\n',
    'unidade_medida: ', new.unidade_medida, '\n',
    'categoria_id: ', new.categoria_id, '\n',
    'fornecedor_id: ', new.fornecedor_id
	));
end
$$
delimiter ;

-- view

drop view if exists `ver_produto`;
CREATE view `ver_produto` as
select
  `p`.*,
  `c`.`nome` as `categoria`,
  `f`.`cnpj` AS `cnpj`,
  `f`.`razao_social` AS `razao_social`,
  `f`.`nome_fantasia` AS `nome_fantasia`
from `produto` `p`
join `fornecedor` `f` on((`p`.`fornecedor_id` = `f`.`id`))
join `categoria` `c` on((`p`.`categoria_id` = `c`.`id`));

insert into categoria (nome) values
('Bebidas'),
('Gelados');

insert into fornecedor (cnpj, razao_social, nome_fantasia) values
('1234', 'Colca Cola', 'Colca Cola'),
('5678', 'Pepsi', 'Pepsi');

insert into produto (codigo_barra, nome, quantidade_estoque, preco_compra, preco_venda, volume, unidade_medida, categoria_id, fornecedor_id) values
('1234', 'Colca Cola', '2', '3', '4', '600', 'ml', '1', '2'),
('1234', 'Pepsi', '2', '3', '4', '600', 'ml', '1', '2');