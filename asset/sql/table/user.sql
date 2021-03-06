CREATE TABLE IF NOT EXISTS `user` (
    `id` int(11) unsigned NOT NULL,
    `account` varchar(20) NOT NULL,
    `csrf_token` varchar(32) NOT NULL,
    `email` varchar(255) NOT NULL,
    `name` varchar(100) NOT NULL,
    `password` varchar(32) NOT NULL,
    `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
    `create_time` datetime NOT NULL,
    `modify_time` datetime NOT NULL,
    `delete_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `user` ADD PRIMARY KEY (`id`);
ALTER TABLE `user` MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;