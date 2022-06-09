/*
Navicat MySQL Data Transfer

Source Server         : MYSQL
Source Server Version : 100413
Source Host           : localhost:3306
Source Database       : proyecto

Target Server Type    : MYSQL
Target Server Version : 100413
File Encoding         : 65001

Date: 2022-05-25 15:36:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for contenedores
-- ----------------------------
DROP TABLE IF EXISTS `contenedores`;
CREATE TABLE `contenedores` (
  `id_contenedores` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_contenedores` varchar(255) DEFAULT NULL,
  `latitud` varchar(255) DEFAULT NULL,
  `longitud` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `inicio` bit(1) DEFAULT b'0',
  `fin` bit(1) DEFAULT b'0',
  `codigo` varchar(10) DEFAULT NULL,
  `largo` varchar(255) DEFAULT NULL,
  `alto` varchar(255) DEFAULT NULL,
  `ancho` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_contenedores`),
  KEY `FK_ESTADO_CONTENEDOR` (`estado`),
  CONSTRAINT `FK_ESTADO_CONTENEDOR` FOREIGN KEY (`estado`) REFERENCES `estado_contenedor` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contenedores
-- ----------------------------
INSERT INTO `contenedores` VALUES ('43', 'inicio', '-0.0765376', '-78.4336947', '3', '', '\0', '1', null, null, null, null, 'contenedor1.jpg');
INSERT INTO `contenedores` VALUES ('44', 'contenedor 1', '-0.0763982', '-78.4332763', '3', '', '\0', '1', '6', '5', '7', 's', 'contenedor1.jpg');
INSERT INTO `contenedores` VALUES ('45', 'punto 2', '-0.0771843', '-78.4343003', '2', '\0', '\0', '1', null, null, null, null, 'contenedor1.jpg');
INSERT INTO `contenedores` VALUES ('49', 'punto 6', '-0.0762748', '-78.4324636', '1', '\0', '\0', '1', null, null, null, null, 'contenedor1.jpg');
INSERT INTO `contenedores` VALUES ('50', 'punto 7', '-0.0765001', '-78.4324475', '2', '\0', '\0', '1', null, null, null, null, 'contenedor1.jpg');
INSERT INTO `contenedores` VALUES ('51', 'punto 8', '-0.0754463', '-78.4333033', '2', '\0', '\0', '1', null, null, null, null, 'contenedor1.jpg');
INSERT INTO `contenedores` VALUES ('53', 'punto 9', '-0.0766557', '-78.432603', '3', '\0', '\0', 'br9', '', '', '', '', 'contenedor1.jpg');
INSERT INTO `contenedores` VALUES ('55', 'contenedor nuevo', '-0.0753164074475381', '-78.43473315238954', '1', '\0', '\0', 'BR1', '2', '3', '1', 'contenedor nuevo', 'contenedor1.jpg');

-- ----------------------------
-- Table structure for estado_contenedor
-- ----------------------------
DROP TABLE IF EXISTS `estado_contenedor`;
CREATE TABLE `estado_contenedor` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estado_contenedor
-- ----------------------------
INSERT INTO `estado_contenedor` VALUES ('1', 'VACIO', null);
INSERT INTO `estado_contenedor` VALUES ('2', 'MEDIO', null);
INSERT INTO `estado_contenedor` VALUES ('3', 'LLENO', null);

-- ----------------------------
-- Table structure for historial
-- ----------------------------
DROP TABLE IF EXISTS `historial`;
CREATE TABLE `historial` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `sensor` int(255) DEFAULT NULL,
  `estado` int(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `FK_CONTENEDOR_HISTORIAL` (`sensor`),
  KEY `FK_ESTADO_HISTORIAL` (`estado`),
  CONSTRAINT `FK_CONTENEDOR_HISTORIAL` FOREIGN KEY (`sensor`) REFERENCES `contenedores` (`id_contenedores`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_ESTADO_HISTORIAL` FOREIGN KEY (`estado`) REFERENCES `estado_contenedor` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of historial
-- ----------------------------
INSERT INTO `historial` VALUES ('1', '44', '1', '2022-04-09');
INSERT INTO `historial` VALUES ('2', '49', '1', '2022-04-13');
INSERT INTO `historial` VALUES ('3', '44', '1', '2022-05-18');
INSERT INTO `historial` VALUES ('4', '53', '2', '2022-04-06');
INSERT INTO `historial` VALUES ('5', '44', '2', '2022-04-13');
INSERT INTO `historial` VALUES ('6', '45', '2', '2022-04-19');
INSERT INTO `historial` VALUES ('7', '44', '3', '2022-04-20');
INSERT INTO `historial` VALUES ('8', '44', '3', '2022-05-14');
INSERT INTO `historial` VALUES ('9', '44', '2', '2022-05-15');
INSERT INTO `historial` VALUES ('11', '51', '2', '2022-04-13');
INSERT INTO `historial` VALUES ('12', '44', '2', '2022-05-18');
INSERT INTO `historial` VALUES ('13', '44', '1', '2022-04-21');
INSERT INTO `historial` VALUES ('14', '51', '2', '2022-04-20');
INSERT INTO `historial` VALUES ('15', '44', '1', '2022-05-25');
INSERT INTO `historial` VALUES ('16', '50', '1', '2022-04-20');
INSERT INTO `historial` VALUES ('17', '55', '2', '2022-05-12');

-- ----------------------------
-- Table structure for tipo_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `detalle_tipo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tipo_usuario
-- ----------------------------
INSERT INTO `tipo_usuario` VALUES ('1', 'ADMINISTRADOR');
INSERT INTO `tipo_usuario` VALUES ('2', 'USUARIO');

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_usuario` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `ci_ruc` varchar(10) DEFAULT NULL,
  `nick` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `FK_TIPO_USUARIO` (`id_tipo`),
  CONSTRAINT `FK_TIPO_USUARIO` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_usuario` (`id_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('1', 'ADMINISTRADOR', 'DIRECCION DE ADMINISTRADOR', '111111111', 'ADMIN', 'ADMIN', '1', 'usuario1.jpg', '99999999', 'javierexample.com');
INSERT INTO `usuario` VALUES ('2', 'PACO', 'CALDERON', '1722221450', 'PACO', 'PEPE', '2', 'ss', '099999999', null);
SET FOREIGN_KEY_CHECKS=1;
