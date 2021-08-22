create database cotacaodb;

use cotacaodb;

create table transportadora(
	id int auto_increment primary key,
	nome varchar(45)
);

create table cotacao_frete(
	id int auto_increment primary key,
	uf varchar(2),
	percentual_cotacao DECIMAL(10, 2),
	valor_extra  DECIMAL(10, 2),
	transportadora_id int,

	foreign key(transportadora_id) references transportadora(id)
);

-- Popular a tabela transportadora
INSERT INTO transportadora VALUES (0,'Azul Cargo Express');
INSERT INTO transportadora VALUES (0,'TWR');
INSERT INTO transportadora VALUES (0,'Tespal');
INSERT INTO transportadora VALUES (0,'KM Trans');
