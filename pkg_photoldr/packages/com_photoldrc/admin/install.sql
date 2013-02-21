DROP TABLE IF EXISTS `#__photo`;
 
CREATE TABLE `#__photo` (
   `id` int(11) NOT NULL auto_increment,
   `userid` int(11) NOT NULL,
   `fqdn` varchar(255) NOT NULL,
   `app_banner` varchar(50) NOT NULL,
   `site_name` varchar(100) NOT NULL,
   `expiry` varchar(255) NOT NULL,
   `unpublish_content` varchar(50) NOT NULL,
   `content_type` varchar(255) NOT NULL,
   `image_style` varchar(255) NOT NULL,
   `icon_style` varchar(255) NOT NULL,
   `defaultitem` varchar(255) NOT NULL,
   `photoldr_node_weight_article` varchar(50) NOT NULL,
   `photoldr_node_view_article` varchar(50) NOT NULL,
   `photoldr_item_max_article` varchar(50) NOT NULL,
   `photoldr_item_age_max_article` varchar(50) NOT NULL,
   `photoldr_item_order_article` varchar(50) NOT NULL,
   `photoldr_item_orderby_article` varchar(50) NOT NULL,
   
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `#__xml`;
 
CREATE TABLE `#__xml` (
  `id` int(11) NOT NULL auto_increment,
   `xml` varchar(50000) NOT NULL,
  
   PRIMARY KEY (`id`)
);  