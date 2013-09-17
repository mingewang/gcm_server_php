##mysql -uroot -p < thisfile 


CREATE DATABASE IF NOT EXISTS gcm;

GRANT ALL ON *.* TO 'gcm'@'localhost' IDENTIFIED BY 'gcm';

FLUSH PRIVILEGES;

USE gcm;

# alter table gcm_users ADD sipuri VARCHAR(255) NOT NULL after gcm_regid;

# The reg_id from Google cloud messeging
# may have many sip_uri, 
CREATE TABLE IF NOT EXISTS `device_apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_id` text NOT NULL,
  `sip_uri` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `scheme` char(10) NULL,
  `host` varchar(255) NULL,
  `port` char(10) NULL,
  `params` varchar(255) NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp,
  PRIMARY KEY (`id`),
#  index  (reg_id(20)),
  KEY `reg_id`  (`reg_id`(20)),
  KEY `sip_uri` (`sip_uri`),
  KEY `user` (`user`),
  KEY `host` (`host`)
) ENGINE=InnoDB DEFAULT CHARACTER SET  utf8 COLLATE utf8_general_ci  AUTO_INCREMENT=1 ;


