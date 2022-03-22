/*
Navicat MySQL Data Transfer

Source Server         : MYSQL
Source Server Version : 100413
Source Host           : localhost:3306
Source Database       : proyecto

Target Server Type    : MYSQL
Target Server Version : 100413
File Encoding         : 65001

Date: 2022-01-03 09:34:14
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
  PRIMARY KEY (`id_contenedores`),
  KEY `FK_ESTADO_CONTENEDOR` (`estado`),
  CONSTRAINT `FK_ESTADO_CONTENEDOR` FOREIGN KEY (`estado`) REFERENCES `estado_contenedor` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contenedores
-- ----------------------------
INSERT INTO `contenedores` VALUES ('43', 'inicio', '0.3569675240024344', '-78.11545645210407', '3', '', '\0', null);
INSERT INTO `contenedores` VALUES ('44', '1', '0.3552616720188183', '-78.11562826525945', '3', '\0', '\0', null);
INSERT INTO `contenedores` VALUES ('45', 'punto 2', '0.3542746380227375', '-78.11670209748046', '2', '\0', '\0', null);
INSERT INTO `contenedores` VALUES ('46', 'punto3', '0.35558353090779854', '-78.11861351883381', '2', '\0', '\0', null);
INSERT INTO `contenedores` VALUES ('47', 'punto4', '0.35407079403217095', '-78.11979243862851', '1', '\0', '\0', null);
INSERT INTO `contenedores` VALUES ('48', 'punto5', '0.35246149921270215', '-78.12168467898586', '2', '\0', '\0', null);
INSERT INTO `contenedores` VALUES ('49', 'punto 6', '0.35301938811500383', '-78.11833432245635', '1', '\0', '\0', null);
INSERT INTO `contenedores` VALUES ('50', 'punto 7', '0.3518392384745657', '-78.11832904815675', '2', '\0', '\0', null);
INSERT INTO `contenedores` VALUES ('51', 'punto 8', '0.3521825547490327', '-78.12006690141695', '2', '\0', '\0', null);
INSERT INTO `contenedores` VALUES ('52', 'fin', '0.35472524051225746', '-78.12445109655752', '2', '\0', '', null);
INSERT INTO `contenedores` VALUES ('53', 'punto 9', '0.3533305184498302', '-78.11605461080131', '3', '\0', '\0', 'C9');
INSERT INTO `contenedores` VALUES ('54', 'punto 10', '0.3525473282767771', '-78.11640142445857', '1', '\0', '\0', 'C10');

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
  PRIMARY KEY (`id_usuario`),
  KEY `FK_TIPO_USUARIO` (`id_tipo`),
  CONSTRAINT `FK_TIPO_USUARIO` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_usuario` (`id_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('1', 'ADMINISTRADOR', 'DIRECCION DE ADMINISTRADOR', '111111111', 'ADMIN', 'ADMIN', '1');
INSERT INTO `usuario` VALUES ('2', 'PACO', 'CALDERON', '1722221450', 'PACO', 'PEPE', '2');
SET FOREIGN_KEY_CHECKS=1;
