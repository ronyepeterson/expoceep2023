SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS loginphp DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE loginphp;

CREATE TABLE IF NOT EXISTS cliente (
  idCliente int(11) NOT NULL AUTO_INCREMENT,
  nomeCliente varchar(200) NOT NULL,
  cpf varchar(15) NOT NULL,
  idade int(11) NOT NULL,
  endereco varchar(100) DEFAULT NULL,
  PRIMARY KEY (idCliente)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS funcionario (
  idFuncionario int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  endereco varchar(255) NOT NULL,
  salario float(15,2) NOT NULL,
  PRIMARY KEY (idFuncionario)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO funcionario (idFuncionario, nome, endereco, salario) VALUES
(1, 'Ronye Peterson Cordeiro', 'Avenida das Torres, 186', 3500.89),
(2, 'Ronye Peterson Cordeiro', 'avenida das torres', 2500.00),
(3, 'CEEP Pedro Boaretto Neto', 'conexao', 3333.00),
(6, 'JoÃ£o da Silva Sauro', 'av Brasil.', 500000.00),
(7, 'JoÃ£o da Silva Sauro', 'av Brasil.', 500000.00),
(8, 'Pedro de AlcÃ¢ntara Francisco Antonio JoÃ£o Carlos Xavier', 'av. ParanÃ¡', 25965.36),
(9, 'Pedro de AlcÃ¢ntara Francisco Antonio JoÃ£o Carlos Xavier', 'av. ParanÃ¡', 25965.36),
(10, 'IberÃª RolÃ©ver', 'av. ParanÃ¡', 25965.36),
(11, 'Andre Luiz', 'avenida Brasil, 5500', 20000.00);

CREATE TABLE IF NOT EXISTS produto (
  idProduto int(11) NOT NULL AUTO_INCREMENT,
  cod_produto int(11) NOT NULL,
  nome varchar(50) NOT NULL,
  idSubProduto int(11) NOT NULL,
  quantidade int(11) NOT NULL,
  valor_unit decimal(12,2) NOT NULL,
  PRIMARY KEY (idProduto),
  UNIQUE KEY cod_produto (cod_produto),
  KEY idSubProduto (idSubProduto)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO produto (idProduto, cod_produto, nome, idSubProduto, quantidade, valor_unit) VALUES
(1, 10, 'livro', 1, 10, '1.50'),
(2, 1, 'caderno', 1, 50, '12.00'),
(3, 12, 'caderno', 1, 100, '50.50'),
(4, 25, 'LÃ¡pis', 6, 50, '1.55'),
(5, 1256, 'caneta', 3, 123, '1.55');

CREATE TABLE IF NOT EXISTS subgrupo (
  idSubGrupo int(11) NOT NULL AUTO_INCREMENT,
  codSub int(11) NOT NULL,
  nome varchar(50) NOT NULL,
  PRIMARY KEY (idSubGrupo)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO subgrupo (idSubGrupo, codSub, nome) VALUES
(1, 10, 'vinho'),
(2, 20, 'refrigerante'),
(3, 30, 'cerveja'),
(4, 40, 'gatos'),
(5, 50, 'passaros'),
(6, 60, 'alcool'),
(7, 70, 'sabão');

CREATE TABLE IF NOT EXISTS usuario (
  idUsuario int(11) NOT NULL AUTO_INCREMENT,
  login varchar(60) NOT NULL,
  senha varchar(32) NOT NULL,
  nome varchar(100) NOT NULL,
  data_cadastro datetime NOT NULL,
  PRIMARY KEY (idUsuario)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO usuario (idUsuario, login, senha, nome, data_cadastro) VALUES
(1, 'ronye', 'e7d80ffeefa212b7c5c55700e4f7193e', 'Ronye Peterson Cordeiro', '2021-10-04 19:39:34'),
(2, 'rpc', 'e7d80ffeefa212b7c5c55700e4f7193e', 'Ronye Peterson Cordeiro', '2021-10-04 19:47:14'),
(3, 'eu', '4829322d03d1606fb09ae9af59a271d3', 'eu', '2021-10-04 19:48:45');
COMMIT;
