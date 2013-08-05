/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50525
Source Host           : localhost:3306
Source Database       : ik_erp

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2013-08-05 03:37:13
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `shipping_date` date NOT NULL,
  `worker` varchar(255) NOT NULL,
  `customer` varchar(255) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `comment` text,
  `need_install` tinyint(1) NOT NULL,
  `install_person` varchar(255) DEFAULT NULL,
  `install_phone` varchar(255) DEFAULT NULL,
  `install_address` varchar(255) DEFAULT NULL,
  `install_comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `articul` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', '0001', 'Продукт 1', '1111');
INSERT INTO `products` VALUES ('2', '0002', 'Продукт 2', '2222');
INSERT INTO `products` VALUES ('3', '0003', 'Продукт 3', '3333');
INSERT INTO `products` VALUES ('4', '0004', 'Продукт 4', '4444');
INSERT INTO `products` VALUES ('5', '0005', 'Продукт 5', '5555');
INSERT INTO `products` VALUES ('6', '0006', 'Продукт 6', '6666');
INSERT INTO `products` VALUES ('7', '0007', 'Продукт 7', '7777');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'ozicoder@gmail.com', 'admin', '', '', null);
