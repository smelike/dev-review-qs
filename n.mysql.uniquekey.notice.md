## Q：一个公告只能给一个用户 发送唯一一次通知

> 解决方案：为 notice_id 和 receive_id 创建一个联合的唯一索引

| notice_send | CREATE TABLE `notice_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_id` int(11) NOT NULL COMMENT '公告id',
  `receive_id` int(11) NOT NULL COMMENT '接受者id',
  `readed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '查看状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx-notice-receive` (`notice_id`,`receive_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci |