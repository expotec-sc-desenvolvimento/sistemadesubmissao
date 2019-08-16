# Host: localhost  (Version 5.5.5-10.1.35-MariaDB)
# Date: 2019-08-16 19:43:13
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "area"
#

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `subAreas` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

#
# Data for table "area"
#

INSERT INTO `area` VALUES (26,'Mecanica','-'),(27,'Português','-'),(28,'Matemática','-'),(29,'Geografia','-');

#
# Structure for table "evento"
#

DROP TABLE IF EXISTS `evento`;
CREATE TABLE `evento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL DEFAULT '0',
  `periodo` varchar(255) NOT NULL,
  `inicioSubmissao` date NOT NULL DEFAULT '0000-00-00',
  `fimSubmissao` date NOT NULL DEFAULT '0000-00-00',
  `prazoFinalEnvioAvaliacaoParcial` date NOT NULL DEFAULT '0000-00-00',
  `prazoFinalEnvioSubmissaoCorrigida` date NOT NULL DEFAULT '0000-00-00',
  `prazoFinalEnvioAvaliacaoCorrigida` date NOT NULL DEFAULT '0000-00-00',
  `prazoFinalEnvioAvaliacaoFinal` date NOT NULL DEFAULT '0000-00-00',
  `distribuicaoAutomaticaAvaliadores` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

#
# Data for table "evento"
#

INSERT INTO `evento` VALUES (23,'23.jpg','EXPOTEC','Expotec','','2019-08-12','2019-09-15','2019-09-17','2019-09-20','2019-09-22','2019-09-30',0);

#
# Structure for table "areasevento"
#

DROP TABLE IF EXISTS `areasevento`;
CREATE TABLE `areasevento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idEvento` int(10) unsigned NOT NULL DEFAULT '0',
  `idArea` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `AreasEvento_Evento` (`idEvento`),
  KEY `AreasEvento_Area` (`idArea`),
  CONSTRAINT `AreasEvento_Area` FOREIGN KEY (`idArea`) REFERENCES `area` (`id`),
  CONSTRAINT `AreasEvento_Evento` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

#
# Data for table "areasevento"
#

INSERT INTO `areasevento` VALUES (23,23,26),(24,23,27),(25,23,28),(26,23,29);

#
# Structure for table "modalidade"
#

DROP TABLE IF EXISTS `modalidade`;
CREATE TABLE `modalidade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

#
# Data for table "modalidade"
#

INSERT INTO `modalidade` VALUES (31,'Apresentação Oral');

#
# Structure for table "modalidadesevento"
#

DROP TABLE IF EXISTS `modalidadesevento`;
CREATE TABLE `modalidadesevento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idEvento` int(10) unsigned NOT NULL DEFAULT '0',
  `idModalidade` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `modalidadesevento_evento` (`idEvento`),
  KEY `modalidadesevento_modalidades` (`idModalidade`),
  CONSTRAINT `modalidadesevento_evento` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`id`),
  CONSTRAINT `modalidadesevento_modalidades` FOREIGN KEY (`idModalidade`) REFERENCES `modalidade` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

#
# Data for table "modalidadesevento"
#

INSERT INTO `modalidadesevento` VALUES (32,23,31);

#
# Structure for table "perfil"
#

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# Data for table "perfil"
#

INSERT INTO `perfil` VALUES (1,'Administrador'),(2,'Participante'),(3,'Operador');

#
# Structure for table "situacaoavaliacao"
#

DROP TABLE IF EXISTS `situacaoavaliacao`;
CREATE TABLE `situacaoavaliacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

#
# Data for table "situacaoavaliacao"
#

INSERT INTO `situacaoavaliacao` VALUES (1,'Pendente'),(2,'Finalizada'),(3,'Atrasada'),(4,'Aprovado(a)'),(5,'Aprovado(a) com ressalvas'),(6,'Reprovado(a)');

#
# Structure for table "situacaosubmissao"
#

DROP TABLE IF EXISTS `situacaosubmissao`;
CREATE TABLE `situacaosubmissao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

#
# Data for table "situacaosubmissao"
#

INSERT INTO `situacaosubmissao` VALUES (1,'Submetida'),(2,'Cancelada'),(3,'Em avaliacao'),(4,'Aprovado(a)'),(5,'Aprovado(a) com ressalvas'),(6,'Reprovado(a)'),(7,'Apresentado(a)');

#
# Structure for table "tiposubmissao"
#

DROP TABLE IF EXISTS `tiposubmissao`;
CREATE TABLE `tiposubmissao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `detalhamento` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# Data for table "tiposubmissao"
#

INSERT INTO `tiposubmissao` VALUES (1,'Parcial','Versão Inicial, enviada para a primeira avaliação dos avaliadores'),(2,'Corrigida','Versão enviada após a correção pedida por algum avaliador'),(3,'Final','Versão para apresentação no Evento');

#
# Structure for table "submissao"
#

DROP TABLE IF EXISTS `submissao`;
CREATE TABLE `submissao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idEvento` int(10) unsigned NOT NULL DEFAULT '0',
  `idArea` int(10) unsigned NOT NULL DEFAULT '0',
  `idModalidade` int(10) unsigned NOT NULL DEFAULT '0',
  `idTipoSubmissao` int(10) unsigned NOT NULL DEFAULT '0',
  `idSituacaoSubmissao` int(10) unsigned NOT NULL DEFAULT '0',
  `arquivo` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL DEFAULT '',
  `resumo` varchar(255) NOT NULL DEFAULT '',
  `palavrasChave` varchar(255) NOT NULL DEFAULT '',
  `relacaoCom` varchar(255) DEFAULT NULL,
  `dataEnvio` date NOT NULL DEFAULT '0000-00-00',
  `nota` int(11) unsigned DEFAULT NULL,
  `idRelacaoComSubmissao` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Submissao_SituacaoSubmissao` (`idSituacaoSubmissao`),
  KEY `Submissao_TipoSubmissao` (`idTipoSubmissao`),
  KEY `Submissao_Area` (`idArea`),
  KEY `Submissao_Evento` (`idEvento`),
  KEY `SubmissaoFinal_SubmissaoParcial` (`idRelacaoComSubmissao`),
  KEY `Submissao_Modalidade` (`idModalidade`),
  CONSTRAINT `SubmissaoFinal_SubmissaoParcial` FOREIGN KEY (`idRelacaoComSubmissao`) REFERENCES `submissao` (`id`),
  CONSTRAINT `Submissao_Area` FOREIGN KEY (`idArea`) REFERENCES `area` (`id`),
  CONSTRAINT `Submissao_Evento` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`id`),
  CONSTRAINT `Submissao_Modalidade` FOREIGN KEY (`idModalidade`) REFERENCES `modalidade` (`id`),
  CONSTRAINT `Submissao_SituacaoSubmissao` FOREIGN KEY (`idSituacaoSubmissao`) REFERENCES `situacaosubmissao` (`id`),
  CONSTRAINT `Submissao_TipoSubmissao` FOREIGN KEY (`idtipoSubmissao`) REFERENCES `tiposubmissao` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

#
# Data for table "submissao"
#

INSERT INTO `submissao` VALUES (60,23,27,31,1,3,'EXPOTEC-Apresentação Oral-8cfad2e44a4e321-Parcial.pdf','j','j','j','-','2019-08-16',NULL,NULL),(61,23,26,31,1,3,'EXPOTEC-Apresentação Oral-7cba2685b21eee8-Parcial.pdf','h','h','h','PI','2019-08-16',NULL,NULL),(62,23,26,31,1,3,'EXPOTEC-Apresentação Oral-7bd7de8c61eb0f7-Parcial.pdf','ds','ds','sd','PI','2019-08-16',NULL,NULL),(63,23,28,31,1,3,'EXPOTEC-Apresentação Oral-4338251954b1ed8-Parcial.pdf','s','a','ds','TCC','2019-08-16',NULL,NULL),(64,23,26,31,1,3,'EXPOTEC-Apresentação Oral-9acd769d879f154-Parcial.pdf','as','as','as','-','2019-08-16',NULL,NULL),(65,23,28,31,1,3,'EXPOTEC-Apresentação Oral-a1d0e1b5b7b7595-Parcial.pdf','asd','asd','nads;dsdskl;dskldks','PI','2019-08-16',NULL,NULL),(66,23,29,31,1,3,'EXPOTEC-Apresentação Oral-fb58940add28cbd-Parcial.pdf','as','s','ds','TCC','2019-08-16',NULL,NULL),(67,23,29,31,1,3,'EXPOTEC-Apresentação Oral-11e131c63a25848-Parcial.pdf','a','a','a','TCC','2019-08-16',NULL,NULL),(68,23,27,31,1,3,'EXPOTEC-Apresentação Oral-0dd750b6a2df2fb-Parcial.pdf','as','as','dsdsds','PI','2019-08-16',NULL,NULL),(69,23,27,31,1,3,'EXPOTEC-Apresentação Oral-c804a91ff76eeb0-Parcial.pdf','as','das','Ad; ds; qwe','PI','2019-08-16',NULL,NULL);

#
# Structure for table "criterio"
#

DROP TABLE IF EXISTS `criterio`;
CREATE TABLE `criterio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idModalidade` int(10) unsigned NOT NULL DEFAULT '0',
  `idTipoSubmissao` int(10) unsigned NOT NULL DEFAULT '0',
  `descricao` varchar(255) NOT NULL,
  `peso` int(10) unsigned DEFAULT '0',
  `detalhamento` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Criterio_ModalidadeSubmissao` (`idModalidade`),
  KEY `Criterio_TipoSubmissao` (`idTipoSubmissao`),
  CONSTRAINT `Criterio_ModalidadeSubmissao` FOREIGN KEY (`idModalidade`) REFERENCES `modalidade` (`id`),
  CONSTRAINT `Criterio_TipoSubmissao` FOREIGN KEY (`idTipoSubmissao`) REFERENCES `tiposubmissao` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

#
# Data for table "criterio"
#

INSERT INTO `criterio` VALUES (19,31,1,'Criterio 1',0,'O trabalho foi satisfatório?'),(20,31,2,'Criterio 5',0,'O Trabalho foi corrigido?'),(21,31,3,'Apresentação 1',2,'Teste'),(22,31,3,'Apresentação 2',2,'d');

#
# Structure for table "tipousuario"
#

DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE `tipousuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# Data for table "tipousuario"
#

INSERT INTO `tipousuario` VALUES (1,'Aluno do IFRN'),(2,'Servidor do IFRN'),(3,'Visitante/Externo');

