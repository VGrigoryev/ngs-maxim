DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(1) NOT NULL COMMENT 'Тип товара',
  `width` float NOT NULL COMMENT 'Ширина',
  `height` float NOT NULL COMMENT 'Высота',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `product` VALUES (1,'a',120,120),(2,'b',60,90),(3,'c',150,150);
