DROP TABLE IF EXISTS `#__photo`;
 
CREATE TABLE `#__photo` (
  `id` int(11) NOT NULL auto_increment,
`userid` int(11) NOT NULL,
`name` varchar(255) NOT NULL,
`password` varchar(255) NOT NULL,
   `fqdn` varchar(255) NOT NULL,
   `expiry` varchar(255) NOT NULL,
   `content_type` varchar(255) NOT NULL,
   `image_style` varchar(255) NOT NULL,
  `icon_style` varchar(255) NOT NULL,
  `defaultitem` varchar(255) NOT NULL,
   
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `#__xml`;
 
CREATE TABLE `#__xml` (
  `id` int(11) NOT NULL auto_increment,
   `xml` varchar(50000) NOT NULL,
  
   PRIMARY KEY (`id`)
);  