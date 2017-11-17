
-- create tables under mmxci
-- create table mmxci;
grant all PRIVILEGES on mmxci.* to mmxci@localhost IDENTIFIED by '!1234roon';
flush PRIVILEGES;

-- 后台管理员登陆账号
CREATE TABLE `mmxci_operator` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  account varchar(20) NOT NULL COMMENT '登录账户',
  nick_name varchar(20) NULL COMMENT '昵称',
  password varchar(50) NOT NULL,
  role_id int(11) NULL COMMENT '角色编号',
  token varchar(255) NULL COMMENT '根据token获取特定权限，后期可用',
  status tinyint(1) NOT NULL COMMENT ' 0-无效 1-正常',
  logined_count int(11) NOT NULL COMMENT '登录次数',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作员用户表';

-- 后台菜单管理
CREATE TABLE `mmxci_rights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0' COMMENT '父级菜单id',
  `idx` int(5) DEFAULT '0' COMMENT '排列顺序',
  `name` varchar(32) NOT NULL COMMENT '名称',
  `right_key` varchar(100) NOT NULL COMMENT '权限关键字',
  `uri` varchar(100) DEFAULT NULL COMMENT '链接路径',
  `icon` varchar(100) NOT NULL COMMENT '菜单图标',
  `memo` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT ' 0-无效 1-正常',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  `is_menu` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `right_key` (`right_key`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='权限信息表';

-- 后台账号角色管理
CREATE TABLE `mmxci_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '名称',
  `status` tinyint(1) NOT NULL COMMENT ' 0-无效 1-正常',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色信息表';

-- 后台账号角色-菜单关联管理
CREATE TABLE `mmxci_role_rights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `right_id` int(11) NOT NULL COMMENT '关联 mmxci_rights id',
  `right_key` varchar(100) NOT NULL COMMENT '权限',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色菜单表';

-- 后台账号登陆日志
CREATE TABLE `mmxci_login_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT '管理员绑定的微信openid' ,
  `member_id` int(11) DEFAULT NULL COMMENT '关联mmxci_operator id',
  `memo` varchar(100) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志信息表';

-- 微信配置
CREATE TABLE `mmxci_wechat_config` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `qrc_img` varchar(100) DEFAULT NULL COMMENT '公众号二维码',
  `token` varchar(100) DEFAULT NULL COMMENT '接口token',
  `appid` varchar(100) DEFAULT NULL COMMENT '公众号 appid',
  `encodingaeskey` varchar(100) DEFAULT NULL COMMENT '加密key',
  `appsecret` varchar(100) DEFAULT NULL COMMENT '公众号 密钥',
  `mch_id` varchar(100) DEFAULT NULL COMMENT '商户身份标识',
  `partnerkey` varchar(100) DEFAULT NULL COMMENT '商户权限密钥',
  `ssl_cer` varchar(500) DEFAULT NULL COMMENT '商户证书CER',
  `ssl_key` varchar(500) DEFAULT NULL COMMENT '商户证书KEY',
  `publish_status` char(2) DEFAULT NULL COMMENT '菜单发布状态，0：未发布，1：已发布',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信配置信息表';


CREATE TABLE `mmxci_wechat_config_meta` (
  `key_id` varchar(100) NOT NULL,
  `key_val` varchar(1024) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信配置信息元数据表';


CREATE TABLE `mmxci_wechat_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类id',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `type` char(30) NOT NULL DEFAULT '1' COMMENT '事件类型',
  `url` varchar(511) DEFAULT NULL COMMENT 'url',
  `keyword` varchar(255) DEFAULT NULL COMMENT '关键词',
  `idx` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='微信底部菜单表';