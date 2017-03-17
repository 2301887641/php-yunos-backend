/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : yunos

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-03-10 17:31:18
*/

-- Table structure for `yunos_account`
-- ----------------------------
DROP TABLE IF EXISTS `yunos_account`;
CREATE TABLE `yunos_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) DEFAULT '' COMMENT '账号',
  `passwd` varchar(32) DEFAULT '' COMMENT '密码',
  `salt` char(5) DEFAULT '' COMMENT '加盐',
  `role` int(11) unsigned DEFAULT '0' COMMENT '角色',
  `createtime` int(11) DEFAULT '0',
  `updatetime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunos_account
-- ----------------------------

-- ----------------------------
-- Table structure for `yunos_category`
-- ----------------------------
DROP TABLE IF EXISTS `yunos_category`;
CREATE TABLE `yunos_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '' COMMENT '栏目名称',
  `parent_id` int(10) unsigned DEFAULT '0' COMMENT '父栏目id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunos_category
-- ----------------------------

-- ----------------------------
-- Table structure for `yunos_privilege`
-- ----------------------------
DROP TABLE IF EXISTS `yunos_privilege`;
CREATE TABLE `yunos_privilege` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '' COMMENT '权限名称',
  `module_name` varchar(50) DEFAULT '' COMMENT '模块名称',
  `controller_name` varchar(50) DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(50) DEFAULT '' COMMENT '方法名称',
  `parent_id` int(10) unsigned DEFAULT '0' COMMENT '父id',
  `createtime` int(11) DEFAULT '0',
  `updatetime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunos_privilege
-- ----------------------------

-- ----------------------------
-- Table structure for `yunos_role`
-- ----------------------------
DROP TABLE IF EXISTS `yunos_role`;
CREATE TABLE `yunos_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `privilege_list` varchar(200) DEFAULT ',' COMMENT '权限列表',
  `name` varchar(50) DEFAULT '' COMMENT '角色名称',
  `sort` smallint(6) unsigned DEFAULT '0' COMMENT '排序',
  `is_on` bit(1) DEFAULT b'0' COMMENT '是否启用',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunos_role
-- ----------------------------
INSERT INTO `yunos_role` VALUES ('1', ',1,2,3,', '测试', '1111', '', '111', '1111');
INSERT INTO `yunos_role` VALUES ('2', ',1,2', '测试2', '22', '', '1111', '222');
INSERT INTO `yunos_role` VALUES ('3', ',22', '似懂非懂', '222', '', '333', '3333');
INSERT INTO `yunos_role` VALUES ('4', ',33', '哒哒', '444', '', '333', '333');
INSERT INTO `yunos_role` VALUES ('5', ',3', '测3', '444', '', '44', '444');
INSERT INTO `yunos_role` VALUES ('6', ',3', '地方', '333', '', '444', '234');
