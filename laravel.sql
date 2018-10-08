/*
Navicat MySQL Data Transfer

Source Server         : 本地(xampp)
Source Server Version : 100130
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 100130
File Encoding         : 65001

Date: 2018-03-08 18:32:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for addr
-- ----------------------------
DROP TABLE IF EXISTS `addr`;
CREATE TABLE `addr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `Info` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='收货地址';

-- ----------------------------
-- Records of addr
-- ----------------------------
INSERT INTO `addr` VALUES ('1', '1', '张三', '18166666666', '四川成都', '武侯', '132456@qq.com');
INSERT INTO `addr` VALUES ('2', '1', '小米', '456789', '成都市试试', '辅导费', '132456@qq.com');
INSERT INTO `addr` VALUES ('3', '2', '小花', '456', '1313', '是否', '465');
INSERT INTO `addr` VALUES ('4', '3', '方娜师', '321321', '胜多负少', '速度多少分', '4564');

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(10) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL COMMENT '密码',
  `time` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('3', '1112323', '222313123', '1498572137', null, '1', '2018-02-26 09:55:40', '2018-02-27 10:33:14');
INSERT INTO `admin` VALUES ('5', '2', '2', '1498572186', null, '0', '2018-02-26 09:55:40', '2018-02-27 14:34:33');
INSERT INTO `admin` VALUES ('6', '22', '22', '1498572226', null, '0', '2018-02-26 09:55:40', '2018-02-27 10:34:22');
INSERT INTO `admin` VALUES ('7', 'asdfg', 'zaqxsw', null, null, '0', '2018-02-26 09:55:40', '2018-02-26 09:55:40');
INSERT INTO `admin` VALUES ('8', '小明', '123', null, null, '0', '2018-02-26 09:57:16', '2018-02-26 09:57:16');
INSERT INTO `admin` VALUES ('9', '张虎', '123456', null, null, '0', '2018-02-27 01:14:00', '2018-02-27 01:14:00');
INSERT INTO `admin` VALUES ('10', '枫之韵', '123456', null, null, '1', '2018-02-27 06:34:25', '2018-02-27 06:34:25');

-- ----------------------------
-- Table structure for ads
-- ----------------------------
DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ads
-- ----------------------------
INSERT INTO `ads` VALUES ('2', '/storage/img/COhQdSlxMgPSS0zMutP3CdbM3hmEpGCDeZaqwUUS.jpeg', '1', 'www.baidu.com', '是是是');
INSERT INTO `ads` VALUES ('3', '/storage/img/enTFuhbgAWhJjCNKNzz7JH1zxecj5kHTclZOP37J.jpeg', '2', 'www.baidu.com', 'gg是');
INSERT INTO `ads` VALUES ('4', '/storage/img/hYzthGiwjN80PyOOL33nXoWAQRXXLw0kTp55F514.jpeg', '3', 'www.baidu.com', 'sdf 所发生的');

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `statu` tinyint(4) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comment
-- ----------------------------

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `types_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `text` text,
  `config` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('1', '12', '女生新潮裤', '水电费水电费', '/storage/img/Cm2mnEHQziBt3J3Cje9iT427oMvyojidVGN6llZ8.jpeg', '123', '123', '<p>地方放水电费</p>', '<p>非官方大哥</p>');
INSERT INTO `goods` VALUES ('2', '9', '女生新潮裤', '水电费水电费', '/storage/img/wAlC0ZayYfhe7O8D8RJ6JVbkKjJcAvtIMpmyxdKH.jpeg', '111', '111', '<p>sdfsd&nbsp;</p>', '<p>ghfdhgf&nbsp;</p>');

-- ----------------------------
-- Table structure for goodsimg
-- ----------------------------
DROP TABLE IF EXISTS `goodsimg`;
CREATE TABLE `goodsimg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goodsimg
-- ----------------------------
INSERT INTO `goodsimg` VALUES ('1', '1', '/storage/img/abrqc5Vo5phWcFtR6BOOKflXHxZhsi3MUeoLsin3.jpeg');
INSERT INTO `goodsimg` VALUES ('2', '2', '/storage/img/mFXy3wBEXPadNiB2CVDcpFlZbWmOTANumjjJssAH.jpeg');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_num` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `addr_id` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `pay_status` tinyint(2) DEFAULT '0' COMMENT '支付状态，0-待支付，1-支付成功，2-支付失败',
  `orderstatu_id` tinyint(2) DEFAULT NULL COMMENT '订单状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', '0001', '1', '1', '2', '2', '1', '2018-02-26 09:36:16', '1', '1');
INSERT INTO `orders` VALUES ('2', '0002', '2', '2', '2', '2', '3', '2018-02-26 09:36:16', '1', '1');
INSERT INTO `orders` VALUES ('3', '0003', '1', '2', '2', '2', '2', '2018-02-26 09:36:16', '1', '1');

-- ----------------------------
-- Table structure for orderstatu
-- ----------------------------
DROP TABLE IF EXISTS `orderstatu`;
CREATE TABLE `orderstatu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='订单状态';

-- ----------------------------
-- Records of orderstatu
-- ----------------------------
INSERT INTO `orderstatu` VALUES ('1', '未付款');
INSERT INTO `orderstatu` VALUES ('2', '已发货');
INSERT INTO `orderstatu` VALUES ('3', '在途中');
INSERT INTO `orderstatu` VALUES ('4', '配送中');
INSERT INTO `orderstatu` VALUES ('5', '签收');
INSERT INTO `orderstatu` VALUES ('6', '已完成');

-- ----------------------------
-- Table structure for slider
-- ----------------------------
DROP TABLE IF EXISTS `slider`;
CREATE TABLE `slider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) DEFAULT NULL,
  `realimg` varchar(255) DEFAULT NULL,
  `order` tinyint(4) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='轮播图';

-- ----------------------------
-- Records of slider
-- ----------------------------
INSERT INTO `slider` VALUES ('1', '/storage/avatars/8YTkihKN9zTR3PsPhM7op8KjrtPbLoT7gdKHnsGz.jpeg', 'avatars/8YTkihKN9zTR3PsPhM7op8KjrtPbLoT7gdKHnsGz.jpeg', '1', 'www', 'www.baidu.com');
INSERT INTO `slider` VALUES ('2', '/storage/img/D4lVv3WTopRqGpOoHeaHcuWgqpsu5sTWsL81o02y.jpeg', 'public/img/D4lVv3WTopRqGpOoHeaHcuWgqpsu5sTWsL81o02y.jpeg', '1', 'asdsd', 'asdsa');
INSERT INTO `slider` VALUES ('3', '/storage/img/VAtV6W8N168flsG3AdPwEmyFabIa0Kmml1xOiGT3.jpeg', 'public/img/VAtV6W8N168flsG3AdPwEmyFabIa0Kmml1xOiGT3.jpeg', '2', 'sdfds', 'www.baidu.com');

-- ----------------------------
-- Table structure for types
-- ----------------------------
DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL COMMENT '路径',
  `sort` int(11) DEFAULT NULL,
  `is_lou` tinyint(4) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='商品分类';

-- ----------------------------
-- Records of types
-- ----------------------------
INSERT INTO `types` VALUES ('1', '衣服', '0', '0,', '1', '1', '衣服', '衣服', '衣服');
INSERT INTO `types` VALUES ('2', '裤子', '0', '0,', '2', '1', '裤子', '裤子', '裤子');
INSERT INTO `types` VALUES ('3', '鞋子', '0', '0,', '1', '1', '鞋子', '鞋子', '鞋子');
INSERT INTO `types` VALUES ('4', '女裤', '2', '0,2,', '4', '1', '女裤', '女裤', '女裤');
INSERT INTO `types` VALUES ('5', '男裤', '2', '0,2,', '5', '1', '男裤', '男裤', '男裤');
INSERT INTO `types` VALUES ('6', '皮鞋', '3', '0,3,', '6', '1', '皮鞋', '皮鞋', '皮鞋');
INSERT INTO `types` VALUES ('7', '布鞋', '3', '0,3,', '7', '1', '布鞋', '布鞋', '布鞋');
INSERT INTO `types` VALUES ('9', '短裤', '4', '0,2,4,', '9', '1', '短裤', '短裤', '短裤');
INSERT INTO `types` VALUES ('10', '男鞋', '6', '0,3,6,', '43', '1', '所发生的', '12', '水电费水电费');
INSERT INTO `types` VALUES ('11', '女靴', '6', '0,3,6,', '3', '1', '所发生的', '水电费水电费', '胜多负少');
INSERT INTO `types` VALUES ('12', '长裤', '4', '0,2,4,', '5', '1', '水电费水电费', '水电费水电费是', '防守打法');

-- ----------------------------
-- Table structure for typesads
-- ----------------------------
DROP TABLE IF EXISTS `typesads`;
CREATE TABLE `typesads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of typesads
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `create_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '12312@qq.com', 'asd', '123', null, '0', '1111', null, '2018-03-01 11:45:51', '2018-02-26 07:42:11');
INSERT INTO `user` VALUES ('2', '12312@qq.com', 'azxs', '1234', null, '0', '11111', null, '2018-03-01 11:45:55', '2018-02-26 07:55:40');
INSERT INTO `user` VALUES ('3', '12312@qq.com', 'abcd', '123456', null, '0', '1111', null, '2018-03-01 11:45:56', '2018-02-26 09:26:00');
INSERT INTO `user` VALUES ('4', null, 'qwer', '123456', null, '0', null, null, '2018-02-26 09:34:48', '2018-02-26 09:34:48');
INSERT INTO `user` VALUES ('5', null, '小米', '123456', null, '0', null, null, '2018-03-01 14:45:07', '2018-02-26 09:36:01');
INSERT INTO `user` VALUES ('6', null, 'zxcdsa', 'asdfgh', null, '0', null, null, '2018-02-26 09:36:16', '2018-02-26 09:36:16');
INSERT INTO `user` VALUES ('7', null, '中山港', 'cdevfr', null, '0', null, null, '2018-02-26 09:37:08', '2018-02-26 09:37:08');
INSERT INTO `user` VALUES ('8', '123456@qq.com', '小米2', '123', '123123', '0', '5bCP57GzMg==', null, '2018-03-01 06:49:36', '2018-03-01 06:49:36');

-- ----------------------------
-- Table structure for userinfo
-- ----------------------------
DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE `userinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `addrInfo` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of userinfo
-- ----------------------------
