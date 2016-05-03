/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : hotelms

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-04-30 19:02:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for t_admin
-- ----------------------------
DROP TABLE IF EXISTS `t_admin`;
CREATE TABLE `t_admin` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `user` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `job` varchar(50) NOT NULL,
  `jobid` varchar(20) NOT NULL,
  `permission` int(5) NOT NULL COMMENT '1管理员,2普通用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_admin
-- ----------------------------
INSERT INTO `t_admin` VALUES ('1', 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '张总', '经理', '1001', '1');
INSERT INTO `t_admin` VALUES ('2', 'staff', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '李四', '员工', '1002', '2');
INSERT INTO `t_admin` VALUES ('3', 'staff1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '张思', '员工', '1003', '2');
INSERT INTO `t_admin` VALUES ('4', 'staff3', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '高才', '收银', '1004', '2');
INSERT INTO `t_admin` VALUES ('5', 'staff4', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '单鄂', '收银', '1005', '2');
INSERT INTO `t_admin` VALUES ('6', 'staff5', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '分饿', '收银', '1006', '2');
INSERT INTO `t_admin` VALUES ('7', 'admin1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '张丹峰', '收银', '1000', '1');

-- ----------------------------
-- Table structure for t_check_in
-- ----------------------------
DROP TABLE IF EXISTS `t_check_in`;
CREATE TABLE `t_check_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(6) DEFAULT NULL,
  `cust_id` int(6) NOT NULL,
  `room_id` int(6) NOT NULL,
  `check_in_time` datetime DEFAULT NULL,
  `guarantee_price` decimal(9,2) DEFAULT NULL,
  `room_price` decimal(9,2) DEFAULT NULL,
  `check_out` int(11) DEFAULT NULL,
  `check_out_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_check_in
-- ----------------------------
INSERT INTO `t_check_in` VALUES ('1', '1', '1', '1', '2016-04-27 07:54:13', '120.00', '98.00', '1', '2016-04-28 07:54:13');
INSERT INTO `t_check_in` VALUES ('2', '1', '2', '2', '2016-04-27 08:19:25', '150.00', '135.00', '0', '2016-04-28 21:26:30');
INSERT INTO `t_check_in` VALUES ('3', '1', '4', '4', '2016-04-27 08:32:37', '350.00', '300.00', '0', '2016-04-29 21:26:35');
INSERT INTO `t_check_in` VALUES ('4', '1', '3', '3', '2016-04-27 09:07:11', '250.00', '200.00', '1', '2016-04-29 21:26:38');
INSERT INTO `t_check_in` VALUES ('5', '1', '1', '3', '2016-04-30 01:37:39', '300.00', '200.00', '1', '2016-05-01 00:00:00');
INSERT INTO `t_check_in` VALUES ('6', '1', '3', '1', '2016-04-30 00:00:00', '100.00', '98.00', '1', '2016-05-01 00:00:00');
INSERT INTO `t_check_in` VALUES ('7', '1', '3', '1', '2016-04-30 02:00:12', '100.00', '98.00', '1', '2016-05-01 02:00:12');
INSERT INTO `t_check_in` VALUES ('8', '1', '3', '1', '2016-04-30 14:01:58', '100.00', '98.00', '0', '2016-05-01 14:01:58');
INSERT INTO `t_check_in` VALUES ('9', '1', '5', '5', '2016-04-30 12:46:19', '250.00', '98.00', '0', '2016-04-29 00:00:00');
INSERT INTO `t_check_in` VALUES ('10', '1', '5', '5', '2016-04-30 12:47:08', '250.00', '98.00', '0', '2016-04-29 00:00:00');

-- ----------------------------
-- Table structure for t_customer
-- ----------------------------
DROP TABLE IF EXISTS `t_customer`;
CREATE TABLE `t_customer` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `idcard` varchar(50) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `is_delete` int(6) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_customer
-- ----------------------------
INSERT INTO `t_customer` VALUES ('1', '林更新', '女', '32146790315678935x', '18155228399', '000000');
INSERT INTO `t_customer` VALUES ('2', '李海东', '男', '32146790315656735x', '18155228323', '000000');
INSERT INTO `t_customer` VALUES ('3', '张丹峰', '男', '321467903156567359', '18155228397', '000001');
INSERT INTO `t_customer` VALUES ('4', '唐大新', '男', '321467903156567323', '18155228322', '000000');
INSERT INTO `t_customer` VALUES ('5', '林铁蛋', '男', '321467903156567234', '18154528399', '000000');
INSERT INTO `t_customer` VALUES ('8', '赵瑞', '男', '321467903156567312', '18155228397', '000000');
INSERT INTO `t_customer` VALUES ('9', '单鄂', '男', '321467903156561312', '18155228397', '000000');

-- ----------------------------
-- Table structure for t_reserve
-- ----------------------------
DROP TABLE IF EXISTS `t_reserve`;
CREATE TABLE `t_reserve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(6) DEFAULT NULL,
  `cust_id` int(6) NOT NULL,
  `room_id` int(6) NOT NULL,
  `check_in_time` datetime DEFAULT NULL,
  `guarantee_price` decimal(9,2) DEFAULT NULL,
  `room_price` decimal(9,2) DEFAULT NULL,
  `check_out_time` datetime DEFAULT NULL,
  `check_in` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_reserve
-- ----------------------------
INSERT INTO `t_reserve` VALUES ('1', '1', '5', '5', '2016-04-28 00:00:00', '250.00', '98.00', '2016-04-29 00:00:00', '1');

-- ----------------------------
-- Table structure for t_room
-- ----------------------------
DROP TABLE IF EXISTS `t_room`;
CREATE TABLE `t_room` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `room_num` varchar(20) DEFAULT NULL,
  `room_type` int(6) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `state` int(6) DEFAULT NULL COMMENT '房间状态，0空闲，1预订，2入住',
  `is_delete` int(6) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_room
-- ----------------------------
INSERT INTO `t_room` VALUES ('1', 'A-1001', '1', '010-1234567', '2', '000000');
INSERT INTO `t_room` VALUES ('2', 'A-1002', '2', '010-1234568', '2', '000000');
INSERT INTO `t_room` VALUES ('3', 'B-1002', '3', '010-1234569', '1', '000000');
INSERT INTO `t_room` VALUES ('4', 'C-1001', '4', '010-1234560', '2', '000000');
INSERT INTO `t_room` VALUES ('5', 'A-1003', '1', '010-1234560', '1', '000000');
INSERT INTO `t_room` VALUES ('7', 'B-1003', '3', '010-1234568', '1', '000000');

-- ----------------------------
-- Table structure for t_room_type
-- ----------------------------
DROP TABLE IF EXISTS `t_room_type`;
CREATE TABLE `t_room_type` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `room_type` varchar(20) DEFAULT NULL,
  `price` decimal(9,2) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `remain` int(6) DEFAULT NULL,
  `is_delete` int(6) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_room_type
-- ----------------------------
INSERT INTO `t_room_type` VALUES ('1', '单间', '100.00', '100', '100', '000001');
INSERT INTO `t_room_type` VALUES ('2', '标准间', '135.00', '50', '50', '000000');
INSERT INTO `t_room_type` VALUES ('3', '家庭房', '200.00', '100', '50', '000000');
INSERT INTO `t_room_type` VALUES ('4', '商务房', '300.00', '40', '40', '000000');
INSERT INTO `t_room_type` VALUES ('6', '大床房', '200.00', '10', '10', '000000');
