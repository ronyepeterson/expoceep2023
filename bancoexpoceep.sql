SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `expoceep2023` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `expoceep2023`;

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `idaluno` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `idprojeto` int(11) NOT NULL,
  PRIMARY KEY (`idaluno`),
  KEY `fk_aluno_projeto1_idx` (`idprojeto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `idcurso` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`idcurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `professor`;
CREATE TABLE IF NOT EXISTS `professor` (
  `idprofessor` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `idprojeto` int(11) NOT NULL,
  PRIMARY KEY (`idprofessor`),
  KEY `fk_professor_projeto1_idx` (`idprojeto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `projeto`;
CREATE TABLE IF NOT EXISTS `projeto` (
  `idprojeto` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `modalida_proj` varchar(45) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `modalida_turno` varchar(45) NOT NULL,
  `serieturma` varchar(45) NOT NULL,
  `nome_coordenador` varchar(45) NOT NULL,
  `area_proj` varchar(45) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idcurso` int(11) NOT NULL,
  `caminhoImagemEnsalamento` varchar(60) DEFAULT NULL,
  `ensalamento` varchar(25) NOT NULL,
  PRIMARY KEY (`idprojeto`),
  KEY `fk_projeto_usuario_idx` (`idusuario`),
  KEY `fk_projeto_curso1_idx` (`idcurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(45) NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `usuario` (`idusuario`, `nome`, `login`, `senha`) VALUES
(1, 'Adminstrador', 'admin', '679ca4f2f8df0cc95d22dc7b12b74e06'),
(2, 'Ronye Peterson Cordeiro', 'ronye', '39d36fe9dbf55edd5ae74aed935be7f0');


ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_aluno_projeto1` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`idprojeto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `professor`
  ADD CONSTRAINT `fk_professor_projeto1` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`idprojeto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `projeto`
  ADD CONSTRAINT `fk_projeto_curso1` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projeto_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;
