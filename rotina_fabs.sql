-- MySQL dump 10.13  Distrib 5.5.10, for osx10.6 (i386)
--
-- Host: localhost    Database: mapas
-- ------------------------------------------------------
-- Server version	5.5.9

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alert`
--

DROP TABLE IF EXISTS `alert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `alert_type` tinyint(4) NOT NULL COMMENT '1 - MOBILE, 2 - EMAIL',
  `alert_recipient` varchar(200) DEFAULT NULL,
  `alert_code` varchar(30) DEFAULT NULL,
  `alert_confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `alert_lat` varchar(150) DEFAULT NULL,
  `alert_lon` varchar(150) DEFAULT NULL,
  `alert_radius` tinyint(4) NOT NULL DEFAULT '20',
  `alert_ip` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_alert_code` (`alert_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alert`
--

LOCK TABLES `alert` WRITE;
/*!40000 ALTER TABLE `alert` DISABLE KEYS */;
/*!40000 ALTER TABLE `alert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alert_sent`
--

DROP TABLE IF EXISTS `alert_sent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_sent` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` bigint(20) NOT NULL,
  `alert_id` bigint(20) NOT NULL,
  `alert_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alert_sent`
--

LOCK TABLES `alert_sent` WRITE;
/*!40000 ALTER TABLE `alert_sent` DISABLE KEYS */;
/*!40000 ALTER TABLE `alert_sent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_banned`
--

DROP TABLE IF EXISTS `api_banned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_banned` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `banned_ipaddress` varchar(50) NOT NULL,
  `banned_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='For logging banned API IP addresses';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_banned`
--

LOCK TABLES `api_banned` WRITE;
/*!40000 ALTER TABLE `api_banned` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_banned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_log`
--

DROP TABLE IF EXISTS `api_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `api_task` varchar(10) NOT NULL,
  `api_parameters` varchar(50) NOT NULL,
  `api_records` tinyint(11) NOT NULL,
  `api_ipaddress` varchar(50) NOT NULL,
  `api_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='For logging API activities';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_log`
--

LOCK TABLES `api_log` WRITE;
/*!40000 ALTER TABLE `api_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_settings`
--

DROP TABLE IF EXISTS `api_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default_record_limit` int(11) NOT NULL DEFAULT '20',
  `max_record_limit` int(11) DEFAULT NULL,
  `max_requests_per_ip_address` int(11) DEFAULT NULL,
  `max_requests_quota_basis` int(11) DEFAULT NULL,
  `modification_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='For storing API logging settings';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_settings`
--

LOCK TABLES `api_settings` WRITE;
/*!40000 ALTER TABLE `api_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(10) NOT NULL DEFAULT 'en_US',
  `category_type` tinyint(4) DEFAULT NULL,
  `category_title` varchar(255) DEFAULT NULL,
  `category_description` text,
  `category_color` varchar(20) DEFAULT NULL,
  `category_image` varchar(100) DEFAULT NULL,
  `category_image_thumb` varchar(100) DEFAULT NULL,
  `category_image_shadow` varchar(100) DEFAULT NULL,
  `category_visible` tinyint(4) NOT NULL DEFAULT '1',
  `category_trusted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_visible` (`category_visible`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,0,'en_US',5,'Legal','Lugares Legais','f51111',NULL,NULL,NULL,1,0),(2,0,'en_US',5,'Universidade','Universidade','3300FF',NULL,NULL,NULL,1,0),(3,0,'en_US',5,'Letra B','B','663300','category_3_1306168326.png','category_3_1306168326_16x16.png',NULL,1,0),(4,0,'en_US',5,'Trusted Reports','Reports from trusted reporters','339900',NULL,NULL,NULL,1,1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_lang`
--

DROP TABLE IF EXISTS `category_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `locale` varchar(10) DEFAULT NULL,
  `category_title` varchar(255) DEFAULT NULL,
  `category_description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_lang`
--

LOCK TABLES `category_lang` WRITE;
/*!40000 ALTER TABLE `category_lang` DISABLE KEYS */;
INSERT INTO `category_lang` VALUES (1,1,'en_US','',NULL),(2,1,'en_US_bkp','',NULL),(3,1,'fr_FR','',NULL),(4,1,'pt_BR','',NULL),(5,2,'en_US','',NULL),(6,2,'en_US_bkp','',NULL),(7,2,'fr_FR','',NULL),(8,2,'pt_BR','',NULL),(9,3,'en_US','',NULL),(10,3,'en_US_bkp','',NULL),(11,3,'fr_FR','',NULL),(12,3,'pt_BR','',NULL);
/*!40000 ALTER TABLE `category_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `city_lat` varchar(150) DEFAULT NULL,
  `city_lon` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` VALUES (1,115,'Nairobi','-1.28333','36.81667'),(2,115,'Mombasa','-4.055','39.6605'),(3,115,'Kisumu','-0.10221','34.76171'),(4,115,'Nakuru','-0.28333','36.06667'),(5,115,'Nyeri','-0.42013','36.94759'),(6,115,'Kakamega','0.28422','34.75228'),(7,115,'Garissa','-0.45355','39.64011'),(8,115,'Embu','-0.53112','37.4506'),(9,115,'Eldoret','0.52036','35.26992'),(10,115,'Thika','-1.03326','37.06933'),(11,115,'Nyahururu','0.0421','36.36734'),(12,115,'Malindi','-3.21748','40.1191'),(13,115,'Kitale','1.01572','35.00622'),(14,115,'Webuye','0.60751','34.76966'),(15,115,'Wajir','1.7471','40.05732'),(16,115,'Naivasha','-0.71667','36.43591'),(17,115,'Murang’a','-0.71667','37.15'),(18,115,'Moyale','3.5167','39.05842'),(19,115,'Molo','-0.2479','35.73743'),(20,115,'Meru','0.04626','37.65587'),(21,115,'Mandera','3.93663','41.86701'),(22,115,'Machakos','-1.51667','37.26667'),(23,115,'Lodwar','3.11911','35.59727'),(24,115,'Lamu','-2.26925','40.89915'),(25,115,'Kiambu','-1.16667','36.83333'),(26,115,'Keruguya','-0.49886','37.28031'),(27,115,'Kajiado','-1.85238','36.77683'),(28,115,'Isiolo','0.35462','37.58218'),(29,115,'Homa Bay','-0.52731','34.45714'),(30,115,'Eldama Ravine','0.05158','35.73078'),(31,115,'Bungoma','0.5635','34.56055'),(32,115,'Yala','0.09906','34.53757'),(33,115,'Wundanyi','-3.40193','38.36402'),(34,115,'Voi','-3.39452','38.56304'),(35,115,'Taveta','-3.39632','37.67362'),(36,115,'Takaungu','-3.68367','39.85662'),(37,115,'Sotik','-0.68333','35.11871'),(38,115,'Oyugis','-0.50898','34.73583'),(39,115,'Narok','-1.07829','35.86012'),(40,115,'Nanyuki','0.01667','37.07283'),(41,115,'Namanga','-2.54327','36.79053'),(42,115,'Mumias','0.33511','34.4864'),(43,115,'Muhoroni','-0.15406','35.19878'),(44,115,'Mtito Andei','-2.69009','38.16631'),(45,115,'Migori','-1.06344','34.47313'),(46,115,'Maua','0.23206','37.94052'),(47,115,'Marsabit','2.32839','37.98986'),(48,115,'Mariakani','-3.86332','39.47362'),(49,115,'Maralal','1.09679','36.69799'),(50,115,'Makueni','-1.80409','37.62034'),(51,115,'Magadi','-1.90122','36.287'),(52,115,'Lugulu','0.39361','34.30528'),(53,115,'Luanda','0.29668','34.06459'),(54,115,'Lokichokio','4.20711','34.36384'),(55,115,'Kitui','-1.36696','38.01056'),(56,115,'Kisii','-0.67394','34.77225'),(57,115,'Kinancha','-1.18376','34.62616'),(58,115,'Kilifi','-3.63045','39.84992'),(59,115,'Kikuyu','-1.24576','36.66328'),(60,115,'Kapsabet','0.20387','35.105'),(61,115,'Kangundo','-1.29792','37.34705'),(62,115,'Kabarnet','0.49194','35.74303'),(63,115,'Gazi','-4.42477','39.50772'),(64,115,'Butere','0.20636','34.49348'),(65,115,'Port Bunyala','0.09388','33.97559'),(66,115,'Bomet','-0.78129','35.34156'),(67,115,'Athi River','-1.45071','36.98245'),(68,115,'Siaya','0.06116','34.28823'),(69,115,'Wote','-1.78079','37.62882'),(70,115,'Tekwa Ruins','-2.28088','40.96667'),(71,115,'Dar es Salaam','-1.65755','41.56041'),(72,115,'Sendeni','-1.88074','41.37405'),(73,115,'Sawasawa','-4.47246','39.48758'),(74,115,'Rongai','-0.17333','35.86382'),(75,115,'Rangala','0.15036','34.33187'),(76,115,'Rabour','-0.14958','34.8249'),(77,115,'Othaya','-0.56516','36.96091'),(78,115,'Oloyaingalani','-1.75652','36.70235'),(79,115,'Olololong’a','-1','35.66667'),(80,115,'Oloiserri','-2.24574','36.42785'),(81,115,'Olmesutye','-1.90812','35.73481'),(82,115,'Olengarua','-2.09102','36.11267'),(83,115,'Myabogi','-2.07511','41.12831'),(84,115,'Ngovio','-0.42392','37.44906'),(85,115,'Ngong','-1.36175','36.6566'),(86,115,'Ngiya','0.03795','34.37386'),(87,115,'Ndulelei','-1.09588','36.08567'),(88,115,'Naro Moru','-0.16756','37.02129'),(89,115,'Nanigi East','-0.84897','39.86118'),(90,115,'Nambale','0.44594','34.25194'),(91,115,'Mwingi','-0.93435','38.06005'),(92,115,'Mukutan','0.63346','36.25701'),(93,115,'Mokowe','-2.23428','40.84656'),(94,115,'Mohoru','-0.99943','34.09624'),(95,115,'Mkunumbi','-2.29894','40.70459'),(96,115,'Mkuki','-0.47006','35.67946'),(97,115,'Matondoni','-2.26492','40.83815'),(98,115,'Matayo','0.36186','34.16684'),(99,115,'Manoni','-2.37883','38.08167'),(100,115,'Malikisi','0.67694','34.42167');
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cluster`
--

DROP TABLE IF EXISTS `cluster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cluster` (
  `id` int(11) NOT NULL,
  `location_id` bigint(20) NOT NULL DEFAULT '0',
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `latitude_min` double NOT NULL,
  `longitude_min` double NOT NULL,
  `latitude_max` double NOT NULL,
  `longitude_max` double NOT NULL,
  `child_count` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `left_side` int(11) NOT NULL,
  `right_side` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `incident_id` bigint(20) NOT NULL DEFAULT '0',
  `incident_title` varchar(255) DEFAULT NULL,
  `incident_date` int(10) NOT NULL DEFAULT '0',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `category_color` varchar(20) NOT NULL DEFAULT '990000',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cluster`
--

LOCK TABLES `cluster` WRITE;
/*!40000 ALTER TABLE `cluster` DISABLE KEYS */;
/*!40000 ALTER TABLE `cluster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` bigint(20) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `comment_author` varchar(100) DEFAULT NULL,
  `comment_email` varchar(120) DEFAULT NULL,
  `comment_description` text,
  `comment_ip` varchar(100) DEFAULT NULL,
  `comment_rating` varchar(15) NOT NULL DEFAULT '0',
  `comment_spam` tinyint(4) NOT NULL DEFAULT '0',
  `comment_active` tinyint(4) NOT NULL DEFAULT '0',
  `comment_date` datetime DEFAULT NULL,
  `comment_date_gmt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,12,0,'juliana','julianamori@hotmail.com','Olha é a minha vista tb!','189.120.225.202','0',0,1,'2011-05-25 01:49:00',NULL);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` varchar(10) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `capital` varchar(100) DEFAULT NULL,
  `cities` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=248 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'AD','Andorra','Andorra la Vella',0),(2,'AE','United Arab Emirates','Abu Dhabi',0),(3,'AF','Afghanistan','Kabul',0),(4,'AG','Antigua and Barbuda','St. John\'s',0),(5,'AI','Anguilla','The Valley',0),(6,'AL','Albania','Tirana',0),(7,'AM','Armenia','Yerevan',0),(8,'AN','Netherlands Antilles','Willemstad',0),(9,'AO','Angola','Luanda',0),(10,'AQ','Antarctica','',0),(11,'AR','Argentina','Buenos Aires',0),(12,'AS','American Samoa','Pago Pago',0),(13,'AT','Austria','Vienna',0),(14,'AU','Australia','Canberra',0),(15,'AW','Aruba','Oranjestad',0),(16,'AX','Aland Islands','Mariehamn',0),(17,'AZ','Azerbaijan','Baku',0),(18,'BA','Bosnia and Herzegovina','Sarajevo',0),(19,'BB','Barbados','Bridgetown',0),(20,'BD','Bangladesh','Dhaka',0),(21,'BE','Belgium','Brussels',0),(22,'BF','Burkina Faso','Ouagadougou',0),(23,'BG','Bulgaria','Sofia',0),(24,'BH','Bahrain','Manama',0),(25,'BI','Burundi','Bujumbura',0),(26,'BJ','Benin','Porto-Novo',0),(27,'BL','Saint BarthÃ©lemy','Gustavia',0),(28,'BM','Bermuda','Hamilton',0),(29,'BN','Brunei','Bandar Seri Begawan',0),(30,'BO','Bolivia','La Paz',0),(31,'BR','Brazil','BrasÃ­lia',0),(32,'BS','Bahamas','Nassau',0),(33,'BT','Bhutan','Thimphu',0),(34,'BV','Bouvet Island','',0),(35,'BW','Botswana','Gaborone',0),(36,'BY','Belarus','Minsk',0),(37,'BZ','Belize','Belmopan',0),(38,'CA','Canada','Ottawa',0),(39,'CC','Cocos Islands','West Island',0),(40,'CD','Democratic Republic of the Congo','Kinshasa',0),(41,'CF','Central African Republic','Bangui',0),(42,'CG','Congo Brazzavile','Brazzaville',0),(43,'CH','Switzerland','Berne',0),(44,'CI','Ivory Coast','Yamoussoukro',0),(45,'CK','Cook Islands','Avarua',0),(46,'CL','Chile','Santiago',0),(47,'CM','Cameroon','YaoundÃ©',0),(48,'CN','China','Beijing',0),(49,'CO','Colombia','BogotÃ¡',0),(50,'CR','Costa Rica','San JosÃ©',0),(51,'CS','Serbia and Montenegro','Belgrade',0),(52,'CU','Cuba','Havana',0),(53,'CV','Cape Verde','Praia',0),(54,'CX','Christmas Island','Flying Fish Cove',0),(55,'CY','Cyprus','Nicosia',0),(56,'CZ','Czech Republic','Prague',0),(57,'DE','Germany','Berlin',0),(58,'DJ','Djibouti','Djibouti',0),(59,'DK','Denmark','Copenhagen',0),(60,'DM','Dominica','Roseau',0),(61,'DO','Dominican Republic','Santo Domingo',0),(62,'DZ','Algeria','Algiers',0),(63,'EC','Ecuador','Quito',0),(64,'EE','Estonia','Tallinn',0),(65,'EG','Egypt','Cairo',0),(66,'EH','Western Sahara','El-Aaiun',0),(67,'ER','Eritrea','Asmara',0),(68,'ES','Spain','Madrid',0),(69,'ET','Ethiopia','Addis Ababa',0),(70,'FI','Finland','Helsinki',0),(71,'FJ','Fiji','Suva',0),(72,'FK','Falkland Islands','Stanley',0),(73,'FM','Micronesia','Palikir',0),(74,'FO','Faroe Islands','TÃ³rshavn',0),(75,'FR','France','Paris',0),(76,'GA','Gabon','Libreville',0),(77,'GB','United Kingdom','London',0),(78,'GD','Grenada','St. George\'s',0),(79,'GE','Georgia','Tbilisi',0),(80,'GF','French Guiana','Cayenne',0),(81,'GG','Guernsey','St Peter Port',0),(82,'GH','Ghana','Accra',0),(83,'GI','Gibraltar','Gibraltar',0),(84,'GL','Greenland','Nuuk',0),(85,'GM','Gambia','Banjul',0),(86,'GN','Guinea','Conakry',0),(87,'GP','Guadeloupe','Basse-Terre',0),(88,'GQ','Equatorial Guinea','Malabo',0),(89,'GR','Greece','Athens',0),(90,'GS','South Georgia and the South Sandwich Islands','Grytviken',0),(91,'GT','Guatemala','Guatemala City',0),(92,'GU','Guam','HagÃ¥tÃ±a',0),(93,'GW','Guinea-Bissau','Bissau',0),(94,'GY','Guyana','Georgetown',0),(95,'HK','Hong Kong','Hong Kong',0),(96,'HM','Heard Island and McDonald Islands','',0),(97,'HN','Honduras','Tegucigalpa',0),(98,'HR','Croatia','Zagreb',0),(99,'HT','Haiti','Port-au-Prince',0),(100,'HU','Hungary','Budapest',0),(101,'ID','Indonesia','Jakarta',0),(102,'IE','Ireland','Dublin',0),(103,'IL','Israel','Jerusalem',0),(104,'IM','Isle of Man','Douglas, Isle of Man',0),(105,'IN','India','New Delhi',0),(106,'IO','British Indian Ocean Territory','Diego Garcia',0),(107,'IQ','Iraq','Baghdad',0),(108,'IR','Iran','Tehran',0),(109,'IS','Iceland','ReykjavÃ­k',0),(110,'IT','Italy','Rome',0),(111,'JE','Jersey','Saint Helier',0),(112,'JM','Jamaica','Kingston',0),(113,'JO','Jordan','Amman',0),(114,'JP','Japan','Tokyo',0),(115,'KE','Kenya','Nairobi',100),(116,'KG','Kyrgyzstan','Bishkek',0),(117,'KH','Cambodia','Phnom Penh',0),(118,'KI','Kiribati','South Tarawa',0),(119,'KM','Comoros','Moroni',0),(120,'KN','Saint Kitts and Nevis','Basseterre',0),(121,'KP','North Korea','Pyongyang',0),(122,'KR','South Korea','Seoul',0),(123,'KW','Kuwait','Kuwait City',0),(124,'KY','Cayman Islands','George Town',0),(125,'KZ','Kazakhstan','Astana',0),(126,'LA','Laos','Vientiane',0),(127,'LB','Lebanon','Beirut',0),(128,'LC','Saint Lucia','Castries',0),(129,'LI','Liechtenstein','Vaduz',0),(130,'LK','Sri Lanka','Colombo',0),(131,'LR','Liberia','Monrovia',0),(132,'LS','Lesotho','Maseru',0),(133,'LT','Lithuania','Vilnius',0),(134,'LU','Luxembourg','Luxembourg',0),(135,'LV','Latvia','Riga',0),(136,'LY','Libya','Tripolis',0),(137,'MA','Morocco','Rabat',0),(138,'MC','Monaco','Monaco',0),(139,'MD','Moldova','Chi_in_u',0),(140,'ME','Montenegro','Podgorica',0),(141,'MF','Saint Martin','Marigot',0),(142,'MG','Madagascar','Antananarivo',0),(143,'MH','Marshall Islands','Uliga',0),(144,'MK','Macedonia','Skopje',0),(145,'ML','Mali','Bamako',0),(146,'MM','Myanmar','Yangon',0),(147,'MN','Mongolia','Ulan Bator',0),(148,'MO','Macao','Macao',0),(149,'MP','Northern Mariana Islands','Saipan',0),(150,'MQ','Martinique','Fort-de-France',0),(151,'MR','Mauritania','Nouakchott',0),(152,'MS','Montserrat','Plymouth',0),(153,'MT','Malta','Valletta',0),(154,'MU','Mauritius','Port Louis',0),(155,'MV','Maldives','MalÃ©',0),(156,'MW','Malawi','Lilongwe',0),(157,'MX','Mexico','Mexico City',0),(158,'MY','Malaysia','Kuala Lumpur',0),(159,'MZ','Mozambique','Maputo',0),(160,'NA','Namibia','Windhoek',0),(161,'NC','New Caledonia','NoumÃ©a',0),(162,'NE','Niger','Niamey',0),(163,'NF','Norfolk Island','Kingston',0),(164,'NG','Nigeria','Abuja',0),(165,'NI','Nicaragua','Managua',0),(166,'NL','Netherlands','Amsterdam',0),(167,'NO','Norway','Oslo',0),(168,'NP','Nepal','Kathmandu',0),(169,'NR','Nauru','Yaren',0),(170,'NU','Niue','Alofi',0),(171,'NZ','New Zealand','Wellington',0),(172,'OM','Oman','Muscat',0),(173,'PA','Panama','Panama City',0),(174,'PE','Peru','Lima',0),(175,'PF','French Polynesia','Papeete',0),(176,'PG','Papua New Guinea','Port Moresby',0),(177,'PH','Philippines','Manila',0),(178,'PK','Pakistan','Islamabad',0),(179,'PL','Poland','Warsaw',0),(180,'PM','Saint Pierre and Miquelon','Saint-Pierre',0),(181,'PN','Pitcairn','Adamstown',0),(182,'PR','Puerto Rico','San Juan',0),(183,'PS','Palestinian Territory','East Jerusalem',0),(184,'PT','Portugal','Lisbon',0),(185,'PW','Palau','Koror',0),(186,'PY','Paraguay','AsunciÃ³n',0),(187,'QA','Qatar','Doha',0),(188,'RE','Reunion','Saint-Denis',0),(189,'RO','Romania','Bucharest',0),(190,'RS','Serbia','Belgrade',0),(191,'RU','Russia','Moscow',0),(192,'RW','Rwanda','Kigali',0),(193,'SA','Saudi Arabia','Riyadh',0),(194,'SB','Solomon Islands','Honiara',0),(195,'SC','Seychelles','Victoria',0),(196,'SD','Sudan','Khartoum',0),(197,'SE','Sweden','Stockholm',0),(198,'SG','Singapore','Singapur',0),(199,'SH','Saint Helena','Jamestown',0),(200,'SI','Slovenia','Ljubljana',0),(201,'SJ','Svalbard and Jan Mayen','Longyearbyen',0),(202,'SK','Slovakia','Bratislava',0),(203,'SL','Sierra Leone','Freetown',0),(204,'SM','San Marino','San Marino',0),(205,'SN','Senegal','Dakar',0),(206,'SO','Somalia','Mogadishu',0),(207,'SR','Suriname','Paramaribo',0),(208,'ST','Sao Tome and Principe','SÃ£o TomÃ©',0),(209,'SV','El Salvador','San Salvador',0),(210,'SY','Syria','Damascus',0),(211,'SZ','Swaziland','Mbabane',0),(212,'TC','Turks and Caicos Islands','Cockburn Town',0),(213,'TD','Chad','N\'Djamena',0),(214,'TF','French Southern Territories','Martin-de-ViviÃ¨s',0),(215,'TG','Togo','LomÃ©',0),(216,'TH','Thailand','Bangkok',0),(217,'TJ','Tajikistan','Dushanbe',0),(218,'TK','Tokelau','',0),(219,'TL','East Timor','Dili',0),(220,'TM','Turkmenistan','Ashgabat',0),(221,'TN','Tunisia','Tunis',0),(222,'TO','Tonga','Nuku\'alofa',0),(223,'TR','Turkey','Ankara',0),(224,'TT','Trinidad and Tobago','Port of Spain',0),(225,'TV','Tuvalu','Vaiaku',0),(226,'TW','Taiwan','Taipei',0),(227,'TZ','Tanzania','Dar es Salaam',0),(228,'UA','Ukraine','Kiev',0),(229,'UG','Uganda','Kampala',0),(230,'UM','United States Minor Outlying Islands','',0),(231,'US','United States','Washington',0),(232,'UY','Uruguay','Montevideo',0),(233,'UZ','Uzbekistan','Tashkent',0),(234,'VA','Vatican','Vatican City',0),(235,'VC','Saint Vincent and the Grenadines','Kingstown',0),(236,'VE','Venezuela','Caracas',0),(237,'VG','British Virgin Islands','Road Town',0),(238,'VI','U.S. Virgin Islands','Charlotte Amalie',0),(239,'VN','Vietnam','Hanoi',0),(240,'VU','Vanuatu','Port Vila',0),(241,'WF','Wallis and Futuna','MatÃ¢\'Utu',0),(242,'WS','Samoa','Apia',0),(243,'YE','Yemen','Sanâ€˜aâ€™',0),(244,'YT','Mayotte','Mamoudzou',0),(245,'ZA','South Africa','Pretoria',0),(246,'ZM','Zambia','Lusaka',0),(247,'ZW','Zimbabwe','Harare',0);
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feed`
--

DROP TABLE IF EXISTS `feed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `feed_name` varchar(255) DEFAULT NULL,
  `feed_url` varchar(255) DEFAULT NULL,
  `feed_cache` text,
  `feed_active` tinyint(4) DEFAULT '1',
  `feed_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feed`
--

LOCK TABLES `feed` WRITE;
/*!40000 ALTER TABLE `feed` DISABLE KEYS */;
INSERT INTO `feed` VALUES (1,'Vidagee','http://feeds.feedburner.com/VidaGeek?format=xml',NULL,1,1308013216),(2,'Ohay','http://feeds.folha.uol.com.br/ambiente/rss091.xml',NULL,1,1308013216);
/*!40000 ALTER TABLE `feed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feed_item`
--

DROP TABLE IF EXISTS `feed_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feed_id` int(11) NOT NULL,
  `location_id` bigint(20) DEFAULT '0',
  `incident_id` int(11) NOT NULL DEFAULT '0',
  `item_title` varchar(255) DEFAULT NULL,
  `item_description` text,
  `item_link` varchar(255) DEFAULT NULL,
  `item_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feed_item`
--

LOCK TABLES `feed_item` WRITE;
/*!40000 ALTER TABLE `feed_item` DISABLE KEYS */;
INSERT INTO `feed_item` VALUES (1,1,0,0,'Conversa Rápida 13/06','<p>No dia 13 de Junho, das 19:30 às 22:00, acontecerá na <a href=\"http://www.adaptworks.com.br\" target=\"_blank\">AdaptWorks</a> mais uma edição do <a href=\"http://www.adaptworks.com.br/blog/2011/05/18/conversa-rapida-junho/\" target=\"_blank\">Conversa Rápida</a>.</p>\n<p>A <a href=\"http://vidageek.net/2011/05/14/conversa-rapida/\" target=\"_blank\">edição passada</a> foi bem divertida. Se tiver interesse em participar, mande um email para jabreu@adaptworks.com.br&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/M1wMHH29LMw/','2011-05-20 15:25:00'),(2,1,0,0,'Expressividade','<p>Enquanto eu resolvia o <a href=\"http://vidageek.net/2011/05/16/desafio-de-expressividade-i/\" target=\"_blank\">primeiro desafio de expressividade</a>, eu notei uma coisa relacionada ao <a href=\"https://github.com/jonasabreu/desafio20110516\" target=\"_blank\">código das minhas classes</a>.</p>\n<p>O código mais próximo da interface que resolvia o desafio, eu tentei manter o mais próximo da linguagem&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/HM5bB6ujfdw/','2011-05-18 07:00:00'),(3,1,0,0,'Desafio de expressividade I','<p>Já faz um bom tempo em que venho pensando em como criar formas de exercitar diversas técnicas de programação.</p>\n<p>Recentemente, enquanto eu desenvolvia um <a href=\"http://www.adaptworks.com.br/treinamento/CSD-Scrum-Developer-Skills\" target=\"_blank\">treinamento para a AdaptWorks</a> (parte da <a href=\"http://www.scrumalliance.org/CSD\" target=\"_blank\">certificação CSD da ScrumAlliance</a>), me veio&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/95gTQlD-aJc/','2011-05-16 07:00:00'),(4,1,0,0,'Conversa Rápida','<p>No começo da semana passada aconteceu um mini evento na <a href=\"http://www.adaptworks.com.br\" target=\"_blank\">AdaptWorks</a>, organizado por mim, chamado Conversa Rápida.</p>\n<p>Foram 12 palestras com aproximadamente 5 minutos, que foram filmadas e <a href=\"http://www.youtube.com/user/adaptworks\" target=\"_blank\">colocadas no YouTube</a>.</p>\n<p>Das 12, 5 fui eu&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/8bxgK-AktZo/','2011-05-14 15:31:00'),(5,1,0,0,'Não. Seu site não é totalmente confiável.','<p>&#8220;A loja é totalmente confiável e os seus dados estão seguros&#8221;. Essa frase me deu calafrios assim que li em um email que recebi.</p>\n<p>Um pouco de contexto. A fonte do meu notebook se decompos. Como não vivo sem ele,&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/trTv0_ZjD48/','2011-05-09 16:09:00'),(6,1,0,0,'Agile Searcher','<p>Tempos atrás precisei reunir várias referências sobre desenvolvimento ágil. Depois de buscar muito no Google e sofrer um pouco para filtrar os resultados, resolvi criar um <a href=\"http://www.google.com/cse\" target=\"_blank\">Google Custom Search Engine</a> com alguns sites para facilitar a minha vida.&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/BPD3-NZg1Cs/','2011-04-06 18:22:00'),(7,1,0,0,'Open Source Week – Fim','<p>Foram duas semanas de trabalhos para documentar e lançar esses projetos (alguns já estavam &#8220;quase prontos&#8221; a mais de 6 meses.).</p>\n<p>Para finalizar isso, resolvi colocar no ar <a href=\"http://projetos.vidageek.net/\" target=\"_blank\">a página de projetos do VidaGeek.net</a>. A idéia dessa página&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/aBCxS0XN1z4/','2011-02-27 07:00:00'),(8,1,0,0,'Open Source Week – Mirror','<p>Para finalizar os lançamentos de projetos essa semana, a versão 1.6 do <a href=\"http://projetos.vidageek.net/mirror-pt\" target=\"_blank\">Mirror</a> finalmente foi lançada.</p>\n<p>Essa versão trás muitas pequenas melhorias para o dia a dia (como refletir um getter/setter) e algumas novas features que fizeram falta&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/nWzgYYP135Q/','2011-02-26 07:00:00'),(9,1,0,0,'Open Source Week – Scraper','<p>O Terceiro lançamento é o <a href=\"http://projetos.vidageek.net/scraper\" target=\"_blank\">Scraper</a>.</p>\n<p>O Scraper é uma ferramenta para facilitar <a href=\"http://en.wikipedia.org/wiki/Web_scraping\" target=\"_blank\">Html Scrapping</a>, ou seja, extrair dados de páginas html.</p>\n<p>Existem diversas formas de extrair dados de páginas Html. Você pode usar <a href=\"http://en.wikipedia.org/wiki/Regular_expression\"&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/QPqgu3lvpJo/','2011-02-25 07:00:00'),(10,1,0,0,'Open Source Week – I18n','<p>O segundo lançamento é da versão 0.5 do <a href=\"http://vidageek.net/2010/02/24/i18n-para-java/\" target=\"_blank\">I18n, lançado ano passado</a>. Essa versão resolve o problema que tivemos para lidar<br />\ncom mensagens muito grandes (ficava muito ruim no .properties).</p>\n<p>Também melhoramos a documentação.</p>\n<p>Mais informações em&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/mePL0FU-edQ/','2011-02-24 07:00:00'),(11,2,0,0,'Código Florestal vai para 2ª tentativa de votação na terça','As lideranças partidárias devem se mobilizar novamente nesta terça-feira, dia em que o projeto do novo Código Florestal será levado para votação na Câmara pela segunda vez.\nA primeira tentativa de se aprovar o novo texto ocorreu no último dia 11, mas a sessão foi cancelada pelo governo, que temia uma perda política em início do mandato da presidente Dilma Rousseff.\nUm dos principais pontos da discórdia no programa, cujo relator é o deputado Aldo Rebelo (PBdoB-SP), refere-se o uso das APPs (Áreas de Preservação Permanente).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919535-codigo-florestal-vai-para-2-tentativa-de-votacao-na-terca.shtml\">Leia mais</a> (23/05/2011 - 11h41)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919535-codigo-florestal-vai-para-2-tentativa-de-votacao-na-terca.shtml','2011-05-23 11:41:00'),(12,2,0,0,'Nível dos oceanos subirá mais do que previu ONU, diz Austrália','As inundações em regiões costeiras devem ocorrer com mais frequência dentro de um século, devido ao aumento no nível dos oceanos provocado pelo aquecimento global, diz um estudo divulgado pelo governo australiano nesta segunda-feira.\n&quot;O cálculo plausível do aumento do nível das águas para 2100, em comparação com 2000, é de 0,5 a um metro&quot;, cita o relatório &quot;A Década Crítica&quot;, da Comissão de Mudança Climática, subordinado ao governo da Austrália.\n<table>\n<tr>\n<td>AP</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/homepage/images/1101028.jpeg\" alt=\"Australianos se protegem durante inundação na Austrália, que deve ser mais corrente com aumento do nível dos oceanos\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Australianos se protegem durante inundação na Austrália, que deve ser mais corrente com aumento do nível dos oceanos</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919501-nivel-dos-oceanos-subira-mais-do-que-previu-onu-diz-australia.shtml\">Leia mais</a> (23/05/2011 - 10h34)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919501-nivel-dos-oceanos-subira-mais-do-que-previu-onu-diz-australia.shtml','2011-05-23 10:34:00'),(13,2,0,0,'Tribo amazônica desconhece conceito de tempo, diz estudo','Pesquisadores brasileiros e britânicos identificaram uma tribo amazônica que, segundo eles, não tem noção do conceito abstrato de tempo.\nChamada Amondawa, a tribo não possui as estruturas linguísticas que relacionam tempo e espaço --como, por exemplo, na tradicional ideia de &quot;no ano que vem&quot;.\nO estudo feito com os Amondawa, chamado &quot;Língua e Cognição&quot;, mostra que, ainda que a tribo entenda que os eventos ocorrem ao longo do tempo, este não existe como um conceito separado.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919488-tribo-amazonica-desconhece-conceito-de-tempo-diz-estudo.shtml\">Leia mais</a> (23/05/2011 - 09h59)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919488-tribo-amazonica-desconhece-conceito-de-tempo-diz-estudo.shtml','2011-05-23 09:59:00'),(14,2,0,0,'Sucesso da civilização inca se deve a lhamas, diz estudo','Machu Picchu, a famosa cidade inca nos Andes peruanos, celebrará em julho o centenário de sua &quot;descoberta&quot; pelo mundo exterior, em um evento imponente, mas há indicativos de que as origens do local tenham sido menos glamourosas.\nSegundo pesquisa publicada no jornal &quot;Antiquity&quot;, especializado em arqueologia, a civilização inca pode ter crescido e evoluído graças aos dejetos das lhamas.\nA transição da caça e coleta à agricultura, 2.700 anos atrás, que permitiu aos incas se acomodar e prosperar na área de Cuzco onde fica Machu Picchu, diz o autor do estudo, Alex Chepstow-Lusty.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919487-sucesso-da-civilizacao-inca-se-deve-a-lhamas-diz-estudo.shtml\">Leia mais</a> (23/05/2011 - 09h52)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919487-sucesso-da-civilizacao-inca-se-deve-a-lhamas-diz-estudo.shtml','2011-05-23 09:52:00'),(15,2,0,0,'Projeto quer fotografar em 3D todas as espécies de formigas','Cientistas da Academia de Ciências da Califórnia iniciaram um projeto para fazer imagens digitais e superdetalhadas de todas as cerca de 12 mil espécies de formigas conhecidas da ciência.\n&quot;São insetos incríveis&quot;, diz o pesquisador-chefe do projeto, Brian Fisher. &quot;As formigas inventaram (o conceito de) cultivo agrícola muito antes que os humanos.&quot;\n<a href=\"http://fotografia.folha.uol.com.br/galerias/2992-especies-de-formigas-conhecidas\">Veja galeria de fotos</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919484-projeto-quer-fotografar-em-3d-todas-as-especies-de-formigas.shtml\">Leia mais</a> (23/05/2011 - 09h43)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919484-projeto-quer-fotografar-em-3d-todas-as-especies-de-formigas.shtml','2011-05-23 09:43:00'),(16,2,0,0,'Grupo acha &quot;avô&quot; de crocodilos terrestres no interior de MG','Medindo só 1,80 metro da ponta do focinho à extremidade da cauda, o <i>Campinasuchus dinizi</i> não se encaixa muito bem na definição de monstro pré-histórico. Mesmo assim, parece ter sido um excelente fundador de dinastia.\nIsso porque, segundo seus descobridores, o bicho é o membro mais primitivo do grupo de crocodilos que dominou o interior do Brasil na Era dos Dinossauros.\n<a href=\"http://www1.folha.uol.com.br/ciencia/919474-nome-de-crocodilo-primitivo-mineiro-homenageia-filho.shtml\">Nome de crocodilo primitivo mineiro homenageia filho</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/919468-grupo-acha-avo-de-crocodilos-terrestres-no-interior-de-mg.shtml\">Leia mais</a> (23/05/2011 - 08h57)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/919468-grupo-acha-avo-de-crocodilos-terrestres-no-interior-de-mg.shtml','2011-05-23 08:57:00'),(17,2,0,0,'Yangtzé, o rio mais longo da Ásia, sofre sua pior seca em 50 anos','O rio Yangtzé, o mais longo da Ásia e em cuja bacia vive um terço da população chinesa (cerca de 400 milhões de pessoas), enfrenta a pior seca em 50 anos, devido à maior escassez de chuvas desde 1961, informou nesta segunda-feira a agência oficial Xinhua.\nAs províncias do curso médio do rio (Jiangxi, Hunan e Hubei) são as mais afetadas, já que nelas as precipitações entre janeiro e abril foram entre 40% e 60% inferiores à média anual, destacou o diretor do centro de controle de inundações e secas do rio, Wang Guosheng.\nA seca afeta os sistemas de irrigação, o abastecimento de água em algumas regiões e inclusive o transporte fluvial deste rio, uma das artérias do transporte de carga na China, e onde já foram vários os navios que encalharam devido ao caudal reduzido.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919434-yangtze-o-rio-mais-longo-da-asia-sofre-sua-pior-seca-em-50-anos.shtml\">Leia mais</a> (23/05/2011 - 04h12)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919434-yangtze-o-rio-mais-longo-da-asia-sofre-sua-pior-seca-em-50-anos.shtml','2011-05-23 04:12:00'),(18,2,0,0,'Vazamento de cloro em Maceió levou 22 crianças ao hospital','Um <a href=\"http://www1.folha.uol.com.br/cotidiano/919250-vazamento-de-cloro-em-fabrica-da-braskem-intoxica-30-em-alagoas.shtml\">vazamento</a> de cloro gasoso ocorrido na noite deste sábado (21) em uma unidade da Braskem na região do Pontal da Barra, em Maceió (AL), levou 22 crianças ao hospital.\n<a href=\"http://www1.folha.uol.com.br/cotidiano/919250-vazamento-de-cloro-em-fabrica-da-braskem-intoxica-30-em-alagoas.shtml\">Cloro vaza em fábrica da Braskem em Alagoas</a>\nSegundo informações da Secretaria de Estado da Saúde de Alagoas, elas têm idades entre um e 15 anos e já receberam alta.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919314-vazamento-de-cloro-em-maceio-levou-22-criancas-ao-hospital.shtml\">Leia mais</a> (22/05/2011 - 17h21)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919314-vazamento-de-cloro-em-maceio-levou-22-criancas-ao-hospital.shtml','2011-05-22 17:21:00'),(19,2,0,0,'Marina cobra veto de Dilma à reforma do Código Florestal','Mais de mil pessoas --segundo dados da assessoria de imprensa da SOS Mata Atlântica-- protestaram na manhã deste domingo contra o novo Código Florestal, proposto pelo relator do projeto, deputado Aldo Rebelo (PC do B-SP).\n<a href=\"http://www1.folha.uol.com.br/ambiente/918143-relator-do-codigo-florestal-critica-ibama-por-desmate-na-amazonia.shtml\">Relator do Código Florestal critica Ibama por desmate na Amazônia</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/917451-desmate-cresce-27-na-amazonia-governo-exime-codigo-florestal.shtml\">Desmate cresce 27% na Amazônia; governo exime Código Florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/914619-confira-o-relatorio-final-do-codigo-florestal.shtml\">Confira o relatório final do Código Florestal</a>\n<table>\n<tr>\n<td>Rodrigo Capote/Folhapress</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/poder/images/11142197.jpeg\" alt=\"Marina Silva discursa para manifestantes no protesto\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Marina Silva discursa para manifestantes no protesto</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919295-marina-cobra-veto-de-dilma-a-reforma-do-codigo-florestal.shtml\">Leia mais</a> (22/05/2011 - 16h14)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919295-marina-cobra-veto-de-dilma-a-reforma-do-codigo-florestal.shtml','2011-05-22 16:14:00'),(20,2,0,0,'Vazamento de cloro em fábrica da Braskem intoxica 30 em Alagoas','Um vazamento de cloro ocorrido na noite de sábado intoxicou cerca de 30 pessoas em uma comunidade pesqueira próxima de uma fábrica da Braskem em Alagoas, informou o órgão ambiental do Estado.\n<a href=\"http://www1.folha.uol.com.br/cotidiano/919314-vazamento-de-cloro-em-maceio-levou-22-criancas-ao-hospital.shtml\">Vazamento de cloro levou 22 crianças ao hospital</a>\nPor volta das 18h40 do sábado, alarmes de detecção de vazamento de cloro soaram na planta da Braskem no bairro Pontal da Barra, em Maceió. O alarme só desligou às 20h15, quando a nuvem de gás de cloro se dissipou.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919250-vazamento-de-cloro-em-fabrica-da-braskem-intoxica-30-em-alagoas.shtml\">Leia mais</a> (22/05/2011 - 12h21)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919250-vazamento-de-cloro-em-fabrica-da-braskem-intoxica-30-em-alagoas.shtml','2011-05-22 12:21:00'),(21,2,0,0,'Carga de urânio chega às instalações da INB em Caetité (BA)','A carga de urânio que havia sido bloqueada pela população de Caetité (624 km de Salvador) no domingo (15) foi transportada, na madrugada desta sexta-feira até as instalações da INB (Indústrias Nucleares do Brasil) na cidade.\n<a href=\"http://www1.folha.uol.com.br/cotidiano/917224-carga-de-uranio-esta-em-batalhao-da-pm-a-ceu-aberto-na-ba.shtml\">Carga de urânio está a céu aberto na BA</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/916944-impasse-sobre-carga-de-uranio-levada-a-bahia-continua.shtml\">Impasse sobre carga de urânio continua</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/916807-protesto-de-moradores-barra-carga-de-uranio-em-caetite-ba.shtml\">Protesto de moradores barra carga de urânio</a>\n<table>\n<tr>\n<td>Divulgação/Greenpeace</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/cotidiano/images/11137617.jpeg\" alt=\"Carga de urânio em que gerou impasse em Caitité (BA)\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Carga de urânio em que gerou impasse em Caitité (BA)</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/918694-carga-de-uranio-chega-as-instalacoes-da-inb-em-caetite-ba.shtml\">Leia mais</a> (20/05/2011 - 18h28)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/918694-carga-de-uranio-chega-as-instalacoes-da-inb-em-caetite-ba.shtml','2011-05-20 18:28:00'),(22,2,0,0,'Associações de cientistas pedem suspensão de Belo Monte','Vinte associações e sociedades científicas protocolaram nesta quinta-feira (19) uma carta em que pedem à presidente Dilma Rousseff a suspensão do licenciamento da usina de Belo Monte, no rio Xingu (PA), até que as condicionantes impostas pelo Ibama sejam cumpridas.\nA SBPC (Sociedade Brasileira para o Progresso da Ciência), a ABA (Associação Brasileira de Antropologia) e demais entidades solicitam ainda que o governo federal espere consultas a indígenas e a moradores da região e o julgamento de ações contra a usina que existem hoje na Justiça.\n<a href=\"http://www1.folha.uol.com.br/mercado/917195-sem-licenca-inicio-de-operacao-de-belo-monte-pode-atrasar.shtml\">Sem licença, início de operação de Belo Monte pode atrasar</a><br/>\n<a href=\"http://www1.folha.uol.com.br/mercado/916852-ibama-faz-vistoria-final-antes-de-licenca-que-libera-belo-monte.shtml\">Ibama faz vistoria final antes de licença que libera Belo Monte</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/918596-associacoes-de-cientistas-pedem-suspensao-de-belo-monte.shtml\">Leia mais</a> (20/05/2011 - 15h54)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/918596-associacoes-de-cientistas-pedem-suspensao-de-belo-monte.shtml','2011-05-20 15:54:00'),(23,2,0,0,'Cientistas se preparam para encalhe em massa de baleias','Especialistas em animais marinhos estão se preparando para o encalhe de até cem baleias-piloto nas ilhas Ocidentais, localizadas no norte da Escócia.\nO grupo de baleias foi visto na tarde de quinta-feira na região de Loch Carnan. Cerca de 20 delas já apresentariam ferimentos nas cabeças, que teriam sido causados pelas tentativas das baleias de irem para a faixa litorânea da região, que é rochosa.\nBaleias doentes ou feridas geralmente vão para as praias, onde morrem. No entanto, em alguns casos, baleias saudáveis seguem as que estão agonizando.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/918564-cientistas-se-preparam-para-encalhe-em-massa-de-baleias.shtml\">Leia mais</a> (20/05/2011 - 15h14)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/918564-cientistas-se-preparam-para-encalhe-em-massa-de-baleias.shtml','2011-05-20 15:14:00'),(24,2,0,0,'Projeto coloca GPS em ursos que invadem zona urbana','Conservacionistas da Eslováquia iniciaram um projeto para colocar coleiras com tecnologia GPS e estudar o comportamento do urso pardo europeu.\nO país conseguiu conservar a espécie --cerca de mil vivem na Eslováquia--, mas os animais perderam o medo dos humanos e agora invadem cidades em busca de comida.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"tp://www.bbc.co.uk/worldservice/emp/pop.shtml?l=pt&amp;t=video&amp;r=1&amp;p=/portuguese/meta/dps/2011/05/emp/110520_ursos_eslovaquia_video_fn.emp.xml\">Veja o vídeo</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/918521-projeto-coloca-gps-em-ursos-que-invadem-zona-urbana.shtml\">Leia mais</a> (20/05/2011 - 13h25)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/918521-projeto-coloca-gps-em-ursos-que-invadem-zona-urbana.shtml','2011-05-20 13:25:00'),(25,2,0,0,'PM manda 160 homens acompanharem transporte de urânio na Bahia','A Polícia Militar da Bahia destacou 160 homens do 17º Batalhão e da Companhia de Ações Especiais do Sudoeste e Gerais para acompanhar o transporte da carga de urânio que, na segunda-feira (16), foi impedida por moradores de Caetité (624 km de Salvador) de entrar na cidade.\n<a href=\"http://www1.folha.uol.com.br/cotidiano/917224-carga-de-uranio-esta-em-batalhao-da-pm-a-ceu-aberto-na-ba.shtml\">Carga de urânio está em batalhão da PM a céu aberto na BA</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/916944-impasse-sobre-carga-de-uranio-levada-a-bahia-continua.shtml\">Impasse sobre carga de urânio levada à Bahia continua</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/916807-protesto-de-moradores-barra-carga-de-uranio-em-caetite-ba.shtml\">Protesto de moradores barra carga de urânio em Caetité (BA)</a>\n<table>\n<tr>\n<td>Divulgação/Greenpeace</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/cotidiano/images/11137617.jpeg\" alt=\"Carga de urânio em que gerou impasse em Caitité (BA)\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Carga de urânio em que gerou impasse em Caitité (BA)</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/918362-pm-manda-160-homens-acompanharem-transporte-de-uranio-na-bahia.shtml\">Leia mais</a> (19/05/2011 - 21h51)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/918362-pm-manda-160-homens-acompanharem-transporte-de-uranio-na-bahia.shtml','2011-05-19 21:51:00'),(26,2,0,0,'Ex-ministros vão a Dilma para se oporem ao Código Florestal','Ex-ministros da pasta de Meio Ambiente se encontram com a presidente Dilma Rousseff nesta segunda-feira.\nO grupo quer expressar em carta aberta sua preocupação sobre as mudanças sugeridas pelo relator do texto, deputado Aldo Rebelo (PCdoB-SP).\nOs signatárias são Nogueira Neto, José Goldemberg, Henrique Brandão Cavalcanti, Gustavo Krause, José Carlos Carvalho, Fernando Coutinho Jorge, Rubens Ricupero, José Sarney Filho, Marina Silva e Carlos Minc.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919598-ex-ministros-vao-a-dilma-para-se-oporem-ao-codigo-florestal.shtml\">Leia mais</a> (23/05/2011 - 13h58)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919598-ex-ministros-vao-a-dilma-para-se-oporem-ao-codigo-florestal.shtml','2011-05-23 13:58:00'),(27,2,0,0,'Novo Código Florestal é perverso, dizem ex-ministros de Ambiente','Dez ex-ministros do Meio Ambiente se uniram nesta segunda-feira contra o texto da reforma do Código Florestal que deve ser votado amanhã (24) pela Câmara.\nEm carta aberta à presidente Dilma Rousseff e ao Congresso, o grupo diz que a proposta a ser analisada significa um retrocesso na política ambiental brasileira, que foi &quot;pioneira&quot; na criação de leis de conservação e proteção de recursos naturais.\nSegundo os ex-ministros, a votação do texto do deputado Aldo Rebelo (PCdoB-SP) nesta semana é prematura.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919652-novo-codigo-florestal-e-perverso-dizem-ex-ministros-de-ambiente.shtml\">Leia mais</a> (23/05/2011 - 15h51)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919652-novo-codigo-florestal-e-perverso-dizem-ex-ministros-de-ambiente.shtml','2011-05-23 15:51:00'),(28,2,0,0,'Pesquisa nacional estuda aproveitamento de bagaço de uva','A CTAA (Embrapa Agroindústria de Alimentos), unidade da Empresa Brasileira de Pesquisa Agropecuária, está iniciando uma pesquisa sobre o aproveitamento econômico dos resíduos da indústria vinícola e de sucos.\nA coordenadora do projeto, Lourdes Maria Correa Cabral, explicou à Agência Brasil que um dos fatores que justificam os benefícios trazidos à saúde pelo vinho é a presença de substâncias antioxidantes, que retardam o envelhecimento.\nEntre elas, estão os compostos fenólicos, com destaque para as antocianinas, que dão a frutas e legumes a coloração vermelha, como ocorre no caso da uva. Esses compostos funcionais têm interesse comercial e industrial.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/919623-pesquisa-nacional-estuda-aproveitamento-de-bagaco-de-uva.shtml\">Leia mais</a> (23/05/2011 - 15h03)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/919623-pesquisa-nacional-estuda-aproveitamento-de-bagaco-de-uva.shtml','2011-05-23 15:03:00'),(29,2,0,0,'Dilma recebe ex-ministros que são contra texto de lei florestal','Os oito ex-ministros de Meio Ambiente que vieram a Brasília pedir o adiamento da votação na Câmara dos Deputados do novo Código Florestal foram recebidos no final desta manhã (24) pela presidente Dilma Rousseff.\nAo final do encontro, eles declararam que Dilma acredita que o aumento do desmatamento está relacionado &quot;à expectativa de aprovação&quot; do novo Código Florestal. O texto em discussão na Câmara anistia produtores rurais que desmataram no passado.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Leia mais</a> (24/05/2011 - 13h53)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml','2011-05-24 13:53:00'),(30,2,0,0,'Relator do Código Florestal critica ex-ministros de Meio Ambiente','O relator do novo Código Florestal, Aldo Rebelo (PC do B-SP), distribuiu críticas aos ex-ministros de Meio Ambiente que estão em Brasília desde segunda-feira (23) para tentar o adiamento da votação do texto na Câmara.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nAo chegar para uma reunião com os ministros Antonio Palocci (Casa Civil) e Luiz Sérgio (Relações Institucionais), Rebelo chamou a carta enviada pelos ex-titulares à presidente Dilma Rousseff de &quot;abaixo-assinado&quot;. Criticou ainda os ex-ministros Carlos Minc e Marina Silva (governo Lula) e Zequinha Sarney (governo Fernando Henrique Cardoso).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Leia mais</a> (24/05/2011 - 13h47)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml','2011-05-24 13:47:00'),(31,2,0,0,'Líder extrativista do PA é morto; Dilma ordena investigação','A presidente Dilma Rousseff foi comunicada nesta terça-feira pelos ex-ministros de Meio Ambiente do assassinato, no Pará, de um líder extrativista e sua mulher.\nEla determinou que o ministro da Justiça, José Eduardo Cardozo, mobilize a Polícia Federal para investigar a morte, que está sendo comparada à da missionária Dorothy Stang, assassinada há seis anos em Anapu (PA).\nJosé Claudio Ribeiro da Silva e a mulher, Maria do Espírito Santo da Silva, foram mortos hoje no Assentamento Agroextrativista Praialtapiranheira, no município de Nova Ipixuna, próximo a Marabá.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920120-lider-extrativista-do-pa-e-morto-dilma-ordena-investigacao.shtml\">Leia mais</a> (24/05/2011 - 13h31)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920120-lider-extrativista-do-pa-e-morto-dilma-ordena-investigacao.shtml','2011-05-24 13:31:00'),(32,2,0,0,'Impasse regimental impede votação do Código Florestal, diz Rebelo','Relator da reforma do Código Florestal, o deputado Aldo Rebelo (PC do B-SP) afirmou nesta terça-feira que um impasse regimental ainda não permite que o texto seja colocado em votação no plenário da Câmara.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nDesde o início da manhã, a Casa já realiza sessão para analisar o texto.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Leia mais</a> (24/05/2011 - 13h05)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml','2011-05-24 13:05:00'),(33,2,0,0,'Governo cede para votar nova lei florestal nesta terça-feira','Para costurar um acordo com a base aliada na Câmara sobre o Código Florestal, o governo recuou em um dos principais pontos da reforma: aceitou flexibilizar a regra das APPs (áreas de preservação ambiental) em propriedades de agricultura familiar.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nO recuo foi considerado uma &quot;evolução&quot; pelo relator do texto, deputado Aldo Rebelo (PCdoB-SP).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Leia mais</a> (24/05/2011 - 11h53)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml','2011-05-24 11:53:00'),(34,2,0,0,'Imagens da Nasa mostram vulcões em erupção vistos do espaço','Imagens feitas por satélites da Nasa, a agência espacial americana, mostram a atividade do vulcão Grimsvotn, na Islândia, que entrou em erupção no último sábado, e ajudam a mostrar a dimensão e o impacto do fenômeno.\nA erupção do Grimsvotn já provocou o cancelamento de centenas de voos na Europa.\nNo ano passado, as cinzas de outro vulcão islandês, o Eyjafjallajokull, provocaram o cancelamento de cerca de 100 mil voos na Europa ao longo de quase um mês, gerando um prejuízo estimado em US$ 1,7 bilhão (cerca de R$ 2,75 bilhões).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920048-imagens-da-nasa-mostram-vulcoes-em-erupcao-vistos-do-espaco.shtml\">Leia mais</a> (24/05/2011 - 10h45)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920048-imagens-da-nasa-mostram-vulcoes-em-erupcao-vistos-do-espaco.shtml','2011-05-24 10:45:00'),(35,2,0,0,'Acusada de promover safáris de onça é multada em R$ 115 mil','A pecuarista Beatriz Rondon, acusada de abrigar em sua fazenda no Pantanal de Mato Grosso do Sul um esquema de <a href=\"http://www1.folha.uol.com.br/cotidiano/912479-video-leva-pf-a-apreender-cranios-de-onca-e-armas-em-ms.shtml\">safáris ilegais</a> de onças e outros animais silvestres, recebeu uma multa do Ibama no valor de R$ 115 mil.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-video-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://www1.folha.uol.com.br/cotidiano/912479-video-leva-pf-a-apreender-cranios-de-onca-e-armas-em-ms.shtml\"><b>PF apreende crânios de onça e armas</b></a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/771291-ibama-multa-suspeitos-de-organizar-safaris-para-cacar-oncas-no-pantanal.shtml\">Ibama multa suspeitos de organizar safáris</a>\nAlvo da Operação Jaguar 2, deflagrada pelo Ibama e a Polícia Federal no dia 5, a pecuarista já havia sido multada anteriormente em R$ 105 mil por caça ilegal e abate de animais ameaçados de extinção.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919830-acusada-de-promover-safaris-de-onca-e-multada-em-r-115-mil.shtml\">Leia mais</a> (23/05/2011 - 19h48)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919830-acusada-de-promover-safaris-de-onca-e-multada-em-r-115-mil.shtml','2011-05-23 19:48:00'),(36,2,0,0,'Governo flexibiliza Código Florestal um dia antes da votação','A menos de 24 horas da votação do Código Florestal, o governo lançou uma nova proposta para a base aliada. O Palácio do Planalto sugeriu a flexibilização das APPs (áreas de preservação ambiental).\n<table>\n<tr>\n<td>Marcelo Camargo/Folhapress</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/ambiente/images/11143526.jpeg\" alt=\"Marina Silva e Carlos Minc, ex-ministros do Ambiente, criticaram texto do Código Florestal\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Marina Silva e Carlos Minc, ex-ministros do Ambiente, criticaram texto do Código Florestal</td>\n</tr>\n</table>\nA nova proposta do governo prevê que as APPs em matas ciliares (as chamadas APPs de rio) para propriedades de até quatro módulos (de 20 a 400 hectares) serão de 20%, em casos de regularização.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919819-governo-flexibiliza-codigo-florestal-um-dia-antes-da-votacao.shtml\">Leia mais</a> (23/05/2011 - 19h34)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919819-governo-flexibiliza-codigo-florestal-um-dia-antes-da-votacao.shtml','2011-05-23 19:34:00'),(37,1,0,0,'Conversa Rápida 13/06','<p>No dia 13 de Junho, das 19:30 às 22:00, acontecerá na <a href=\"http://www.adaptworks.com.br\" target=\"_blank\">AdaptWorks</a> mais uma edição do <a href=\"http://www.adaptworks.com.br/blog/2011/05/18/conversa-rapida-junho/\" target=\"_blank\">Conversa Rápida</a>.</p>\n<p>A <a href=\"http://vidageek.net/2011/05/14/conversa-rapida/\" target=\"_blank\">edição passada</a> foi bem divertida. Se tiver interesse em participar, mande um email para jabreu@adaptworks.com.br&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/M1wMHH29LMw/','2011-05-20 18:25:00'),(38,1,0,0,'Expressividade','<p>Enquanto eu resolvia o <a href=\"http://vidageek.net/2011/05/16/desafio-de-expressividade-i/\" target=\"_blank\">primeiro desafio de expressividade</a>, eu notei uma coisa relacionada ao <a href=\"https://github.com/jonasabreu/desafio20110516\" target=\"_blank\">código das minhas classes</a>.</p>\n<p>O código mais próximo da interface que resolvia o desafio, eu tentei manter o mais próximo da linguagem&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/HM5bB6ujfdw/','2011-05-18 10:00:00'),(39,1,0,0,'Desafio de expressividade I','<p>Já faz um bom tempo em que venho pensando em como criar formas de exercitar diversas técnicas de programação.</p>\n<p>Recentemente, enquanto eu desenvolvia um <a href=\"http://www.adaptworks.com.br/treinamento/CSD-Scrum-Developer-Skills\" target=\"_blank\">treinamento para a AdaptWorks</a> (parte da <a href=\"http://www.scrumalliance.org/CSD\" target=\"_blank\">certificação CSD da ScrumAlliance</a>), me veio&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/95gTQlD-aJc/','2011-05-16 10:00:00'),(40,1,0,0,'Conversa Rápida','<p>No começo da semana passada aconteceu um mini evento na <a href=\"http://www.adaptworks.com.br\" target=\"_blank\">AdaptWorks</a>, organizado por mim, chamado Conversa Rápida.</p>\n<p>Foram 12 palestras com aproximadamente 5 minutos, que foram filmadas e <a href=\"http://www.youtube.com/user/adaptworks\" target=\"_blank\">colocadas no YouTube</a>.</p>\n<p>Das 12, 5 fui eu&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/8bxgK-AktZo/','2011-05-14 18:31:00'),(41,1,0,0,'Não. Seu site não é totalmente confiável.','<p>&#8220;A loja é totalmente confiável e os seus dados estão seguros&#8221;. Essa frase me deu calafrios assim que li em um email que recebi.</p>\n<p>Um pouco de contexto. A fonte do meu notebook se decompos. Como não vivo sem ele,&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/trTv0_ZjD48/','2011-05-09 19:09:00'),(42,1,0,0,'Agile Searcher','<p>Tempos atrás precisei reunir várias referências sobre desenvolvimento ágil. Depois de buscar muito no Google e sofrer um pouco para filtrar os resultados, resolvi criar um <a href=\"http://www.google.com/cse\" target=\"_blank\">Google Custom Search Engine</a> com alguns sites para facilitar a minha vida.&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/BPD3-NZg1Cs/','2011-04-06 21:22:00'),(43,1,0,0,'Open Source Week – Fim','<p>Foram duas semanas de trabalhos para documentar e lançar esses projetos (alguns já estavam &#8220;quase prontos&#8221; a mais de 6 meses.).</p>\n<p>Para finalizar isso, resolvi colocar no ar <a href=\"http://projetos.vidageek.net/\" target=\"_blank\">a página de projetos do VidaGeek.net</a>. A idéia dessa página&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/aBCxS0XN1z4/','2011-02-27 10:00:00'),(44,1,0,0,'Open Source Week – Mirror','<p>Para finalizar os lançamentos de projetos essa semana, a versão 1.6 do <a href=\"http://projetos.vidageek.net/mirror-pt\" target=\"_blank\">Mirror</a> finalmente foi lançada.</p>\n<p>Essa versão trás muitas pequenas melhorias para o dia a dia (como refletir um getter/setter) e algumas novas features que fizeram falta&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/nWzgYYP135Q/','2011-02-26 10:00:00'),(45,1,0,0,'Open Source Week – Scraper','<p>O Terceiro lançamento é o <a href=\"http://projetos.vidageek.net/scraper\" target=\"_blank\">Scraper</a>.</p>\n<p>O Scraper é uma ferramenta para facilitar <a href=\"http://en.wikipedia.org/wiki/Web_scraping\" target=\"_blank\">Html Scrapping</a>, ou seja, extrair dados de páginas html.</p>\n<p>Existem diversas formas de extrair dados de páginas Html. Você pode usar <a href=\"http://en.wikipedia.org/wiki/Regular_expression\"&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/QPqgu3lvpJo/','2011-02-25 10:00:00'),(46,1,0,0,'Open Source Week – I18n','<p>O segundo lançamento é da versão 0.5 do <a href=\"http://vidageek.net/2010/02/24/i18n-para-java/\" target=\"_blank\">I18n, lançado ano passado</a>. Essa versão resolve o problema que tivemos para lidar<br />\ncom mensagens muito grandes (ficava muito ruim no .properties).</p>\n<p>Também melhoramos a documentação.</p>\n<p>Mais informações em&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/mePL0FU-edQ/','2011-02-24 10:00:00'),(47,2,0,0,'Dilma irrita-se com Código Florestal e promete veto','A presidente Dilma Rousseff ficou irritada com a aprovação do Código Florestal na Câmara dos Deputados após um racha da base governista e garantiu a um governista que participou das negociações que vetará os trechos do texto que considera equivocados, caso a base não consiga promover mudanças no Senado.\nDe acordo com o governista, que pediu para não ter o nome revelado, Dilma afirmou antes da votação que esperava a derrota do governo, mas se disse confiante de que a base governista conseguirá fazer as mudanças na votação no Senado.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920514-camara-aprova-texto-do-novo-codigo-florestal.shtml\">Câmara aprova texto do novo Código Florestal</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920572-dilma-irrita-se-com-codigo-florestal-e-promete-veto.shtml\">Leia mais</a> (25/05/2011 - 09h28)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920572-dilma-irrita-se-com-codigo-florestal-e-promete-veto.shtml','2011-05-25 12:28:00'),(48,2,0,0,'Câmara aprova texto do novo Código Florestal','Após semanas de embate, negociações e troca de acusações, a Câmara dos Deputados aprovou ontem o texto da reforma do Código Florestal com alterações que significaram uma derrota para o governo.\nUma emenda aprovada por 273 votos a 182 rachou a base do governo levando os principais partidos governistas, PT e PMDB, para lados opostos. O texto da emenda consolida a manutenção de atividades agrícolas nas APPs (áreas de preservação permanente), autoriza os Estados a participarem da regularização ambiental e deixa claro a anistia para os desmates ocorridos até junho de 2008.\nO líder do governo, Cândido Vaccarezza (PT-SP), chegou a falar, em nome da presidente Dilma Rousseff, que a aprovação da emenda seria &quot;uma vergonha&quot;.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920514-camara-aprova-texto-do-novo-codigo-florestal.shtml\">Leia mais</a> (25/05/2011 - 00h43)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920514-camara-aprova-texto-do-novo-codigo-florestal.shtml','2011-05-25 03:43:00'),(49,2,0,0,'Queimadas ameaçam florestas de turfa na Indonésia','As florestas de turfa são um dos ecossistemas que mais armazenam gás carbônico. Na Indonésia, estão ameaçadas pelo desmatamento. Incentivos financeiros e mudanças nas políticas dos países industriais podem ser a saída.\nEm julho de 1997, as pessoas foram obrigadas a usar máscaras cirúrgicas nas ruas entre os edifícios de Jacarta, capital da Indonésia, devido à alta concentração de fumaça no ar. Naquele ano, marcado por uma forte estiagem, as queimadas saíram do controle e uma densa camada de fumaça cobriu a Indonésia e a Malásia. A nuvem chegou a atingir a Austrália e só se desfez por completo após um ano. Dez milhões de hectares foram queimados.\nGrande parte do que queimou foram as florestas de turfa, um dos ecossistemas que mais armazena CO2 no planeta. A turfa é o material precursor do carvão e, sendo assim, em tais florestas o processo de decomposição em solo já se encontra em um estágio avançado, muito mais do que onde crescem as florestas tropicais normais. Por esse motivo, as turfeiras podem armazenar até 50 vezes mais carbono do que outras áreas florestais dos trópicos.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/dw/920235-queimadas-ameacam-florestas-de-turfa-na-indonesia.shtml\">Leia mais</a> (24/05/2011 - 23h28)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/dw/920235-queimadas-ameacam-florestas-de-turfa-na-indonesia.shtml','2011-05-25 02:28:00'),(50,2,0,0,'Entenda a polêmica sobre o novo Código Florestal','A Câmara dos Deputados aprovou o texto-base do polêmico projeto do novo Código Florestal, proposto pelo deputado Aldo Rebelo (PCdoB-SP).\nA proposta, que já sofreu diversas modificações desde que foi apresentada pela primeira vez, dividiu ruralistas, ambientalistas e acadêmicos.\nEntenda a polêmica em torno do novo Código Florestal:\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920452-entenda-a-polemica-sobre-o-novo-codigo-florestal.shtml\">Leia mais</a> (24/05/2011 - 21h27)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920452-entenda-a-polemica-sobre-o-novo-codigo-florestal.shtml','2011-05-25 00:27:00'),(51,2,0,0,'Câmara aprova texto-base do Código Florestal; emendas serão analisadas','O plenário da Câmara dos Deputados aprovou, por 410 votos a 63 e 1 abstenção, o texto-base da última versão do deputado Aldo Rebelo (PC do B-SP) para o projeto de lei do novo Código Florestal.\nOs deputados devem votar, em seguida, os destaques de emendas e de partes do texto apresentados pelos partidos. A emenda que causa discórdia é a do PMDB, que consolida as APPs (área de preservação permanente) e autoriza a participação dos Estados no processo de regularização ambiental.\nMais cedo, o líder do governo na Câmara, Cândido Vaccarezza (PT-SP), disse que a reforma do Código Florestal seria votado hoje mesmo sem acordo entre o Palácio do Planalto e os líderes da base aliada.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920447-camara-aprova-texto-base-do-codigo-florestal-emendas-serao-analisadas.shtml\">Leia mais</a> (24/05/2011 - 21h19)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920447-camara-aprova-texto-base-do-codigo-florestal-emendas-serao-analisadas.shtml','2011-05-25 00:19:00'),(52,2,0,0,'Google e Citigroup investirão US$ 110 mi em energia eólica','O Google e o Citigroup investirão cada um US$ 55 milhões no projeto Alta 4, da Terra-Gen Power, capaz de gerar 102 megawatts de energia na Califórnia, afirmaram as companhias.\nO projeto deve se tornar um dos maiores geradores de energia eólica dos Estados Unidos --com capacidade de abastecer 450 mil casas.\nA Terra-Gen Power, que trabalha com energia renovável, está construindo o projeto Awec (Alta Wind Energy Center), com capacidade de geração eólica de 1.550 MW, em várias fases, das quais cinco já foram concluídas.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/920379-google-e-citigroup-investirao-us-110-mi-em-energia-eolica.shtml\">Leia mais</a> (24/05/2011 - 20h08)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/920379-google-e-citigroup-investirao-us-110-mi-em-energia-eolica.shtml','2011-05-24 23:08:00'),(53,2,0,0,'Mesmo sem acordo, votação do Código Florestal deve sair hoje','Após idas e vindas da Casa Civil, o líder do governo na Câmara, Cândido Vaccarezza (PT-SP), disse que a reforma do Código Florestal será votada na noite desta terça-feira sem acordo entre o Palácio do Planalto e os líderes da base aliada.\nSegundo Vaccarezza, o governo vai orientar para que a base derrube a emenda que será apresentada pelo PMDB que consolida as APPs (área de preservação permanente) e autoriza a participação dos Estados no processo de regularização ambiental.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920240-mesmo-sem-acordo-votacao-do-codigo-florestal-deve-sair-hoje.shtml\">Leia mais</a> (24/05/2011 - 17h41)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920240-mesmo-sem-acordo-votacao-do-codigo-florestal-deve-sair-hoje.shtml','2011-05-24 20:41:00'),(54,2,0,0,'Fungo brasileiro está entre as espécies mais significativas de 2010','Um fungo que emite luz, uma sanguessuga com dentes gigantes batizada de &quot;T-rex&quot; e uma barata saltadora são alguns dos integrantes da lista com dez novas espécies consideradas mais significativas de 2010.\nO Estado de São Paulo representa o Brasil com um pequeno fungo encontrado no interior da Mata Atlântica. Com caules forrados por uma espécie de gel, a espécie emite uma constante e brilhante luz verde-amarelada.\n<table>\n<tr>\n<td>Arizona State University</td>\n</tr>\n<tr>\n<td><a href=\"http://fotografia.folha.uol.com.br/galerias/3007-fungo-brasileiro-esta-entre-as-especies-mais-significativas-de-2010\"><img src=\"http://f.i.uol.com.br/folha/ciencia/images/11144461.jpeg\" alt=\"Fungo bioluminescente descoberto pela USP possui camada de gel que emite luz verde-amarelada; veja galeria de fotos\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://fotografia.folha.uol.com.br/galerias/3007-fungo-brasileiro-esta-entre-as-especies-mais-significativas-de-2010\">Fungo bioluminescente descoberto pela USP possui camada de gel que emite luz verde-amarelada; veja galeria de fotos</a> </td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/920200-fungo-brasileiro-esta-entre-as-especies-mais-significativas-de-2010.shtml\">Leia mais</a> (24/05/2011 - 17h18)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/920200-fungo-brasileiro-esta-entre-as-especies-mais-significativas-de-2010.shtml','2011-05-24 20:18:00'),(55,2,0,0,'Dilma recebe ex-ministros que são contra texto de lei florestal','Os oito ex-ministros de Meio Ambiente que vieram a Brasília pedir o adiamento da votação na Câmara dos Deputados do novo Código Florestal foram recebidos no final desta manhã (24) pela presidente Dilma Rousseff.\nAo final do encontro, eles declararam que Dilma acredita que o aumento do desmatamento está relacionado &quot;à expectativa de aprovação&quot; do novo Código Florestal. O texto em discussão na Câmara anistia produtores rurais que desmataram no passado.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Leia mais</a> (24/05/2011 - 13h53)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml','2011-05-24 16:53:00'),(56,2,0,0,'Relator do Código Florestal critica ex-ministros de Meio Ambiente','O relator do novo Código Florestal, Aldo Rebelo (PC do B-SP), distribuiu críticas aos ex-ministros de Meio Ambiente que estão em Brasília desde segunda-feira (23) para tentar o adiamento da votação do texto na Câmara.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nAo chegar para uma reunião com os ministros Antonio Palocci (Casa Civil) e Luiz Sérgio (Relações Institucionais), Rebelo chamou a carta enviada pelos ex-titulares à presidente Dilma Rousseff de &quot;abaixo-assinado&quot;. Criticou ainda os ex-ministros Carlos Minc e Marina Silva (governo Lula) e Zequinha Sarney (governo Fernando Henrique Cardoso).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Leia mais</a> (24/05/2011 - 13h47)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml','2011-05-24 16:47:00'),(57,2,0,0,'Líder extrativista do PA é morto; Dilma ordena investigação','A presidente Dilma Rousseff foi comunicada nesta terça-feira pelos ex-ministros de Meio Ambiente do assassinato, no Pará, de um líder extrativista e sua mulher.\nEla determinou que o ministro da Justiça, José Eduardo Cardozo, mobilize a Polícia Federal para investigar a morte, que está sendo comparada à da missionária Dorothy Stang, assassinada há seis anos em Anapu (PA).\nJosé Claudio Ribeiro da Silva e a mulher, Maria do Espírito Santo da Silva, foram mortos hoje no Assentamento Agroextrativista Praialtapiranheira, no município de Nova Ipixuna, próximo a Marabá.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920120-lider-extrativista-do-pa-e-morto-dilma-ordena-investigacao.shtml\">Leia mais</a> (24/05/2011 - 13h31)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920120-lider-extrativista-do-pa-e-morto-dilma-ordena-investigacao.shtml','2011-05-24 16:31:00'),(58,2,0,0,'Impasse regimental impede votação do Código Florestal, diz Rebelo','Relator da reforma do Código Florestal, o deputado Aldo Rebelo (PC do B-SP) afirmou nesta terça-feira que um impasse regimental ainda não permite que o texto seja colocado em votação no plenário da Câmara.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nDesde o início da manhã, a Casa já realiza sessão para analisar o texto.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Leia mais</a> (24/05/2011 - 13h05)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml','2011-05-24 16:05:00'),(59,2,0,0,'Governo cede para votar nova lei florestal nesta terça-feira','Para costurar um acordo com a base aliada na Câmara sobre o Código Florestal, o governo recuou em um dos principais pontos da reforma: aceitou flexibilizar a regra das APPs (áreas de preservação ambiental) em propriedades de agricultura familiar.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nO recuo foi considerado uma &quot;evolução&quot; pelo relator do texto, deputado Aldo Rebelo (PCdoB-SP).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Leia mais</a> (24/05/2011 - 11h53)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml','2011-05-24 14:53:00'),(60,2,0,0,'Imagens da Nasa mostram vulcões em erupção vistos do espaço','Imagens feitas por satélites da Nasa, a agência espacial americana, mostram a atividade do vulcão Grimsvotn, na Islândia, que entrou em erupção no último sábado, e ajudam a mostrar a dimensão e o impacto do fenômeno.\nA erupção do Grimsvotn já provocou o cancelamento de centenas de voos na Europa.\nNo ano passado, as cinzas de outro vulcão islandês, o Eyjafjallajokull, provocaram o cancelamento de cerca de 100 mil voos na Europa ao longo de quase um mês, gerando um prejuízo estimado em US$ 1,7 bilhão (cerca de R$ 2,75 bilhões).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920048-imagens-da-nasa-mostram-vulcoes-em-erupcao-vistos-do-espaco.shtml\">Leia mais</a> (24/05/2011 - 10h45)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920048-imagens-da-nasa-mostram-vulcoes-em-erupcao-vistos-do-espaco.shtml','2011-05-24 13:45:00'),(61,2,0,0,'Acusada de promover safáris de onça é multada em R$ 115 mil','A pecuarista Beatriz Rondon, acusada de abrigar em sua fazenda no Pantanal de Mato Grosso do Sul um esquema de <a href=\"http://www1.folha.uol.com.br/cotidiano/912479-video-leva-pf-a-apreender-cranios-de-onca-e-armas-em-ms.shtml\">safáris ilegais</a> de onças e outros animais silvestres, recebeu uma multa do Ibama no valor de R$ 115 mil.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-video-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://www1.folha.uol.com.br/cotidiano/912479-video-leva-pf-a-apreender-cranios-de-onca-e-armas-em-ms.shtml\"><b>PF apreende crânios de onça e armas</b></a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/771291-ibama-multa-suspeitos-de-organizar-safaris-para-cacar-oncas-no-pantanal.shtml\">Ibama multa suspeitos de organizar safáris</a>\nAlvo da Operação Jaguar 2, deflagrada pelo Ibama e a Polícia Federal no dia 5, a pecuarista já havia sido multada anteriormente em R$ 105 mil por caça ilegal e abate de animais ameaçados de extinção.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919830-acusada-de-promover-safaris-de-onca-e-multada-em-r-115-mil.shtml\">Leia mais</a> (23/05/2011 - 19h48)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919830-acusada-de-promover-safaris-de-onca-e-multada-em-r-115-mil.shtml','2011-05-23 22:48:00'),(62,2,0,0,'O não acordo','Na falta de um consenso mínimo sobre os pontos principais do novo Código Florestal, o Palácio do Planalto, os ambientalistas, os 10 ex-ministros do Meio Ambiente, o PT, o PV e o PSOL jogaram a toalha e decidiram votar logo na Câmara como estava. Depois é depois. Ou melhor: depois se vê o que se faz.\nFoi assim que o texto do relator Aldo Rebelo (PC do B-SP) foi aprovado na noite de terça-feira, com todos exaustos e uma sensação de alívio. Os que mais comemoraram foram os ruralistas e os que pregavam um equilíbrio entre a necessidade de preservação do meio ambiente e a necessidade de preservação também dos pequenos produtores.\nComo Aldo está rouco de repetir, dos 5,2 milhões de produtores brasileiros, 4,3 milhões são pequenos, aqueles sujeitos que dão um duro danado para ter sua plantação, fornecer comida à população e garantir a sobrevivência mais ou menos digna deles próprios e das suas famílias.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/colunas/elianecantanhede/920604-o-nao-acordo.shtml\">Leia mais</a> (25/05/2011 - 11h14)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/colunas/elianecantanhede/920604-o-nao-acordo.shtml','2011-05-25 14:14:00'),(63,1,0,0,'Gradle Trick – Escopo Provided','<p>Eu tenho brincado bastante com <a href=\"http://gradle.org\" target=\"_blank\">gradle</a> (pretendo migrar todos meus projetos maven para ele).</p>\n<p>Uma das coisas que precisei recentemente foi de algo semelhante ao escopo provided do maven. Aparentemente a <a href=\"http://issues.gradle.org/browse/GRADLE-784\" target=\"_blank\">versão 1.0 terá suporte</a>, mas&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/mKnvMG92ctM/','2011-06-08 19:08:00'),(64,2,0,0,'Complexo turístico gigante no Egito ameaça aves e fósseis','Um projeto de complexo turístico de proporções gigantescas ameaça a reserva natural do lago Qarun, no oásis de Al Fayoum, ao sul do Cairo, onde vivem milhares de aves e se encontram fósseis e jazidas arqueológicas ainda não estudados.\nOs ambientalistas, que defendem o turismo sustentável na região, veem com suspeita este projeto depois que o governo do ex-presidente Hosni Mubarak cedeu, em dezembro do ano passado, 2,8 quilômetros quadrados de terreno junto ao lago à construtora Amre Group por US$ 0,01 por metro quadrado.\n<table>\n<tr>\n<td>Zorbey Tunçer - 1º.ago.2008/Creative Commons</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/turismo/images/11164682.jpeg\" alt=\"Oásis Faiyum, região onde fica o lago Qarum, ameaçado por projeto turístico, a cerca de 130 km a sul do Cairo, no Egito\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Oásis Faiyum, região onde fica o lago Qarum, ameaçado por projeto turístico, a cerca de 130 km a sul do Cairo, no Egito</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/929380-complexo-turistico-gigante-no-egito-ameaca-aves-e-fosseis.shtml\">Leia mais</a> (13/06/2011 - 18h17)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/929380-complexo-turistico-gigante-no-egito-ameaca-aves-e-fosseis.shtml','2011-06-13 18:17:00'),(65,2,0,0,'Datafolha indica que 80% rejeitam corte de proteção a matas','Uma pesquisa encomendada pelas principais organizações ambientalistas do país diz que cerca de 80% da população não aprova as mudanças no Código Florestal.\nA nova versão dessa lei, que determina as áreas de mata que devem ser preservadas em propriedades rurais, foi aprovada no mês passado pela Câmara e agora aguarda votação no Senado.\nEntre as mudanças no código estão, por exemplo, a isenção de reserva legal (proporção de uma fazenda que não pode ser desmatada) para pequenas propriedades, de até 400 hectares.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/929142-datafolha-indica-que-80-rejeitam-corte-de-protecao-a-matas.shtml\">Leia mais</a> (13/06/2011 - 11h37)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/929142-datafolha-indica-que-80-rejeitam-corte-de-protecao-a-matas.shtml','2011-06-13 11:37:00'),(66,2,0,0,'Ambientalistas colocam barco de tetra pak em canal alemão','Um barco com nove metros de comprimento, fabricado com embalagens do tipo tetra pak, flutuou nesta segunda-feira pelo canal de Karl-Heine, na cidade alemã de Leipzig.\nO artista conceitual Frank Boelter, que idealizou o embarcação, disse que as embalagens simbolizam o fim da Era Industrial e, ao mesmo tempo, criticam a mentalidade do desperdício.\nSegundo os organizadores do evento, o ato serve para pedir pelo retorno da topografia fluvial original em regiões urbanas.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/929171-ambientalistas-colocam-barco-de-tetra-pak-em-canal-alemao.shtml\">Leia mais</a> (13/06/2011 - 11h37)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/929171-ambientalistas-colocam-barco-de-tetra-pak-em-canal-alemao.shtml','2011-06-13 11:37:00'),(67,2,0,0,'Águia pescando vence concurso de fotos de vida selvagem','O Museu Nacional de História Natural Smithsonian, em Washington (EUA), está exibindo fotos vencedoras do concurso anual Windland Smith Rice International Awards, da revista &quot;Nature\'s Best Photography&quot;, que escolhe as melhores imagens da vida selvagem ao redor do mundo.\nO concurso recebeu mais de 20 mil inscrições com imagens que capturam momentos únicos da vida selvagem em 56 países.\n<a href=\"http://fotografia.folha.uol.com.br/galerias/3235-concurso-global-de-imagens-da-vida-selvagem\">Veja galeria de fotos</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/929090-aguia-pescando-vence-concurso-de-fotos-de-vida-selvagem.shtml\">Leia mais</a> (13/06/2011 - 07h12)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/929090-aguia-pescando-vence-concurso-de-fotos-de-vida-selvagem.shtml','2011-06-13 07:12:00'),(68,2,0,0,'Avião movido a energia solar não consegue completar voo','O avião suíço Impulso Solar, que funciona por energia solar, deu meia volta neste sábado de volta a Bruxelas, devido a dificuldades durante o voo. Com isso, o objetivo de alcançar o aeroporto de Le Bourget, perto de Paris, não foi atingido, anunciou uma porta-voz à France Presse.\nA aeronave, que decolou da capital belga, teve de dar meia volta logo depois de entrar em território francês, segundo a porta-voz do Solar Impulse.\n&quot;Não há nenhuma pista de aterrissagem intermediária, e como as baterias de energia estavam diminuindo, preferimos dar meia volta para não colocar a vida do piloto [André Borschberg] em perigo&quot;, explicou a porta-voz.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/928792-aviao-movido-a-energia-solar-nao-consegue-completar-voo.shtml\">Leia mais</a> (11/06/2011 - 18h43)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/928792-aviao-movido-a-energia-solar-nao-consegue-completar-voo.shtml','2011-06-11 18:43:00'),(69,2,0,0,'Games: Zé Colméia apronta todas para salvar parque florestal','<table>\n<tr>\n<td>Divulgação</td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1165101/yogi-bear-the-video-game\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/1115890.jpeg\" alt=\"Yogi Bear (Zé Colméia) e Catatau devem salvar a floresta\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1165101/yogi-bear-the-video-game\">Yogi Bear (Zé Colméia) e Catatau devem salvar a floresta</a> </td>\n</tr>\n</table>\nO querido e malandro personagem <a href=\"http://livraria.folha.com.br/catalogo/1165101/yogi-bear-the-video-game\"><b>Zé Colméia</b></a> tem uma missão especial em seu jogo para Wii.\nO parque onde vive e costuma &quot;pegar emprestado&quot; algumas cestas de piquenique dos visitantes está para ser fechado, pois urbanistas loucos querem cortar todas as árvores e expulsar os animais dali para construir edifícios gigantes e avenidas sem fim. Para que isso não aconteça, você deve tomar o comando do Zé e viver aventuras em diversos cenários da floresta.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/926406-games-ze-colmeia-apronta-todas-para-salvar-parque-florestal.shtml\">Leia mais</a> (11/06/2011 - 11h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/926406-games-ze-colmeia-apronta-todas-para-salvar-parque-florestal.shtml','2011-06-11 11:00:00'),(70,2,0,0,'Relações de risco em &quot;Vizinho - o Pentelho que Mora ao Lado&quot;','<table>\n<tr>\n<td>Divulgação</td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1031010/vizinho-o-pentelho-mora-ao-lado\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/11159211.jpeg\" alt=\"Quando o assunto é vizinho, restam-lhe duas opções: chorar ou rir\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1031010/vizinho-o-pentelho-mora-ao-lado\">Quando o assunto é vizinho, restam-lhe duas opções: chorar ou rir</a> </td>\n</tr>\n</table>\nO tema é recorrente e sempre atual. No que consta, desde os tempos bíblicos há implicâncias e desafetos com a pessoa da porta ao lado, seja lá quais forem os motivos, pois numericamente falando, eles são praticamente infinitos.\nPara analisar de uma ótica muito particular a tendência humana de se desentender com o próximo, o humorista Castelo (codinome resumido de Carlos Antônio de Melo e Castelo Branco) enumera de forma escrachada personagens e situações que uma ora ou outra o leitor vai conhecer ou vivenciar no livro <a href=\"http://livraria.folha.com.br/catalogo/1031010/vizinho-o-pentelho-mora-ao-lado\"><b>&quot;Vizinho - o Pentelho que Mora ao Lado&quot;</b></a>.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/926999-relacoes-de-risco-em-vizinho---o-pentelho-que-mora-ao-lado.shtml\">Leia mais</a> (10/06/2011 - 14h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/926999-relacoes-de-risco-em-vizinho---o-pentelho-que-mora-ao-lado.shtml','2011-06-10 14:00:00'),(71,2,0,0,'Mudança climática reduzirá água disponível para agricultura','A FAO (Organização das Nações Unidas para Agricultura e Alimentação) advertiu nesta quinta-feira que a mudança climática terá graves consequências na disponibilidade de água destinada à produção de alimentos e na produtividade dos cultivos durante as próximas décadas.\nEstas são algumas das conclusões do estudo &quot;Mudança climática, água e segurança alimentar&quot;, elaborado pela FAO, segundo informou a agência em comunicado divulgado hoje em Roma.\nO relatório indica que deve haver uma aceleração do ciclo hidrológico do planeta, já que a alta das temperaturas elevará a taxa de evaporação de água da terra e do mar.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927859-mudanca-climatica-reduzira-agua-disponivel-para-agricultura.shtml\">Leia mais</a> (09/06/2011 - 19h02)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927859-mudanca-climatica-reduzira-agua-disponivel-para-agricultura.shtml','2011-06-09 19:02:00'),(72,2,0,0,'Empresa propõe acabar com camelos para controlar efeito estufa','Uma empresa australiana apresentou uma proposta inovadora contra as emissões poluentes: matar toda a população de camelos do país, já que seus gases contribuem para o efeito estufa.\nCada camelo emite cerca de 45 kg de gás metano por ano, que equivale a uma tonelada de dióxido de carbono.\nEmbora seja considerada como uma missão impossível, erradicar a população de cerca de 1,2 milhão de camelos seria igual a tirar de circulação 300 mil carros que percorrem cerca de 20 mil km anuais.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927848-empresa-propoe-acabar-com-camelos-para-controlar-efeito-estufa.shtml\">Leia mais</a> (09/06/2011 - 18h44)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927848-empresa-propoe-acabar-com-camelos-para-controlar-efeito-estufa.shtml','2011-06-09 18:44:00'),(73,2,0,0,'China descobre novas cavernas de gelo; assista vídeo','Pesquisadores anunciaram ter descoberto o maior aglomerado de cavernas de gelo da China nas montanhas da província de Shanxi, no norte do país.\n<a href=\"http://www.bbc.co.uk/worldservice/emp/pop.shtml?l=pt&amp;t=video&amp;r=1&amp;p=/portuguese/meta/dps/2011/06/emp/110609_chinacavernasebc.emp.xml\">Veja vídeo</a>\nEm meio à natureza exuberante, com temperaturas exteriores beirando os 22ºC, os cinco conjuntos de cavernas se espalham por uma área de 35 quilômetros quadrados.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/927734-china-descobre-novas-cavernas-de-gelo-assista-video.shtml\">Leia mais</a> (09/06/2011 - 17h24)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/927734-china-descobre-novas-cavernas-de-gelo-assista-video.shtml','2011-06-09 17:24:00'),(74,2,0,0,'China inaugura centro internacional para proteção de pandas','Um centro internacional de pesquisa para a preservação do urso panda gigante e de outras espécies em extinção foi inaugurado na província de Sichuan, no sudoeste da China, informa nesta quinta-feira o jornal oficial &quot;China Daily&quot;.\nO Centro Internacional para a Conservação do Urso Panda Gigante é um projeto conjunto patrocinado pela base de pesquisas de pandas da cidade de Chengdu e pela fundação americana Global Cause.\nOs recursos, a tecnologia e as verbas locais e internacionais serão somadas para abordar ameaças contra a subsistência e desenvolvimento dos pandas e de outras espécies em extinção, disse o diretor da base de Chengdu, Zhang Zhihe.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/927673-china-inaugura-centro-internacional-para-protecao-de-pandas.shtml\">Leia mais</a> (09/06/2011 - 15h47)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/927673-china-inaugura-centro-internacional-para-protecao-de-pandas.shtml','2011-06-09 15:47:00'),(75,2,0,0,'Bolha construída por aranha mergulhadora funciona como \'guelra\'','A teia que aranhas mergulhadoras constroem e enchem de ar para formar uma bolha funciona como uma guelra de peixe, permitindo que os aracnídeos permaneçam embaixo da água por longos períodos de tempo, um estudo revelou.\n<table>\n<tr>\n<td>Stephan Hetz/BBC</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/ciencia/images/11160273.jpeg\" alt=\"Bolha de ar construída por aranha mergulhadora funciona como \'guelra\'\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Bolha de ar de aranha mergulhadora funciona como \'guelra\'</td>\n</tr>\n</table>\nA espécie, conhecida como Argyroneta aquatica, habita pequenos lagos e riachos de pouca correnteza na Europa e Ásia.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/927551-bolha-construida-por-aranha-mergulhadora-funciona-como-guelra.shtml\">Leia mais</a> (09/06/2011 - 13h27)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/927551-bolha-construida-por-aranha-mergulhadora-funciona-como-guelra.shtml','2011-06-09 13:27:00'),(76,2,0,0,'Governo prorroga decreto que adia punição a desmatador','A Presidência da República confirmou nesta quinta-feira que a presidente Dilma Rousseff assinou hoje a prorrogação por 180 dias do prazo para averbação de reserva legal, estendendo o prazo do decreto que vencia em 11 de junho.\nSegundo a Presidência, a definição da nova data atende à solicitação de lideranças partidárias no Senado. A Casa recebeu há poucas semanas o texto do Código Florestal aprovado pela Câmara.\nA prorrogação do texto impede multas e sanções aos produtores que não estejam cumprindo o Código Florestal em suas fazendas.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927605-governo-prorroga-decreto-que-adia-punicao-a-desmatador.shtml\">Leia mais</a> (09/06/2011 - 13h12)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927605-governo-prorroga-decreto-que-adia-punicao-a-desmatador.shtml','2011-06-09 13:12:00'),(77,2,0,0,'Amor aos animais levou empresária a cozinhar para cães','<table>\n<tr>\n<td>Divulgação</td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1167606/cao-gourmet\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/11146190.jpeg\" alt=\"Volume reúne receitas culinárias criadas especialmente para cães\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1167606/cao-gourmet\">Volume reúne receitas culinárias criadas especialmente para cães</a> </td>\n</tr>\n</table>\nEspecialista em culinária saudável e apaixonada por cachorros, a empresária Myrian Abicair, dona de um spa, compilou sua experiência de cozinhar para seus animais no livro <a href=\"http://livraria.folha.com.br/catalogo/1167606/\"><b>&quot;Cão Gourmet: Receitas Caseiras e Saudáveis para seu Cão&quot;</b></a> (Cook Lovers, 2011), escrito com a supervisão de veterinários.\nDe acordo com a mestre cuca, a ascendência árabe a aproximou dos vegetais. Quando começou a cultivar verduras e legumes orgânicos para vender, passou a utilizar sobras de talos e folhagens para complementar a alimentação dos 20 cães que criava no momento.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/927076-amor-aos-animais-levou-empresaria-a-cozinhar-para-caes.shtml\">Leia mais</a> (09/06/2011 - 13h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/927076-amor-aos-animais-levou-empresaria-a-cozinhar-para-caes.shtml','2011-06-09 13:00:00'),(78,2,0,0,'PV pede explicações à ministra sobre redução de parques no Pará','O PV pediu na noite desta quarta-feira (8) explicações à ministra Izabella Teixeira (Meio Ambiente) sobre o plano do governo de reduzir sete unidades de conservação no Pará para permitir a construção das hidrelétricas do complexo Tapajós.\nO requerimento foi protocolado na Câmara pela deputada verde Rosane Ferreira (PR), após a intenção do governo ter sido detalhada em reportagem da <b>Folha</b>.\nDocumentos internos do ICMBio (Instituto Chico Mendes para a Conservação da Biodiversidade) mostram que a redução de dois parques nacionais, quatro florestas nacionais e uma área de proteção ambiental no mosaico da BR-163/Terra do Meio, o maior conjunto de áreas protegidas do país, foi pedida em janeiro pela Eletronorte sem estudos técnicos prévios. Os chefes de todas as sete unidades se opõem ao projeto.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927554-pv-pede-explicacoes-a-ministra-sobre-reducao-de-parques-no-para.shtml\">Leia mais</a> (09/06/2011 - 11h31)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927554-pv-pede-explicacoes-a-ministra-sobre-reducao-de-parques-no-para.shtml','2011-06-09 11:31:00');
/*!40000 ALTER TABLE `feed_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` tinyint(11) NOT NULL AUTO_INCREMENT,
  `feedback_mesg` text NOT NULL,
  `feedback_status` tinyint(3) NOT NULL,
  `feedback_dateadd` datetime DEFAULT NULL,
  `feedback_datemodify` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback_person`
--

DROP TABLE IF EXISTS `feedback_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback_person` (
  `id` tinyint(11) NOT NULL AUTO_INCREMENT,
  `feedback_id` tinyint(11) NOT NULL,
  `person_email` varchar(30) NOT NULL,
  `person_date` datetime DEFAULT NULL,
  `person_ip` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback_person`
--

LOCK TABLES `feedback_person` WRITE;
/*!40000 ALTER TABLE `feedback_person` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_title` varchar(200) NOT NULL,
  `form_description` text,
  `form_active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
INSERT INTO `form` VALUES (1,'Default Form','Default form, for report entry',1);
/*!40000 ALTER TABLE `form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_field`
--

DROP TABLE IF EXISTS `form_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL DEFAULT '0',
  `field_name` varchar(200) DEFAULT NULL,
  `field_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - TEXTFIELD, 2 - TEXTAREA (FREETEXT), 3 - DATE, 4 - PASSWORD, 5 - RADIO, 6 - CHECKBOX',
  `field_required` tinyint(4) DEFAULT '0',
  `field_options` text,
  `field_position` tinyint(4) NOT NULL DEFAULT '0',
  `field_default` varchar(200) DEFAULT NULL,
  `field_maxlength` int(11) NOT NULL DEFAULT '0',
  `field_width` smallint(6) NOT NULL DEFAULT '0',
  `field_height` tinyint(4) DEFAULT '5',
  `field_isdate` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_form_id` (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_field`
--

LOCK TABLES `form_field` WRITE;
/*!40000 ALTER TABLE `form_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_response`
--

DROP TABLE IF EXISTS `form_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_response` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_field_id` int(11) NOT NULL,
  `incident_id` bigint(20) NOT NULL,
  `form_response` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_form_field_id` (`form_field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_response`
--

LOCK TABLES `form_response` WRITE;
/*!40000 ALTER TABLE `form_response` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idp`
--

DROP TABLE IF EXISTS `idp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `idp` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` bigint(20) NOT NULL,
  `verified_id` bigint(20) DEFAULT NULL,
  `idp_idnumber` varchar(100) DEFAULT NULL,
  `idp_orig_idnumber` varchar(100) DEFAULT NULL,
  `idp_fname` varchar(50) DEFAULT NULL,
  `idp_lname` varchar(50) DEFAULT NULL,
  `idp_email` varchar(100) DEFAULT NULL,
  `idp_phone` varchar(50) DEFAULT NULL,
  `current_location_id` bigint(20) DEFAULT NULL,
  `displacedfrom_location_id` bigint(20) DEFAULT NULL,
  `movedto_location_id` bigint(20) DEFAULT NULL,
  `idp_move_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idp`
--

LOCK TABLES `idp` WRITE;
/*!40000 ALTER TABLE `idp` DISABLE KEYS */;
/*!40000 ALTER TABLE `idp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident`
--

DROP TABLE IF EXISTS `incident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL DEFAULT '1',
  `locale` varchar(10) NOT NULL DEFAULT 'en_US',
  `user_id` bigint(20) DEFAULT NULL,
  `incident_title` varchar(255) DEFAULT NULL,
  `incident_description` longtext,
  `incident_date` datetime DEFAULT NULL,
  `incident_mode` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - WEB, 2 - SMS, 3 - EMAIL, 4 - TWITTER',
  `incident_active` tinyint(4) NOT NULL DEFAULT '0',
  `incident_verified` tinyint(4) NOT NULL DEFAULT '0',
  `incident_source` varchar(5) DEFAULT NULL,
  `incident_information` varchar(5) DEFAULT NULL,
  `incident_rating` varchar(15) NOT NULL DEFAULT '0',
  `incident_dateadd` datetime DEFAULT NULL,
  `incident_dateadd_gmt` datetime DEFAULT NULL,
  `incident_datemodify` datetime DEFAULT NULL,
  `incident_alert_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - Not Tagged for Sending, 1 - Tagged for Sending, 2 - Alerts Have Been Sent',
  PRIMARY KEY (`id`),
  KEY `incident_active` (`incident_active`),
  KEY `incident_date` (`incident_date`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident`
--

LOCK TABLES `incident` WRITE;
/*!40000 ALTER TABLE `incident` DISABLE KEYS */;
INSERT INTO `incident` VALUES (18,0,'en_US',0,'Rotina do Fabs','Lugares em que o Fabs vai durante uma semana','2011-06-13 22:10:00',1,1,1,NULL,NULL,'0','2011-06-13 22:13:38',NULL,NULL,0);
/*!40000 ALTER TABLE `incident` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_category`
--

DROP TABLE IF EXISTS `incident_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `incident_id` bigint(20) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `incident_category_ids` (`incident_id`,`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_category`
--

LOCK TABLES `incident_category` WRITE;
/*!40000 ALTER TABLE `incident_category` DISABLE KEYS */;
INSERT INTO `incident_category` VALUES (6,5,1),(7,6,1),(3,3,1),(4,4,1),(5,4,3),(8,6,3),(9,7,1),(10,8,1),(11,8,3),(12,9,1),(13,10,2),(14,11,3),(15,12,1),(16,13,1),(17,14,1),(18,14,3),(19,15,1),(20,16,1),(21,17,3),(22,18,1);
/*!40000 ALTER TABLE `incident_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_lang`
--

DROP TABLE IF EXISTS `incident_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_lang` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` bigint(20) NOT NULL,
  `locale` varchar(10) DEFAULT NULL,
  `incident_title` varchar(255) DEFAULT NULL,
  `incident_description` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_lang`
--

LOCK TABLES `incident_lang` WRITE;
/*!40000 ALTER TABLE `incident_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `incident_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_location`
--

DROP TABLE IF EXISTS `incident_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_location` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_location`
--

LOCK TABLES `incident_location` WRITE;
/*!40000 ALTER TABLE `incident_location` DISABLE KEYS */;
INSERT INTO `incident_location` VALUES (19,17,32),(20,17,33),(21,17,34),(22,17,35),(23,17,36),(24,18,37),(25,18,38),(26,18,39),(27,18,40),(28,18,41),(29,18,42),(30,18,43),(31,18,44),(32,18,45),(33,18,46);
/*!40000 ALTER TABLE `incident_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_person`
--

DROP TABLE IF EXISTS `incident_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_person` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` bigint(20) DEFAULT NULL,
  `location_id` bigint(20) DEFAULT NULL,
  `person_first` varchar(200) DEFAULT NULL,
  `person_last` varchar(200) DEFAULT NULL,
  `person_email` varchar(120) DEFAULT NULL,
  `person_phone` varchar(60) DEFAULT NULL,
  `person_ip` varchar(50) DEFAULT NULL,
  `person_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_person`
--

LOCK TABLES `incident_person` WRITE;
/*!40000 ALTER TABLE `incident_person` DISABLE KEYS */;
INSERT INTO `incident_person` VALUES (4,5,5,'','','',NULL,NULL,'2011-05-23 13:35:02'),(2,3,3,'','','',NULL,NULL,'2011-05-23 11:19:30'),(3,4,4,'','','',NULL,NULL,'2011-05-23 13:29:32'),(5,6,6,'Fabricio','Nascimento','fabriciosn@gmail.com',NULL,NULL,'2011-05-23 13:37:08'),(6,7,7,'','','',NULL,NULL,'2011-05-23 13:37:59'),(7,8,8,'','','',NULL,NULL,'2011-05-23 13:38:30'),(8,9,9,'','','',NULL,NULL,'2011-05-23 13:39:00'),(9,10,10,'','','',NULL,NULL,'2011-05-25 01:37:02'),(10,11,11,'','','',NULL,NULL,'2011-05-25 01:40:12'),(11,12,12,'','','',NULL,NULL,'2011-05-25 01:46:25'),(12,13,13,'','','',NULL,NULL,'2011-05-26 23:12:15');
/*!40000 ALTER TABLE `incident_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layer`
--

DROP TABLE IF EXISTS `layer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `layer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `layer_name` varchar(255) DEFAULT NULL,
  `layer_url` varchar(255) DEFAULT NULL,
  `layer_file` varchar(100) DEFAULT NULL,
  `layer_color` varchar(20) DEFAULT NULL,
  `layer_visible` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layer`
--

LOCK TABLES `layer` WRITE;
/*!40000 ALTER TABLE `layer` DISABLE KEYS */;
/*!40000 ALTER TABLE `layer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `level`
--

DROP TABLE IF EXISTS `level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `level` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `level_title` varchar(200) DEFAULT NULL,
  `level_description` varchar(200) DEFAULT NULL,
  `level_weight` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `level`
--

LOCK TABLES `level` WRITE;
/*!40000 ALTER TABLE `level` DISABLE KEYS */;
INSERT INTO `level` VALUES (1,'SPAM + Delete','SPAM + Delete',-2),(2,'SPAM','SPAM',-1),(3,'Untrusted','Untrusted',0),(4,'Trusted','Trusted',1),(5,'Trusted + Verify','Trusted + Verify',2);
/*!40000 ALTER TABLE `level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_name` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `latitude` double NOT NULL DEFAULT '0',
  `longitude` double NOT NULL DEFAULT '0',
  `location_visible` tinyint(4) NOT NULL DEFAULT '1',
  `location_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (37,'Relógio',NULL,-23.558283,-46.733909,1,'2011-06-13 22:13:38'),(38,'Eldorado',NULL,-23.559149,-46.723781,1,'2011-06-13 22:13:38'),(39,'Paulista',NULL,-23.57268,-46.697087,1,'2011-06-13 22:13:38'),(40,'Tailorbirds',NULL,-23.560801,-46.657348,1,'2011-06-13 22:13:38'),(41,'CEATS',NULL,-23.57331,-46.749358,1,'2011-06-13 22:13:38'),(42,'Rafael',NULL,-23.56914,-46.743264,1,'2011-06-13 22:13:38'),(43,'CIETEC',NULL,-23.569927,-46.741977,1,'2011-06-13 22:13:38'),(44,'Mercado',NULL,-23.560801,-46.738801,1,'2011-06-13 22:13:38'),(45,'Point 8',NULL,-23.557103,-46.747642,1,'2011-06-13 22:13:38'),(46,'Point 9',NULL,-23.564499,-46.70198,1,'2011-06-13 22:13:38');
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` bigint(20) DEFAULT NULL,
  `incident_id` bigint(20) DEFAULT NULL,
  `message_id` bigint(20) DEFAULT NULL,
  `media_type` tinyint(4) DEFAULT NULL COMMENT '1 - IMAGES, 2 - VIDEO, 3 - AUDIO, 4 - NEWS, 5 - PODCAST',
  `media_title` varchar(255) DEFAULT NULL,
  `media_description` longtext,
  `media_link` varchar(255) DEFAULT NULL,
  `media_medium` varchar(255) DEFAULT NULL,
  `media_thumb` varchar(255) DEFAULT NULL,
  `media_date` datetime DEFAULT NULL,
  `media_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,4,4,NULL,2,NULL,NULL,'http://www.youtube.com/watch?v=QW0i1U4u0KE&feature=aso',NULL,NULL,'2011-05-23 13:29:30',1),(2,4,4,NULL,1,NULL,NULL,'4_1_1306168170.png','4_1_1306168170_m.png','4_1_1306168170_t.png','2011-05-23 13:29:32',1),(3,11,11,NULL,4,NULL,NULL,'http://www.padboulevard.com.br/',NULL,NULL,'2011-05-25 01:40:12',1),(4,12,12,NULL,1,NULL,NULL,'12_1_1306287984.jpg','12_1_1306287984_m.jpg','12_1_1306287984_t.jpg','2011-05-25 01:46:25',1),(5,13,13,NULL,1,NULL,NULL,'13_1_1306451534.jpg','13_1_1306451534_m.jpg','13_1_1306451534_t.jpg','2011-05-26 23:12:15',1);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) DEFAULT '0',
  `incident_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `reporter_id` bigint(20) DEFAULT NULL,
  `service_messageid` varchar(100) DEFAULT NULL,
  `message_from` varchar(100) DEFAULT NULL,
  `message_to` varchar(100) DEFAULT NULL,
  `message` text,
  `message_detail` text,
  `message_type` tinyint(4) DEFAULT '1' COMMENT '1 - INBOX, 2 - OUTBOX (From Admin)',
  `message_date` datetime DEFAULT NULL,
  `message_level` tinyint(4) DEFAULT '0' COMMENT '0 - UNREAD, 1 - READ, 99 - SPAM',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization`
--

DROP TABLE IF EXISTS `organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organization` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `organization_name` varchar(255) DEFAULT NULL,
  `organization_description` longtext,
  `organization_website` varchar(255) DEFAULT NULL,
  `organization_email` varchar(120) DEFAULT NULL,
  `organization_phone1` varchar(50) DEFAULT NULL,
  `organization_phone2` varchar(50) DEFAULT NULL,
  `organization_address` varchar(255) DEFAULT NULL,
  `organization_country` varchar(100) DEFAULT NULL,
  `organization_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization`
--

LOCK TABLES `organization` WRITE;
/*!40000 ALTER TABLE `organization` DISABLE KEYS */;
/*!40000 ALTER TABLE `organization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization_incident`
--

DROP TABLE IF EXISTS `organization_incident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organization_incident` (
  `organization_id` bigint(20) DEFAULT NULL,
  `incident_id` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization_incident`
--

LOCK TABLES `organization_incident` WRITE;
/*!40000 ALTER TABLE `organization_incident` DISABLE KEYS */;
/*!40000 ALTER TABLE `organization_incident` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) NOT NULL,
  `page_description` longtext,
  `page_tab` varchar(100) NOT NULL,
  `page_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pending_users`
--

DROP TABLE IF EXISTS `pending_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL,
  `email` varchar(127) NOT NULL,
  `username` varchar(31) NOT NULL DEFAULT '',
  `password` char(50) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pending_users`
--

LOCK TABLES `pending_users` WRITE;
/*!40000 ALTER TABLE `pending_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `pending_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugin`
--

DROP TABLE IF EXISTS `plugin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(100) NOT NULL,
  `plugin_url` varchar(250) DEFAULT NULL,
  `plugin_description` text,
  `plugin_priority` tinyint(4) DEFAULT '0',
  `plugin_active` tinyint(4) DEFAULT '0',
  `plugin_installed` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `plugin_name` (`plugin_name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plugin`
--

LOCK TABLES `plugin` WRITE;
/*!40000 ALTER TABLE `plugin` DISABLE KEYS */;
INSERT INTO `plugin` VALUES (1,'clickatell',NULL,NULL,0,0,0),(2,'frontlinesms',NULL,NULL,0,0,0),(3,'smssync',NULL,NULL,0,0,0);
/*!40000 ALTER TABLE `plugin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rating`
--

DROP TABLE IF EXISTS `rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rating` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` bigint(20) DEFAULT NULL,
  `comment_id` bigint(20) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT '0',
  `rating_ip` varchar(100) DEFAULT NULL,
  `rating_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating`
--

LOCK TABLES `rating` WRITE;
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
INSERT INTO `rating` VALUES (1,12,NULL,1,'189.120.225.202','2011-05-25 01:49:10'),(2,9,NULL,1,'187.38.39.194','2011-05-25 15:12:24');
/*!40000 ALTER TABLE `rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporter`
--

DROP TABLE IF EXISTS `reporter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporter` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` bigint(20) DEFAULT NULL,
  `location_id` bigint(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL,
  `service_userid` varchar(255) DEFAULT NULL,
  `service_account` varchar(255) DEFAULT NULL,
  `reporter_first` varchar(200) DEFAULT NULL,
  `reporter_last` varchar(200) DEFAULT NULL,
  `reporter_email` varchar(120) DEFAULT NULL,
  `reporter_phone` varchar(60) DEFAULT NULL,
  `reporter_ip` varchar(50) DEFAULT NULL,
  `reporter_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporter`
--

LOCK TABLES `reporter` WRITE;
/*!40000 ALTER TABLE `reporter` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `reports_view` tinyint(4) NOT NULL DEFAULT '0',
  `reports_edit` tinyint(4) NOT NULL DEFAULT '0',
  `reports_evaluation` tinyint(4) NOT NULL DEFAULT '0',
  `reports_comments` tinyint(4) NOT NULL DEFAULT '0',
  `reports_download` tinyint(4) NOT NULL DEFAULT '0',
  `reports_upload` tinyint(4) NOT NULL DEFAULT '0',
  `messages` tinyint(4) NOT NULL DEFAULT '0',
  `messages_reporters` tinyint(4) NOT NULL DEFAULT '0',
  `stats` tinyint(4) NOT NULL DEFAULT '0',
  `settings` tinyint(4) NOT NULL DEFAULT '0',
  `manage` tinyint(4) NOT NULL DEFAULT '0',
  `users` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'login','Login privileges, granted after account confirmation',0,0,0,0,0,0,0,0,0,0,0,0),(2,'admin','Administrative user, has access to almost everything.',1,1,1,1,1,1,1,1,1,1,1,1),(3,'superadmin','Super administrative user, has access to everything.',1,1,1,1,1,1,1,1,1,1,1,1);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_users`
--

DROP TABLE IF EXISTS `roles_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_users` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`),
  CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_users`
--

LOCK TABLES `roles_users` WRITE;
/*!40000 ALTER TABLE `roles_users` DISABLE KEYS */;
INSERT INTO `roles_users` VALUES (1,1),(1,2),(1,3);
/*!40000 ALTER TABLE `roles_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduler`
--

DROP TABLE IF EXISTS `scheduler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scheduler` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scheduler_name` varchar(100) NOT NULL,
  `scheduler_last` int(10) unsigned NOT NULL DEFAULT '0',
  `scheduler_weekday` smallint(6) NOT NULL DEFAULT '-1',
  `scheduler_day` smallint(6) NOT NULL DEFAULT '-1',
  `scheduler_hour` smallint(6) NOT NULL DEFAULT '-1',
  `scheduler_minute` smallint(6) NOT NULL,
  `scheduler_controller` varchar(100) NOT NULL,
  `scheduler_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduler`
--

LOCK TABLES `scheduler` WRITE;
/*!40000 ALTER TABLE `scheduler` DISABLE KEYS */;
INSERT INTO `scheduler` VALUES (1,'Feeds',1308013216,-1,-1,-1,0,'s_feeds',1),(2,'Alerts',1308015869,-1,-1,-1,-1,'s_alerts',1),(3,'Email',1306765753,-1,-1,-1,0,'s_email',1),(4,'Twitter',1306765753,-1,-1,-1,0,'s_twitter',1),(5,'Sharing',1306765753,-1,-1,-1,0,'s_sharing',1);
/*!40000 ALTER TABLE `scheduler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduler_log`
--

DROP TABLE IF EXISTS `scheduler_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scheduler_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `scheduler_id` int(11) NOT NULL,
  `scheduler_name` varchar(100) NOT NULL,
  `scheduler_status` varchar(20) DEFAULT NULL,
  `scheduler_date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=335 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduler_log`
--

LOCK TABLES `scheduler_log` WRITE;
/*!40000 ALTER TABLE `scheduler_log` DISABLE KEYS */;
INSERT INTO `scheduler_log` VALUES (1,1,'Feeds','200',1305745652),(2,2,'Alerts','200',1305745652),(3,1,'Feeds','200',1305753201),(4,2,'Alerts','200',1305753201),(5,1,'Feeds','200',1306154418),(6,2,'Alerts','200',1306154418),(7,2,'Alerts','200',1306154547),(8,2,'Alerts','200',1306155127),(9,2,'Alerts','200',1306155265),(10,2,'Alerts','200',1306155318),(11,2,'Alerts','200',1306155540),(12,1,'Feeds','200',1306155612),(13,2,'Alerts','200',1306155612),(14,2,'Alerts','200',1306155692),(15,2,'Alerts','200',1306155722),(16,2,'Alerts','200',1306155798),(17,2,'Alerts','200',1306155910),(18,2,'Alerts','200',1306156147),(19,2,'Alerts','200',1306156277),(20,2,'Alerts','200',1306156416),(21,2,'Alerts','200',1306156463),(22,2,'Alerts','200',1306156501),(23,2,'Alerts','200',1306156621),(24,2,'Alerts','200',1306156761),(25,2,'Alerts','200',1306156832),(26,2,'Alerts','200',1306156990),(27,2,'Alerts','200',1306157044),(28,2,'Alerts','200',1306157119),(29,2,'Alerts','200',1306157500),(30,2,'Alerts','200',1306157528),(31,2,'Alerts','200',1306157795),(32,2,'Alerts','200',1306157852),(33,2,'Alerts','200',1306157894),(34,2,'Alerts','200',1306157946),(35,2,'Alerts','200',1306158014),(36,2,'Alerts','200',1306158085),(37,2,'Alerts','200',1306158154),(38,2,'Alerts','200',1306158181),(39,2,'Alerts','200',1306158306),(40,2,'Alerts','200',1306158413),(41,2,'Alerts','200',1306158421),(42,2,'Alerts','200',1306158487),(43,2,'Alerts','200',1306158540),(44,2,'Alerts','200',1306158542),(45,2,'Alerts','200',1306158639),(46,2,'Alerts','200',1306158778),(47,2,'Alerts','200',1306158781),(48,2,'Alerts','200',1306158869),(49,2,'Alerts','200',1306158953),(50,2,'Alerts','200',1306159016),(51,2,'Alerts','200',1306159024),(52,2,'Alerts','200',1306159160),(53,1,'Feeds','200',1306159292),(54,2,'Alerts','200',1306159292),(55,2,'Alerts','200',1306159334),(56,2,'Alerts','200',1306159445),(57,2,'Alerts','200',1306159527),(58,2,'Alerts','200',1306159667),(59,2,'Alerts','200',1306159695),(60,2,'Alerts','200',1306159755),(61,2,'Alerts','200',1306159829),(62,2,'Alerts','200',1306159872),(63,2,'Alerts','200',1306159924),(64,2,'Alerts','200',1306159984),(65,2,'Alerts','200',1306160087),(66,2,'Alerts','200',1306160335),(67,2,'Alerts','200',1306160345),(68,2,'Alerts','200',1306160400),(69,2,'Alerts','200',1306160402),(70,2,'Alerts','200',1306161732),(71,2,'Alerts','200',1306161805),(72,2,'Alerts','200',1306161870),(73,2,'Alerts','200',1306161918),(74,2,'Alerts','200',1306161963),(75,2,'Alerts','200',1306162024),(76,2,'Alerts','200',1306162082),(77,2,'Alerts','200',1306162154),(78,2,'Alerts','200',1306162201),(79,2,'Alerts','200',1306162318),(80,2,'Alerts','200',1306162483),(81,2,'Alerts','200',1306162501),(82,2,'Alerts','200',1306162583),(83,2,'Alerts','200',1306162794),(84,1,'Feeds','200',1306162825),(85,2,'Alerts','200',1306162825),(86,2,'Alerts','200',1306162930),(87,2,'Alerts','200',1306164178),(88,1,'Feeds','200',1306168056),(89,2,'Alerts','200',1306168056),(90,2,'Alerts','200',1306168173),(91,2,'Alerts','200',1306168355),(92,2,'Alerts','200',1306168391),(93,2,'Alerts','200',1306168452),(94,2,'Alerts','200',1306168502),(95,2,'Alerts','200',1306168577),(96,2,'Alerts','200',1306168629),(97,2,'Alerts','200',1306168680),(98,2,'Alerts','200',1306168683),(99,2,'Alerts','200',1306168741),(100,2,'Alerts','200',1306168815),(101,2,'Alerts','200',1306169197),(102,2,'Alerts','200',1306169242),(103,2,'Alerts','200',1306169343),(104,2,'Alerts','200',1306169408),(105,2,'Alerts','200',1306169488),(106,2,'Alerts','200',1306169539),(107,2,'Alerts','200',1306169758),(108,2,'Alerts','200',1306169808),(109,2,'Alerts','200',1306169886),(110,2,'Alerts','200',1306169981),(111,1,'Feeds','200',1306170004),(112,2,'Alerts','200',1306170004),(113,1,'Feeds','200',1306170005),(114,2,'Alerts','200',1306170005),(115,2,'Alerts','200',1306170083),(116,2,'Alerts','200',1306170163),(117,2,'Alerts','200',1306170205),(118,2,'Alerts','200',1306170252),(119,2,'Alerts','200',1306170363),(120,2,'Alerts','200',1306170427),(121,2,'Alerts','200',1306170529),(122,2,'Alerts','200',1306170547),(123,2,'Alerts','200',1306170630),(124,2,'Alerts','200',1306170677),(125,2,'Alerts','200',1306170733),(126,2,'Alerts','200',1306170781),(127,2,'Alerts','200',1306171147),(128,2,'Alerts','200',1306171350),(129,2,'Alerts','200',1306171576),(130,2,'Alerts','200',1306171693),(131,2,'Alerts','200',1306171765),(132,2,'Alerts','200',1306171813),(133,2,'Alerts','200',1306171936),(134,2,'Alerts','200',1306172057),(135,2,'Alerts','200',1306172114),(136,2,'Alerts','200',1306172239),(137,2,'Alerts','200',1306172297),(138,2,'Alerts','200',1306172535),(139,2,'Alerts','200',1306172595),(140,2,'Alerts','200',1306172642),(141,2,'Alerts','200',1306172726),(142,2,'Alerts','200',1306172774),(143,2,'Alerts','200',1306173278),(144,2,'Alerts','200',1306173307),(145,2,'Alerts','200',1306173494),(146,2,'Alerts','200',1306173541),(147,1,'Feeds','200',1306173748),(148,2,'Alerts','200',1306173748),(149,1,'Feeds','200',1306177578),(150,2,'Alerts','200',1306177578),(151,1,'Feeds','200',1306266279),(152,2,'Alerts','200',1306266279),(153,2,'Alerts','200',1306266408),(154,2,'Alerts','200',1306266766),(155,3,'Email','200',1306266766),(156,4,'Twitter','200',1306266766),(157,5,'Sharing','200',1306266766),(158,2,'Alerts','200',1306266933),(159,2,'Alerts','200',1306267059),(160,2,'Alerts','200',1306267093),(161,2,'Alerts','200',1306267145),(162,1,'Feeds','200',1306267288),(163,2,'Alerts','200',1306267288),(164,1,'Feeds','200',1306267288),(165,2,'Alerts','200',1306267288),(166,3,'Email','200',1306267288),(167,3,'Email','200',1306267288),(168,4,'Twitter','200',1306267288),(169,5,'Sharing','200',1306267288),(170,4,'Twitter','200',1306267288),(171,5,'Sharing','200',1306267288),(172,2,'Alerts','200',1306267747),(173,2,'Alerts','200',1306267832),(174,2,'Alerts','200',1306267939),(175,2,'Alerts','200',1306268130),(176,2,'Alerts','200',1306268184),(177,2,'Alerts','200',1306268279),(178,2,'Alerts','200',1306268306),(179,2,'Alerts','200',1306268355),(180,2,'Alerts','200',1306268462),(181,2,'Alerts','200',1306268695),(182,2,'Alerts','200',1306268710),(183,2,'Alerts','200',1306268761),(184,2,'Alerts','200',1306268861),(185,2,'Alerts','200',1306268890),(186,2,'Alerts','200',1306270373),(187,2,'Alerts','200',1306270388),(188,2,'Alerts','200',1306270504),(189,1,'Feeds','200',1306277861),(190,2,'Alerts','200',1306277861),(191,3,'Email','200',1306277861),(192,4,'Twitter','200',1306277861),(193,5,'Sharing','200',1306277861),(194,1,'Feeds','200',1306280902),(195,2,'Alerts','200',1306280902),(196,3,'Email','200',1306280902),(197,4,'Twitter','200',1306280902),(198,5,'Sharing','200',1306280902),(199,1,'Feeds','200',1306281936),(200,2,'Alerts','200',1306281936),(201,3,'Email','200',1306281936),(202,4,'Twitter','200',1306281936),(203,5,'Sharing','200',1306281936),(204,1,'Feeds','200',1306287065),(205,2,'Alerts','200',1306287065),(206,3,'Email','200',1306287065),(207,4,'Twitter','200',1306287065),(208,5,'Sharing','200',1306287065),(209,2,'Alerts','200',1306287288),(210,2,'Alerts','200',1306287424),(211,2,'Alerts','200',1306287613),(212,2,'Alerts','200',1306287865),(213,2,'Alerts','200',1306287987),(214,2,'Alerts','200',1306288090),(215,2,'Alerts','200',1306288141),(216,2,'Alerts','200',1306288203),(217,1,'Feeds','200',1306332492),(218,2,'Alerts','200',1306332492),(219,3,'Email','200',1306332492),(220,4,'Twitter','200',1306332492),(221,5,'Sharing','200',1306332492),(222,1,'Feeds','200',1306332494),(223,2,'Alerts','200',1306332494),(224,3,'Email','200',1306332494),(225,4,'Twitter','200',1306332494),(226,5,'Sharing','200',1306332494),(227,2,'Alerts','200',1306332607),(228,2,'Alerts','200',1306332783),(229,2,'Alerts','200',1306332884),(230,2,'Alerts','200',1306332925),(231,2,'Alerts','200',1306333027),(232,2,'Alerts','200',1306333086),(233,2,'Alerts','200',1306333141),(234,2,'Alerts','200',1306333216),(235,2,'Alerts','200',1306333270),(236,2,'Alerts','200',1306333382),(237,2,'Alerts','200',1306333448),(238,2,'Alerts','200',1306333699),(239,2,'Alerts','200',1306333778),(240,2,'Alerts','200',1306333859),(241,2,'Alerts','200',1306334033),(242,2,'Alerts','200',1306335204),(243,2,'Alerts','200',1306335326),(244,2,'Alerts','200',1306335377),(245,2,'Alerts','200',1306335561),(246,1,'Feeds','200',1306335689),(247,2,'Alerts','200',1306335689),(248,3,'Email','200',1306335689),(249,4,'Twitter','200',1306335689),(250,5,'Sharing','200',1306335689),(251,1,'Feeds','200',1306335728),(252,2,'Alerts','200',1306335728),(253,3,'Email','200',1306335728),(254,4,'Twitter','200',1306335728),(255,5,'Sharing','200',1306335728),(256,2,'Alerts','200',1306335837),(257,2,'Alerts','200',1306336067),(258,2,'Alerts','200',1306336216),(259,2,'Alerts','200',1306336263),(260,2,'Alerts','200',1306336321),(261,2,'Alerts','200',1306336386),(262,2,'Alerts','200',1306336448),(263,2,'Alerts','200',1306336927),(264,2,'Alerts','200',1306337107),(265,1,'Feeds','200',1306451474),(266,1,'Feeds','200',1306451474),(267,2,'Alerts','200',1306451474),(268,2,'Alerts','200',1306451474),(269,3,'Email','200',1306451474),(270,3,'Email','200',1306451474),(271,4,'Twitter','200',1306451474),(272,5,'Sharing','200',1306451474),(273,4,'Twitter','200',1306451474),(274,5,'Sharing','200',1306451474),(275,2,'Alerts','200',1306451536),(276,2,'Alerts','200',1306451616),(277,2,'Alerts','200',1306451669),(278,2,'Alerts','200',1306451704),(279,1,'Feeds','200',1306541516),(280,2,'Alerts','200',1306541516),(281,3,'Email','200',1306541516),(282,4,'Twitter','200',1306541516),(283,5,'Sharing','200',1306541516),(284,1,'Feeds','200',1306725343),(285,2,'Alerts','200',1306725343),(286,3,'Email','200',1306725343),(287,4,'Twitter','200',1306725343),(288,5,'Sharing','200',1306725343),(289,2,'Alerts','200',1306725381),(290,1,'Feeds','200',1306763792),(291,2,'Alerts','200',1306763792),(292,3,'Email','200',1306763792),(293,4,'Twitter','200',1306763792),(294,5,'Sharing','200',1306763792),(295,1,'Feeds','200',1306765738),(296,2,'Alerts','200',1306765738),(297,3,'Email','200',1306765738),(298,4,'Twitter','200',1306765738),(299,5,'Sharing','200',1306765738),(300,2,'Alerts','200',1306765746),(301,1,'Feeds','200',1306765753),(302,2,'Alerts','200',1306765753),(303,3,'Email','200',1306765753),(304,4,'Twitter','200',1306765753),(305,5,'Sharing','200',1306765753),(306,2,'Alerts','200',1306765821),(307,1,'Feeds','200',1308012040),(308,2,'Alerts','200',1308012040),(309,2,'Alerts','200',1308012118),(310,2,'Alerts','200',1308012121),(311,2,'Alerts','200',1308012236),(312,2,'Alerts','200',1308012435),(313,2,'Alerts','200',1308012493),(314,2,'Alerts','200',1308012660),(315,2,'Alerts','200',1308013067),(316,2,'Alerts','200',1308013105),(317,2,'Alerts','200',1308013173),(318,1,'Feeds','200',1308013216),(319,2,'Alerts','200',1308013216),(320,2,'Alerts','200',1308013263),(321,2,'Alerts','200',1308013360),(322,2,'Alerts','200',1308013777),(323,2,'Alerts','200',1308013833),(324,2,'Alerts','200',1308014020),(325,2,'Alerts','200',1308014107),(326,2,'Alerts','200',1308014246),(327,2,'Alerts','200',1308014516),(328,2,'Alerts','200',1308014554),(329,2,'Alerts','200',1308014614),(330,2,'Alerts','200',1308014772),(331,2,'Alerts','200',1308014824),(332,2,'Alerts','200',1308014896),(333,2,'Alerts','200',1308015267),(334,2,'Alerts','200',1308015869);
/*!40000 ALTER TABLE `scheduler_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_name` varchar(100) DEFAULT NULL,
  `service_description` varchar(255) DEFAULT NULL,
  `service_url` varchar(255) DEFAULT NULL,
  `service_api` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (1,'SMS','Text messages from phones',NULL,NULL),(2,'Email','Text messages from phones',NULL,NULL),(3,'Twitter','Tweets tweets tweets','http://twitter.com',NULL),(4,'Laconica','Tweets tweets tweets',NULL,NULL);
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `session_id` varchar(40) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) DEFAULT NULL,
  `site_tagline` varchar(255) DEFAULT NULL,
  `site_email` varchar(120) DEFAULT NULL,
  `site_key` varchar(100) DEFAULT NULL,
  `site_language` varchar(10) NOT NULL DEFAULT 'en_US',
  `site_style` varchar(50) NOT NULL DEFAULT 'default',
  `site_timezone` varchar(80) DEFAULT NULL,
  `site_contact_page` tinyint(4) NOT NULL DEFAULT '1',
  `site_help_page` tinyint(4) NOT NULL DEFAULT '1',
  `site_message` text NOT NULL,
  `site_copyright_statement` text,
  `allow_reports` tinyint(4) NOT NULL DEFAULT '1',
  `allow_comments` tinyint(4) NOT NULL DEFAULT '1',
  `allow_feed` tinyint(4) NOT NULL DEFAULT '1',
  `allow_stat_sharing` tinyint(4) NOT NULL DEFAULT '1',
  `allow_clustering` tinyint(4) NOT NULL DEFAULT '0',
  `cache_pages` tinyint(4) NOT NULL DEFAULT '0',
  `cache_pages_lifetime` int(4) NOT NULL DEFAULT '1800',
  `default_map` varchar(100) NOT NULL DEFAULT 'google_normal',
  `default_map_all` varchar(20) NOT NULL DEFAULT 'CC0000',
  `api_google` varchar(200) DEFAULT NULL,
  `api_yahoo` varchar(200) DEFAULT NULL,
  `api_live` varchar(200) DEFAULT NULL,
  `api_akismet` varchar(200) DEFAULT NULL,
  `default_country` int(11) DEFAULT NULL,
  `multi_country` tinyint(4) NOT NULL DEFAULT '0',
  `default_city` varchar(150) DEFAULT NULL,
  `default_lat` varchar(100) DEFAULT NULL,
  `default_lon` varchar(100) DEFAULT NULL,
  `default_zoom` tinyint(4) NOT NULL DEFAULT '10',
  `items_per_page` smallint(6) NOT NULL DEFAULT '20',
  `items_per_page_admin` smallint(6) NOT NULL DEFAULT '20',
  `sms_provider` varchar(100) DEFAULT NULL,
  `sms_no1` varchar(100) DEFAULT NULL,
  `sms_no2` varchar(100) DEFAULT NULL,
  `sms_no3` varchar(100) DEFAULT NULL,
  `google_analytics` text,
  `twitter_hashtags` text,
  `laconica_username` varchar(50) DEFAULT NULL,
  `laconica_password` varchar(50) DEFAULT NULL,
  `laconica_site` varchar(30) DEFAULT NULL COMMENT 'a laconica site',
  `date_modify` datetime DEFAULT NULL,
  `stat_id` bigint(20) DEFAULT NULL COMMENT 'comes from centralized stats',
  `stat_key` varchar(30) NOT NULL,
  `email_username` varchar(100) NOT NULL,
  `email_password` varchar(100) NOT NULL,
  `email_port` int(11) NOT NULL,
  `email_host` varchar(100) NOT NULL,
  `email_servertype` varchar(100) NOT NULL,
  `email_ssl` int(5) NOT NULL,
  `ftp_server` varchar(100) DEFAULT NULL,
  `ftp_user_name` varchar(100) DEFAULT NULL,
  `alerts_email` varchar(120) NOT NULL,
  `db_version` varchar(20) DEFAULT NULL,
  `ushahidi_version` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'mapascoletivos','mapas','fabriciosn@gmail.com',NULL,'en_US','default',NULL,1,1,'','',1,1,1,1,0,0,1800,'google_satellite','CC0000','ABQIAAAAZQVvkUMmHSU48Y8mCjnWMhSMZKSkciUzkpujvqVT6p77iOR9_BS1pnqTQC3G1H4JBbj9xzN2WF9ukA','5CYeWbfV34E21JOW1a4.54Mf6e9jLNkD0HVzaKoQmJZi2qzmSZd5mD8X49x7',NULL,'',31,0,'nairobi','-23.546048317205','-46.68399810791',11,20,20,NULL,NULL,NULL,NULL,'','',NULL,NULL,NULL,'2011-06-13 22:09:31',18584,'7f8358c0821dc8b1a6eb2a3d18d107','fabriciosn','Va$7Fe@gmail',993,'imap.gmail.com','imap',1,NULL,NULL,'fabriciosn@gmail.com','39','2.0.1');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sharing`
--

DROP TABLE IF EXISTS `sharing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sharing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sharing_name` varchar(150) NOT NULL,
  `sharing_url` varchar(255) NOT NULL,
  `sharing_color` varchar(20) DEFAULT 'CC0000',
  `sharing_active` tinyint(4) NOT NULL DEFAULT '1',
  `sharing_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sharing`
--

LOCK TABLES `sharing` WRITE;
/*!40000 ALTER TABLE `sharing` DISABLE KEYS */;
/*!40000 ALTER TABLE `sharing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sharing_incident`
--

DROP TABLE IF EXISTS `sharing_incident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sharing_incident` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sharing_id` int(10) unsigned NOT NULL,
  `incident_id` int(11) NOT NULL,
  `incident_title` varchar(255) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `incident_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sharing_incident`
--

LOCK TABLES `sharing_incident` WRITE;
/*!40000 ALTER TABLE `sharing_incident` DISABLE KEYS */;
/*!40000 ALTER TABLE `sharing_incident` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_tokens`
--

DROP TABLE IF EXISTS `user_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tokens`
--

LOCK TABLES `user_tokens` WRITE;
/*!40000 ALTER TABLE `user_tokens` DISABLE KEYS */;
INSERT INTO `user_tokens` VALUES (1,1,'2a4dc598ea59dc708ff981b28ea59c17bb68acba','GiAs99cabmHeJiDFSikZNnzfm3PAZxsj',1306160095,1307369695),(2,1,'2a4dc598ea59dc708ff981b28ea59c17bb68acba','kmeE3NwK5R1JbqYufQnCLUFtoyMPQC5h',1306162337,1307371937),(3,1,'2a4dc598ea59dc708ff981b28ea59c17bb68acba','HaFOEEhXg7UYdKrSzJjR0UyWVN18I7Zh',1306178308,1307387908),(4,1,'2a4dc598ea59dc708ff981b28ea59c17bb68acba','qjUz3wNEbLY6ihmFGo4fN14a6XY0B66Y',1306333845,1307543445),(5,1,'76a89b4b576d97733b64e11ceee438097cad88da','B23wuLlBoxFhTZQwZ4Q8e4STqNCJGgST',1306333878,1307543478),(6,1,'72184714002490a22d3c49cbd08b7aff47fea104','ScM0xOawFDKaYb74XtsCvzrZPCRQxHYd',1308013740,1309223340);
/*!40000 ALTER TABLE `user_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(127) NOT NULL,
  `username` varchar(31) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Flag incase admin opts in for email notifications',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','david@ushahidi.com','admin','bae4b17e9acbabf959654a4c496e577003e0b887c6f52803d7',90,1308013770,0,'2011-06-14 01:09:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verified`
--

DROP TABLE IF EXISTS `verified`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verified` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` bigint(20) DEFAULT NULL,
  `idp_id` bigint(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `verified_comment` longtext,
  `verified_date` datetime DEFAULT NULL,
  `verified_status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verified`
--

LOCK TABLES `verified` WRITE;
/*!40000 ALTER TABLE `verified` DISABLE KEYS */;
INSERT INTO `verified` VALUES (1,12,NULL,1,NULL,'2011-05-25 14:33:09',1),(2,13,NULL,1,NULL,'2011-05-26 23:14:23',1),(3,13,NULL,1,NULL,'2011-05-26 23:14:44',2),(4,13,NULL,1,NULL,'2011-05-26 23:15:12',0),(5,13,NULL,1,NULL,'2011-05-26 23:15:17',1),(6,13,NULL,1,NULL,'2011-05-26 23:16:08',1);
/*!40000 ALTER TABLE `verified` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-06-13 22:47:29
