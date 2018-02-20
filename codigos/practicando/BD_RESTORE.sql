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




DROP TABLE conferencias;

CREATE TABLE `conferencias` (
  `id_conferencias` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id_publicaciones` mediumint(9) NOT NULL,
  `nombre` text NOT NULL,
  `lugar` text NOT NULL,
  `resena` int(15) NOT NULL,
  PRIMARY KEY (`id_conferencias`),
  KEY `id_publicaciones` (`id_publicaciones`),
  CONSTRAINT `conferencia_ibfk_1` FOREIGN KEY (`id_publicaciones`) REFERENCES `publicaciones` (`id_publicacion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO conferencias VALUES("1","1","","","0");
INSERT INTO conferencias VALUES("2","1","fedsdfsd","sdfs","342");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO miembros VALUES("1","yurena","del peso","perez","becario","0","yurena@ugr.es","36e1512ec214ee07f6fd919b4fd9fa80cf96e0d9","677277715","http://yurema.es","decssai","ugr","miniterio","lugar san miguel","https://yurena.es","0","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO proyectosInvestigacion VALUES("1","122","laspalmas","medioAmbiente","2017-02-01","2018-03-08","lacaixa endesa","15000","yurena del peso","yurena del peso andres guerrero","http://www.google.es");
INSERT INTO proyectosInvestigacion VALUES("2","12","lassspalmas","medioAmbiente","2017-02-01","2018-03-08","lacaixa endesa","15000","yurena del peso","yurena del peso andres guerrero","http://www.google.es");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO publicaciones VALUES("1","1","conferencia","2","SDFSDF","SDFSD","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("2","1","conferencia","123413","sdfsd","sdfds","0000-00-00","","","","");



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

INSERT INTO usuarios VALUES("z","fbade9e36a3f36d3d676c1b808451dd7","profesor","z","z","z");
INSERT INTO usuarios VALUES("r","4b43b0aee35624cd95b910189b3dc231","profesor","r","r","s");
INSERT INTO usuarios VALUES("a","0cc175b9c0f1b6a831c399e269772661","profesor","a","b","a");
INSERT INTO usuarios VALUES("y","363b122c528f54df4a0446b6bab05515","profesor","e","5","miguel");
INSERT INTO usuarios VALUES("ad","523af537946b79c4f8369ed39ba78605","admin","ad","ad","ad");
INSERT INTO usuarios VALUES("sadf","912ec803b2ce49e4a541068d495ab570","admin","refsda","asdf","sdaf");
INSERT INTO usuarios VALUES("asdf","fe6d1fed11fa60277fb6a2f73efb8be2","profesor","ghfstg","sdf","asfd");
INSERT INTO usuarios VALUES("yure","670b14728ad9902aecba32e22fa4f6bd","profesor","miids","46706518G","aw@msn.com");
INSERT INTO usuarios VALUES("wwww","670b14728ad9902aecba32e22fa4f6bd","admin","yureyure","46706517G","ase@kjsd.es");



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




DROP TABLE conferencias;

CREATE TABLE `conferencias` (
  `id_conferencias` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id_publicaciones` mediumint(9) NOT NULL,
  `nombre` text NOT NULL,
  `lugar` text NOT NULL,
  `resena` int(15) NOT NULL,
  PRIMARY KEY (`id_conferencias`),
  KEY `id_publicaciones` (`id_publicaciones`),
  CONSTRAINT `conferencia_ibfk_1` FOREIGN KEY (`id_publicaciones`) REFERENCES `publicaciones` (`id_publicacion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO conferencias VALUES("1","1","","","0");
INSERT INTO conferencias VALUES("2","1","fedsdfsd","sdfs","342");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO miembros VALUES("1","yurena","del peso","perez","becario","0","yurena@ugr.es","36e1512ec214ee07f6fd919b4fd9fa80cf96e0d9","677277715","http://yurema.es","decssai","ugr","miniterio","lugar san miguel","https://yurena.es","0","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO proyectosInvestigacion VALUES("1","122","laspalmas","medioAmbiente","2017-02-01","2018-03-08","lacaixa endesa","15000","yurena del peso","yurena del peso andres guerrero","http://www.google.es");
INSERT INTO proyectosInvestigacion VALUES("2","12","lassspalmas","medioAmbiente","2017-02-01","2018-03-08","lacaixa endesa","15000","yurena del peso","yurena del peso andres guerrero","http://www.google.es");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO publicaciones VALUES("1","1","conferencia","2","SDFSDF","SDFSD","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("2","1","conferencia","123413","sdfsd","sdfds","0000-00-00","","","","");



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

INSERT INTO usuarios VALUES("z","fbade9e36a3f36d3d676c1b808451dd7","profesor","z","z","z");
INSERT INTO usuarios VALUES("r","4b43b0aee35624cd95b910189b3dc231","profesor","r","r","s");
INSERT INTO usuarios VALUES("a","0cc175b9c0f1b6a831c399e269772661","profesor","a","b","a");
INSERT INTO usuarios VALUES("y","363b122c528f54df4a0446b6bab05515","profesor","e","5","miguel");
INSERT INTO usuarios VALUES("ad","523af537946b79c4f8369ed39ba78605","admin","ad","ad","ad");
INSERT INTO usuarios VALUES("sadf","912ec803b2ce49e4a541068d495ab570","admin","refsda","asdf","sdaf");
INSERT INTO usuarios VALUES("asdf","fe6d1fed11fa60277fb6a2f73efb8be2","profesor","ghfstg","sdf","asfd");
INSERT INTO usuarios VALUES("yure","670b14728ad9902aecba32e22fa4f6bd","profesor","miids","46706518G","aw@msn.com");
INSERT INTO usuarios VALUES("wwww","670b14728ad9902aecba32e22fa4f6bd","admin","yureyure","46706517G","ase@kjsd.es");



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




DROP TABLE conferencias;

CREATE TABLE `conferencias` (
  `id_conferencias` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id_publicaciones` mediumint(9) NOT NULL,
  `nombre` text NOT NULL,
  `lugar` text NOT NULL,
  `resena` int(15) NOT NULL,
  PRIMARY KEY (`id_conferencias`),
  KEY `id_publicaciones` (`id_publicaciones`),
  CONSTRAINT `conferencia_ibfk_1` FOREIGN KEY (`id_publicaciones`) REFERENCES `publicaciones` (`id_publicacion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO conferencias VALUES("1","1","","","0");
INSERT INTO conferencias VALUES("2","1","fedsdfsd","sdfs","342");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO miembros VALUES("1","yurena","del peso","perez","becario","0","yurena@ugr.es","36e1512ec214ee07f6fd919b4fd9fa80cf96e0d9","677277715","http://yurema.es","decssai","ugr","miniterio","lugar san miguel","https://yurena.es","0","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO proyectosInvestigacion VALUES("1","122","laspalmas","medioAmbiente","2017-02-01","2018-03-08","lacaixa endesa","15000","yurena del peso","yurena del peso andres guerrero","http://www.google.es");
INSERT INTO proyectosInvestigacion VALUES("2","12","lassspalmas","medioAmbiente","2017-02-01","2018-03-08","lacaixa endesa","15000","yurena del peso","yurena del peso andres guerrero","http://www.google.es");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO publicaciones VALUES("1","1","conferencia","2","SDFSDF","SDFSD","0000-00-00","","","","");
INSERT INTO publicaciones VALUES("2","1","conferencia","123413","sdfsd","sdfds","0000-00-00","","","","");



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

INSERT INTO usuarios VALUES("z","fbade9e36a3f36d3d676c1b808451dd7","profesor","z","z","z");
INSERT INTO usuarios VALUES("r","4b43b0aee35624cd95b910189b3dc231","profesor","r","r","s");
INSERT INTO usuarios VALUES("a","0cc175b9c0f1b6a831c399e269772661","profesor","a","b","a");
INSERT INTO usuarios VALUES("y","363b122c528f54df4a0446b6bab05515","profesor","e","5","miguel");
INSERT INTO usuarios VALUES("ad","523af537946b79c4f8369ed39ba78605","admin","ad","ad","ad");
INSERT INTO usuarios VALUES("sadf","912ec803b2ce49e4a541068d495ab570","admin","refsda","asdf","sdaf");
INSERT INTO usuarios VALUES("asdf","fe6d1fed11fa60277fb6a2f73efb8be2","profesor","ghfstg","sdf","asfd");
INSERT INTO usuarios VALUES("yure","670b14728ad9902aecba32e22fa4f6bd","profesor","miids","46706518G","aw@msn.com");
INSERT INTO usuarios VALUES("wwww","670b14728ad9902aecba32e22fa4f6bd","admin","yureyure","46706517G","ase@kjsd.es");



