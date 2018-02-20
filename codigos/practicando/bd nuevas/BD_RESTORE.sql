DROP TABLE capitulos;

CREATE TABLE `capitulos` (
  `id_capitulo` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id_publicaciones` mediumint(9) NOT NULL,
  `titulo` text NOT NULL,
  `editorial` text NOT NULL,
  `editor` text NOT NULL,
  PRIMARY KEY (`id_capitulo`),
  KEY `id_publicaciones` (`id_publicaciones`),
  CONSTRAINT `capitulos_ibfk_1` FOREIGN KEY (`id_publicaciones`) REFERENCES `publicaciones` (`id_publicacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE libros;

CREATE TABLE `libros` (
  `id_libro` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id_publicaciones` mediumint(9) NOT NULL,
  `editorial` text NOT NULL,
  `editor` text NOT NULL,
  `isbn` int(15) NOT NULL,
  PRIMARY KEY (`id_libro`),
  KEY `id_publicaciones` (`id_publicaciones`),
  CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_publicaciones`) REFERENCES `publicaciones` (`id_publicacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE miembros;

CREATE TABLE `miembros` (
  `id_miembro` mediumint(9) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `primerApellido` text NOT NULL,
  `segundoApellido` text,
  `categoria` enum('catedratico','titular','becario') NOT NULL,
  `director` tinyint(1) DEFAULT NULL,
  `email` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `telefono` text,
  `url` text,
  `departamento` text NOT NULL,
  `centro` text NOT NULL,
  `institucion` text NOT NULL,
  `direccion` longtext NOT NULL,
  `foto` text,
  `activo` tinyint(1) NOT NULL,
  `permiso` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_miembro`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO miembros VALUES("1","yurena","del peso","perez","becario","1","yurena@ugr.es","d41d8cd98f00b204e9800998ecf8427e","677277715","http://yurema.es","decssai","ugr","miniterio","lugar san miguel","https://yurena.es","0","0");
INSERT INTO miembros VALUES("2","wgsddafg","asdgad","asdfgdfa","","0","adfsgad","asfdg","","wgdfaer","asdg","asdfas","asdf","asdf","","0","0");



DROP TABLE proyectosInvestigacion;

CREATE TABLE `proyectosInvestigacion` (
  `id_proyecto` mediumint(9) NOT NULL AUTO_INCREMENT,
  `codigo` text NOT NULL,
  `titulo` text NOT NULL,
  `descrpcion` longtext,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `entidadesColaboradoras` text,
  `cuantia` int(100) DEFAULT NULL,
  `responsable` text NOT NULL,
  `integrantes` longtext,
  `url` text,
  PRIMARY KEY (`id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO proyectosInvestigacion VALUES("1","122","laspalmas","medioAmbiente","2017-02-01","2018-03-08","lacaixa endesa","15000","yurena del peso","yurena del peso andres guerrero","http://www.google.es");
INSERT INTO proyectosInvestigacion VALUES("2","12","lassspalmas","medioAmbiente","2017-02-01","2018-03-08","lacaixa endesa","15000","yurena del peso","yurena del peso andres guerrero","http://www.google.es");
INSERT INTO proyectosInvestigacion VALUES("5","55","snsdjnsd","jonsjjsln","2012-01-01","2017-01-01","jnsjsnjs","22222","jnsjsn","sonolsn","www.nslns.es");
INSERT INTO proyectosInvestigacion VALUES("6","99","jnsnpspos","jksjnslnj","2013-01-01","2017-01-01","ojndond","333333","sjnosnos","nssnlks","www.www");
INSERT INTO proyectosInvestigacion VALUES("7","00","sfg","sdfsd","2015-01-01","2017-01-01","arskñfgkas","22222","afgsg","asdf","asdf");
INSERT INTO proyectosInvestigacion VALUES("8","onopj","sapiasj","snsjn","2017-01-01","2017-01-01","jspijs","2222","sjnsj","snspikns","snpsns");
INSERT INTO proyectosInvestigacion VALUES("9","sjnaojn","sakna","assa","2017-01-01","2017-01-01","oisiosjº","8732827","onon","onoinn","nonk");
INSERT INTO proyectosInvestigacion VALUES("10","376376","ewwn","wkmkmw","2017-01-01","2017-01-01","skmkms msk","2222","skmsmk","kskms","smksm");



DROP TABLE publicaciones;

CREATE TABLE `publicaciones` (
  `id_publicacion` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id_proyec` mediumint(9) NOT NULL,
  `tipo` enum('revista','libro','capitulo','conferencia') NOT NULL,
  `doi` text NOT NULL,
  `titulo` text NOT NULL,
  `autores` longtext NOT NULL,
  `fechaPublicacion` date DEFAULT NULL,
  `resumen` longtext,
  `palabras` longtext,
  `url` text,
  `id_proyecto` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_publicacion`),
  KEY `id_proyec` (`id_proyec`),
  CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`id_proyec`) REFERENCES `proyectosInvestigacion` (`id_proyecto`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=latin1;

INSERT INTO publicaciones VALUES("135","1","revista","333","sknsn","skns","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("136","1","revista","333","sknsn","skns","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("137","1","revista","3333","qqqqqqq","sddlfmskdjf","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("138","1","revista","3333","qqqqqqq","sddlfmskdjf","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("139","1","revista","777777777","jodfsj","justiu","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("140","1","revista","777777777","jodfsj","justiu","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("141","1","revista","9999999","hidsfsfhb","dfhh","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("142","1","revista","9999999","hidsfsfhb","dfhh","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("143","1","revista","9797979797","HDSSHUD","HH","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("144","1","revista","9797979797","HDSSHUD","HH","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("145","1","revista","5656565","isjfsdj","dsfjid","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("146","1","revista","5656565","isjfsdj","dsfjid","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("147","1","revista","45454545","idjfidfj","ijierj","0000-00-00","","","","");



DROP TABLE revistas;

CREATE TABLE `revistas` (
  `id_revista` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id_publicaciones` mediumint(9) NOT NULL,
  `nombre` text NOT NULL,
  `volumen` int(5) NOT NULL,
  `paginas` int(5) NOT NULL,
  PRIMARY KEY (`id_revista`),
  KEY `id_publicaciones` (`id_publicaciones`),
  CONSTRAINT `revistas_ibfk_1` FOREIGN KEY (`id_publicaciones`) REFERENCES `publicaciones` (`id_publicacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE usuarios;

CREATE TABLE `usuarios` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `type` text NOT NULL,
  `nombre` text NOT NULL,
  `dni` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO usuarios VALUES("admin","21232f297a57a5a743894a0e4a801fc3","admin","admin","66178705T","admin@admin.com");
INSERT INTO usuarios VALUES("z","fbade9e36a3f36d3d676c1b808451dd7","profesor","z","z","z");
INSERT INTO usuarios VALUES("r","4b43b0aee35624cd95b910189b3dc231","profesor","r","r","s");
INSERT INTO usuarios VALUES("a","0cc175b9c0f1b6a831c399e269772661","profesor","a","b","a");
INSERT INTO usuarios VALUES("y","363b122c528f54df4a0446b6bab05515","profesor","e","5","miguel");
INSERT INTO usuarios VALUES("ad","523af537946b79c4f8369ed39ba78605","admin","ad","ad","ad");