#
# Structure for table "usuario"
#

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPerfil` int(10) unsigned NOT NULL DEFAULT '0',
  `cpf` varchar(255) NOT NULL DEFAULT '000.000.000-00',
  `nome` varchar(255) NOT NULL,
  `sobrenome` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `dataNascimento` date NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT 'sem-email@nao-enviar.com',
  `idTipoUsuario` int(10) unsigned NOT NULL DEFAULT '0',
  `imagem` varchar(255) DEFAULT '',
  `isCredenciado` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dataCredenciamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_unico` (`cpf`) COMMENT 'Obrigatoriedade de CPF',
  UNIQUE KEY `email_unico` (`email`) COMMENT 'Obrigatoriedade de Email',
  KEY `Usuario_Perfil` (`idPerfil`),
  KEY `Usuario_TipoUsuario` (`idTipoUsuario`),
  CONSTRAINT `Usuario_Perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`id`),
  CONSTRAINT `Usuario_TipoUsuario` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tipousuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

#
# Data for table "usuario"
#

INSERT INTO `usuario` VALUES (2,1,'069.440.264-81','José Sueney','de Lima','4737bbadab50fcbf8d2acf5a6962e12b','1987-06-24','sueney.lima@ifrn.edu.br',1,'06944026481.jpg',0,NULL),(3,2,'123.456.789-00','Danilo Henrique','Macedos','827ccb0eea8a706c4c34a16891f84e7b','1987-10-10','a@g.com',1,'semFoto.jpg',0,NULL),(23,2,'069.440.264-82','Leonardo Duarte','de Albuquerque','827ccb0eea8a706c4c34a16891f84e7b','1986-06-14','leo@ifrn.br',1,'semFoto.jpg',0,NULL),(30,2,'876.537.890-65','Samira Fernandes','Delgado','827ccb0eea8a706c4c34a16891f84e7b','2017-12-12','sueney.lima@ifrn.edu',1,'semFoto.jpg',0,NULL),(31,2,'876.547.890-65','Kassimati','Maria','827ccb0eea8a706c4c34a16891f84e7b','2017-12-12','sueney.lima@ifrn.ed',1,'semFoto.jpg',0,NULL),(32,2,'876.667.840-65','Alyson Alves','de Lima','827ccb0eea8a706c4c34a16891f84e7b','2017-12-12','sueney.lima@ifrn.q',1,'semFoto.jpg',0,NULL),(33,2,'872.587.840-65','Danielle Bezerra','de Souza','26b5542258bc1994b7423fb175caf101','2017-12-12','sueney.lima@ifrn.qas',1,'semFoto.jpg',0,NULL),(34,2,'111.141.111-11','Ana Luiza','Palhano','26b5542258bc1994b7423fb175caf101','2017-12-12','sueney.lima@ifrn.br.sv',1,'semFoto.jpg',0,NULL),(35,2,'111.111.111-12','Vinicius Fernandes','Pinto','827ccb0eea8a706c4c34a16891f84e7b','2017-12-12','sueney.lima@ifrn.br.sb',1,'semFoto.jpg',0,NULL),(36,2,'111.131.111-14','Laysi Rocha','de Oliveira','827ccb0eea8a706c4c34a16891f84e7b','2017-12-12','sueney.lima@ifrn.asd',1,'semFoto.jpg',0,NULL),(37,2,'111.569.235-76','Erivan Ferreira','do Amaral','827ccb0eea8a706c4c34a16891f84e7b','2017-12-12','dado.lima@ifrn.asw',1,'semFoto.jpg',0,NULL),(38,2,'211.555.235-72','Jean Carlos Pinto','Fernandes','827ccb0eea8a706c4c34a16891f84e7b','2017-12-12','dado.lima@ifrn.as',1,'semFoto.jpg',0,NULL),(39,3,'198.723.789-98','Andreza Luna','de Brandao','827ccb0eea8a706c4c34a16891f84e7b','1989-11-11','s@iui.com',1,'semFoto.jpg',0,NULL),(41,2,'927.478.291-82','Ricardo Luiz','Cacho','827ccb0eea8a706c4c34a16891f84e7b','1989-11-11','sd@4.comcc',1,'semFoto.jpg',0,NULL),(42,2,'098.267.487-56','Joatan Fernandes','Junior','26b5542258bc1994b7423fb175caf101','1989-10-11','sasq@s.com',1,'semFoto.jpg',0,NULL),(43,2,'567.125.435-60','Adriano de Lima','Nobrega','827ccb0eea8a706c4c34a16891f84e7b','1978-07-06','etec@com.brom',1,'semFoto.jpg',0,NULL),(44,2,'239.871.253-68','Geogenes Ferreira','Pinto','4737bbadab50fcbf8d2acf5a6962e12b','1989-08-11','dsasdlkj@iico.com',1,'semFoto.jpg',0,NULL),(46,2,'222.222.222-22','Severino Zeca','Medeiros','827ccb0eea8a706c4c34a16891f84e7b','1990-11-11','a@g.c',1,'semFoto.jpg',0,NULL),(50,2,'123.123.234-56','Mirosmar Bolsista','Bodão','26b5542258bc1994b7423fb175caf101','1990-12-11','sdsds@ifrn.c',1,'semFoto.jpg',0,NULL),(67,2,'876.547.890-63','Felipe Fernandes','de Oliveira','827ccb0eea8a706c4c34a16891f84e7b','1990-11-11','dsds@dsds.com',1,'semFoto.jpg',0,NULL),(68,2,'077.669.584-30','Edwiges Pereira','do Nascimento','827ccb0eea8a706c4c34a16891f84e7b','1994-02-02','edwiges_pereira8@hotmail.com',1,'semFoto.jpg',0,NULL),(69,2,'543.039.458-42','Joao Batista','Dantinhas','827ccb0eea8a706c4c34a16891f84e7b','1989-10-11','joao.danta@ifrn.edu',2,'semFoto.jpg',0,NULL),(71,3,'738.291.823-71','Gilbran','Lopes','827ccb0eea8a706c4c34a16891f84e7b','1979-12-11','gilb.dsd@ds.co',2,'semFoto.jpg',0,NULL),(72,2,'091.283.091-28','Cristiane Maria','Nobrega','827ccb0eea8a706c4c34a16891f84e7b','1980-10-11','cristiane@ifrn.com',2,'semFoto.jpg',0,NULL),(73,1,'049.063.294-70','Lennedy','Soarea','827ccb0eea8a706c4c34a16891f84e7b','1989-10-11','lennedy.soarea@ids.ed',2,'semFoto.jpg',0,NULL);

#
# Structure for table "avaliacao"
#

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE `avaliacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idSubmissao` int(10) unsigned NOT NULL DEFAULT '0',
  `idUsuario` int(10) unsigned NOT NULL DEFAULT '0',
  `idSituacaoAvaliacao` int(10) unsigned NOT NULL DEFAULT '0',
  `nota` int(11) unsigned DEFAULT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `dataRecebimento` date NOT NULL DEFAULT '0000-00-00',
  `prazo` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Avaliacao_SituacaoAvaliacao` (`idSituacaoAvaliacao`),
  KEY `Avaliacao_Submissao` (`idSubmissao`),
  KEY `Avaliacao_Usuario` (`idUsuario`),
  CONSTRAINT `Avaliacao_SituacaoAvaliacao` FOREIGN KEY (`idSituacaoAvaliacao`) REFERENCES `situacaoavaliacao` (`id`),
  CONSTRAINT `Avaliacao_Submissao` FOREIGN KEY (`idSubmissao`) REFERENCES `submissao` (`id`),
  CONSTRAINT `Avaliacao_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=latin1;

#
# Data for table "avaliacao"
#

INSERT INTO `avaliacao` VALUES (200,60,3,1,NULL,NULL,'2019-08-16','2019-09-17'),(201,60,68,1,NULL,NULL,'2019-08-16','2019-09-17'),(202,60,2,1,NULL,NULL,'2019-08-16','2019-09-17'),(203,61,31,1,NULL,NULL,'2019-08-16','2019-09-17'),(204,61,36,1,NULL,NULL,'2019-08-16','2019-09-17'),(205,61,31,1,NULL,NULL,'2019-08-16','2019-09-17'),(206,62,30,1,NULL,NULL,'2019-08-16','2019-09-17'),(207,62,42,1,NULL,NULL,'2019-08-16','2019-09-17'),(208,62,23,1,NULL,NULL,'2019-08-16','2019-09-17'),(209,63,71,1,NULL,NULL,'2019-08-16','2019-09-17'),(210,63,2,1,NULL,NULL,'2019-08-16','2019-09-17'),(211,63,34,1,NULL,NULL,'2019-08-16','2019-09-17'),(212,64,50,1,NULL,NULL,'2019-08-16','2019-09-17'),(213,64,67,1,NULL,NULL,'2019-08-16','2019-09-17'),(214,64,44,1,NULL,NULL,'2019-08-16','2019-09-17'),(215,65,3,1,NULL,NULL,'2019-08-16','2019-09-17'),(216,65,71,1,NULL,NULL,'2019-08-16','2019-09-17'),(217,65,72,1,NULL,NULL,'2019-08-16','2019-09-17'),(218,66,23,1,NULL,NULL,'2019-08-16','2019-09-17'),(219,66,34,1,NULL,NULL,'2019-08-16','2019-09-17'),(220,66,30,1,NULL,NULL,'2019-08-16','2019-09-17'),(221,67,44,1,NULL,NULL,'2019-08-16','2019-09-17'),(222,67,23,1,NULL,NULL,'2019-08-16','2019-09-17'),(223,67,36,1,NULL,NULL,'2019-08-16','2019-09-17'),(224,68,68,1,NULL,NULL,'2019-08-16','2019-09-17'),(225,68,72,1,NULL,NULL,'2019-08-16','2019-09-17'),(226,68,42,1,NULL,NULL,'2019-08-16','2019-09-17'),(227,69,3,1,NULL,NULL,'2019-08-16','2019-09-17'),(228,69,68,1,NULL,NULL,'2019-08-16','2019-09-17'),(229,69,50,1,NULL,NULL,'2019-08-16','2019-09-17');

#
# Structure for table "avaliacaocriterio"
#

DROP TABLE IF EXISTS `avaliacaocriterio`;
CREATE TABLE `avaliacaocriterio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idAvaliacao` int(10) unsigned NOT NULL DEFAULT '0',
  `idCriterio` int(10) unsigned NOT NULL DEFAULT '0',
  `nota` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `AvaliacaoCriterio_Avaliacao` (`idAvaliacao`),
  KEY `AvaliacaoCriterio_Criterio` (`idCriterio`),
  CONSTRAINT `AvaliacaoCriterio_Avaliacao` FOREIGN KEY (`idAvaliacao`) REFERENCES `avaliacao` (`id`),
  CONSTRAINT `AvaliacaoCriterio_Criterio` FOREIGN KEY (`idCriterio`) REFERENCES `criterio` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=420 DEFAULT CHARSET=latin1;

#
# Data for table "avaliacaocriterio"
#

INSERT INTO `avaliacaocriterio` VALUES (438,200,19,NULL),(439,201,19,NULL),(440,202,19,NULL),(441,203,19,NULL),(442,204,19,NULL),(443,205,19,NULL),(444,206,19,NULL),(445,207,19,NULL),(446,208,19,NULL),(447,209,19,NULL),(448,210,19,NULL),(449,211,19,NULL),(450,212,19,NULL),(451,213,19,NULL),(452,214,19,NULL),(453,215,19,NULL),(454,216,19,NULL),(455,217,19,NULL),(456,218,19,NULL),(457,219,19,NULL),(458,220,19,NULL),(459,221,19,NULL),(460,222,19,NULL),(461,223,19,NULL),(462,224,19,NULL),(463,225,19,NULL),(464,226,19,NULL),(465,227,19,NULL),(466,228,19,NULL),(467,229,19,NULL);

#
# Structure for table "solicitacaoavaliador"
#

DROP TABLE IF EXISTS `solicitacaoavaliador`;
CREATE TABLE `solicitacaoavaliador` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL DEFAULT '0',
  `idEvento` int(10) unsigned NOT NULL DEFAULT '0',
  `idArea` int(10) unsigned NOT NULL DEFAULT '0',
  `situacao` varchar(255) NOT NULL DEFAULT 'Pendente',
  `observacao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `SolicitacaoAvaliador_Usuario` (`idUsuario`),
  KEY `SolicitacaoAvaliador_Area` (`idArea`),
  KEY `SolicitacaoAvaliador_Evento` (`idEvento`),
  CONSTRAINT `SolicitacaoAvaliador_Area` FOREIGN KEY (`idArea`) REFERENCES `area` (`id`),
  CONSTRAINT `SolicitacaoAvaliador_Evento` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`id`),
  CONSTRAINT `SolicitacaoAvaliador_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

#
# Data for table "solicitacaoavaliador"
#


#
# Structure for table "avaliador"
#

DROP TABLE IF EXISTS `avaliador`;
CREATE TABLE `avaliador` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idEvento` int(10) unsigned NOT NULL DEFAULT '0',
  `idArea` int(10) unsigned NOT NULL DEFAULT '0',
  `idUsuario` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `Avaliador_Area` (`idArea`),
  KEY `Avaliador_Usuario` (`idUsuario`),
  KEY `Avaliador_Evento` (`idEvento`),
  CONSTRAINT `Avaliador_Area` FOREIGN KEY (`idArea`) REFERENCES `area` (`id`),
  CONSTRAINT `Avaliador_Evento` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`id`),
  CONSTRAINT `Avaliador_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

#
# Data for table "avaliador"
#

INSERT INTO `avaliador` VALUES (57,23,26,31),(58,23,26,36),(60,23,27,72),(61,23,27,3),(62,23,26,42),(63,23,26,67),(64,23,26,30),(65,23,26,50),(66,23,29,34),(67,23,29,23),(68,23,29,44),(69,23,27,68),(70,23,28,71),(71,23,28,31),(72,23,28,2),(73,23,28,3);

#
# Structure for table "usuariosdasubmissao"
#

DROP TABLE IF EXISTS `usuariosdasubmissao`;
CREATE TABLE `usuariosdasubmissao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idSubmissao` int(10) unsigned NOT NULL,
  `idUsuario` int(10) unsigned NOT NULL,
  `isSubmissor` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UsuariosDaSubmissao_Submissao` (`idSubmissao`),
  KEY `UsuariosDaSubmissao_Usuario` (`idUsuario`),
  CONSTRAINT `UsuariosDaSubmissao_Submissao` FOREIGN KEY (`idSubmissao`) REFERENCES `submissao` (`id`),
  CONSTRAINT `UsuariosDaSubmissao_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

#
# Data for table "usuariosdasubmissao"
#

INSERT INTO `usuariosdasubmissao` VALUES (140,60,23,1),(141,60,30,0),(142,61,23,1),(143,61,30,0),(144,62,41,1),(145,62,44,0),(146,62,50,0),(147,62,69,0),(148,63,41,1),(149,64,41,1),(150,64,30,0),(151,65,41,1),(152,65,50,0),(153,66,41,1),(154,66,39,0),(155,67,41,1),(156,68,41,1),(157,69,41,1),(158,69,2,0);

#
# Procedure "adicionarArea"
#

DROP PROCEDURE IF EXISTS `adicionarArea`;
CREATE PROCEDURE `adicionarArea`(IN descricao varchar(255), IN subAreas varchar(255))
BEGIN

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
    INSERT
      INTO `area`
      (`descricao`, `subAreas`)
    VALUES
      (descricao, subAreas);

    SELECT 1 AS 'resposta';
  COMMIT;
END;

#
# Procedure "adicionarAreaEvento"
#

DROP PROCEDURE IF EXISTS `adicionarAreaEvento`;
CREATE PROCEDURE `adicionarAreaEvento`(IN idEvento int(11),IN areas varchar(255))
BEGIN

  DECLARE tamanho,proximo varchar(255);
  
  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    SET tamanho = CHAR_LENGTH(areas);
    SET proximo = SUBSTRING_INDEX(areas, ';', 1);
    
    WHILE CHAR_LENGTH(areas)>0 DO

      INSERT INTO areasevento (idEvento,idArea) VALUES (idEvento,proximo);
   
      
      SET areas = RIGHT(areas,tamanho-(CHAR_LENGTH(proximo)+1));
      SET tamanho = CHAR_LENGTH(areas);
      SET proximo = SUBSTRING_INDEX(areas, ';', 1);
    END WHILE;
    
    -- SE CHEGOU AQUI, TUDO OCORREU SEM ERROS
    SELECT 1 AS 'resposta';
  COMMIT;
END;

#
# Procedure "adicionarAvaliacaoCriterio"
#

DROP PROCEDURE IF EXISTS `adicionarAvaliacaoCriterio`;
CREATE PROCEDURE `adicionarAvaliacaoCriterio`(IN idAvaliacao int(11), IN idCriterio int(11))
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
    INSERT
      INTO `avaliacaocriterio`
      (`idAvaliacao`,`idCriterio`)
    VALUES
      (idAvaliacao,idCriterio);
  COMMIT;
END;

#
# Procedure "adicionarAvaliacoes"
#

DROP PROCEDURE IF EXISTS `adicionarAvaliacoes`;
CREATE PROCEDURE `adicionarAvaliacoes`(IN idSubmissao int(11), IN tipoSubmissao int(11), IN modalidadeSubmissao int(11),IN idAvaliadores char(255), IN prazo date)
BEGIN


  DECLARE novoId int(11);
  DECLARE tamanho,proximo varchar(255);

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    SET tamanho = CHAR_LENGTH(idAvaliadores);
    SET proximo = SUBSTRING_INDEX(idAvaliadores, ';', 1);


    WHILE CHAR_LENGTH(idAvaliadores)>0 DO
    
      UPDATE submissao SET `nota`='' WHERE submissao.id = idSubmissao;
      -- INSERE uma avaliacao para um avaliador, com o tipo PENDENTE
      INSERT INTO avaliacao (idSubmissao,idUsuario,idSituacaoAvaliacao,dataRecebimento,prazo) VALUES (idSubmissao,proximo,1,now(),prazo);
      -- PEGA o ID da Avaliação inserido no banco de Dados
      SELECT MAX(`id`) FROM `avaliacao` INTO novoId;    
      
      -- O bloco BEGIN-END abaixo insere na tabela avaliacaocriterio cada criterio que foi cadastrado para o tipo de submissao (Parcial/Final) e a Modalidade da Submissao
      BEGIN
        -- Iterador que percorre todos os criterios do Tipo e da Modalidade de Submissao

        DECLARE idCriterio int(11);
        DECLARE done INT DEFAULT FALSE;
        DECLARE cur1 CURSOR FOR SELECT id FROM criterio c WHERE c.idModalidade = modalidadeSubmissao AND c.idTipoSubmissao = tipoSubmissao;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;        
        
        OPEN cur1;
  
        read_loop: LOOP
          FETCH cur1 INTO idCriterio;      
          IF done THEN
            LEAVE read_loop;
          ELSE
            CALL adicionarAvaliacaoCriterio(novoId,idCriterio);
          END IF;
        END LOOP;
      END;
      
      -- Pega o proximo avaliador (se houver) para a realização das operações acima       
      SET idAvaliadores = RIGHT(idAvaliadores,tamanho-(CHAR_LENGTH(proximo)+1));
      SET tamanho = CHAR_LENGTH(idAvaliadores);
      SET proximo = SUBSTRING_INDEX(idAvaliadores, ';', 1);
    END WHILE;

    -- SE CHEGOU AQUI, TUDO OCORREU SEM ERROS
    UPDATE submissao SET idSituacaoSubmissao=3,`nota`=null WHERE submissao.id = idSubmissao;

    SELECT 1 AS 'resposta';
  COMMIT;
  
END;

#
# Procedure "adicionarAvaliacoesAutomaticas"
#

DROP PROCEDURE IF EXISTS `adicionarAvaliacoesAutomaticas`;
CREATE PROCEDURE `adicionarAvaliacoesAutomaticas`(IN idSubmissao int(11), IN idUsuario int(11), IN idSituacaoAvaliacao int(11), IN observacao varchar(255))
BEGIN

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

      INSERT INTO avaliacao (idSubmissao,idUsuario,idSituacaoAvaliacao,dataRecebimento,observacao) VALUES (idSubmissao,idUsuario,idSituacaoAvaliacao,now(),observacao);
      SELECT 1 AS 'resposta';
  COMMIT;
  
END;

#
# Procedure "adicionarAvaliador"
#

DROP PROCEDURE IF EXISTS `adicionarAvaliador`;
CREATE PROCEDURE `adicionarAvaliador`(IN idEvento int(11),IN idArea int(11),IN idUsuarios varchar(255))
BEGIN


  -- Variaveis abaixo são utilizadas apenas na segunda parte, que é a insercao dos componentes da submissao
  DECLARE tamanho,proximo varchar(255);
  DECLARE avaliadorExistente int(11) DEFAULT 0;
  
  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
  -- PRIMEIRA PARTE - Tentativa de insercao da submissao
  
    SET tamanho = CHAR_LENGTH(idUsuarios);
    SET proximo = SUBSTRING_INDEX(idUsuarios, ';', 1);

    -- SEGUNDA PARTE - Tentativa de insercao dos componentes da submissao    

    WHILE CHAR_LENGTH(idUsuarios)>0 DO
    
      SELECT COUNT(id) INTO avaliadorExistente FROM avaliador a WHERE a.idEvento = idEvento AND a.idArea = idArea AND a.idUsuario = proximo;
      
      IF (avaliadorExistente<=0) THEN
        INSERT INTO avaliador (idEvento,idArea,idUsuario) VALUES (idEvento,idArea,proximo);
      END IF;
      
      SET avaliadorExistente = 0;
      SET idUsuarios = RIGHT(idUsuarios,tamanho-(CHAR_LENGTH(proximo)+1));
      SET tamanho = CHAR_LENGTH(idUsuarios);
      SET proximo = SUBSTRING_INDEX(idUsuarios, ';', 1);
    END WHILE;
    
  
    -- SE CHEGOU AQUI, TUDO OCORREU SEM ERROS
    SELECT 1 AS 'resposta';
  COMMIT;
  
END;

#
# Procedure "adicionarCriterio"
#

DROP PROCEDURE IF EXISTS `adicionarCriterio`;
CREATE PROCEDURE `adicionarCriterio`(IN idModalidade int(11), IN idTipoSubmissao int(11), IN descricao varchar(255), IN detalhamento varchar(255), IN peso int(11))
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
  
     /* Primeiro, verificamos se já não existem submissoes já finalizadas para a modalidade e o Tipo de Critério, ou se existem
        submissoes pendentes, mas com pelo menos uma avaliação já realizada por algum usuário
     */
     
     
     
      IF (SELECT COUNT(*) FROM submissao s WHERE s.idModalidade = idModalidade AND s.idTipoSubmissao = idTipoSubmissao AND s.idSituacaoSubmissao IN (4,5))<=0  AND 
          (SELECT COUNT(*) FROM avaliacao a WHERE a.idSituacaoAvaliacao = 2 AND a.idSubmissao IN (SELECT s.id FROM submissao s WHERE s.idModalidade = idModalidade AND s.idTipoSubmissao = idTipoSubmissao))<=0 THEN
                
        BEGIN
          DECLARE idCriterio int(11);
          DECLARE idAvaliacao int(11);
          DECLARE done INT DEFAULT FALSE;
          DECLARE cur1 CURSOR FOR SELECT id FROM avaliacao a WHERE a.idSubmissao IN (SELECT s.id FROM submissao s WHERE s.idModalidade = idModalidade AND s.idTipoSubmissao = idTipoSubmissao);
          DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

          INSERT INTO `criterio` (`idModalidade`,`idTipoSubmissao`,`descricao`,`detalhamento`,`peso`) VALUES (idModalidade,idTipoSubmissao,descricao,detalhamento,peso);
          SELECT MAX(id) FROM criterio INTO idCriterio;
          
          OPEN cur1;
      
          read_loop: LOOP
            FETCH cur1 INTO idAvaliacao;      
            IF done THEN
              LEAVE read_loop;
            ELSE
              CALL adicionarAvaliacaoCriterio(idAvaliacao,idCriterio);
            END IF;
          END LOOP;
        


      /* ACRESCENTAR CÓDIGO DE QUE, CASO HAJAM AVALIAÇÕES JÁ GERADAS PARA A MODALIDADE, ACRESCEMTAR OS CRITÉRIOS A ESSAS AVALIAÇÕES*/
      
      
            SELECT 1 AS 'resposta';
          END;
      ELSE
        SELECT 'Já existem submissoes finalizadas para esta modalidade' as 'resposta';
      END IF;
  COMMIT;
END;

#
# Procedure "adicionarEvento"
#

DROP PROCEDURE IF EXISTS `adicionarEvento`;
CREATE PROCEDURE `adicionarEvento`(IN logo varchar(255), IN nome varchar(255), IN descricao varchar(255), IN inicioSubmissao date, IN fimSubmissao date,
                                                              IN prazoFinalEnvioAvaliacaoParcial date, IN prazoFinalEnvioSubmissaoCorrigida date, IN prazoFinalEnvioAvaliacaoCorrigida date, 
                                                              IN prazoFinalEnvioAvaliacaoFinal date, IN distribuicaoAutomaticaAvaliadores int(11))
BEGIN


  DECLARE novoId int(11);
  DECLARE novoNome varchar(255);

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
    INSERT
      INTO `evento`
      (`logo`,`nome`,`descricao`,`inicioSubmissao`,`fimSubmissao`,`prazoFinalEnvioAvaliacaoParcial`,`prazoFinalEnvioSubmissaoCorrigida`,
       `prazoFinalEnvioAvaliacaoCorrigida`,`prazoFinalEnvioAvaliacaoFinal`,`distribuicaoAutomaticaAvaliadores`)
    VALUES
      (logo,nome,descricao,inicioSubmissao,fimSubmissao,prazoFinalEnvioAvaliacaoParcial,prazoFinalEnvioSubmissaoCorrigida,prazoFinalEnvioAvaliacaoCorrigida,
       prazoFinalEnvioAvaliacaoFinal,distribuicaoAutomaticaAvaliadores);
 
    SELECT 1 AS 'resposta';
  COMMIT;
END;

#
# Procedure "adicionarModalidade"
#

DROP PROCEDURE IF EXISTS `adicionarModalidade`;
CREATE PROCEDURE `adicionarModalidade`(IN descricao varchar(255))
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
    INSERT
      INTO `modalidade`
      (`descricao`)
    VALUES
      (descricao);
  
    SELECT 1 AS 'resposta';
  COMMIT;
END;

#
# Procedure "adicionarModalidadeEvento"
#

DROP PROCEDURE IF EXISTS `adicionarModalidadeEvento`;
CREATE PROCEDURE `adicionarModalidadeEvento`(IN idEvento int(11),IN modalidades varchar(255))
BEGIN

  DECLARE tamanho,proximo varchar(255);
  
  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    SET tamanho = CHAR_LENGTH(modalidades);
    SET proximo = SUBSTRING_INDEX(modalidades, ';', 1);
    
    WHILE CHAR_LENGTH(modalidades)>0 DO

      INSERT INTO modalidadesevento (idEvento,idModalidade) VALUES (idEvento,proximo);
   
      
      SET modalidades = RIGHT(modalidades,tamanho-(CHAR_LENGTH(proximo)+1));
      SET tamanho = CHAR_LENGTH(modalidades);
      SET proximo = SUBSTRING_INDEX(modalidades, ';', 1);
    END WHILE;
    
    -- SE CHEGOU AQUI, TUDO OCORREU SEM ERROS
    SELECT 1 AS 'resposta';
  COMMIT;
END;

#
# Procedure "adicionarSolicitacaoAvaliador"
#

DROP PROCEDURE IF EXISTS `adicionarSolicitacaoAvaliador`;
CREATE PROCEDURE `adicionarSolicitacaoAvaliador`(IN idUsuario int(11), IN idEvento int(11), IN idArea int(11))
BEGIN



  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
    INSERT
      INTO `solicitacaoavaliador`
      (`idUsuario`,`idEvento`,`idArea`)
    VALUES
      (idUsuario,idEvento,idArea);
    SELECT 1 AS 'resposta';
  COMMIT;
END;

#
# Procedure "adicionarSubmissao"
#

DROP PROCEDURE IF EXISTS `adicionarSubmissao`;
CREATE PROCEDURE `adicionarSubmissao`(IN idEvento int(11),IN idArea int(11),IN idModalidade int(11),IN idTipoSubmissao int(11),IN idSituacaoSubmissao int(11),IN arquivo varchar(255),
                                                                 IN titulo varchar(255),IN resumo varchar(255),IN palavrasChave varchar(255),IN relacaoCom varchar(255),
                                                                 IN componentes varchar(255),IN idRelacaoComSubmissao int(11))
BEGIN


  DECLARE novoId int(11);

  -- Variaveis abaixo são utilizadas apenas na segunda parte, que é a insercao dos componentes da submissao
  DECLARE tamanho,proximo varchar(255);
  DECLARE submissor int(10);


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
  -- PRIMEIRA PARTE - Tentativa de insercao da submissao
  
    IF idRelacaoComSubmissao!='' THEN
      INSERT
        INTO `submissao`
        (`idEvento`,`idArea`,`idModalidade`,`idTipoSubmissao`,`idSituacaoSubmissao`,`arquivo`,`titulo`,`resumo`,`palavrasChave`,`relacaoCom`,`dataEnvio`,`idRelacaoComSubmissao`)
      VALUES
        (idEvento,idArea,idModalidade,idTipoSubmissao,idSituacaoSubmissao,arquivo,titulo,resumo,palavrasChave,relacaoCom,now(),idRelacaoComSubmissao);
      SELECT MAX(`id`) FROM `submissao` INTO novoId;
    ELSE
      INSERT
        INTO `submissao`
        (`idEvento`,`idArea`,`idModalidade`,`idTipoSubmissao`,`idSituacaoSubmissao`,`arquivo`,`titulo`,`resumo`,`palavrasChave`,`relacaoCom`,`dataEnvio`)
      VALUES
        (idEvento,idArea,idModalidade,idTipoSubmissao,idSituacaoSubmissao,arquivo,titulo,resumo,palavrasChave,relacaoCom,now());
      SELECT MAX(`id`) FROM `submissao` INTO novoId;    
    END IF;
    
    -- SEGUNDA PARTE - Tentativa de insercao dos componentes da submissao    
    SET tamanho = CHAR_LENGTH(componentes);
    SET proximo = SUBSTRING_INDEX(componentes, ';', 1);
    SET submissor = 1;

    WHILE CHAR_LENGTH(componentes)>0 DO
      IF submissor=1 THEN -- O primeiro componente da lista é sempre o submissor do trabalho, que terá a possibilidade de apagá-lo e excluir todos os outros componentes;
        INSERT INTO usuariosdasubmissao (idSubmissao,idUsuario,isSubmissor) VALUES (novoId,proximo,1);
        SET submissor=0;
      ELSE
        INSERT INTO usuariosdasubmissao (idSubmissao,idUsuario,isSubmissor) VALUES (novoId,proximo,0);
      END IF;
   
      
      SET componentes = RIGHT(componentes,tamanho-(CHAR_LENGTH(proximo)+1));
      SET tamanho = CHAR_LENGTH(componentes);
      SET proximo = SUBSTRING_INDEX(componentes, ';', 1);
    END WHILE;
    
  
    -- SE CHEGOU AQUI, TUDO OCORREU SEM ERROS

    SELECT 1 AS 'resposta';
  COMMIT;
  
END;

#
# Procedure "adicionarUsuario"
#

DROP PROCEDURE IF EXISTS `adicionarUsuario`;
CREATE PROCEDURE `adicionarUsuario`(IN idPerfil int(11), IN cpf varchar(14), IN nome varchar(255), IN sobrenome varchar(255), IN senha varchar(255),
                                                                   IN dataNascimento date, IN email varchar(255), IN tipoUsuario int(11),IN foto varchar(255))
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
    INSERT
      INTO `usuario`
      (`idPerfil`,`cpf`,`nome`, `sobrenome`,`senha`,`dataNascimento`,`email`,`idTipoUsuario`,`imagem`)
    VALUES
      (idPerfil,cpf,nome,sobrenome,senha,dataNascimento,email,tipoUsuario,foto);
   
    
    SELECT 1 AS 'resposta';
  COMMIT;
END;

#
# Procedure "adicionarUsuariosDaSubmissao"
#

DROP PROCEDURE IF EXISTS `adicionarUsuariosDaSubmissao`;
CREATE PROCEDURE `adicionarUsuariosDaSubmissao`(IN idSubmissao int(11), IN idUsuario int(11), IN isSubmissor int(1))
BEGIN

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
    INSERT
      INTO `usuariosdasubmissao`
      (`idSubmissao`,`idUsuario`, `isSubmissor`)
    VALUES
      (idSubmissao,idUsuario, isSubmissor);

    SELECT 1 AS 'resposta';
  COMMIT;
END;

#
# Procedure "atualizarArea"
#

DROP PROCEDURE IF EXISTS `atualizarArea`;
CREATE PROCEDURE `atualizarArea`(in id int(11), in descricao varchar(255), in subAreas varchar(255))
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
  
    UPDATE area SET `descricao`=descricao, `subAreas`=subAreas WHERE area.id=id;
    SELECT 1 as 'resposta';
  commit;
END;

#
# Procedure "atualizarAvaliacao"
#

DROP PROCEDURE IF EXISTS `atualizarAvaliacao`;
CREATE PROCEDURE `atualizarAvaliacao`(in id int(11), in idUsuario int(11), in idSituacaoAvaliacao int(11), in prazo date)
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
  
    UPDATE avaliacao SET `idUsuario`=idUsuario, `idSituacaoAvaliacao`=idSituacaoAvaliacao, `prazo`=prazo WHERE avaliacao.id=id;
    SELECT 1 as 'resposta';
  commit;
END;

#
# Procedure "atualizarAvaliacaoCriterio"
#

DROP PROCEDURE IF EXISTS `atualizarAvaliacaoCriterio`;
CREATE PROCEDURE `atualizarAvaliacaoCriterio`(IN id int(11), IN nota int(11))
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    UPDATE avaliacaocriterio SET `nota`=nota WHERE avaliacaocriterio.id=id;

  COMMIT;


END;

#
# Procedure "atualizarCriterio"
#

DROP PROCEDURE IF EXISTS `atualizarCriterio`;
CREATE PROCEDURE `atualizarCriterio`(in id int(11), in descricao varchar(255),in detalhamento varchar(255),IN peso int(11))
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    -- Para atualizar um critério, é preciso que nenhuam avaliação para o tal critério tenha sido realizada!
    IF (SELECT COUNT(*) FROM avaliacaocriterio ac WHERE ac.idCriterio = id AND ISNULL(nota))<=0 THEN
      UPDATE criterio SET `descricao`=descricao, `detalhamento`=detalhamento, `peso`=peso WHERE criterio.id=id;
      SELECT 1 as resposta;
    ELSE
      SELECT 0 as resposta;
    END IF;
    
  COMMIT;


END;

#
# Procedure "atualizarEvento"
#

DROP PROCEDURE IF EXISTS `atualizarEvento`;
CREATE PROCEDURE `atualizarEvento`(in id int(11), logo varchar(255), IN nome varchar(255), IN descricao varchar(255), IN inicioSubmissao date, IN fimSubmissao date,
                                                              IN prazoFinalEnvioAvaliacaoParcial date, IN prazoFinalEnvioSubmissaoCorrigida date, IN prazoFinalEnvioAvaliacaoCorrigida date, 
                                                              IN prazoFinalEnvioAvaliacaoFinal date, IN distribuicaoAutomaticaAvaliadores int(11))
BEGIN

DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    IF logo = -1 THEN
      UPDATE evento SET `nome`=nome, `descricao`=descricao, `inicioSubmissao`=inicioSubmissao, `fimSubmissao`=fimSubmissao, `prazoFinalEnvioAvaliacaoParcial`=prazoFinalEnvioAvaliacaoParcial,
                        `prazoFinalEnvioSubmissaoCorrigida`=prazoFinalEnvioSubmissaoCorrigida, `prazoFinalEnvioAvaliacaoCorrigida`=prazoFinalEnvioAvaliacaoCorrigida, 
                        `prazoFinalEnvioAvaliacaoFinal`=prazoFinalEnvioAvaliacaoFinal, `distribuicaoAutomaticaAvaliadores`=distribuicaoAutomaticaAvaliadores WHERE evento.id=id;
    ELSE
      UPDATE evento SET `logo`=logo, `nome`=nome, `descricao`=descricao, `inicioSubmissao`=inicioSubmissao, `fimSubmissao`=fimSubmissao, `prazoFinalEnvioAvaliacaoParcial`=prazoFinalEnvioAvaliacaoParcial,
                        `prazoFinalEnvioSubmissaoCorrigida`=prazoFinalEnvioSubmissaoCorrigida, `prazoFinalEnvioAvaliacaoCorrigida`=prazoFinalEnvioAvaliacaoCorrigida, 
                        `prazoFinalEnvioAvaliacaoFinal`=prazoFinalEnvioAvaliacaoFinal, `distribuicaoAutomaticaAvaliadores`=distribuicaoAutomaticaAvaliadores WHERE evento.id=id;
    END IF;

    SELECT 1 as 'resposta';
  COMMIT;
END;

#
# Procedure "atualizarModalidade"
#

DROP PROCEDURE IF EXISTS `atualizarModalidade`;
CREATE PROCEDURE `atualizarModalidade`(in id int(11), in descricao varchar(255))
BEGIN

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    UPDATE modalidade SET `descricao`=descricao WHERE modalidade.id=id;

    SELECT 1 as 'resposta';
  COMMIT;

END;

#
# Procedure "atualizarSenha"
#

DROP PROCEDURE IF EXISTS `atualizarSenha`;
CREATE PROCEDURE `atualizarSenha`(IN idUser int, IN SenhaAntiga varchar(250), IN SenhaNova varchar(250))
BEGIN
  DECLARE senhaAntigaCorreta int DEFAULT 0;
  
  SELECT COUNT(`id`) INTO senhaAntigaCorreta FROM `usuario` WHERE `id` = idUser AND `senha` = SenhaAntiga;

  IF senhaAntigaCorreta = 1 THEN
    
    UPDATE `usuario` SET `senha` = SenhaNova WHERE `id` = idUser;
    SELECT 1 AS 'resposta';
  ELSE
    SELECT 0 AS 'resposta';
  END IF;
END;

#
# Procedure "atualizarSituacaoAvaliacoes"
#

DROP PROCEDURE IF EXISTS `atualizarSituacaoAvaliacoes`;
CREATE PROCEDURE `atualizarSituacaoAvaliacoes`()
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    /* Atualização de Avaliações Parciais atrasadas e com novos prazos */
    UPDATE avaliacao a SET idSituacaoAvaliacao=3 WHERE idSituacaoAvaliacao=1 AND now() > prazo;
    UPDATE avaliacao a SET idSituacaoAvaliacao=1 WHERE idSituacaoAvaliacao=3 AND now() <= prazo;
    
    
    SELECT 1 as resposta;

  COMMIT;


END;

#
# Procedure "atualizarSolicitacaoAvaliador"
#

DROP PROCEDURE IF EXISTS `atualizarSolicitacaoAvaliador`;
CREATE PROCEDURE `atualizarSolicitacaoAvaliador`(in id int(11), in idUsuario int(11), in idEvento int(11), in idArea int(11),
                                                                            in situacao varchar(255), in observacao varchar(255))
BEGIN


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    UPDATE solicitacaoavaliador SET `situacao`=situacao, `observacao`=observacao WHERE solicitacaoavaliador.id=id;
    
    IF situacao = 'Deferida' THEN
      SET idUsuario = CONCAT(idUsuario,';');
      CALL adicionarAvaliador(idEvento,idArea,idUsuario);  
    END IF;
    SELECT 1 as resposta;

  COMMIT;


END;

#
# Procedure "atualizarSubmissao"
#

DROP PROCEDURE IF EXISTS `atualizarSubmissao`;
CREATE PROCEDURE `atualizarSubmissao`(IN idSubmissao int(11), IN idEvento int(11),IN idArea int(11),IN idModalidade int(11),IN idTipoSubmissao int(11),
                                                                 IN idSituacaoSubmissao int(11),IN arquivo varchar(255), IN titulo varchar(255),IN resumo varchar(255),
                                                                 IN palavrasChave varchar(255),IN relacaoCom varchar(255), IN componentes varchar(255),IN idRelacaoComSubmissao int(11))
BEGIN


  -- Variaveis abaixo são utilizadas apenas na segunda parte, que é a insercao dos componentes da submissao
  DECLARE tamanho,proximo varchar(255);
  DECLARE submissor int(10);


  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
  -- PRIMEIRA PARTE - Apaga todos os usuarios da submissao para inseri-los novamente
  
    DELETE FROM usuariosdasubmissao WHERE usuariosdasubmissao.idSubmissao = idSubmissao;
    
    IF idRelacaoComSubmissao='' THEN
    
      UPDATE `submissao` 
      SET
        `idEvento`=idEvento,`idArea`=idArea,`idModalidade`=idModalidade,`idTipoSubmissao`=idTipoSubmissao,`idSituacaoSubmissao`=idSituacaoSubmissao,
        `arquivo`=arquivo,`titulo`=titulo,`resumo`=resumo,`palavrasChave`=palavrasChave,`relacaoCom`=relacaoCom
      WHERE submissao.id = idSubmissao;  
    ELSE
      UPDATE `submissao` 
      SET
        `idEvento`=idEvento,`idArea`=idArea,`idModalidade`=idModalidade,`idTipoSubmissao`=idTipoSubmissao,`idSituacaoSubmissao`=idSituacaoSubmissao,
        `arquivo`=arquivo,`titulo`=titulo,`resumo`=resumo,`palavrasChave`=palavrasChave,`relacaoCom`=relacaoCom,`idRelacaoComSubmissao`=idRelacaoComSubmissao
      WHERE submissao.id = idSubmissao;  
    END IF;


    -- SEGUNDA PARTE - Tentativa de insercao dos componentes da submissao    
    SET tamanho = CHAR_LENGTH(componentes);
    SET proximo = SUBSTRING_INDEX(componentes, ';', 1);
    SET submissor = 1;

    WHILE CHAR_LENGTH(componentes)>0 DO
      IF submissor=1 THEN -- O primeiro componente da lista é sempre o submissor do trabalho, que terá a possibilidade de apagá-lo e excluir todos os outros componentes;
        INSERT INTO usuariosdasubmissao (idSubmissao,idUsuario,isSubmissor) VALUES (idSubmissao,proximo,1);
        SET submissor=0;
      ELSE
        INSERT INTO usuariosdasubmissao (idSubmissao,idUsuario,isSubmissor) VALUES (idSubmissao,proximo,0);
      END IF;
   
      
      SET componentes = RIGHT(componentes,tamanho-(CHAR_LENGTH(proximo)+1));
      SET tamanho = CHAR_LENGTH(componentes);
      SET proximo = SUBSTRING_INDEX(componentes, ';', 1);
    END WHILE;
    
  
    -- SE CHEGOU AQUI, TUDO OCORREU SEM ERROS
    SELECT 1 AS 'resposta';
  COMMIT;
  
END;

#
# Procedure "atualizarUsuario"
#

DROP PROCEDURE IF EXISTS `atualizarUsuario`;
CREATE PROCEDURE `atualizarUsuario`(in idUser int(11), in idPerfil int(11), in pCpf varchar(14), in pNome varchar(255), in pSobrenome varchar(255), in pDataNascimento varchar(255), 
                                                              in pEmail varchar(255),in tipoUsuario int(11))
BEGIN

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

     UPDATE usuario SET `idPerfil`=idPerfil, 
                        `cpf`=pCpf, `nome`=pNome,
                        `sobreNome`=pSobrenome, 
                        `dataNascimento`=pDataNascimento, 
                        `email`=pEmail, `idTipoUsuario`=tipoUsuario
                    WHERE 
                        `id`=idUser;

    SELECT 1 as resposta;

   COMMIT;
END;

#
# Procedure "cancelarSubmissao"
#

DROP PROCEDURE IF EXISTS `cancelarSubmissao`;
CREATE PROCEDURE `cancelarSubmissao`(in idSubmissao int(11))
BEGIN

  DECLARE idCancelada int(11);

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
    
    SELECT id INTO idCancelada FROM situacaosubmissao s WHERE s.descricao = 'Cancelada';
    UPDATE submissao SET `idSituacaoSubmissao`=idCancelada WHERE submissao.id=idSubmissao;
    
    SELECT 1 as 'resposta';
  commit;
END;

#
# Procedure "existeSubmissaoCorrigida"
#

DROP PROCEDURE IF EXISTS `existeSubmissaoCorrigida`;
CREATE PROCEDURE `existeSubmissaoCorrigida`(IN idSubmissaoParcial int(11))
BEGIN
  DECLARE qtde int(11);
  
  SELECT COUNT(id) INTO qtde FROM submissao s WHERE s.idRelacaoComSubmissao = idSubmissaoParcial;
  
  IF qtde>0 THEN SELECT 1 as 'resposta';
  ELSE SELECT 0 as 'resposta';
  END IF;

END;

#
# Procedure "finalizarSubmissao"
#

DROP PROCEDURE IF EXISTS `finalizarSubmissao`;
CREATE PROCEDURE `finalizarSubmissao`(in id int(11), in idSituacaoSubmissao int(11))
BEGIN

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    UPDATE submissao SET `idSituacaoSubmissao`=idSituacaoSubmissao WHERE submissao.id=id;

    SELECT 1 as 'resposta';
  COMMIT;

END;

#
# Procedure "listaAreaEventoComFiltro"
#

DROP PROCEDURE IF EXISTS `listaAreaEventoComFiltro`;
CREATE PROCEDURE `listaAreaEventoComFiltro`(in idArea int(11), in idEvento int(11))
BEGIN

  DECLARE flag varchar(255);
  SET @consulta  = CONCAT('SELECT * FROM areasevento a ');
  SET flag = 'WHERE';
  
  IF idArea != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' a.idArea=', idArea);
    SET flag = ' AND';
  END IF;
  
  IF idEvento != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' a.idEvento=', idEvento);
  END IF;

  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;

  
  
END;

#
# Procedure "listaAreasPorEvento"
#

DROP PROCEDURE IF EXISTS `listaAreasPorEvento`;
CREATE PROCEDURE `listaAreasPorEvento`(IN idEvento int(11))
BEGIN

   SELECT a.id,a.descricao,a.subAreas from area a, areasevento ae WHERE ae.idEvento = idEvento AND ae.idArea = a.id;
  
END;

#
# Procedure "listaAvaliacoesComFiltro"
#

DROP PROCEDURE IF EXISTS `listaAvaliacoesComFiltro`;
CREATE PROCEDURE `listaAvaliacoesComFiltro`(IN idUsuario int(11), IN idSubmissao int(11), IN idSituacao int(11))
BEGIN


  DECLARE flag varchar(255);
  SET @consulta = 'SELECT av.* FROM avaliacao av ';
  SET flag = ' WHERE';

  IF idUsuario != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' av.idUsuario=', idUsuario);
    SET flag = ' AND';
  END IF;
  
  IF idSubmissao != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' av.idSubmissao=', idSubmissao);
    SET flag = ' AND';
  END IF;

  IF idSituacao != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' av.idSituacaoAvaliacao=', idSituacao);
  END IF;
  

  
  
  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
END;

#
# Procedure "listaAvaliadoresComFiltro"
#

DROP PROCEDURE IF EXISTS `listaAvaliadoresComFiltro`;
CREATE PROCEDURE `listaAvaliadoresComFiltro`(in idEvento int(11),in idArea int(11), in idUsuario int(11), in tipo varchar(255))
BEGIN

  DECLARE flag varchar(255);
  SET @consulta  = CONCAT('SELECT * FROM avaliador a');
  SET flag = ' WHERE';
  
  IF idEvento != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' a.idEvento=', idEvento);
    SET flag = ' AND';
  END IF;
  
  IF idArea != '' THEN
    IF tipo = "area" THEN
      SET @consulta = CONCAT(@consulta,flag,' a.idArea=', idArea);
    ELSE
      SET @consulta = CONCAT(@consulta,flag,' a.idArea!=', idArea);
    END IF;
    SET flag = ' AND';
  END IF;
  
  IF idUsuario != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' a.idUsuario=', idUsuario);
  END IF;
  
  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;

  
  
END;

#
# Procedure "listaAvaliadoresParaCadastro"
#

DROP PROCEDURE IF EXISTS `listaAvaliadoresParaCadastro`;
CREATE PROCEDURE `listaAvaliadoresParaCadastro`(IN idEvento int(11), IN idArea int (11), IN tipo char(255), IN limite int(11), IN idSubmissao int(11))
BEGIN

    DECLARE tipoAvaliacao int(11);
    SELECT s.idTipoSubmissao INTO tipoAvaliacao FROM submissao s WHERE s.id = idSubmissao;

    IF tipo = 'mesma-area' THEN
        SELECT u.* FROM usuario u
        WHERE 
             u.id IN (SELECT a.idUsuario FROM avaliador a WHERE a.idEvento = idEvento AND a.idArea=idArea) AND
             u.id NOT IN (SELECT us.idUsuario FROM submissao s, usuariosdasubmissao us WHERE us.idSubmissao = s.id AND s.id = idSubmissao)
        ORDER BY (SELECT COUNT(*) FROM avaliacao a, submissao s WHERE a.idUsuario = u.id AND a.idSubmissao = s.id AND s.idTipoSubmissao=tipoAvaliacao),id
        LIMIT limite;
    ELSE
        SELECT u.* FROM usuario u
        WHERE 
             u.id IN (SELECT a.idUsuario FROM avaliador a WHERE a.idEvento = idEvento AND a.idArea!=idArea) AND
             u.id NOT IN (SELECT us.idUsuario FROM submissao s, usuariosdasubmissao us WHERE us.idSubmissao = s.id AND s.id = idSubmissao)
        ORDER BY (SELECT COUNT(*) FROM avaliacao a, submissao s WHERE a.idUsuario = u.id AND a.idSubmissao = s.id AND s.idTipoSubmissao=tipoAvaliacao),id
        LIMIT limite;
    END IF;      
END;

#
# Procedure "listaCriteriosComFiltro"
#

DROP PROCEDURE IF EXISTS `listaCriteriosComFiltro`;
CREATE PROCEDURE `listaCriteriosComFiltro`(IN idModalidade int(11), IN idTipoSubmissao int(11))
BEGIN


  DECLARE flag varchar(255);
  SET @consulta = 'SELECT * from criterio c ';
  SET flag = ' WHERE';

  IF idModalidade != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' c.idModalidade=', idModalidade);
    SET flag = ' AND';
  END IF;
  
  IF idTipoSubmissao != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' c.idTipoSubmissao=', idTipoSubmissao);
  END IF;
  
  
  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
END;

#
# Procedure "listaItens"
#

DROP PROCEDURE IF EXISTS `listaItens`;
CREATE PROCEDURE `listaItens`(in item varchar(255))
BEGIN

 DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
  
    CASE item
      WHEN "area" THEN SELECT * from area;
      WHEN "areasevento" THEN SELECT * from areasevento;
      WHEN "avaliador" THEN SELECT * FROM avaliador;
      WHEN "avaliacao" THEN SELECT * FROM avaliacao;
      WHEN "criterio" THEN SELECT * FROM criterio;
      WHEN "download" THEN SELECT * FROM download;
      WHEN "evento" THEN SELECT * FROM evento;
      WHEN "modalidade" THEN SELECT * FROM modalidade;
      WHEN "modalidadesevento" THEN SELECT * FROM modalidadesevento;
      WHEN "noticia" THEN SELECT * FROM noticia;
      WHEN "perfil" THEN SELECT * FROM perfil;
      WHEN "prazosevento" THEN SELECT * FROM prazosevento;
      WHEN "situacaoavaliacao" THEN SELECT * FROM situacaoavaliacao;
      WHEN "situacaosubmissao" THEN SELECT * FROM situacaosubmissao;
      WHEN "solicitacaoavaliador" THEN SELECT * FROM solicitacaoavaliador;
      WHEN "submissao" THEN SELECT * FROM submissao;
      WHEN "tipoprazo" THEN SELECT * FROM tipoprazo;
      WHEN "tiposubmissao" THEN SELECT * FROM tiposubmissao;
      WHEN "tipousuario" THEN SELECT * FROM tipousuario;
      WHEN "usuario" THEN SELECT * FROM usuario;
      WHEN "usuariosdasubmissao" THEN SELECT * FROM usuariosdasubmissao;
      

    END CASE;
    
  COMMIT;

END;

#
# Procedure "listaModalidadeEventoComFiltro"
#

DROP PROCEDURE IF EXISTS `listaModalidadeEventoComFiltro`;
CREATE PROCEDURE `listaModalidadeEventoComFiltro`(in idModalidade int(11), in idEvento int(11))
BEGIN

  DECLARE flag varchar(255);
  SET @consulta  = CONCAT('SELECT * FROM modalidadesevento m ');
  SET flag = 'WHERE';
  
  IF idModalidade != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' m.idModalidade=', idModalidade);
    SET flag = ' AND';
  END IF;
  
  IF idEvento != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' m.idEvento=', idEvento);
  END IF;

  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;

  
  
END;

#
# Procedure "listaModalidadesPorEvento"
#

DROP PROCEDURE IF EXISTS `listaModalidadesPorEvento`;
CREATE PROCEDURE `listaModalidadesPorEvento`(IN idEvento int(11))
BEGIN

   SELECT m.id,m.descricao from modalidade m, modalidadesevento me WHERE m.id = me.idModalidade AND me.idEvento=idEvento;
  
END;

#
# Procedure "listaPrazosComFiltro"
#

DROP PROCEDURE IF EXISTS `listaPrazosComFiltro`;
CREATE PROCEDURE `listaPrazosComFiltro`(IN idPrazoEvento int(11), IN idEntidade int(11))
BEGIN


  DECLARE flag varchar(255);
  SET @consulta = 'SELECT p.* FROM prazo p ';
  SET flag = ' WHERE';

  IF idEvento != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' p.idPrazoEvento=', idPrazoEvento);
    SET flag = ' AND';
  END IF;

  IF idTipoSubmissao != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' p.idEntidade=', idEntidade);
  END IF;
  

  
  
  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
END;

#
# Procedure "listaPrazosEventoComFiltro"
#

DROP PROCEDURE IF EXISTS `listaPrazosEventoComFiltro`;
CREATE PROCEDURE `listaPrazosEventoComFiltro`(IN idEvento int(11), IN idTipoPrazo int(11))
BEGIN


  DECLARE flag varchar(255);
  SET @consulta = 'SELECT pe.* FROM prazosevento pe ';
  SET flag = ' WHERE';

  IF idEvento != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' pe.idEvento=', idEvento);
    SET flag = ' AND';
  END IF;

  IF idTipoPrazo != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' pe.idTipoPrazo=', idTipoPrazo);
    SET flag = ' AND';
  END IF;  
  
  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
END;

#
# Procedure "listaSolicitacaoAvaliadorComFiltro"
#

DROP PROCEDURE IF EXISTS `listaSolicitacaoAvaliadorComFiltro`;
CREATE PROCEDURE `listaSolicitacaoAvaliadorComFiltro`(in idUsuario int(11),in idEvento int(11), in idArea int(11), in situacao varchar(255))
BEGIN

  DECLARE flag varchar(255);
  SET @consulta  = CONCAT('SELECT * FROM solicitacaoavaliador a');
  SET flag = ' WHERE';
  
  IF idUsuario != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' a.idUsuario=', idUsuario);
    SET flag = ' AND';
  END IF;
  
  IF idEvento != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' a.idEvento=', idEvento);
    SET flag = ' AND';
  END IF;
  
  IF idArea != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' a.idArea=', idArea);
    SET flag = ' AND';
  END IF;
  
  IF situacao != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' a.situacao=\'', situacao,'\'');
  END IF;
  
  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;

  
  
END;

#
# Procedure "listaSubmissoesComFiltro"
#

DROP PROCEDURE IF EXISTS `listaSubmissoesComFiltro`;
CREATE PROCEDURE `listaSubmissoesComFiltro`(IN idEvento int(11), IN idModalidade int(11), IN idArea int(11), IN idSituacao int(11), IN idTipo int(11))
BEGIN

  DECLARE flag varchar(255) DEFAULT ' WHERE ';
  SET @consulta = 'SELECT s.* FROM submissao s ';

  IF idEvento != '' THEN
    SET @consulta = CONCAT(@consulta,flag, ' s.idEvento=', idEvento);
    SET flag = ' AND ';
  END IF;
  
  IF idModalidade != '' THEN
    SET @consulta = CONCAT(@consulta,flag, ' s.idModalidade=', idModalidade);
    SET flag = ' AND ';
  END IF;
  
  IF idArea != '' THEN
    SET @consulta = CONCAT(@consulta,flag, ' s.idArea=', idArea);
    SET flag = ' AND ';
  END IF;
  
  IF idSituacao != '' THEN
    SET @consulta = CONCAT(@consulta,flag, ' s.idSituacaoSubmissao=', idSituacao);
    SET flag = ' AND ';
  END IF;
  
  IF idTipo != '' THEN
    SET @consulta = CONCAT(@consulta,flag, ' s.idTipoSubmissao=', idTipo);

  END IF;
  
  
  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
END;

#
# Procedure "listaUsuarios"
#

DROP PROCEDURE IF EXISTS `listaUsuarios`;
CREATE PROCEDURE `listaUsuarios`(IN filtroNome varchar(250), IN filtroTipoUsuario int(10), IN filtroPerfil int(10))
BEGIN

  SET @consulta = 'SELECT u.* FROM usuario u, perfil p ';
  SET @consulta = CONCAT(@consulta, ' WHERE u.nome LIKE \'%', filtroNome, '%\'');
  
  IF (filtroTipoUsuario != '-1' AND filtroTipoUsuario!='') THEN
    SET @consulta = CONCAT(@consulta, ' AND u.idTipoUsuario =', filtroTipoUsuario);
  END IF;

  SET @consulta = CONCAT(@consulta, ' AND u.idPerfil = p.id ');
  IF (filtroPerfil != -1) THEN
    SET @consulta = CONCAT(@consulta, 'AND u.idPerfil =', filtroPerfil);
  END IF;


  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;

END;

#
# Procedure "listaUsuariosDaSubmissaoComFiltro"
#

DROP PROCEDURE IF EXISTS `listaUsuariosDaSubmissaoComFiltro`;
CREATE PROCEDURE `listaUsuariosDaSubmissaoComFiltro`(IN idSubmissao int(11), IN idUsuario int(11), IN isSubmissor int(11))
BEGIN


  DECLARE flag varchar(255);
  SET @consulta = 'SELECT * FROM usuariosdasubmissao us ';
  SET flag = ' WHERE';

  IF idSubmissao != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' us.idSubmissao=', idSubmissao);
    SET flag = ' AND';
  END IF;

  IF idUsuario != '' THEN
    SET @consulta = CONCAT(@consulta,flag,' us.idUsuario=', idUsuario);
    SET flag = ' AND';
  END IF;

  IF isSubmissor = 1 THEN
    SET @consulta = CONCAT(@consulta,flag,' us.isSubmissor=1');
  END IF;
  

  
  
  PREPARE stmt FROM @consulta;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
END;

#
# Procedure "login"
#

DROP PROCEDURE IF EXISTS `login`;
CREATE PROCEDURE `login`(in pCpf varchar(14), in pSenha varchar(250))
BEGIN

  
  
  select
          *


  from 
        	usuario u WHERE u.cpf = pCpf and 
          u.senha = pSenha;
  
END;

#
# Procedure "recuperarSenha"
#

DROP PROCEDURE IF EXISTS `recuperarSenha`;
CREATE PROCEDURE `recuperarSenha`(in pCpf varchar(14), in pEmail varchar(250), in pSenhaNova varchar(250))
BEGIN

  DECLARE done INT DEFAULT FALSE;
  DECLARE cpfEmailExistente INT DEFAULT 0;
  DECLARE buscaCpf,buscaEmail VARCHAR(255);
  
  DECLARE cur1 CURSOR FOR SELECT cpf,email FROM usuarios;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  
  OPEN cur1;
  
  read_loop: LOOP
    FETCH cur1 INTO buscaCpf,buscaEmail;

    IF done THEN
      LEAVE read_loop;
    ELSEIF (buscaCpf = pCpf  && buscaEmail = pEmail) THEN
      UPDATE usuarios SET senha = pSenhaNova WHERE cpf = pCpf;
  
      SET cpfEmailExistente = 1;
      LEAVE read_loop;
    END IF;
  END LOOP;

  CLOSE cur1;  
   
  IF cpfEmailExistente=1 THEN
    Select 1;
  ELSE
    SELECT * FROM usuarios WHERE idUsuario=0; -- Retorno de valor NULO
  END IF;
  
  
END;

#
# Procedure "retornaCriteriosParaAvaliacao"
#

DROP PROCEDURE IF EXISTS `retornaCriteriosParaAvaliacao`;
CREATE PROCEDURE `retornaCriteriosParaAvaliacao`(IN idAvaliacao int(11))
BEGIN

  SELECT * from avaliacaocriterio ac WHERE ac.idAvaliacao = idAvaliacao;
  
END;

#
# Procedure "retornaDadosPrazoPorTipoEntidade"
#

DROP PROCEDURE IF EXISTS `retornaDadosPrazoPorTipoEntidade`;
CREATE PROCEDURE `retornaDadosPrazoPorTipoEntidade`(IN idTipoPrazo int(11),IN idEntidade int(11))
BEGIN

  SELECT p.* FROM prazo p WHERE p.idTipoPrazo = idTipoPrazo AND pe.idEntidade = idEntidade;
  
END;

#
# Procedure "retornaIdAreaEvento"
#

DROP PROCEDURE IF EXISTS `retornaIdAreaEvento`;
CREATE PROCEDURE `retornaIdAreaEvento`(IN idEvento int(11),IN idArea int(11))
BEGIN

  SELECT id FROM areasevento a WHERE a.idArea = idArea AND a.idEvento = idEvento;
  
END;

#
# Procedure "retornaIdModalidadeEvento"
#

DROP PROCEDURE IF EXISTS `retornaIdModalidadeEvento`;
CREATE PROCEDURE `retornaIdModalidadeEvento`(IN idEvento int(11),IN idModalidade int(11))
BEGIN

  SELECT id FROM modalidadesevento m WHERE m.idModalidade = idModalidade AND m.idEvento = idEvento;
  
END;

#
# Procedure "retornaIdPrazosEvento"
#

DROP PROCEDURE IF EXISTS `retornaIdPrazosEvento`;
CREATE PROCEDURE `retornaIdPrazosEvento`(IN idEvento int(11),IN idTipoPrazo int(11))
BEGIN

  SELECT id FROM prazosevento pe WHERE pe.idEvento = idEvento AND pe.idTipoPrazo = idTipoPrazo;
  
END;

#
# Procedure "retornaIdTipoSubmissao"
#

DROP PROCEDURE IF EXISTS `retornaIdTipoSubmissao`;
CREATE PROCEDURE `retornaIdTipoSubmissao`(in nome varchar(255))
BEGIN
  
  
  SELECT id FROM tiposubmissao t WHERE t.descricao=nome;
  
END;

#
# Procedure "retornaIdUltimaSubmissao"
#

DROP PROCEDURE IF EXISTS `retornaIdUltimaSubmissao`;
CREATE PROCEDURE `retornaIdUltimaSubmissao`()
BEGIN

  SELECT MAX(id) as id from submissao;
  
END;

#
# Procedure "retornaIdUltimoEvento"
#

DROP PROCEDURE IF EXISTS `retornaIdUltimoEvento`;
CREATE PROCEDURE `retornaIdUltimoEvento`()
BEGIN

  SELECT MAX(id) as id from evento;
  
END;

#
# Procedure "retornaItemPorId"
#

DROP PROCEDURE IF EXISTS `retornaItemPorId`;
CREATE PROCEDURE `retornaItemPorId`(in item char(255), in id int(11))
BEGIN

 DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
  
    CASE item
      WHEN "area" THEN SELECT * from area WHERE area.id = id;
      WHEN "areasevento" THEN SELECT * from areasevento WHERE areasevento.id = id;
      WHEN "avaliacao" THEN SELECT * from avaliacao WHERE avaliacao.id = id;
      WHEN "avaliador" THEN SELECT * from avaliador WHERE avaliador.id = id;
      WHEN "criterio" THEN SELECT * from criterio WHERE criterio.id = id;
      WHEN "download" THEN SELECT * from download WHERE download.id = id;
      WHEN "evento" THEN SELECT * from evento WHERE evento.id = id;
      WHEN "modalidade" THEN SELECT * from modalidade WHERE modalidade.id = id;
      WHEN "modalidadesevento" THEN SELECT * from modalidadesevento WHERE modalidadesevento.id = id;
      WHEN "noticia" THEN SELECT * from noticia WHERE noticia.id = id;
      WHEN "perfil" THEN SELECT * from perfil WHERE perfil.id = id;
      WHEN "prazo" THEN SELECT * from prazo WHERE prazo.id = id;
      WHEN "situacaoavaliacao" THEN SELECT * from situacaoavaliacao WHERE situacaoavaliacao.id = id;
      WHEN "situacaosubmissao" THEN SELECT * from situacaosubmissao WHERE situacaosubmissao.id = id;
      WHEN "solicitacaoavaliador" THEN SELECT * from solicitacaoavaliador WHERE solicitacaoavaliador.id = id;
      WHEN "submissao" THEN SELECT * from submissao WHERE submissao.id = id;
      WHEN "tipoprazo" THEN SELECT * from tipoprazo WHERE tipoprazo.id = id;      
      WHEN "prazosevento" THEN SELECT * from prazosevento WHERE prazosevento.id = id;    
      WHEN "tiposubmissao" THEN SELECT * from tiposubmissao WHERE tiposubmissao.id = id;
      WHEN "tipousuario" THEN SELECT * from tipousuario WHERE tipousuario.id = id;
      WHEN "usuario" THEN SELECT * from usuario WHERE usuario.id = id;
      WHEN "usuariosdasubmissao" THEN SELECT * from usuariosdasubmissao WHERE usuariosdasubmissao.id = id;
      

    END CASE;

  COMMIT;

END;

#
# Procedure "retornaSubmissaoCorrigidaPelaParcial"
#

DROP PROCEDURE IF EXISTS `retornaSubmissaoCorrigidaPelaParcial`;
CREATE PROCEDURE `retornaSubmissaoCorrigidaPelaParcial`(IN idSubmissaoParcial int(11))
BEGIN

  SELECT s.* FROM submissao s WHERE s.idRelacaoComSubmissao = idSubmissaoParcial;
  
END;

#
# Procedure "setarSenha"
#

DROP PROCEDURE IF EXISTS `setarSenha`;
CREATE PROCEDURE `setarSenha`(in id int(11), in senha varchar(255))
BEGIN

    UPDATE usuario SET `senha`=senha WHERE usuario.id=id;

END;

#
# Procedure "validarCadastro"
#

DROP PROCEDURE IF EXISTS `validarCadastro`;
CREATE PROCEDURE `validarCadastro`(in pCpf varchar(14), in pNome varchar(255), in pSobrenome varchar(255), in pDataNascimento varchar(255), 
                                                              in pEmail varchar(255),in pMatricula varchar(255), in pInstituicaoEnsino varchar(255), in pSenha varchar(255), in pPerfil int(11))
BEGIN

  DECLARE done INT DEFAULT FALSE;
  DECLARE cpfEmailExistente INT DEFAULT 0;
  DECLARE buscaCpf,buscaEmail VARCHAR(255);
  DECLARE novoId int;
  DECLARE novoNome VARCHAR(255);
  
  DECLARE cur1 CURSOR FOR SELECT cpf,email FROM usuario;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  
  OPEN cur1;
  
  read_loop: LOOP
    FETCH cur1 INTO buscaCpf,buscaEmail;

    IF done THEN
      LEAVE read_loop;
    ELSEIF (buscaCpf = pCpf  OR buscaEmail = pEmail) THEN
      SET cpfEmailExistente = 1;
      LEAVE read_loop;
    END IF;
  END LOOP;

  CLOSE cur1;  
  
  IF cpfEmailExistente=0 THEN
    INSERT INTO usuario (cpf,nome,sobrenome,senha,dataNascimento,email,matricula,instituicaoEnsino,idPerfil) VALUES (pCpf,pNome,pSobrenome,pSenha,pDataNascimento,pEmail,pMatricula,pInstituicaoEnsino,pPerfil);
    SELECT 1 as resposta;
  ELSE
    SELECT 0 as resposta;
  END IF;
  

END;

#
# Procedure "verificarGeracaoNotaFinalSubmissao"
#

DROP PROCEDURE IF EXISTS `verificarGeracaoNotaFinalSubmissao`;
CREATE PROCEDURE `verificarGeracaoNotaFinalSubmissao`(IN idSubmissao int(11))
BEGIN

  DECLARE media float(3,1);
  DECLARE idTipoSubmissao int(11);
  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;

    SELECT s.idTipoSubmissao INTO idTipoSubmissao FROM submissao s WHERE s.id = idSubmissao;
    
    /* Caso seja uma submissão final, previsa do cálculo da média das notas dos avaliadores  */
    IF idTipoSubmissao=3 THEN
        /* Caso 1 - Exista pelo menos uma avaliação para a submissao ; 2 - Todas as avaliações tiverem sido realizadas ; 3 - A nota da submissão não seja Nula */
        IF (SELECT COUNT(*) from avaliacao a WHERE a.idSubmissao = idSubmissao)>0 AND 
            (SELECT COUNT(*) from avaliacao a WHERE a.idSubmissao = idSubmissao AND ISNULL(a.nota))=0 AND 
              (SELECT COUNT(*) from submissao s WHERE s.id = idSubmissao AND NOT ISNULL(s.nota))=0 THEN
      		SELECT AVG(nota) as 'notaFinal' INTO media FROM avaliacao a WHERE a.idSubmissao = idSubmissao;
    	   	UPDATE submissao SET `nota`=media WHERE submissao.id = idSubmissao;
          SELECT 1 as 'resposta';
        END IF;
    ELSE /* Caso seja uma submissão parcial(1) ou corrigida(2), verifica se todas as avaliações foram realizadas. Se 'Sim', calcula se a mesma está REPROVADA, APROVADA OU APROVADA COM RESSALVAS  */
        BEGIN
          
          DECLARE aprovado int(11) DEFAULT 0;
          DECLARE reprovado int(11) DEFAULT 0;
          DECLARE apRessalvas int(11) DEFAULT 0;
          DECLARE resultado int(11);
          
          DECLARE done INT DEFAULT FALSE;
          DECLARE cur1 CURSOR FOR SELECT a.idSituacaoAvaliacao FROM avaliacao a WHERE a.idSubmissao = idSubmissao;
          DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;        
          
          IF (SELECT COUNT(*) FROM avaliacao a WHERE a.idSubmissao = idSubmissao AND a.idSituacaoAvaliacao IN (4,5,6))=3 THEN
              OPEN cur1;
        
              read_loop: LOOP
                FETCH cur1 INTO resultado;      
                IF done THEN
                  LEAVE read_loop;
                ELSE
                  CASE resultado 
                    WHEN '4' THEN SET aprovado = aprovado+1;
                    WHEN '5' THEN SET apRessalvas = apRessalvas+1;
                    WHEN '6' THEN SET reprovado = reprovado+1;
                  END CASE;
                END IF;
  
                /* Situações de Submissões - 4: APROVADO, 5: APROVADO COM RESSALVAS, 6: REPROVADO */              
                IF aprovado>=2 THEN 
                    UPDATE submissao SET `idSituacaoSubmissao`=4 WHERE submissao.id=idSubmissao;
                ELSE
                  IF reprovado>=2 THEN 
                    UPDATE submissao SET `idSituacaoSubmissao`=6 WHERE submissao.id=idSubmissao;
                  ELSE
                    UPDATE submissao SET `idSituacaoSubmissao`=5 WHERE submissao.id=idSubmissao;
                  END IF;
                END IF;
              END LOOP;
          END IF;

        END;
    END IF;   
  COMMIT;
END;

#
# Procedure "realizarAvaliacao"
#

DROP PROCEDURE IF EXISTS `realizarAvaliacao`;
CREATE PROCEDURE `realizarAvaliacao`(IN idAvaliacao int(11), IN idSituacaoAvaliacao int(11),IN notas varchar(255), IN notaFinalAvaliacao int(11),IN observacao varchar(255))
BEGIN


  DECLARE avaliacaoCriterio int(11);
  DECLARE notaAvaliacao int(11);
  DECLARE mediaPonderada char(255);
  DECLARE tamanho int(11);

  DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;



    WHILE CHAR_LENGTH(notas)>0 DO


      SET tamanho = CHAR_LENGTH(notas);
      SET avaliacaoCriterio = SUBSTRING_INDEX(notas, '=', 1);      
      SET notas = RIGHT(notas,tamanho-(CHAR_LENGTH(avaliacaoCriterio)+1));
      
      SET tamanho = CHAR_LENGTH(notas);
      SET notaAvaliacao = SUBSTRING_INDEX(notas, ';', 1);      
      SET notas = RIGHT(notas,tamanho-(CHAR_LENGTH(notaAvaliacao)+1));

      CALL atualizarAvaliacaoCriterio(avaliacaoCriterio,notaAvaliacao);
    
    END WHILE;
-- ATUALIZAR A AVALIACAO COM A NOTA FINAL E A OBSERVACAO
--    CALL atualizarAvaliacao
    BEGIN

      DECLARE idSubmissao int(11);
      DECLARE idTipoSubmissao int(11);
      SELECT s.id,s.idTipoSubmissao INTO idSubmissao,idTipoSubmissao FROM submissao s, avaliacao a WHERE a.id = idAvaliacao AND s.id = a.idSubmissao;

      IF idTipoSubmissao=1 OR idTipoSubmissao=2 THEN
        UPDATE avaliacao SET `idSituacaoAvaliacao`=idSituacaoAvaliacao, `observacao`=observacao WHERE avaliacao.id = idAvaliacao;
      ELSE
        UPDATE avaliacao SET `idSituacaoAvaliacao`=idSituacaoAvaliacao, `nota`= notaFinalAvaliacao, `observacao`=observacao WHERE avaliacao.id = idAvaliacao;
      END IF;
      
      CALL verificarGeracaoNotaFinalSubmissao(idSubmissao);
    END;

      SELECT 1 as 'resposta';    

  COMMIT;
  
END;

#
# Procedure "excluirItem"
#

DROP PROCEDURE IF EXISTS `excluirItem`;
CREATE PROCEDURE `excluirItem`(in item varchar(255),in id int(11))
BEGIN

 DECLARE exit handler for sqlexception
  
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
		SELECT  @p2 as resposta;
		ROLLBACK;
	END;
  
  start transaction;
  
    CASE item
      WHEN "area" THEN DELETE from area WHERE area.id = id;                                                  SELECT 1 as 'resposta';

      WHEN "areasevento" THEN 
          /* Antes da exclusão, verifica se há submissões já realizadas para essa área neste evento. Caso exista, esse vínculo não pode ser excluído */
          IF (SELECT COUNT(*) FROM submissao s WHERE s.idEvento IN (SELECT ae.idEvento FROM areasevento ae WHERE ae.id = id) AND
                                                     s.idArea   IN (SELECT ae.idArea   FROM areasevento ae WHERE ae.id = id))>0
          THEN
            SELECT 0; /* Qualquer valor diferente de '1' significa ERRO */
          ELSE
             /* Exclui todos os vinculos de avaliadores para esta área/evento */
             DELETE FROM avaliador WHERE avaliador.idEvento IN (SELECT ae.idEvento FROM areasevento ae WHERE ae.id = id) AND
                                         avaliador.idArea   IN (SELECT ae.idArea   FROM areasevento ae WHERE ae.id = id);
  
             /* Exclui todos os vinculos de solicitacoes de avaliadores para esta área/evento */
             DELETE FROM solicitacaoavaliador WHERE solicitacaoavaliador.idEvento IN (SELECT ae.idEvento FROM areasevento ae WHERE ae.id = id) AND
                                                    solicitacaoavaliador.idArea   IN (SELECT ae.idArea   FROM areasevento ae WHERE ae.id = id);
             /* Exclui o vínculo da área com o evento */
             DELETE from areasevento WHERE areasevento.id = id; 
             SELECT 1;
          END IF;

      WHEN "avaliacao" THEN 
          IF (SELECT COUNT(*) FROM avaliacao a WHERE a.id = id AND a.idSituacaoAvaliacao = 2)=0 THEN
            BEGIN
              DECLARE idSubmissao int(11);
              SELECT a.idSubmissao INTO idSubmissao FROM avaliacao a WHERE a.id = id;
              DELETE from avaliacaocriterio WHERE avaliacaocriterio.idAvaliacao = id;
              DELETE from avaliacao WHERE avaliacao.id = id;
              CALL verificarGeracaoNotaFinalSubmissao(idSubmissao);
              
              IF (SELECT COUNT(*) FROM avaliacao a WHERE a.idSubmissao=idSUbmissao)=0 THEN
                UPDATE submissao SET `idSituacaoSubmissao`=1 WHERE submissao.id=idSubmissao; /* Caso todas as avaliacoes tenham sido excluidas, a submissao volta ao estado SUBMETIDA */
              END IF;
              SELECT 1 as 'resposta';          
            END;
          ELSE
            SELECT 'A avaliação já foi realizada e não pode ser excluida' as resposta;
          END IF;

      WHEN "avaliador" THEN
           IF (SELECT COUNT(*) FROM avaliacao a, submissao s, avaliador av WHERE av.id = id AND
                                                                                 s.idEvento = av.idEvento AND
                                                                                 s.idArea = av.idArea AND
                                                                                 s.id = a.idSubmissao AND
                                                                                 a.idUsuario = av.idUsuario)<=0 THEN
            /* DELETA, CASO HAJA, ALGUMA SOLICITACAO DE AVALIADOR CORRESPONDENTE */
            DELETE from solicitacaoavaliador where solicitacaoavaliador.id IN 
                    (SELECT solicitacaoavaliador.id FROM avaliador a WHERE a.id=id
                        AND a.idEvento = solicitacaoavaliador.idEvento
                        AND a.idArea = solicitacaoavaliador.idArea
                        AND a.idUsuario = solicitacaoavaliador.idUsuario );
            DELETE from avaliador WHERE avaliador.id = id;
            SELECT 1 as 'resposta';
           ELSE
            SELECT 'Existem avaliações vinculadas a este avaliador' as 'resposta';
           END IF;
      WHEN "criterio" THEN
          /* Antes da exclusão, verifica se há avaliações já realizadas que possuem esse critério. Caso existam, o critério não poderá ser excluído*/      
          IF (SELECT COUNT(*) FROM avaliacaocriterio ac WHERE ac.idCriterio = id AND ISNULL(nota))<=0 THEN
          /* Caso não existam, todas as avaliações para este critério são excluídas */
            DELETE from avaliacaocriterio WHERE avaliacaocriterio.idCriterio = id;
            DELETE from criterio WHERE criterio.id = id;
            SELECT 1 as 'resposta';
          ELSE
            SELECT 'O critério não pode ser excluido porque já foram realizadas avaliacoes' as 'resposta';
          END IF;


      WHEN "download" THEN DELETE from download WHERE download.id = id;                                      SELECT 1 as 'resposta';
      WHEN "evento" THEN DELETE from evento WHERE evento.id = id;                                            SELECT 1 as 'resposta';
      WHEN "modalidade" THEN DELETE from modalidade WHERE modalidade.id = id;                                SELECT 1 as 'resposta';
      WHEN "modalidadesevento" THEN
          /* Antes da exclusão, verifica se há submissões já realizadas para essa modalidade neste evento. Caso exista, esse vínculo não pode ser excluído */
          IF (SELECT COUNT(*) FROM submissao s WHERE s.idEvento     IN (SELECT me.idEvento     FROM modalidadesevento me WHERE me.id = id) AND
                                                     s.idModalidade IN (SELECT me.idModalidade FROM modalidadesevento me WHERE me.id = id))>0
          THEN
            SELECT 0; /* Qualquer valor diferente de '1' significa ERRO */
          ELSE
             /* Exclui o vínculo da modalidade com o evento */
             DELETE from modalidadesevento WHERE modalidadesevento.id = id; 
             SELECT 1;
          END IF;

      WHEN "noticia" THEN DELETE from noticia WHERE noticia.id = id;                                         SELECT 1 as 'resposta';
      WHEN "perfil" THEN DELETE from perfil WHERE perfil.id = id;                                            SELECT 1 as 'resposta';
      WHEN "prazosevento" THEN DELETE from prazosevento WHERE prazosevento.id = id;                          SELECT 1 as 'resposta';
      WHEN "situacaoavaliacao" THEN DELETE from situacaoavaliacao WHERE situacaoavaliacao.id = id;           SELECT 1 as 'resposta';
      WHEN "situacaosubmissao" THEN DELETE from situacaosubmissao WHERE situacaosubmissao.id = id;           SELECT 1 as 'resposta';
      WHEN "solicitacaoavaliador" THEN DELETE from solicitacaoavaliador WHERE solicitacaoavaliador.id = id;  SELECT 1 as 'resposta';
      WHEN "submissao" THEN DELETE from submissao WHERE submissao.id = id;                                   SELECT 1 as 'resposta';
      WHEN "tiposubmissao" THEN DELETE from tiposubmissao WHERE tiposubmissao.id = id;                       SELECT 1 as 'resposta';
      WHEN "usuario" THEN DELETE from usuario WHERE usuario.id = id;                                         SELECT 1 as 'resposta';
      WHEN "usuariosdasubmissao" THEN DELETE from usuariosdasubmissao WHERE usuariosdasubmissao.id = id;     SELECT 1 as 'resposta';
      

    END CASE;
    
    
  COMMIT;

END;
