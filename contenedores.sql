/*
Navicat MySQL Data Transfer

Source Server         : MYSQL
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : proyecto

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-11-23 11:58:24
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
  `estado` int(11) DEFAULT '1',
  `inicio` bit(1) DEFAULT b'0',
  `fin` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id_contenedores`),
  KEY `FK_ESTADO_CONTENEDOR` (`estado`),
  CONSTRAINT `FK_ESTADO_CONTENEDOR` FOREIGN KEY (`estado`) REFERENCES `estado_contenedor` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contenedores
-- ----------------------------
INSERT INTO `contenedores` VALUES ('1', 'CONTENEDOR 1', '0.366382', '-78.112900', '1', '\0', '\0');
INSERT INTO `contenedores` VALUES ('2', 'CONTENEDOR 2', '0.365749', '-78.112879', '2', '\0', '\0');
INSERT INTO `contenedores` VALUES ('3', 'CONTENEDOR 3', '0.36114095927930573', '-78.11313697450676', '3', '\0', '\0');
INSERT INTO `contenedores` VALUES ('4', 'CONTENEDOR 4', '0.36193487734194213', '-78.11276117488964', '1', '\0', '\0');
INSERT INTO `contenedores` VALUES ('27', 'CONTENEDOR 5', '0.3653036640220642', '-78.11370624632794', '3', '\0', '\0');
INSERT INTO `contenedores` VALUES ('30', 'CONTENEDOR 11', '0.36441318868434264', '-78.11379201216155', '1', '\0', '\0');
INSERT INTO `contenedores` VALUES ('31', 'CONTENEDOR 6', '0.3640591442484949', '-78.11300811464021', '3', '\0', '\0');
INSERT INTO `contenedores` VALUES ('32', 'CONTENEDOR 7', '0.3633081408537183', '-78.11298663799582', '2', '\0', '\0');
INSERT INTO `contenedores` VALUES ('33', 'CONTENEDOR 9', '0.362760981198219', '-78.11301885296243', '3', '\0', '\0');
INSERT INTO `contenedores` VALUES ('34', 'CONTENEDOR 10', '0.3633188694740786', '-78.11214904886343', '1', '\0', '\0');
INSERT INTO `contenedores` VALUES ('41', 'PUNTO DE INICIO', '0.35905960619169736', '-78.11358798403955', '1', '', '\0');
INSERT INTO `contenedores` VALUES ('42', 'PUNTO FINAL', '0.3675137590568327', '-78.11177320758607', '1', '\0', '');
