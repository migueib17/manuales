-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: proyecto
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `capitulos`
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*
CREATE DATABASE IF NOT EXISTS proyecto;

USE proyecto;
*/

DROP TABLE IF EXISTS `capitulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capitulos`
--

LOCK TABLES `capitulos` WRITE;
/*!40000 ALTER TABLE `capitulos` DISABLE KEYS */;
/*!40000 ALTER TABLE `capitulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libros`
--

DROP TABLE IF EXISTS `libros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libros`
--

LOCK TABLES `libros` WRITE;
/*!40000 ALTER TABLE `libros` DISABLE KEYS */;
/*!40000 ALTER TABLE `libros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `miembros`
--

DROP TABLE IF EXISTS `miembros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `miembros`
--

LOCK TABLES `miembros` WRITE;
/*!40000 ALTER TABLE `miembros` DISABLE KEYS */;
INSERT INTO `miembros` VALUES (1,'yurena','del peso','perez','becario',0,'yurena@ugr.es','36e1512ec214ee07f6fd919b4fd9fa80cf96e0d9','677277715','http://yurema.es','decssai','ugr','miniterio','lugar san miguel','https://yurena.es',0,0);
/*!40000 ALTER TABLE `miembros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectosInvestigacion`
--

DROP TABLE IF EXISTS `proyectosInvestigacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectosInvestigacion`
--

LOCK TABLES `proyectosInvestigacion` WRITE;
/*!40000 ALTER TABLE `proyectosInvestigacion` DISABLE KEYS */;
INSERT INTO `proyectosInvestigacion` VALUES (1,'122','laspalmas','medioAmbiente','2017-02-01','2018-03-08','lacaixa endesa',15000,'yurena del peso','yurena del peso andres guerrero','http://www.google.es'),(2,'12','lassspalmas','medioAmbiente','2017-02-01','2018-03-08','lacaixa endesa',15000,'yurena del peso','yurena del peso andres guerrero','http://www.google.es');
/*!40000 ALTER TABLE `proyectosInvestigacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicaciones`
--

DROP TABLE IF EXISTS `publicaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicaciones`
--

LOCK TABLES `publicaciones` WRITE;
/*!40000 ALTER TABLE `publicaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `publicaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revistas`
--

DROP TABLE IF EXISTS `revistas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revistas`
--

LOCK TABLES `revistas` WRITE;
/*!40000 ALTER TABLE `revistas` DISABLE KEYS */;
/*!40000 ALTER TABLE `revistas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-12 12:51:51

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `type` text NOT NULL,
  `nombre` text NOT NULL,
  `dni` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`username`, `password`, `type`, `nombre`, `dni`, `email`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '66178705T', 'admin@admin.com');

--
