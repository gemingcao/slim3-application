/*
Navicat MySQL Data Transfer

Source Server         : localhost-71
Source Server Version : 100135
Source Host           : localhost:3306
Source Database       : slim3-application

Target Server Type    : MYSQL
Target Server Version : 100135
File Encoding         : 65001

Date: 2018-09-26 11:20:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gmc_test
-- ----------------------------
DROP TABLE IF EXISTS `gmc_test`;
CREATE TABLE `gmc_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gmc_test
-- ----------------------------
INSERT INTO `gmc_test` VALUES ('1', 'gemingcao', 'http://www.gemingcao.com/');
INSERT INTO `gmc_test` VALUES ('2', 'hello', 'world!');
