CREATE DATABASE IF NOT EXISTS `trotri`;

USE `trotri`;

DROP TABLE IF EXISTS `tr_system_options`;
CREATE TABLE `tr_system_options` (
  `option_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `option_category` varchar(64) NOT NULL DEFAULT '' COMMENT '配置类别',
  `option_key` varchar(64) NOT NULL DEFAULT '' COMMENT '配置Key',
  `option_value` longtext COMMENT '配置Value',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `uk_cat_key` (`option_category`,`option_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站点配置表';

DROP TABLE IF EXISTS `tr_system_log_ymd`;
CREATE TABLE `tr_system_log_ymd` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_NOTICE' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按天存Notice、Info等日志';

DROP TABLE IF EXISTS `tr_system_logwf_ym`;
CREATE TABLE `tr_system_logwf_ym` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `priority` enum('DB_EMERG','DB_ALERT','DB_CRIT','DB_ERR','DB_WARNING','DB_NOTICE','DB_INFO','DB_DEBUG') NOT NULL DEFAULT 'DB_WARNING' COMMENT '日志类型',
  `event` text COMMENT '日志内容',
  `dt_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表，按月存Warning、Err等日志';
