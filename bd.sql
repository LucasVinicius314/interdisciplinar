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
  `volume` int(11) not null,
  `unidade_medida` varchar(45) not null,
  `categoria_id` int(11) not null,
  foreign key (`categoria_id`) references `categoria` (`id`),
  `fornecedor_id` int(11) not null,
  foreign key (`fornecedor_id`) references `fornecedor` (`id`)
);

drop table if exists `transacao`;
create table `transacao` (
  `id` int auto_increment primary key,
  `tipo` enum('compra', 'venda') not null,
  `data` datetime not null default current_timestamp,
  `quantidade` int not null,
  `preco` double not null,
  `produto_id` int(11) not null,
  foreign key (`produto_id`) references `produto` (`id`),
  `usuario_id` int(11) not null,
  foreign key (`usuario_id`) references `usuario` (`id`)
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
    'volume: ', new.volume, '\n',
    'unidade_medida: ', new.unidade_medida, '\n',
    'categoria_id: ', new.categoria_id, '\n',
    'fornecedor_id: ', new.fornecedor_id
	));
end
$$
delimiter ;

drop trigger if exists `transacao_AFTER_INSERT`;
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

-- views

drop view if exists `ver_produto`;
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

drop view if exists `ver_transacao`;
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