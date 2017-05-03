CREATE TABLE `/*TABLE_PREFIX*/t_banner` (
  `pk_i_id` int(10) NOT NULL AUTO_INCREMENT,
  `s_position` tinytext DEFAULT NULL,
  `i_priority` int(10) DEFAULT NULL,
  `s_settings` mediumtext) DEFAULT NULL,
  PRIMARY KEY (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `/*TABLE_PREFIX*/t_banner_positions` (
  `pk_i_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_title` varchar(255) DEFAULT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `s_type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `/*TABLE_PREFIX*/t_banner_positions` (`pk_i_id`, `s_title`, `s_name`, `s_type`) VALUES ('1', 'All Positions', 'all', 'horizontal');