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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (7,0,'en_US',NULL,'Água','Água','1c44e6',NULL,NULL,NULL,1,0),(5,0,'en_US',NULL,'Mobilidade/Transporte','Mobilidade/Transporte','c7890e',NULL,NULL,NULL,1,0),(6,0,'en_US',NULL,'O Ar','O Ar','67d7eb',NULL,NULL,NULL,1,0),(4,0,'en_US',5,'Áreas Verdes','Áreas Verdes','339900',NULL,NULL,NULL,1,1),(8,0,'en_US',NULL,'Acesso','Acesso','09945c',NULL,NULL,NULL,1,0),(9,0,'en_US',NULL,'Arte','Arte','140e0e',NULL,NULL,NULL,1,0),(10,0,'en_US',NULL,'cultura / educação','cultura / educação','d5db25',NULL,NULL,NULL,1,0),(11,0,'en_US',NULL,'Alimentação','Alimentação','ed9a42',NULL,NULL,NULL,1,0),(12,0,'en_US',NULL,'Habilitação','Habilitação','e045ce',NULL,NULL,NULL,1,0),(13,0,'en_US',NULL,'Limpeza','Limpeza','a8f0ec',NULL,NULL,NULL,1,0),(14,0,'en_US',NULL,'Limpeza','Limpeza','e60c05',NULL,NULL,NULL,1,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_lang`
--

LOCK TABLES `category_lang` WRITE;
/*!40000 ALTER TABLE `category_lang` DISABLE KEYS */;
INSERT INTO `category_lang` VALUES (22,6,'en_US_bkp','',NULL),(21,6,'en_US','',NULL),(20,4,'pt_BR','',NULL),(19,4,'fr_FR','',NULL),(15,5,'fr_FR','',NULL),(14,5,'en_US_bkp','',NULL),(13,5,'en_US','',NULL),(18,4,'en_US_bkp','',NULL),(17,4,'en_US','',NULL),(16,5,'pt_BR','',NULL),(23,6,'fr_FR','',NULL),(24,6,'pt_BR','',NULL),(25,7,'en_US','',NULL),(26,7,'en_US_bkp','',NULL),(27,7,'fr_FR','',NULL),(28,7,'pt_BR','',NULL),(29,8,'en_US','',NULL),(30,8,'en_US_bkp','',NULL),(31,8,'fr_FR','',NULL),(32,8,'pt_BR','',NULL),(33,9,'en_US','',NULL),(34,9,'en_US_bkp','',NULL),(35,9,'fr_FR','',NULL),(36,9,'pt_BR','',NULL),(37,10,'en_US','',NULL),(38,10,'en_US_bkp','',NULL),(39,10,'fr_FR','',NULL),(40,10,'pt_BR','',NULL),(41,11,'en_US','',NULL),(42,11,'en_US_bkp','',NULL),(43,11,'fr_FR','',NULL),(44,11,'pt_BR','',NULL),(45,12,'en_US','',NULL),(46,12,'en_US_bkp','',NULL),(47,12,'fr_FR','',NULL),(48,12,'pt_BR','',NULL),(49,13,'en_US','',NULL),(50,13,'en_US_bkp','',NULL),(51,13,'fr_FR','',NULL),(52,13,'pt_BR','',NULL),(53,14,'en_US','',NULL),(54,14,'en_US_bkp','',NULL),(55,14,'fr_FR','',NULL),(56,14,'pt_BR','',NULL);
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
INSERT INTO `feed` VALUES (1,'Vidagee','http://feeds.feedburner.com/VidaGeek?format=xml',NULL,1,1311089009),(2,'Ohay','http://feeds.folha.uol.com.br/ambiente/rss091.xml',NULL,1,1311089009);
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
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feed_item`
--

LOCK TABLES `feed_item` WRITE;
/*!40000 ALTER TABLE `feed_item` DISABLE KEYS */;
INSERT INTO `feed_item` VALUES (1,1,0,0,'Conversa Rápida 13/06','<p>No dia 13 de Junho, das 19:30 às 22:00, acontecerá na <a href=\"http://www.adaptworks.com.br\" target=\"_blank\">AdaptWorks</a> mais uma edição do <a href=\"http://www.adaptworks.com.br/blog/2011/05/18/conversa-rapida-junho/\" target=\"_blank\">Conversa Rápida</a>.</p>\n<p>A <a href=\"http://vidageek.net/2011/05/14/conversa-rapida/\" target=\"_blank\">edição passada</a> foi bem divertida. Se tiver interesse em participar, mande um email para jabreu@adaptworks.com.br&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/M1wMHH29LMw/','2011-05-20 15:25:00'),(2,1,0,0,'Expressividade','<p>Enquanto eu resolvia o <a href=\"http://vidageek.net/2011/05/16/desafio-de-expressividade-i/\" target=\"_blank\">primeiro desafio de expressividade</a>, eu notei uma coisa relacionada ao <a href=\"https://github.com/jonasabreu/desafio20110516\" target=\"_blank\">código das minhas classes</a>.</p>\n<p>O código mais próximo da interface que resolvia o desafio, eu tentei manter o mais próximo da linguagem&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/HM5bB6ujfdw/','2011-05-18 07:00:00'),(3,1,0,0,'Desafio de expressividade I','<p>Já faz um bom tempo em que venho pensando em como criar formas de exercitar diversas técnicas de programação.</p>\n<p>Recentemente, enquanto eu desenvolvia um <a href=\"http://www.adaptworks.com.br/treinamento/CSD-Scrum-Developer-Skills\" target=\"_blank\">treinamento para a AdaptWorks</a> (parte da <a href=\"http://www.scrumalliance.org/CSD\" target=\"_blank\">certificação CSD da ScrumAlliance</a>), me veio&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/95gTQlD-aJc/','2011-05-16 07:00:00'),(4,1,0,0,'Conversa Rápida','<p>No começo da semana passada aconteceu um mini evento na <a href=\"http://www.adaptworks.com.br\" target=\"_blank\">AdaptWorks</a>, organizado por mim, chamado Conversa Rápida.</p>\n<p>Foram 12 palestras com aproximadamente 5 minutos, que foram filmadas e <a href=\"http://www.youtube.com/user/adaptworks\" target=\"_blank\">colocadas no YouTube</a>.</p>\n<p>Das 12, 5 fui eu&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/8bxgK-AktZo/','2011-05-14 15:31:00'),(5,1,0,0,'Não. Seu site não é totalmente confiável.','<p>&#8220;A loja é totalmente confiável e os seus dados estão seguros&#8221;. Essa frase me deu calafrios assim que li em um email que recebi.</p>\n<p>Um pouco de contexto. A fonte do meu notebook se decompos. Como não vivo sem ele,&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/trTv0_ZjD48/','2011-05-09 16:09:00'),(6,1,0,0,'Agile Searcher','<p>Tempos atrás precisei reunir várias referências sobre desenvolvimento ágil. Depois de buscar muito no Google e sofrer um pouco para filtrar os resultados, resolvi criar um <a href=\"http://www.google.com/cse\" target=\"_blank\">Google Custom Search Engine</a> com alguns sites para facilitar a minha vida.&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/BPD3-NZg1Cs/','2011-04-06 18:22:00'),(7,1,0,0,'Open Source Week – Fim','<p>Foram duas semanas de trabalhos para documentar e lançar esses projetos (alguns já estavam &#8220;quase prontos&#8221; a mais de 6 meses.).</p>\n<p>Para finalizar isso, resolvi colocar no ar <a href=\"http://projetos.vidageek.net/\" target=\"_blank\">a página de projetos do VidaGeek.net</a>. A idéia dessa página&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/aBCxS0XN1z4/','2011-02-27 07:00:00'),(8,1,0,0,'Open Source Week – Mirror','<p>Para finalizar os lançamentos de projetos essa semana, a versão 1.6 do <a href=\"http://projetos.vidageek.net/mirror-pt\" target=\"_blank\">Mirror</a> finalmente foi lançada.</p>\n<p>Essa versão trás muitas pequenas melhorias para o dia a dia (como refletir um getter/setter) e algumas novas features que fizeram falta&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/nWzgYYP135Q/','2011-02-26 07:00:00'),(9,1,0,0,'Open Source Week – Scraper','<p>O Terceiro lançamento é o <a href=\"http://projetos.vidageek.net/scraper\" target=\"_blank\">Scraper</a>.</p>\n<p>O Scraper é uma ferramenta para facilitar <a href=\"http://en.wikipedia.org/wiki/Web_scraping\" target=\"_blank\">Html Scrapping</a>, ou seja, extrair dados de páginas html.</p>\n<p>Existem diversas formas de extrair dados de páginas Html. Você pode usar <a href=\"http://en.wikipedia.org/wiki/Regular_expression\"&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/QPqgu3lvpJo/','2011-02-25 07:00:00'),(10,1,0,0,'Open Source Week – I18n','<p>O segundo lançamento é da versão 0.5 do <a href=\"http://vidageek.net/2010/02/24/i18n-para-java/\" target=\"_blank\">I18n, lançado ano passado</a>. Essa versão resolve o problema que tivemos para lidar<br />\ncom mensagens muito grandes (ficava muito ruim no .properties).</p>\n<p>Também melhoramos a documentação.</p>\n<p>Mais informações em&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/mePL0FU-edQ/','2011-02-24 07:00:00'),(11,2,0,0,'Código Florestal vai para 2ª tentativa de votação na terça','As lideranças partidárias devem se mobilizar novamente nesta terça-feira, dia em que o projeto do novo Código Florestal será levado para votação na Câmara pela segunda vez.\nA primeira tentativa de se aprovar o novo texto ocorreu no último dia 11, mas a sessão foi cancelada pelo governo, que temia uma perda política em início do mandato da presidente Dilma Rousseff.\nUm dos principais pontos da discórdia no programa, cujo relator é o deputado Aldo Rebelo (PBdoB-SP), refere-se o uso das APPs (Áreas de Preservação Permanente).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919535-codigo-florestal-vai-para-2-tentativa-de-votacao-na-terca.shtml\">Leia mais</a> (23/05/2011 - 11h41)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919535-codigo-florestal-vai-para-2-tentativa-de-votacao-na-terca.shtml','2011-05-23 11:41:00'),(12,2,0,0,'Nível dos oceanos subirá mais do que previu ONU, diz Austrália','As inundações em regiões costeiras devem ocorrer com mais frequência dentro de um século, devido ao aumento no nível dos oceanos provocado pelo aquecimento global, diz um estudo divulgado pelo governo australiano nesta segunda-feira.\n&quot;O cálculo plausível do aumento do nível das águas para 2100, em comparação com 2000, é de 0,5 a um metro&quot;, cita o relatório &quot;A Década Crítica&quot;, da Comissão de Mudança Climática, subordinado ao governo da Austrália.\n<table>\n<tr>\n<td>AP</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/homepage/images/1101028.jpeg\" alt=\"Australianos se protegem durante inundação na Austrália, que deve ser mais corrente com aumento do nível dos oceanos\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Australianos se protegem durante inundação na Austrália, que deve ser mais corrente com aumento do nível dos oceanos</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919501-nivel-dos-oceanos-subira-mais-do-que-previu-onu-diz-australia.shtml\">Leia mais</a> (23/05/2011 - 10h34)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919501-nivel-dos-oceanos-subira-mais-do-que-previu-onu-diz-australia.shtml','2011-05-23 10:34:00'),(13,2,0,0,'Tribo amazônica desconhece conceito de tempo, diz estudo','Pesquisadores brasileiros e britânicos identificaram uma tribo amazônica que, segundo eles, não tem noção do conceito abstrato de tempo.\nChamada Amondawa, a tribo não possui as estruturas linguísticas que relacionam tempo e espaço --como, por exemplo, na tradicional ideia de &quot;no ano que vem&quot;.\nO estudo feito com os Amondawa, chamado &quot;Língua e Cognição&quot;, mostra que, ainda que a tribo entenda que os eventos ocorrem ao longo do tempo, este não existe como um conceito separado.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919488-tribo-amazonica-desconhece-conceito-de-tempo-diz-estudo.shtml\">Leia mais</a> (23/05/2011 - 09h59)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919488-tribo-amazonica-desconhece-conceito-de-tempo-diz-estudo.shtml','2011-05-23 09:59:00'),(14,2,0,0,'Sucesso da civilização inca se deve a lhamas, diz estudo','Machu Picchu, a famosa cidade inca nos Andes peruanos, celebrará em julho o centenário de sua &quot;descoberta&quot; pelo mundo exterior, em um evento imponente, mas há indicativos de que as origens do local tenham sido menos glamourosas.\nSegundo pesquisa publicada no jornal &quot;Antiquity&quot;, especializado em arqueologia, a civilização inca pode ter crescido e evoluído graças aos dejetos das lhamas.\nA transição da caça e coleta à agricultura, 2.700 anos atrás, que permitiu aos incas se acomodar e prosperar na área de Cuzco onde fica Machu Picchu, diz o autor do estudo, Alex Chepstow-Lusty.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919487-sucesso-da-civilizacao-inca-se-deve-a-lhamas-diz-estudo.shtml\">Leia mais</a> (23/05/2011 - 09h52)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919487-sucesso-da-civilizacao-inca-se-deve-a-lhamas-diz-estudo.shtml','2011-05-23 09:52:00'),(15,2,0,0,'Projeto quer fotografar em 3D todas as espécies de formigas','Cientistas da Academia de Ciências da Califórnia iniciaram um projeto para fazer imagens digitais e superdetalhadas de todas as cerca de 12 mil espécies de formigas conhecidas da ciência.\n&quot;São insetos incríveis&quot;, diz o pesquisador-chefe do projeto, Brian Fisher. &quot;As formigas inventaram (o conceito de) cultivo agrícola muito antes que os humanos.&quot;\n<a href=\"http://fotografia.folha.uol.com.br/galerias/2992-especies-de-formigas-conhecidas\">Veja galeria de fotos</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919484-projeto-quer-fotografar-em-3d-todas-as-especies-de-formigas.shtml\">Leia mais</a> (23/05/2011 - 09h43)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/919484-projeto-quer-fotografar-em-3d-todas-as-especies-de-formigas.shtml','2011-05-23 09:43:00'),(16,2,0,0,'Grupo acha &quot;avô&quot; de crocodilos terrestres no interior de MG','Medindo só 1,80 metro da ponta do focinho à extremidade da cauda, o <i>Campinasuchus dinizi</i> não se encaixa muito bem na definição de monstro pré-histórico. Mesmo assim, parece ter sido um excelente fundador de dinastia.\nIsso porque, segundo seus descobridores, o bicho é o membro mais primitivo do grupo de crocodilos que dominou o interior do Brasil na Era dos Dinossauros.\n<a href=\"http://www1.folha.uol.com.br/ciencia/919474-nome-de-crocodilo-primitivo-mineiro-homenageia-filho.shtml\">Nome de crocodilo primitivo mineiro homenageia filho</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/919468-grupo-acha-avo-de-crocodilos-terrestres-no-interior-de-mg.shtml\">Leia mais</a> (23/05/2011 - 08h57)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/919468-grupo-acha-avo-de-crocodilos-terrestres-no-interior-de-mg.shtml','2011-05-23 08:57:00'),(17,2,0,0,'Yangtzé, o rio mais longo da Ásia, sofre sua pior seca em 50 anos','O rio Yangtzé, o mais longo da Ásia e em cuja bacia vive um terço da população chinesa (cerca de 400 milhões de pessoas), enfrenta a pior seca em 50 anos, devido à maior escassez de chuvas desde 1961, informou nesta segunda-feira a agência oficial Xinhua.\nAs províncias do curso médio do rio (Jiangxi, Hunan e Hubei) são as mais afetadas, já que nelas as precipitações entre janeiro e abril foram entre 40% e 60% inferiores à média anual, destacou o diretor do centro de controle de inundações e secas do rio, Wang Guosheng.\nA seca afeta os sistemas de irrigação, o abastecimento de água em algumas regiões e inclusive o transporte fluvial deste rio, uma das artérias do transporte de carga na China, e onde já foram vários os navios que encalharam devido ao caudal reduzido.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919434-yangtze-o-rio-mais-longo-da-asia-sofre-sua-pior-seca-em-50-anos.shtml\">Leia mais</a> (23/05/2011 - 04h12)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919434-yangtze-o-rio-mais-longo-da-asia-sofre-sua-pior-seca-em-50-anos.shtml','2011-05-23 04:12:00'),(18,2,0,0,'Vazamento de cloro em Maceió levou 22 crianças ao hospital','Um <a href=\"http://www1.folha.uol.com.br/cotidiano/919250-vazamento-de-cloro-em-fabrica-da-braskem-intoxica-30-em-alagoas.shtml\">vazamento</a> de cloro gasoso ocorrido na noite deste sábado (21) em uma unidade da Braskem na região do Pontal da Barra, em Maceió (AL), levou 22 crianças ao hospital.\n<a href=\"http://www1.folha.uol.com.br/cotidiano/919250-vazamento-de-cloro-em-fabrica-da-braskem-intoxica-30-em-alagoas.shtml\">Cloro vaza em fábrica da Braskem em Alagoas</a>\nSegundo informações da Secretaria de Estado da Saúde de Alagoas, elas têm idades entre um e 15 anos e já receberam alta.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919314-vazamento-de-cloro-em-maceio-levou-22-criancas-ao-hospital.shtml\">Leia mais</a> (22/05/2011 - 17h21)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919314-vazamento-de-cloro-em-maceio-levou-22-criancas-ao-hospital.shtml','2011-05-22 17:21:00'),(19,2,0,0,'Marina cobra veto de Dilma à reforma do Código Florestal','Mais de mil pessoas --segundo dados da assessoria de imprensa da SOS Mata Atlântica-- protestaram na manhã deste domingo contra o novo Código Florestal, proposto pelo relator do projeto, deputado Aldo Rebelo (PC do B-SP).\n<a href=\"http://www1.folha.uol.com.br/ambiente/918143-relator-do-codigo-florestal-critica-ibama-por-desmate-na-amazonia.shtml\">Relator do Código Florestal critica Ibama por desmate na Amazônia</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/917451-desmate-cresce-27-na-amazonia-governo-exime-codigo-florestal.shtml\">Desmate cresce 27% na Amazônia; governo exime Código Florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/914619-confira-o-relatorio-final-do-codigo-florestal.shtml\">Confira o relatório final do Código Florestal</a>\n<table>\n<tr>\n<td>Rodrigo Capote/Folhapress</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/poder/images/11142197.jpeg\" alt=\"Marina Silva discursa para manifestantes no protesto\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Marina Silva discursa para manifestantes no protesto</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919295-marina-cobra-veto-de-dilma-a-reforma-do-codigo-florestal.shtml\">Leia mais</a> (22/05/2011 - 16h14)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919295-marina-cobra-veto-de-dilma-a-reforma-do-codigo-florestal.shtml','2011-05-22 16:14:00'),(20,2,0,0,'Vazamento de cloro em fábrica da Braskem intoxica 30 em Alagoas','Um vazamento de cloro ocorrido na noite de sábado intoxicou cerca de 30 pessoas em uma comunidade pesqueira próxima de uma fábrica da Braskem em Alagoas, informou o órgão ambiental do Estado.\n<a href=\"http://www1.folha.uol.com.br/cotidiano/919314-vazamento-de-cloro-em-maceio-levou-22-criancas-ao-hospital.shtml\">Vazamento de cloro levou 22 crianças ao hospital</a>\nPor volta das 18h40 do sábado, alarmes de detecção de vazamento de cloro soaram na planta da Braskem no bairro Pontal da Barra, em Maceió. O alarme só desligou às 20h15, quando a nuvem de gás de cloro se dissipou.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919250-vazamento-de-cloro-em-fabrica-da-braskem-intoxica-30-em-alagoas.shtml\">Leia mais</a> (22/05/2011 - 12h21)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919250-vazamento-de-cloro-em-fabrica-da-braskem-intoxica-30-em-alagoas.shtml','2011-05-22 12:21:00'),(21,2,0,0,'Carga de urânio chega às instalações da INB em Caetité (BA)','A carga de urânio que havia sido bloqueada pela população de Caetité (624 km de Salvador) no domingo (15) foi transportada, na madrugada desta sexta-feira até as instalações da INB (Indústrias Nucleares do Brasil) na cidade.\n<a href=\"http://www1.folha.uol.com.br/cotidiano/917224-carga-de-uranio-esta-em-batalhao-da-pm-a-ceu-aberto-na-ba.shtml\">Carga de urânio está a céu aberto na BA</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/916944-impasse-sobre-carga-de-uranio-levada-a-bahia-continua.shtml\">Impasse sobre carga de urânio continua</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/916807-protesto-de-moradores-barra-carga-de-uranio-em-caetite-ba.shtml\">Protesto de moradores barra carga de urânio</a>\n<table>\n<tr>\n<td>Divulgação/Greenpeace</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/cotidiano/images/11137617.jpeg\" alt=\"Carga de urânio em que gerou impasse em Caitité (BA)\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Carga de urânio em que gerou impasse em Caitité (BA)</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/918694-carga-de-uranio-chega-as-instalacoes-da-inb-em-caetite-ba.shtml\">Leia mais</a> (20/05/2011 - 18h28)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/918694-carga-de-uranio-chega-as-instalacoes-da-inb-em-caetite-ba.shtml','2011-05-20 18:28:00'),(22,2,0,0,'Associações de cientistas pedem suspensão de Belo Monte','Vinte associações e sociedades científicas protocolaram nesta quinta-feira (19) uma carta em que pedem à presidente Dilma Rousseff a suspensão do licenciamento da usina de Belo Monte, no rio Xingu (PA), até que as condicionantes impostas pelo Ibama sejam cumpridas.\nA SBPC (Sociedade Brasileira para o Progresso da Ciência), a ABA (Associação Brasileira de Antropologia) e demais entidades solicitam ainda que o governo federal espere consultas a indígenas e a moradores da região e o julgamento de ações contra a usina que existem hoje na Justiça.\n<a href=\"http://www1.folha.uol.com.br/mercado/917195-sem-licenca-inicio-de-operacao-de-belo-monte-pode-atrasar.shtml\">Sem licença, início de operação de Belo Monte pode atrasar</a><br/>\n<a href=\"http://www1.folha.uol.com.br/mercado/916852-ibama-faz-vistoria-final-antes-de-licenca-que-libera-belo-monte.shtml\">Ibama faz vistoria final antes de licença que libera Belo Monte</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/918596-associacoes-de-cientistas-pedem-suspensao-de-belo-monte.shtml\">Leia mais</a> (20/05/2011 - 15h54)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/918596-associacoes-de-cientistas-pedem-suspensao-de-belo-monte.shtml','2011-05-20 15:54:00'),(23,2,0,0,'Cientistas se preparam para encalhe em massa de baleias','Especialistas em animais marinhos estão se preparando para o encalhe de até cem baleias-piloto nas ilhas Ocidentais, localizadas no norte da Escócia.\nO grupo de baleias foi visto na tarde de quinta-feira na região de Loch Carnan. Cerca de 20 delas já apresentariam ferimentos nas cabeças, que teriam sido causados pelas tentativas das baleias de irem para a faixa litorânea da região, que é rochosa.\nBaleias doentes ou feridas geralmente vão para as praias, onde morrem. No entanto, em alguns casos, baleias saudáveis seguem as que estão agonizando.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/918564-cientistas-se-preparam-para-encalhe-em-massa-de-baleias.shtml\">Leia mais</a> (20/05/2011 - 15h14)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/918564-cientistas-se-preparam-para-encalhe-em-massa-de-baleias.shtml','2011-05-20 15:14:00'),(24,2,0,0,'Projeto coloca GPS em ursos que invadem zona urbana','Conservacionistas da Eslováquia iniciaram um projeto para colocar coleiras com tecnologia GPS e estudar o comportamento do urso pardo europeu.\nO país conseguiu conservar a espécie --cerca de mil vivem na Eslováquia--, mas os animais perderam o medo dos humanos e agora invadem cidades em busca de comida.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"tp://www.bbc.co.uk/worldservice/emp/pop.shtml?l=pt&amp;t=video&amp;r=1&amp;p=/portuguese/meta/dps/2011/05/emp/110520_ursos_eslovaquia_video_fn.emp.xml\">Veja o vídeo</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/918521-projeto-coloca-gps-em-ursos-que-invadem-zona-urbana.shtml\">Leia mais</a> (20/05/2011 - 13h25)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/918521-projeto-coloca-gps-em-ursos-que-invadem-zona-urbana.shtml','2011-05-20 13:25:00'),(25,2,0,0,'PM manda 160 homens acompanharem transporte de urânio na Bahia','A Polícia Militar da Bahia destacou 160 homens do 17º Batalhão e da Companhia de Ações Especiais do Sudoeste e Gerais para acompanhar o transporte da carga de urânio que, na segunda-feira (16), foi impedida por moradores de Caetité (624 km de Salvador) de entrar na cidade.\n<a href=\"http://www1.folha.uol.com.br/cotidiano/917224-carga-de-uranio-esta-em-batalhao-da-pm-a-ceu-aberto-na-ba.shtml\">Carga de urânio está em batalhão da PM a céu aberto na BA</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/916944-impasse-sobre-carga-de-uranio-levada-a-bahia-continua.shtml\">Impasse sobre carga de urânio levada à Bahia continua</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/916807-protesto-de-moradores-barra-carga-de-uranio-em-caetite-ba.shtml\">Protesto de moradores barra carga de urânio em Caetité (BA)</a>\n<table>\n<tr>\n<td>Divulgação/Greenpeace</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/cotidiano/images/11137617.jpeg\" alt=\"Carga de urânio em que gerou impasse em Caitité (BA)\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Carga de urânio em que gerou impasse em Caitité (BA)</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/918362-pm-manda-160-homens-acompanharem-transporte-de-uranio-na-bahia.shtml\">Leia mais</a> (19/05/2011 - 21h51)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/918362-pm-manda-160-homens-acompanharem-transporte-de-uranio-na-bahia.shtml','2011-05-19 21:51:00'),(26,2,0,0,'Ex-ministros vão a Dilma para se oporem ao Código Florestal','Ex-ministros da pasta de Meio Ambiente se encontram com a presidente Dilma Rousseff nesta segunda-feira.\nO grupo quer expressar em carta aberta sua preocupação sobre as mudanças sugeridas pelo relator do texto, deputado Aldo Rebelo (PCdoB-SP).\nOs signatárias são Nogueira Neto, José Goldemberg, Henrique Brandão Cavalcanti, Gustavo Krause, José Carlos Carvalho, Fernando Coutinho Jorge, Rubens Ricupero, José Sarney Filho, Marina Silva e Carlos Minc.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919598-ex-ministros-vao-a-dilma-para-se-oporem-ao-codigo-florestal.shtml\">Leia mais</a> (23/05/2011 - 13h58)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919598-ex-ministros-vao-a-dilma-para-se-oporem-ao-codigo-florestal.shtml','2011-05-23 13:58:00'),(27,2,0,0,'Novo Código Florestal é perverso, dizem ex-ministros de Ambiente','Dez ex-ministros do Meio Ambiente se uniram nesta segunda-feira contra o texto da reforma do Código Florestal que deve ser votado amanhã (24) pela Câmara.\nEm carta aberta à presidente Dilma Rousseff e ao Congresso, o grupo diz que a proposta a ser analisada significa um retrocesso na política ambiental brasileira, que foi &quot;pioneira&quot; na criação de leis de conservação e proteção de recursos naturais.\nSegundo os ex-ministros, a votação do texto do deputado Aldo Rebelo (PCdoB-SP) nesta semana é prematura.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919652-novo-codigo-florestal-e-perverso-dizem-ex-ministros-de-ambiente.shtml\">Leia mais</a> (23/05/2011 - 15h51)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919652-novo-codigo-florestal-e-perverso-dizem-ex-ministros-de-ambiente.shtml','2011-05-23 15:51:00'),(28,2,0,0,'Pesquisa nacional estuda aproveitamento de bagaço de uva','A CTAA (Embrapa Agroindústria de Alimentos), unidade da Empresa Brasileira de Pesquisa Agropecuária, está iniciando uma pesquisa sobre o aproveitamento econômico dos resíduos da indústria vinícola e de sucos.\nA coordenadora do projeto, Lourdes Maria Correa Cabral, explicou à Agência Brasil que um dos fatores que justificam os benefícios trazidos à saúde pelo vinho é a presença de substâncias antioxidantes, que retardam o envelhecimento.\nEntre elas, estão os compostos fenólicos, com destaque para as antocianinas, que dão a frutas e legumes a coloração vermelha, como ocorre no caso da uva. Esses compostos funcionais têm interesse comercial e industrial.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/919623-pesquisa-nacional-estuda-aproveitamento-de-bagaco-de-uva.shtml\">Leia mais</a> (23/05/2011 - 15h03)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/919623-pesquisa-nacional-estuda-aproveitamento-de-bagaco-de-uva.shtml','2011-05-23 15:03:00'),(29,2,0,0,'Dilma recebe ex-ministros que são contra texto de lei florestal','Os oito ex-ministros de Meio Ambiente que vieram a Brasília pedir o adiamento da votação na Câmara dos Deputados do novo Código Florestal foram recebidos no final desta manhã (24) pela presidente Dilma Rousseff.\nAo final do encontro, eles declararam que Dilma acredita que o aumento do desmatamento está relacionado &quot;à expectativa de aprovação&quot; do novo Código Florestal. O texto em discussão na Câmara anistia produtores rurais que desmataram no passado.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Leia mais</a> (24/05/2011 - 13h53)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml','2011-05-24 13:53:00'),(30,2,0,0,'Relator do Código Florestal critica ex-ministros de Meio Ambiente','O relator do novo Código Florestal, Aldo Rebelo (PC do B-SP), distribuiu críticas aos ex-ministros de Meio Ambiente que estão em Brasília desde segunda-feira (23) para tentar o adiamento da votação do texto na Câmara.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nAo chegar para uma reunião com os ministros Antonio Palocci (Casa Civil) e Luiz Sérgio (Relações Institucionais), Rebelo chamou a carta enviada pelos ex-titulares à presidente Dilma Rousseff de &quot;abaixo-assinado&quot;. Criticou ainda os ex-ministros Carlos Minc e Marina Silva (governo Lula) e Zequinha Sarney (governo Fernando Henrique Cardoso).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Leia mais</a> (24/05/2011 - 13h47)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml','2011-05-24 13:47:00'),(31,2,0,0,'Líder extrativista do PA é morto; Dilma ordena investigação','A presidente Dilma Rousseff foi comunicada nesta terça-feira pelos ex-ministros de Meio Ambiente do assassinato, no Pará, de um líder extrativista e sua mulher.\nEla determinou que o ministro da Justiça, José Eduardo Cardozo, mobilize a Polícia Federal para investigar a morte, que está sendo comparada à da missionária Dorothy Stang, assassinada há seis anos em Anapu (PA).\nJosé Claudio Ribeiro da Silva e a mulher, Maria do Espírito Santo da Silva, foram mortos hoje no Assentamento Agroextrativista Praialtapiranheira, no município de Nova Ipixuna, próximo a Marabá.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920120-lider-extrativista-do-pa-e-morto-dilma-ordena-investigacao.shtml\">Leia mais</a> (24/05/2011 - 13h31)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920120-lider-extrativista-do-pa-e-morto-dilma-ordena-investigacao.shtml','2011-05-24 13:31:00'),(32,2,0,0,'Impasse regimental impede votação do Código Florestal, diz Rebelo','Relator da reforma do Código Florestal, o deputado Aldo Rebelo (PC do B-SP) afirmou nesta terça-feira que um impasse regimental ainda não permite que o texto seja colocado em votação no plenário da Câmara.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nDesde o início da manhã, a Casa já realiza sessão para analisar o texto.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Leia mais</a> (24/05/2011 - 13h05)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml','2011-05-24 13:05:00'),(33,2,0,0,'Governo cede para votar nova lei florestal nesta terça-feira','Para costurar um acordo com a base aliada na Câmara sobre o Código Florestal, o governo recuou em um dos principais pontos da reforma: aceitou flexibilizar a regra das APPs (áreas de preservação ambiental) em propriedades de agricultura familiar.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nO recuo foi considerado uma &quot;evolução&quot; pelo relator do texto, deputado Aldo Rebelo (PCdoB-SP).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Leia mais</a> (24/05/2011 - 11h53)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml','2011-05-24 11:53:00'),(34,2,0,0,'Imagens da Nasa mostram vulcões em erupção vistos do espaço','Imagens feitas por satélites da Nasa, a agência espacial americana, mostram a atividade do vulcão Grimsvotn, na Islândia, que entrou em erupção no último sábado, e ajudam a mostrar a dimensão e o impacto do fenômeno.\nA erupção do Grimsvotn já provocou o cancelamento de centenas de voos na Europa.\nNo ano passado, as cinzas de outro vulcão islandês, o Eyjafjallajokull, provocaram o cancelamento de cerca de 100 mil voos na Europa ao longo de quase um mês, gerando um prejuízo estimado em US$ 1,7 bilhão (cerca de R$ 2,75 bilhões).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920048-imagens-da-nasa-mostram-vulcoes-em-erupcao-vistos-do-espaco.shtml\">Leia mais</a> (24/05/2011 - 10h45)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920048-imagens-da-nasa-mostram-vulcoes-em-erupcao-vistos-do-espaco.shtml','2011-05-24 10:45:00'),(35,2,0,0,'Acusada de promover safáris de onça é multada em R$ 115 mil','A pecuarista Beatriz Rondon, acusada de abrigar em sua fazenda no Pantanal de Mato Grosso do Sul um esquema de <a href=\"http://www1.folha.uol.com.br/cotidiano/912479-video-leva-pf-a-apreender-cranios-de-onca-e-armas-em-ms.shtml\">safáris ilegais</a> de onças e outros animais silvestres, recebeu uma multa do Ibama no valor de R$ 115 mil.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-video-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://www1.folha.uol.com.br/cotidiano/912479-video-leva-pf-a-apreender-cranios-de-onca-e-armas-em-ms.shtml\"><b>PF apreende crânios de onça e armas</b></a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/771291-ibama-multa-suspeitos-de-organizar-safaris-para-cacar-oncas-no-pantanal.shtml\">Ibama multa suspeitos de organizar safáris</a>\nAlvo da Operação Jaguar 2, deflagrada pelo Ibama e a Polícia Federal no dia 5, a pecuarista já havia sido multada anteriormente em R$ 105 mil por caça ilegal e abate de animais ameaçados de extinção.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919830-acusada-de-promover-safaris-de-onca-e-multada-em-r-115-mil.shtml\">Leia mais</a> (23/05/2011 - 19h48)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919830-acusada-de-promover-safaris-de-onca-e-multada-em-r-115-mil.shtml','2011-05-23 19:48:00'),(36,2,0,0,'Governo flexibiliza Código Florestal um dia antes da votação','A menos de 24 horas da votação do Código Florestal, o governo lançou uma nova proposta para a base aliada. O Palácio do Planalto sugeriu a flexibilização das APPs (áreas de preservação ambiental).\n<table>\n<tr>\n<td>Marcelo Camargo/Folhapress</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/ambiente/images/11143526.jpeg\" alt=\"Marina Silva e Carlos Minc, ex-ministros do Ambiente, criticaram texto do Código Florestal\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Marina Silva e Carlos Minc, ex-ministros do Ambiente, criticaram texto do Código Florestal</td>\n</tr>\n</table>\nA nova proposta do governo prevê que as APPs em matas ciliares (as chamadas APPs de rio) para propriedades de até quatro módulos (de 20 a 400 hectares) serão de 20%, em casos de regularização.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919819-governo-flexibiliza-codigo-florestal-um-dia-antes-da-votacao.shtml\">Leia mais</a> (23/05/2011 - 19h34)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/919819-governo-flexibiliza-codigo-florestal-um-dia-antes-da-votacao.shtml','2011-05-23 19:34:00'),(37,1,0,0,'Conversa Rápida 13/06','<p>No dia 13 de Junho, das 19:30 às 22:00, acontecerá na <a href=\"http://www.adaptworks.com.br\" target=\"_blank\">AdaptWorks</a> mais uma edição do <a href=\"http://www.adaptworks.com.br/blog/2011/05/18/conversa-rapida-junho/\" target=\"_blank\">Conversa Rápida</a>.</p>\n<p>A <a href=\"http://vidageek.net/2011/05/14/conversa-rapida/\" target=\"_blank\">edição passada</a> foi bem divertida. Se tiver interesse em participar, mande um email para jabreu@adaptworks.com.br&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/M1wMHH29LMw/','2011-05-20 18:25:00'),(38,1,0,0,'Expressividade','<p>Enquanto eu resolvia o <a href=\"http://vidageek.net/2011/05/16/desafio-de-expressividade-i/\" target=\"_blank\">primeiro desafio de expressividade</a>, eu notei uma coisa relacionada ao <a href=\"https://github.com/jonasabreu/desafio20110516\" target=\"_blank\">código das minhas classes</a>.</p>\n<p>O código mais próximo da interface que resolvia o desafio, eu tentei manter o mais próximo da linguagem&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/HM5bB6ujfdw/','2011-05-18 10:00:00'),(39,1,0,0,'Desafio de expressividade I','<p>Já faz um bom tempo em que venho pensando em como criar formas de exercitar diversas técnicas de programação.</p>\n<p>Recentemente, enquanto eu desenvolvia um <a href=\"http://www.adaptworks.com.br/treinamento/CSD-Scrum-Developer-Skills\" target=\"_blank\">treinamento para a AdaptWorks</a> (parte da <a href=\"http://www.scrumalliance.org/CSD\" target=\"_blank\">certificação CSD da ScrumAlliance</a>), me veio&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/95gTQlD-aJc/','2011-05-16 10:00:00'),(40,1,0,0,'Conversa Rápida','<p>No começo da semana passada aconteceu um mini evento na <a href=\"http://www.adaptworks.com.br\" target=\"_blank\">AdaptWorks</a>, organizado por mim, chamado Conversa Rápida.</p>\n<p>Foram 12 palestras com aproximadamente 5 minutos, que foram filmadas e <a href=\"http://www.youtube.com/user/adaptworks\" target=\"_blank\">colocadas no YouTube</a>.</p>\n<p>Das 12, 5 fui eu&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/8bxgK-AktZo/','2011-05-14 18:31:00'),(41,1,0,0,'Não. Seu site não é totalmente confiável.','<p>&#8220;A loja é totalmente confiável e os seus dados estão seguros&#8221;. Essa frase me deu calafrios assim que li em um email que recebi.</p>\n<p>Um pouco de contexto. A fonte do meu notebook se decompos. Como não vivo sem ele,&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/trTv0_ZjD48/','2011-05-09 19:09:00'),(42,1,0,0,'Agile Searcher','<p>Tempos atrás precisei reunir várias referências sobre desenvolvimento ágil. Depois de buscar muito no Google e sofrer um pouco para filtrar os resultados, resolvi criar um <a href=\"http://www.google.com/cse\" target=\"_blank\">Google Custom Search Engine</a> com alguns sites para facilitar a minha vida.&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/BPD3-NZg1Cs/','2011-04-06 21:22:00'),(43,1,0,0,'Open Source Week – Fim','<p>Foram duas semanas de trabalhos para documentar e lançar esses projetos (alguns já estavam &#8220;quase prontos&#8221; a mais de 6 meses.).</p>\n<p>Para finalizar isso, resolvi colocar no ar <a href=\"http://projetos.vidageek.net/\" target=\"_blank\">a página de projetos do VidaGeek.net</a>. A idéia dessa página&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/aBCxS0XN1z4/','2011-02-27 10:00:00'),(44,1,0,0,'Open Source Week – Mirror','<p>Para finalizar os lançamentos de projetos essa semana, a versão 1.6 do <a href=\"http://projetos.vidageek.net/mirror-pt\" target=\"_blank\">Mirror</a> finalmente foi lançada.</p>\n<p>Essa versão trás muitas pequenas melhorias para o dia a dia (como refletir um getter/setter) e algumas novas features que fizeram falta&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/nWzgYYP135Q/','2011-02-26 10:00:00'),(45,1,0,0,'Open Source Week – Scraper','<p>O Terceiro lançamento é o <a href=\"http://projetos.vidageek.net/scraper\" target=\"_blank\">Scraper</a>.</p>\n<p>O Scraper é uma ferramenta para facilitar <a href=\"http://en.wikipedia.org/wiki/Web_scraping\" target=\"_blank\">Html Scrapping</a>, ou seja, extrair dados de páginas html.</p>\n<p>Existem diversas formas de extrair dados de páginas Html. Você pode usar <a href=\"http://en.wikipedia.org/wiki/Regular_expression\"&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/QPqgu3lvpJo/','2011-02-25 10:00:00'),(46,1,0,0,'Open Source Week – I18n','<p>O segundo lançamento é da versão 0.5 do <a href=\"http://vidageek.net/2010/02/24/i18n-para-java/\" target=\"_blank\">I18n, lançado ano passado</a>. Essa versão resolve o problema que tivemos para lidar<br />\ncom mensagens muito grandes (ficava muito ruim no .properties).</p>\n<p>Também melhoramos a documentação.</p>\n<p>Mais informações em&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/mePL0FU-edQ/','2011-02-24 10:00:00'),(47,2,0,0,'Dilma irrita-se com Código Florestal e promete veto','A presidente Dilma Rousseff ficou irritada com a aprovação do Código Florestal na Câmara dos Deputados após um racha da base governista e garantiu a um governista que participou das negociações que vetará os trechos do texto que considera equivocados, caso a base não consiga promover mudanças no Senado.\nDe acordo com o governista, que pediu para não ter o nome revelado, Dilma afirmou antes da votação que esperava a derrota do governo, mas se disse confiante de que a base governista conseguirá fazer as mudanças na votação no Senado.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920514-camara-aprova-texto-do-novo-codigo-florestal.shtml\">Câmara aprova texto do novo Código Florestal</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920572-dilma-irrita-se-com-codigo-florestal-e-promete-veto.shtml\">Leia mais</a> (25/05/2011 - 09h28)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920572-dilma-irrita-se-com-codigo-florestal-e-promete-veto.shtml','2011-05-25 12:28:00'),(48,2,0,0,'Câmara aprova texto do novo Código Florestal','Após semanas de embate, negociações e troca de acusações, a Câmara dos Deputados aprovou ontem o texto da reforma do Código Florestal com alterações que significaram uma derrota para o governo.\nUma emenda aprovada por 273 votos a 182 rachou a base do governo levando os principais partidos governistas, PT e PMDB, para lados opostos. O texto da emenda consolida a manutenção de atividades agrícolas nas APPs (áreas de preservação permanente), autoriza os Estados a participarem da regularização ambiental e deixa claro a anistia para os desmates ocorridos até junho de 2008.\nO líder do governo, Cândido Vaccarezza (PT-SP), chegou a falar, em nome da presidente Dilma Rousseff, que a aprovação da emenda seria &quot;uma vergonha&quot;.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920514-camara-aprova-texto-do-novo-codigo-florestal.shtml\">Leia mais</a> (25/05/2011 - 00h43)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920514-camara-aprova-texto-do-novo-codigo-florestal.shtml','2011-05-25 03:43:00'),(49,2,0,0,'Queimadas ameaçam florestas de turfa na Indonésia','As florestas de turfa são um dos ecossistemas que mais armazenam gás carbônico. Na Indonésia, estão ameaçadas pelo desmatamento. Incentivos financeiros e mudanças nas políticas dos países industriais podem ser a saída.\nEm julho de 1997, as pessoas foram obrigadas a usar máscaras cirúrgicas nas ruas entre os edifícios de Jacarta, capital da Indonésia, devido à alta concentração de fumaça no ar. Naquele ano, marcado por uma forte estiagem, as queimadas saíram do controle e uma densa camada de fumaça cobriu a Indonésia e a Malásia. A nuvem chegou a atingir a Austrália e só se desfez por completo após um ano. Dez milhões de hectares foram queimados.\nGrande parte do que queimou foram as florestas de turfa, um dos ecossistemas que mais armazena CO2 no planeta. A turfa é o material precursor do carvão e, sendo assim, em tais florestas o processo de decomposição em solo já se encontra em um estágio avançado, muito mais do que onde crescem as florestas tropicais normais. Por esse motivo, as turfeiras podem armazenar até 50 vezes mais carbono do que outras áreas florestais dos trópicos.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/dw/920235-queimadas-ameacam-florestas-de-turfa-na-indonesia.shtml\">Leia mais</a> (24/05/2011 - 23h28)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/dw/920235-queimadas-ameacam-florestas-de-turfa-na-indonesia.shtml','2011-05-25 02:28:00'),(50,2,0,0,'Entenda a polêmica sobre o novo Código Florestal','A Câmara dos Deputados aprovou o texto-base do polêmico projeto do novo Código Florestal, proposto pelo deputado Aldo Rebelo (PCdoB-SP).\nA proposta, que já sofreu diversas modificações desde que foi apresentada pela primeira vez, dividiu ruralistas, ambientalistas e acadêmicos.\nEntenda a polêmica em torno do novo Código Florestal:\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920452-entenda-a-polemica-sobre-o-novo-codigo-florestal.shtml\">Leia mais</a> (24/05/2011 - 21h27)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920452-entenda-a-polemica-sobre-o-novo-codigo-florestal.shtml','2011-05-25 00:27:00'),(51,2,0,0,'Câmara aprova texto-base do Código Florestal; emendas serão analisadas','O plenário da Câmara dos Deputados aprovou, por 410 votos a 63 e 1 abstenção, o texto-base da última versão do deputado Aldo Rebelo (PC do B-SP) para o projeto de lei do novo Código Florestal.\nOs deputados devem votar, em seguida, os destaques de emendas e de partes do texto apresentados pelos partidos. A emenda que causa discórdia é a do PMDB, que consolida as APPs (área de preservação permanente) e autoriza a participação dos Estados no processo de regularização ambiental.\nMais cedo, o líder do governo na Câmara, Cândido Vaccarezza (PT-SP), disse que a reforma do Código Florestal seria votado hoje mesmo sem acordo entre o Palácio do Planalto e os líderes da base aliada.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920447-camara-aprova-texto-base-do-codigo-florestal-emendas-serao-analisadas.shtml\">Leia mais</a> (24/05/2011 - 21h19)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920447-camara-aprova-texto-base-do-codigo-florestal-emendas-serao-analisadas.shtml','2011-05-25 00:19:00'),(52,2,0,0,'Google e Citigroup investirão US$ 110 mi em energia eólica','O Google e o Citigroup investirão cada um US$ 55 milhões no projeto Alta 4, da Terra-Gen Power, capaz de gerar 102 megawatts de energia na Califórnia, afirmaram as companhias.\nO projeto deve se tornar um dos maiores geradores de energia eólica dos Estados Unidos --com capacidade de abastecer 450 mil casas.\nA Terra-Gen Power, que trabalha com energia renovável, está construindo o projeto Awec (Alta Wind Energy Center), com capacidade de geração eólica de 1.550 MW, em várias fases, das quais cinco já foram concluídas.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/920379-google-e-citigroup-investirao-us-110-mi-em-energia-eolica.shtml\">Leia mais</a> (24/05/2011 - 20h08)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/920379-google-e-citigroup-investirao-us-110-mi-em-energia-eolica.shtml','2011-05-24 23:08:00'),(53,2,0,0,'Mesmo sem acordo, votação do Código Florestal deve sair hoje','Após idas e vindas da Casa Civil, o líder do governo na Câmara, Cândido Vaccarezza (PT-SP), disse que a reforma do Código Florestal será votada na noite desta terça-feira sem acordo entre o Palácio do Planalto e os líderes da base aliada.\nSegundo Vaccarezza, o governo vai orientar para que a base derrube a emenda que será apresentada pelo PMDB que consolida as APPs (área de preservação permanente) e autoriza a participação dos Estados no processo de regularização ambiental.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920240-mesmo-sem-acordo-votacao-do-codigo-florestal-deve-sair-hoje.shtml\">Leia mais</a> (24/05/2011 - 17h41)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920240-mesmo-sem-acordo-votacao-do-codigo-florestal-deve-sair-hoje.shtml','2011-05-24 20:41:00'),(54,2,0,0,'Fungo brasileiro está entre as espécies mais significativas de 2010','Um fungo que emite luz, uma sanguessuga com dentes gigantes batizada de &quot;T-rex&quot; e uma barata saltadora são alguns dos integrantes da lista com dez novas espécies consideradas mais significativas de 2010.\nO Estado de São Paulo representa o Brasil com um pequeno fungo encontrado no interior da Mata Atlântica. Com caules forrados por uma espécie de gel, a espécie emite uma constante e brilhante luz verde-amarelada.\n<table>\n<tr>\n<td>Arizona State University</td>\n</tr>\n<tr>\n<td><a href=\"http://fotografia.folha.uol.com.br/galerias/3007-fungo-brasileiro-esta-entre-as-especies-mais-significativas-de-2010\"><img src=\"http://f.i.uol.com.br/folha/ciencia/images/11144461.jpeg\" alt=\"Fungo bioluminescente descoberto pela USP possui camada de gel que emite luz verde-amarelada; veja galeria de fotos\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://fotografia.folha.uol.com.br/galerias/3007-fungo-brasileiro-esta-entre-as-especies-mais-significativas-de-2010\">Fungo bioluminescente descoberto pela USP possui camada de gel que emite luz verde-amarelada; veja galeria de fotos</a> </td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/920200-fungo-brasileiro-esta-entre-as-especies-mais-significativas-de-2010.shtml\">Leia mais</a> (24/05/2011 - 17h18)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/920200-fungo-brasileiro-esta-entre-as-especies-mais-significativas-de-2010.shtml','2011-05-24 20:18:00'),(55,2,0,0,'Dilma recebe ex-ministros que são contra texto de lei florestal','Os oito ex-ministros de Meio Ambiente que vieram a Brasília pedir o adiamento da votação na Câmara dos Deputados do novo Código Florestal foram recebidos no final desta manhã (24) pela presidente Dilma Rousseff.\nAo final do encontro, eles declararam que Dilma acredita que o aumento do desmatamento está relacionado &quot;à expectativa de aprovação&quot; do novo Código Florestal. O texto em discussão na Câmara anistia produtores rurais que desmataram no passado.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Leia mais</a> (24/05/2011 - 13h53)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml','2011-05-24 16:53:00'),(56,2,0,0,'Relator do Código Florestal critica ex-ministros de Meio Ambiente','O relator do novo Código Florestal, Aldo Rebelo (PC do B-SP), distribuiu críticas aos ex-ministros de Meio Ambiente que estão em Brasília desde segunda-feira (23) para tentar o adiamento da votação do texto na Câmara.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nAo chegar para uma reunião com os ministros Antonio Palocci (Casa Civil) e Luiz Sérgio (Relações Institucionais), Rebelo chamou a carta enviada pelos ex-titulares à presidente Dilma Rousseff de &quot;abaixo-assinado&quot;. Criticou ainda os ex-ministros Carlos Minc e Marina Silva (governo Lula) e Zequinha Sarney (governo Fernando Henrique Cardoso).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Leia mais</a> (24/05/2011 - 13h47)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml','2011-05-24 16:47:00'),(57,2,0,0,'Líder extrativista do PA é morto; Dilma ordena investigação','A presidente Dilma Rousseff foi comunicada nesta terça-feira pelos ex-ministros de Meio Ambiente do assassinato, no Pará, de um líder extrativista e sua mulher.\nEla determinou que o ministro da Justiça, José Eduardo Cardozo, mobilize a Polícia Federal para investigar a morte, que está sendo comparada à da missionária Dorothy Stang, assassinada há seis anos em Anapu (PA).\nJosé Claudio Ribeiro da Silva e a mulher, Maria do Espírito Santo da Silva, foram mortos hoje no Assentamento Agroextrativista Praialtapiranheira, no município de Nova Ipixuna, próximo a Marabá.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920120-lider-extrativista-do-pa-e-morto-dilma-ordena-investigacao.shtml\">Leia mais</a> (24/05/2011 - 13h31)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/920120-lider-extrativista-do-pa-e-morto-dilma-ordena-investigacao.shtml','2011-05-24 16:31:00'),(58,2,0,0,'Impasse regimental impede votação do Código Florestal, diz Rebelo','Relator da reforma do Código Florestal, o deputado Aldo Rebelo (PC do B-SP) afirmou nesta terça-feira que um impasse regimental ainda não permite que o texto seja colocado em votação no plenário da Câmara.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Governo cede para votar nova lei florestal nesta terça-feira</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nDesde o início da manhã, a Casa já realiza sessão para analisar o texto.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Leia mais</a> (24/05/2011 - 13h05)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml','2011-05-24 16:05:00'),(59,2,0,0,'Governo cede para votar nova lei florestal nesta terça-feira','Para costurar um acordo com a base aliada na Câmara sobre o Código Florestal, o governo recuou em um dos principais pontos da reforma: aceitou flexibilizar a regra das APPs (áreas de preservação ambiental) em propriedades de agricultura familiar.\n<a href=\"http://www1.folha.uol.com.br/ambiente/920128-dilma-recebe-ex-ministros-que-sao-contra-texto-de-lei-florestal.shtml\">Dilma recebe ex-ministros que são contra texto de lei florestal</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920124-relator-do-codigo-florestal-critica-ex-ministros-de-meio-ambiente.shtml\">Relator do Código Florestal critica ex-ministros de Meio Ambiente</a><br/>\n<a href=\"http://www1.folha.uol.com.br/ambiente/920106-impasse-regimental-impede-votacao-do-codigo-florestal-diz-rebelo.shtml\">Impasse regimental impede votação do Código Florestal, diz Rebelo</a><br/>\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://aovivo.folha.uol.com.br/tvfolha/index.shtml\">Deputados discutem o novo Código Florestal; acompanhe</a>\nO recuo foi considerado uma &quot;evolução&quot; pelo relator do texto, deputado Aldo Rebelo (PCdoB-SP).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml\">Leia mais</a> (24/05/2011 - 11h53)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/920073-governo-cede-para-votar-nova-lei-florestal-nesta-terca-feira.shtml','2011-05-24 14:53:00'),(60,2,0,0,'Imagens da Nasa mostram vulcões em erupção vistos do espaço','Imagens feitas por satélites da Nasa, a agência espacial americana, mostram a atividade do vulcão Grimsvotn, na Islândia, que entrou em erupção no último sábado, e ajudam a mostrar a dimensão e o impacto do fenômeno.\nA erupção do Grimsvotn já provocou o cancelamento de centenas de voos na Europa.\nNo ano passado, as cinzas de outro vulcão islandês, o Eyjafjallajokull, provocaram o cancelamento de cerca de 100 mil voos na Europa ao longo de quase um mês, gerando um prejuízo estimado em US$ 1,7 bilhão (cerca de R$ 2,75 bilhões).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920048-imagens-da-nasa-mostram-vulcoes-em-erupcao-vistos-do-espaco.shtml\">Leia mais</a> (24/05/2011 - 10h45)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/920048-imagens-da-nasa-mostram-vulcoes-em-erupcao-vistos-do-espaco.shtml','2011-05-24 13:45:00'),(61,2,0,0,'Acusada de promover safáris de onça é multada em R$ 115 mil','A pecuarista Beatriz Rondon, acusada de abrigar em sua fazenda no Pantanal de Mato Grosso do Sul um esquema de <a href=\"http://www1.folha.uol.com.br/cotidiano/912479-video-leva-pf-a-apreender-cranios-de-onca-e-armas-em-ms.shtml\">safáris ilegais</a> de onças e outros animais silvestres, recebeu uma multa do Ibama no valor de R$ 115 mil.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-video-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://www1.folha.uol.com.br/cotidiano/912479-video-leva-pf-a-apreender-cranios-de-onca-e-armas-em-ms.shtml\"><b>PF apreende crânios de onça e armas</b></a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/771291-ibama-multa-suspeitos-de-organizar-safaris-para-cacar-oncas-no-pantanal.shtml\">Ibama multa suspeitos de organizar safáris</a>\nAlvo da Operação Jaguar 2, deflagrada pelo Ibama e a Polícia Federal no dia 5, a pecuarista já havia sido multada anteriormente em R$ 105 mil por caça ilegal e abate de animais ameaçados de extinção.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919830-acusada-de-promover-safaris-de-onca-e-multada-em-r-115-mil.shtml\">Leia mais</a> (23/05/2011 - 19h48)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/919830-acusada-de-promover-safaris-de-onca-e-multada-em-r-115-mil.shtml','2011-05-23 22:48:00'),(62,2,0,0,'O não acordo','Na falta de um consenso mínimo sobre os pontos principais do novo Código Florestal, o Palácio do Planalto, os ambientalistas, os 10 ex-ministros do Meio Ambiente, o PT, o PV e o PSOL jogaram a toalha e decidiram votar logo na Câmara como estava. Depois é depois. Ou melhor: depois se vê o que se faz.\nFoi assim que o texto do relator Aldo Rebelo (PC do B-SP) foi aprovado na noite de terça-feira, com todos exaustos e uma sensação de alívio. Os que mais comemoraram foram os ruralistas e os que pregavam um equilíbrio entre a necessidade de preservação do meio ambiente e a necessidade de preservação também dos pequenos produtores.\nComo Aldo está rouco de repetir, dos 5,2 milhões de produtores brasileiros, 4,3 milhões são pequenos, aqueles sujeitos que dão um duro danado para ter sua plantação, fornecer comida à população e garantir a sobrevivência mais ou menos digna deles próprios e das suas famílias.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/colunas/elianecantanhede/920604-o-nao-acordo.shtml\">Leia mais</a> (25/05/2011 - 11h14)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/colunas/elianecantanhede/920604-o-nao-acordo.shtml','2011-05-25 14:14:00'),(63,1,0,0,'Gradle Trick – Escopo Provided','<p>Eu tenho brincado bastante com <a href=\"http://gradle.org\" target=\"_blank\">gradle</a> (pretendo migrar todos meus projetos maven para ele).</p>\n<p>Uma das coisas que precisei recentemente foi de algo semelhante ao escopo provided do maven. Aparentemente a <a href=\"http://issues.gradle.org/browse/GRADLE-784\" target=\"_blank\">versão 1.0 terá suporte</a>, mas&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/mKnvMG92ctM/','2011-06-08 19:08:00'),(64,2,0,0,'Complexo turístico gigante no Egito ameaça aves e fósseis','Um projeto de complexo turístico de proporções gigantescas ameaça a reserva natural do lago Qarun, no oásis de Al Fayoum, ao sul do Cairo, onde vivem milhares de aves e se encontram fósseis e jazidas arqueológicas ainda não estudados.\nOs ambientalistas, que defendem o turismo sustentável na região, veem com suspeita este projeto depois que o governo do ex-presidente Hosni Mubarak cedeu, em dezembro do ano passado, 2,8 quilômetros quadrados de terreno junto ao lago à construtora Amre Group por US$ 0,01 por metro quadrado.\n<table>\n<tr>\n<td>Zorbey Tunçer - 1º.ago.2008/Creative Commons</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/turismo/images/11164682.jpeg\" alt=\"Oásis Faiyum, região onde fica o lago Qarum, ameaçado por projeto turístico, a cerca de 130 km a sul do Cairo, no Egito\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Oásis Faiyum, região onde fica o lago Qarum, ameaçado por projeto turístico, a cerca de 130 km a sul do Cairo, no Egito</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/929380-complexo-turistico-gigante-no-egito-ameaca-aves-e-fosseis.shtml\">Leia mais</a> (13/06/2011 - 18h17)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/929380-complexo-turistico-gigante-no-egito-ameaca-aves-e-fosseis.shtml','2011-06-13 18:17:00'),(65,2,0,0,'Datafolha indica que 80% rejeitam corte de proteção a matas','Uma pesquisa encomendada pelas principais organizações ambientalistas do país diz que cerca de 80% da população não aprova as mudanças no Código Florestal.\nA nova versão dessa lei, que determina as áreas de mata que devem ser preservadas em propriedades rurais, foi aprovada no mês passado pela Câmara e agora aguarda votação no Senado.\nEntre as mudanças no código estão, por exemplo, a isenção de reserva legal (proporção de uma fazenda que não pode ser desmatada) para pequenas propriedades, de até 400 hectares.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/929142-datafolha-indica-que-80-rejeitam-corte-de-protecao-a-matas.shtml\">Leia mais</a> (13/06/2011 - 11h37)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/929142-datafolha-indica-que-80-rejeitam-corte-de-protecao-a-matas.shtml','2011-06-13 11:37:00'),(66,2,0,0,'Ambientalistas colocam barco de tetra pak em canal alemão','Um barco com nove metros de comprimento, fabricado com embalagens do tipo tetra pak, flutuou nesta segunda-feira pelo canal de Karl-Heine, na cidade alemã de Leipzig.\nO artista conceitual Frank Boelter, que idealizou o embarcação, disse que as embalagens simbolizam o fim da Era Industrial e, ao mesmo tempo, criticam a mentalidade do desperdício.\nSegundo os organizadores do evento, o ato serve para pedir pelo retorno da topografia fluvial original em regiões urbanas.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/929171-ambientalistas-colocam-barco-de-tetra-pak-em-canal-alemao.shtml\">Leia mais</a> (13/06/2011 - 11h37)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/929171-ambientalistas-colocam-barco-de-tetra-pak-em-canal-alemao.shtml','2011-06-13 11:37:00'),(67,2,0,0,'Águia pescando vence concurso de fotos de vida selvagem','O Museu Nacional de História Natural Smithsonian, em Washington (EUA), está exibindo fotos vencedoras do concurso anual Windland Smith Rice International Awards, da revista &quot;Nature\'s Best Photography&quot;, que escolhe as melhores imagens da vida selvagem ao redor do mundo.\nO concurso recebeu mais de 20 mil inscrições com imagens que capturam momentos únicos da vida selvagem em 56 países.\n<a href=\"http://fotografia.folha.uol.com.br/galerias/3235-concurso-global-de-imagens-da-vida-selvagem\">Veja galeria de fotos</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/929090-aguia-pescando-vence-concurso-de-fotos-de-vida-selvagem.shtml\">Leia mais</a> (13/06/2011 - 07h12)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/929090-aguia-pescando-vence-concurso-de-fotos-de-vida-selvagem.shtml','2011-06-13 07:12:00'),(68,2,0,0,'Avião movido a energia solar não consegue completar voo','O avião suíço Impulso Solar, que funciona por energia solar, deu meia volta neste sábado de volta a Bruxelas, devido a dificuldades durante o voo. Com isso, o objetivo de alcançar o aeroporto de Le Bourget, perto de Paris, não foi atingido, anunciou uma porta-voz à France Presse.\nA aeronave, que decolou da capital belga, teve de dar meia volta logo depois de entrar em território francês, segundo a porta-voz do Solar Impulse.\n&quot;Não há nenhuma pista de aterrissagem intermediária, e como as baterias de energia estavam diminuindo, preferimos dar meia volta para não colocar a vida do piloto [André Borschberg] em perigo&quot;, explicou a porta-voz.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/928792-aviao-movido-a-energia-solar-nao-consegue-completar-voo.shtml\">Leia mais</a> (11/06/2011 - 18h43)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/928792-aviao-movido-a-energia-solar-nao-consegue-completar-voo.shtml','2011-06-11 18:43:00'),(69,2,0,0,'Games: Zé Colméia apronta todas para salvar parque florestal','<table>\n<tr>\n<td>Divulgação</td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1165101/yogi-bear-the-video-game\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/1115890.jpeg\" alt=\"Yogi Bear (Zé Colméia) e Catatau devem salvar a floresta\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1165101/yogi-bear-the-video-game\">Yogi Bear (Zé Colméia) e Catatau devem salvar a floresta</a> </td>\n</tr>\n</table>\nO querido e malandro personagem <a href=\"http://livraria.folha.com.br/catalogo/1165101/yogi-bear-the-video-game\"><b>Zé Colméia</b></a> tem uma missão especial em seu jogo para Wii.\nO parque onde vive e costuma &quot;pegar emprestado&quot; algumas cestas de piquenique dos visitantes está para ser fechado, pois urbanistas loucos querem cortar todas as árvores e expulsar os animais dali para construir edifícios gigantes e avenidas sem fim. Para que isso não aconteça, você deve tomar o comando do Zé e viver aventuras em diversos cenários da floresta.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/926406-games-ze-colmeia-apronta-todas-para-salvar-parque-florestal.shtml\">Leia mais</a> (11/06/2011 - 11h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/926406-games-ze-colmeia-apronta-todas-para-salvar-parque-florestal.shtml','2011-06-11 11:00:00'),(70,2,0,0,'Relações de risco em &quot;Vizinho - o Pentelho que Mora ao Lado&quot;','<table>\n<tr>\n<td>Divulgação</td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1031010/vizinho-o-pentelho-mora-ao-lado\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/11159211.jpeg\" alt=\"Quando o assunto é vizinho, restam-lhe duas opções: chorar ou rir\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1031010/vizinho-o-pentelho-mora-ao-lado\">Quando o assunto é vizinho, restam-lhe duas opções: chorar ou rir</a> </td>\n</tr>\n</table>\nO tema é recorrente e sempre atual. No que consta, desde os tempos bíblicos há implicâncias e desafetos com a pessoa da porta ao lado, seja lá quais forem os motivos, pois numericamente falando, eles são praticamente infinitos.\nPara analisar de uma ótica muito particular a tendência humana de se desentender com o próximo, o humorista Castelo (codinome resumido de Carlos Antônio de Melo e Castelo Branco) enumera de forma escrachada personagens e situações que uma ora ou outra o leitor vai conhecer ou vivenciar no livro <a href=\"http://livraria.folha.com.br/catalogo/1031010/vizinho-o-pentelho-mora-ao-lado\"><b>&quot;Vizinho - o Pentelho que Mora ao Lado&quot;</b></a>.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/926999-relacoes-de-risco-em-vizinho---o-pentelho-que-mora-ao-lado.shtml\">Leia mais</a> (10/06/2011 - 14h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/926999-relacoes-de-risco-em-vizinho---o-pentelho-que-mora-ao-lado.shtml','2011-06-10 14:00:00'),(71,2,0,0,'Mudança climática reduzirá água disponível para agricultura','A FAO (Organização das Nações Unidas para Agricultura e Alimentação) advertiu nesta quinta-feira que a mudança climática terá graves consequências na disponibilidade de água destinada à produção de alimentos e na produtividade dos cultivos durante as próximas décadas.\nEstas são algumas das conclusões do estudo &quot;Mudança climática, água e segurança alimentar&quot;, elaborado pela FAO, segundo informou a agência em comunicado divulgado hoje em Roma.\nO relatório indica que deve haver uma aceleração do ciclo hidrológico do planeta, já que a alta das temperaturas elevará a taxa de evaporação de água da terra e do mar.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927859-mudanca-climatica-reduzira-agua-disponivel-para-agricultura.shtml\">Leia mais</a> (09/06/2011 - 19h02)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927859-mudanca-climatica-reduzira-agua-disponivel-para-agricultura.shtml','2011-06-09 19:02:00'),(72,2,0,0,'Empresa propõe acabar com camelos para controlar efeito estufa','Uma empresa australiana apresentou uma proposta inovadora contra as emissões poluentes: matar toda a população de camelos do país, já que seus gases contribuem para o efeito estufa.\nCada camelo emite cerca de 45 kg de gás metano por ano, que equivale a uma tonelada de dióxido de carbono.\nEmbora seja considerada como uma missão impossível, erradicar a população de cerca de 1,2 milhão de camelos seria igual a tirar de circulação 300 mil carros que percorrem cerca de 20 mil km anuais.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927848-empresa-propoe-acabar-com-camelos-para-controlar-efeito-estufa.shtml\">Leia mais</a> (09/06/2011 - 18h44)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927848-empresa-propoe-acabar-com-camelos-para-controlar-efeito-estufa.shtml','2011-06-09 18:44:00'),(73,2,0,0,'China descobre novas cavernas de gelo; assista vídeo','Pesquisadores anunciaram ter descoberto o maior aglomerado de cavernas de gelo da China nas montanhas da província de Shanxi, no norte do país.\n<a href=\"http://www.bbc.co.uk/worldservice/emp/pop.shtml?l=pt&amp;t=video&amp;r=1&amp;p=/portuguese/meta/dps/2011/06/emp/110609_chinacavernasebc.emp.xml\">Veja vídeo</a>\nEm meio à natureza exuberante, com temperaturas exteriores beirando os 22ºC, os cinco conjuntos de cavernas se espalham por uma área de 35 quilômetros quadrados.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/927734-china-descobre-novas-cavernas-de-gelo-assista-video.shtml\">Leia mais</a> (09/06/2011 - 17h24)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/927734-china-descobre-novas-cavernas-de-gelo-assista-video.shtml','2011-06-09 17:24:00'),(74,2,0,0,'China inaugura centro internacional para proteção de pandas','Um centro internacional de pesquisa para a preservação do urso panda gigante e de outras espécies em extinção foi inaugurado na província de Sichuan, no sudoeste da China, informa nesta quinta-feira o jornal oficial &quot;China Daily&quot;.\nO Centro Internacional para a Conservação do Urso Panda Gigante é um projeto conjunto patrocinado pela base de pesquisas de pandas da cidade de Chengdu e pela fundação americana Global Cause.\nOs recursos, a tecnologia e as verbas locais e internacionais serão somadas para abordar ameaças contra a subsistência e desenvolvimento dos pandas e de outras espécies em extinção, disse o diretor da base de Chengdu, Zhang Zhihe.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/927673-china-inaugura-centro-internacional-para-protecao-de-pandas.shtml\">Leia mais</a> (09/06/2011 - 15h47)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/927673-china-inaugura-centro-internacional-para-protecao-de-pandas.shtml','2011-06-09 15:47:00'),(75,2,0,0,'Bolha construída por aranha mergulhadora funciona como \'guelra\'','A teia que aranhas mergulhadoras constroem e enchem de ar para formar uma bolha funciona como uma guelra de peixe, permitindo que os aracnídeos permaneçam embaixo da água por longos períodos de tempo, um estudo revelou.\n<table>\n<tr>\n<td>Stephan Hetz/BBC</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/ciencia/images/11160273.jpeg\" alt=\"Bolha de ar construída por aranha mergulhadora funciona como \'guelra\'\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Bolha de ar de aranha mergulhadora funciona como \'guelra\'</td>\n</tr>\n</table>\nA espécie, conhecida como Argyroneta aquatica, habita pequenos lagos e riachos de pouca correnteza na Europa e Ásia.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/927551-bolha-construida-por-aranha-mergulhadora-funciona-como-guelra.shtml\">Leia mais</a> (09/06/2011 - 13h27)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/927551-bolha-construida-por-aranha-mergulhadora-funciona-como-guelra.shtml','2011-06-09 13:27:00'),(76,2,0,0,'Governo prorroga decreto que adia punição a desmatador','A Presidência da República confirmou nesta quinta-feira que a presidente Dilma Rousseff assinou hoje a prorrogação por 180 dias do prazo para averbação de reserva legal, estendendo o prazo do decreto que vencia em 11 de junho.\nSegundo a Presidência, a definição da nova data atende à solicitação de lideranças partidárias no Senado. A Casa recebeu há poucas semanas o texto do Código Florestal aprovado pela Câmara.\nA prorrogação do texto impede multas e sanções aos produtores que não estejam cumprindo o Código Florestal em suas fazendas.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927605-governo-prorroga-decreto-que-adia-punicao-a-desmatador.shtml\">Leia mais</a> (09/06/2011 - 13h12)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927605-governo-prorroga-decreto-que-adia-punicao-a-desmatador.shtml','2011-06-09 13:12:00'),(77,2,0,0,'Amor aos animais levou empresária a cozinhar para cães','<table>\n<tr>\n<td>Divulgação</td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1167606/cao-gourmet\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/11146190.jpeg\" alt=\"Volume reúne receitas culinárias criadas especialmente para cães\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1167606/cao-gourmet\">Volume reúne receitas culinárias criadas especialmente para cães</a> </td>\n</tr>\n</table>\nEspecialista em culinária saudável e apaixonada por cachorros, a empresária Myrian Abicair, dona de um spa, compilou sua experiência de cozinhar para seus animais no livro <a href=\"http://livraria.folha.com.br/catalogo/1167606/\"><b>&quot;Cão Gourmet: Receitas Caseiras e Saudáveis para seu Cão&quot;</b></a> (Cook Lovers, 2011), escrito com a supervisão de veterinários.\nDe acordo com a mestre cuca, a ascendência árabe a aproximou dos vegetais. Quando começou a cultivar verduras e legumes orgânicos para vender, passou a utilizar sobras de talos e folhagens para complementar a alimentação dos 20 cães que criava no momento.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/927076-amor-aos-animais-levou-empresaria-a-cozinhar-para-caes.shtml\">Leia mais</a> (09/06/2011 - 13h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/927076-amor-aos-animais-levou-empresaria-a-cozinhar-para-caes.shtml','2011-06-09 13:00:00'),(78,2,0,0,'PV pede explicações à ministra sobre redução de parques no Pará','O PV pediu na noite desta quarta-feira (8) explicações à ministra Izabella Teixeira (Meio Ambiente) sobre o plano do governo de reduzir sete unidades de conservação no Pará para permitir a construção das hidrelétricas do complexo Tapajós.\nO requerimento foi protocolado na Câmara pela deputada verde Rosane Ferreira (PR), após a intenção do governo ter sido detalhada em reportagem da <b>Folha</b>.\nDocumentos internos do ICMBio (Instituto Chico Mendes para a Conservação da Biodiversidade) mostram que a redução de dois parques nacionais, quatro florestas nacionais e uma área de proteção ambiental no mosaico da BR-163/Terra do Meio, o maior conjunto de áreas protegidas do país, foi pedida em janeiro pela Eletronorte sem estudos técnicos prévios. Os chefes de todas as sete unidades se opõem ao projeto.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927554-pv-pede-explicacoes-a-ministra-sobre-reducao-de-parques-no-para.shtml\">Leia mais</a> (09/06/2011 - 11h31)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/927554-pv-pede-explicacoes-a-ministra-sobre-reducao-de-parques-no-para.shtml','2011-06-09 11:31:00'),(79,1,0,0,'Gradle Tricks – Install, Daemon e Dependencies','<p>Usando maven em outros projetos? Sem problemas.</p>\n<pre><code>\ngradle install\n</code></pre>\n<p>Faz algo semelhante ao mvn install. Gera e copia os jars para a sua cache do maven no <em>~/.m2</em>.<br />\nVocê precisa do <a href=\"http://www.gradle.org/maven_plugin.html\" target=\"_blank\">maven plugin</a> para isso funcionar.&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/rLS7Nt-uya8/','2011-06-15 07:00:00'),(80,2,0,0,'Justiça do Chile suspende construção de hidrelétricas na Patagônia','Um tribunal chileno ordenou a suspensão do projeto de Hidroaysen, que prevê a construção de cinco represas na Patagônia chilena, acolhendo três recursos apresentados por parlamentares e associações ambientalistas, segundo comunicado do Poder Judiciário.\n&quot;O tribunal de alçada acolheu uma ordem apresentada contra a resolução aprovada, o que significa que o projeto ficará paralisado até que se resolva o fundo da questão&quot;, informou a Justiça em comunicado.\nCm esta resolução, do tribunal da cidade chilena de Puerto Montt, no sul, o empreendimento hidroelétrico, com tramitação ambiental já aprovada pelo governo, fica suspenso até se esgotarem os recursos.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mundo/932484-justica-do-chile-suspende-construcao-de-hidreletricas-na-patagonia.shtml\">Leia mais</a> (20/06/2011 - 14h34)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mundo/932484-justica-do-chile-suspende-construcao-de-hidreletricas-na-patagonia.shtml','2011-06-20 14:34:00'),(81,2,0,0,'Empresa aposta em viagem Paris-Tóquio sem poluir','Em 2050, os passageiros vão viajar a bordo de aviões-foguetes no trajeto de duas horas e meia entre Paris e Tóquio e sem emitir poluentes, já que os voos serão na estratosfera. Pelo menos esse é o projeto do EADS, grupo de aeronáutica europeu.\nDesde o trágico fim do Concorde, em 2000, a ideia de um avião de alta velocidade parecia abandonada. Os construtores porém, buscam projetar aviões mais leves que possam consumir menos combustíveis, cujo preço disparou.\n<a href=\"http://fotografia.folha.uol.com.br/galerias/3338-empresa-aposta-em-viagem-paris-toquio-sem-poluir\">Veja galeria de fotos</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/932478-empresa-aposta-em-viagem-paris-toquio-sem-poluir.shtml\">Leia mais</a> (20/06/2011 - 14h22)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/932478-empresa-aposta-em-viagem-paris-toquio-sem-poluir.shtml','2011-06-20 14:22:00'),(82,2,0,0,'Menina reúne US$ 200 mil para golfo do México vendendo desenhos','Uma menina de 11 anos conseguiu levantar US$ 200 mil (R$ 320 mil) em um ano com a venda de desenhos e pinturas de aves para a recuperação do golfo do México após o vazamento de petróleo na região, em 2010, considerado o pior desastre ambiental da história dos Estados Unidos.\n<a href=\"http://fotografia.folha.uol.com.br/galerias/3335-menina-de-11-anos-levanta-us-200-mil-para-golfo-do-mexico-vendendo-desenhos\">Veja galeria de fotos</a>\nOlivia Bouler, do Estado de Nova York, escreveu para a ONG de preservação ambiental Audubon Society perguntando se podia ajudar.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/932331-menina-reune-us-200-mil-para-golfo-do-mexico-vendendo-desenhos.shtml\">Leia mais</a> (20/06/2011 - 08h21)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/932331-menina-reune-us-200-mil-para-golfo-do-mexico-vendendo-desenhos.shtml','2011-06-20 08:21:00'),(83,2,0,0,'Ranking indica países mais expostos a catástrofes naturais','Pequenas, idílicas e desprotegidas: Vanuatu e Tonga, ilhas localizadas no Pacífico, são os dois países mais expostos ao risco de acidentes naturais trazido pelas mudanças do clima. O dado consta no novo Relatório de Risco Mundial, um índice criado pelo Instituto de Meio Ambiente e Segurança Humana da Universidade das Nações Unidas, apresentando em Bonn nesta semana.\nO estudo analisou 173 países e considerou aspectos ambientais e humanos, como exposição a catástrofes naturais provocadas pelo clima e vulnerabilidade social.\nO índice também avaliou fatores econômicos, assim como aspectos governamentais, todos considerados decisivos para evitar que um evento natural, como terremoto ou enchente, se transforme numa catástrofe. Segundo o ranking, as Filipinas são o terceiro país com risco mais elevado.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/dw/930906-ranking-indica-paises-mais-expostos-a-catastrofes-naturais.shtml\">Leia mais</a> (18/06/2011 - 07h43)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/dw/930906-ranking-indica-paises-mais-expostos-a-catastrofes-naturais.shtml','2011-06-18 07:43:00'),(84,2,0,0,'Flutuar no mar Morto pode não ser mais possível em 40 anos','O mar Morto morre. A redução em 98% do volume do rio Jordão, que o abastece, e a exploração industrial desenfreada para extrair seus minerais ameaça fazer desaparecer uma formação única no mundo.\nDesfrutar da sensação de falta de gravidade produzida quando se flutua na água hipersalina deste balneário natural e untar o corpo com seu oleoso barro será um luxo do qual as próximas gerações não poderão gozar, segundo os especialistas.\n<table>\n<tr>\n<td>Menahem Kahana - 21.mai.2011/France Presse</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/turismo/images/11168741.jpeg\" alt=\"Israelenses e turistas aproveitam fim de semana no mar Morto\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Israelenses e turistas aproveitam fim de semana no mar Morto</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/931717-flutuar-no-mar-morto-pode-nao-ser-mais-possivel-em-40-anos.shtml\">Leia mais</a> (17/06/2011 - 19h51)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/931717-flutuar-no-mar-morto-pode-nao-ser-mais-possivel-em-40-anos.shtml','2011-06-17 19:51:00'),(85,2,0,0,'Desmate na caatinga caiu em 2009, mostra pesquisa','O desmatamento na caatinga atingiu 1.921 km<sup>2</sup> entre 2008 e 2009, segundo dados do Ministério do Meio Ambiente. Número representa queda em relação ao levantamento anterior, entre 2002 a 2008 e mostrou perda anual de 2.300 km<sup>2</sup>. A queda foi considerada insuficiente pelo governo.\nAtualmente, a área total desmatada da caatinga chega a quase 46% em relação à vegetação original. Mais de 376 mil km<sup>2</sup> foram destruídos, o que equivale à área superior à de todo o Estado do Goiás.\n<table>\n<tr>\n<td rowspan=\"3\"></td>\n<td>Jefferson Coppola/Folhapress</td>\n<td rowspan=\"3\"></td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/ambiente/images/11168708.jpeg\" alt=\"A área total desmatada da caatinga chega a quase 46% em relação à vegetação original\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>A área total desmatada da caatinga chega a quase 46% em relação à vegetação original</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931721-desmate-na-caatinga-caiu-em-2009-mostra-pesquisa.shtml\">Leia mais</a> (17/06/2011 - 19h48)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931721-desmate-na-caatinga-caiu-em-2009-mostra-pesquisa.shtml','2011-06-17 19:48:00'),(86,2,0,0,'Ban Ki-moon diz que desmatamento na Amazônia é problema global','O secretário-geral da ONU (Organização das Nações Unidas) afirmou nesta sexta-feira que o desmatamento da Amazônia é um problema global, e não apenas do Brasil.\nNa véspera, o sul-coreano recebeu o apoio da presidente Dilma Rousseff à sua candidatura.\n<table>\n<tr>\n<td rowspan=\"3\"></td>\n<td>Sérgio Lima/Folhapress</td>\n<td rowspan=\"3\"></td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/mundo/images/11168361.jpeg\" alt=\"Secretário Geral da ONU, Ban Ki-moon é recebido pela ministra do Meio Ambiente, Izabella Teixeira\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Secretário Geral da ONU, Ban Ki-moon é recebido pela ministra do Meio Ambiente, Izabella Teixeira</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931599-ban-ki-moon-diz-que-desmatamento-na-amazonia-e-problema-global.shtml\">Leia mais</a> (17/06/2011 - 18h28)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931599-ban-ki-moon-diz-que-desmatamento-na-amazonia-e-problema-global.shtml','2011-06-17 18:28:00'),(87,2,0,0,'Encontro da ONU para salvar Protocolo de Kyoto não avança','Em duas semanas de conversações, que se encerram nesta sexta-feira, os negociadores obtiveram pouco progresso para salvar o Protocolo de Kyoto para combater as mudanças climáticas depois de 2012, disseram delegados.\n&quot;Quando você olha para o progresso... é muito irregular&quot;, disse Adrian Macey, da Nova Zelândia, ao presidir a sessão de negociações em Bonn, na Alemanha, envolvendo 180 países sobre o Protocolo de Kyoto, que corre o risco de acabar depois de 2012 por falta de apoio.\nNações em desenvolvimento acusaram os países ricos de renegar promessas feitas para prorrogar Kyoto, cujos termos comprometem atualmente cerca de 40 nações a cortar as emissões de gases causadores do efeito estufa até 2012.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931454-encontro-da-onu-para-salvar-protocolo-de-kyoto-nao-avanca.shtml\">Leia mais</a> (17/06/2011 - 14h49)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931454-encontro-da-onu-para-salvar-protocolo-de-kyoto-nao-avanca.shtml','2011-06-17 14:49:00'),(88,2,0,0,'CNBB apoia abaixo-assinado contra texto do Código Florestal','A exemplo da campanha da Ficha Limpa, a CNBB (Conferência Nacional dos Bispos do Brasil) vai incentivar um abaixo-assinado contra o atual texto do Código Florestal, que está em tramitação no Senado.\nOs bispos criticam dois pontos da proposta: a mudança nas regras para as APPs (Áreas de Preservação Permanente) e a chamada anistia aos desmatamentos antigos.\n&quot;Anistiar é um problema. Não é possível que todo esse desmatamento seja esquecido&quot;, afirmou dom Leonardo Steiner, secretário-geral da CNBB e bispo prelado de São Félix do Araguaia (MT).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931452-cnbb-apoia-abaixo-assinado-contra-texto-do-codigo-florestal.shtml\">Leia mais</a> (17/06/2011 - 14h47)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931452-cnbb-apoia-abaixo-assinado-contra-texto-do-codigo-florestal.shtml','2011-06-17 14:47:00'),(89,2,0,0,'Foto mostra bebê macaco de nove dias aos cuidados da mãe','Um zoológico de Hanover, na Alemanha, divulgou a foto de uma mãe macaca cuidando do filhote de apenas nove dias.\nA mãe é um langur-de-hanuman, da espécie <i>Semnopitheaus entellus</i>, nativa do sul da Ásia.\n<table>\n<tr>\n<td rowspan=\"3\"></td>\n<td>Jochen Luebke/France Presse</td>\n<td rowspan=\"3\"></td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/bichos/images/11168180.jpeg\" alt=\"A macaca langur-de-hanuman é uma espécie nativa do sul da Ásia; na foto, a fêmea com o filhote\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>A macaca langur-de-hanuman é uma espécie nativa do sul da Ásia; na foto, a fêmea com o filhote</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/931353-foto-mostra-bebe-macaco-de-nove-dias-aos-cuidados-da-mae.shtml\">Leia mais</a> (17/06/2011 - 10h47)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/931353-foto-mostra-bebe-macaco-de-nove-dias-aos-cuidados-da-mae.shtml','2011-06-17 10:47:00'),(90,2,0,0,'Delta do Alasca lembra labirinto visto do espaço; veja foto','O satélite europeu Envisat divulgou nesta sexta-feira a imagem de um dos maiores deltas do mundo, o Yukon, que fica no Alasca. Vendo de cima do espaço, assemelha-se a um labirinto de rios antes de chegarem ao mar de Bering.\nA foto é, na verdade, uma combinação de três cliques da mesma área, que foram tirados em 2009 e 2010.\nA nascente do Yukon está localizada na Colúmbia Britânica, no Canadá, e percorre 3.190 quilômetros do Alasca.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931348-delta-do-alasca-lembra-labirinto-visto-do-espaco-veja-foto.shtml\">Leia mais</a> (17/06/2011 - 10h26)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/931348-delta-do-alasca-lembra-labirinto-visto-do-espaco-veja-foto.shtml','2011-06-17 10:26:00'),(91,2,0,0,'Jacaré é encontrado em lixo de cidade chinesa','A TV chinesa mostrou imagens de um jacaré que foi encontrado em uma lata de lixo na cidade de Chongqing.\nUma mulher que vasculhava o lixo achou o animal da espécie jacaré-da-china, que está ameaçada.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://www.bbc.co.uk/worldservice/emp/pop.shtml?l=pt&amp;t=video&amp;p=/portuguese/meta/dps/2011/06/emp/110617_jacare_china_rc.emp.xml\">Veja vídeo</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/931317-jacare-e-encontrado-em-lixo-de-cidade-chinesa.shtml\">Leia mais</a> (17/06/2011 - 10h16)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/931317-jacare-e-encontrado-em-lixo-de-cidade-chinesa.shtml','2011-06-17 10:16:00'),(92,2,0,0,'Região da Grande Rio despeja 1/3 de esgoto sem tratamento','A região metropolitana do Rio de Janeiro teve um avanço no que se refere à coleta e ao tratamento de esgoto nos últimos dez anos. No entanto, 31,5% do esgoto residencial produzido na Grande Rio ainda são jogados diretamente no ambiente e 19,3% das residências sequer têm acesso à rede coletora de esgoto, segundo dados de 2010.\nAs conclusões são do estudo &quot;Desafios do Saneamento em Metrópoles da Copa 2014: Estudo da Região Metropolitana do Rio de Janeiro&quot;, divulgado nesta quinta-feira pela FGV (Fundação Getulio Vargas).\nSegundo o coordenador do estudo, Fernando Garcia, o número de domicílios atendidos por rede de esgoto passou de 2,08 milhões em 2000 para 3,17 milhões em 2010, ou seja, um aumento de 53%.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/930934-regiao-da-grande-rio-despeja-13-de-esgoto-sem-tratamento.shtml\">Leia mais</a> (16/06/2011 - 15h35)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/930934-regiao-da-grande-rio-despeja-13-de-esgoto-sem-tratamento.shtml','2011-06-16 15:35:00'),(93,2,0,0,'Governo quer estimular recuperação de mata por produtor rural','O governo diz que vai se empenhar no Plano Agrícola e Pecuário 2011-2012, que será lançado na sexta-feira pela presidente Dilma Rousseff em Ribeirão Preto (a<br/>\n313 km de SP), para estimular os produtores rurais a recuperar cerca de 1,5 milhão de hectares de áreas degradadas.\nA meta é que nos próximos dez anos sejam recuperados 15 milhões de hectares para produção.\nA intenção é elevar a produção agropecuária evitando mais avanço sobre áreas de florestas. Atualmente, o país tem cerca de 47 milhões de hectares ocupados com a agricultura e 170 milhões de hectares usados para a pecuária.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/930932-governo-quer-estimular-recuperacao-de-mata-por-produtor-rural.shtml\">Leia mais</a> (16/06/2011 - 15h26)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/930932-governo-quer-estimular-recuperacao-de-mata-por-produtor-rural.shtml','2011-06-16 15:26:00'),(94,2,0,0,'Golfo do México terá o pior nível de oxigênio na água','As <a href=\"http://www1.folha.uol.com.br/mundo/913581-milhares-de-pessoas-sao-retiradas-de-suas-casas-devido-a-alta-do-rio-mississipi.shtml\">inundações</a> que ocorreram no vale do rio Mississipi, nos EUA, provocaram uma &quot;zona morta&quot;, com baixíssimo nível de oxigênio (O2), ao norte do golfo do México. Será o pior índice desde 2002, segundo o US Geological Survey, instituto de pesquisa geológica americano.\nA estimativa, a ser confirmada no segundo semestre, prevê a zona morta com uma área entre 22 mil e 24 mil quilômetros quadrados.\n<table>\n<tr>\n<td>Sean Gardner/Reuters</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/mundo/images/11134150.jpeg\" alt=\"Marca na parede indica até onde a água pode ir em caso de inundação; rio Mississipi afetou também o golfo do México\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Marca na parede indica até onde a água pode ir em caso de inundação; rio Mississipi afetou também o golfo do México</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/930904-golfo-do-mexico-tera-o-pior-nivel-de-oxigenio-na-agua.shtml\">Leia mais</a> (16/06/2011 - 14h22)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/930904-golfo-do-mexico-tera-o-pior-nivel-de-oxigenio-na-agua.shtml','2011-06-16 14:22:00'),(95,2,0,0,'Reflorestar não resolverá aquecimento global, afirma estudo','Apesar de as florestas serem importantes sumidouros de carbono, os projetos de reflorestamento só terão um impacto limitado no aquecimento global. O alerta parte de um estudo publicado na revista científica &quot;Nature Geoscience&quot;, no domingo (19).\nOs pesquisadores Vivek Arora, da Universidade de Victoria (Canadá), e Alvaro Montenegro, da Universidade de St. Francis Xavier (também no Canadá), desenvolveram cinco modelos de reflorestamento que cobrem de 2011 a 2060.\nOs cientistas examinaram seus efeitos no solo, na água e no ar, se a temperatura da superfície terrestre aumentasse 3º C em 2100 com relação aos níveis pré-industriais de 1850.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/932497-reflorestar-nao-resolvera-aquecimento-global-afirma-estudo.shtml\">Leia mais</a> (20/06/2011 - 14h58)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/932497-reflorestar-nao-resolvera-aquecimento-global-afirma-estudo.shtml','2011-06-20 14:58:00'),(96,2,0,0,'Para vice-premiê britânico, Brasil é &quot;superpotência ambiental&quot;','Em sua primeira escala no Brasil, o número 2 do governo britânico, Nick Clegg, reuniu-se com o governador de São Paulo, Geraldo Alckmin, para falar sobre possíveis parcerias na área de energias renováveis. Segundo o vice-primeiro-ministro, o Brasil pode ser considerado hoje uma &quot;superpotência ambiental&quot;, cujo exemplo deve ser seguido por outros países.\n&quot;A economia verde será um dos pilares da nova economia social, ambiental e sustentável que todos queremos construir. (...) E o Brasil apresenta liderança em energia elétrica, em etanol&quot;, disse Clegg, na abertura do Fórum &quot;Reino Unido e Brasil: uma parceria para desenvolver inovação em negócios verdes&quot;, no Palácio dos Bandeirantes, em São Paulo.\n<table>\n<tr>\n<td rowspan=\"3\"></td>\n<td>Nacho Doce/Reuters</td>\n<td rowspan=\"3\"></td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/mundo/images/11172213.jpeg\" alt=\"Vice-premiê Nick Clegg (à esq.) é recebido pelo governador Geraldo Alckmin em evento ambiental\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Vice-premiê Nick Clegg (à esq.) é recebido pelo governador Geraldo Alckmin em evento ambiental</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mundo/932978-para-vice-premie-britanico-brasil-e-superpotencia-ambiental.shtml\">Leia mais</a> (21/06/2011 - 12h20)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mundo/932978-para-vice-premie-britanico-brasil-e-superpotencia-ambiental.shtml','2011-06-21 12:20:00'),(97,2,0,0,'Ninhada de avestruz explora terreno após nascimento','Um fêmea de avestruz gerou nada menos do que 13 filhotinhos em um zoológico de Berlim, na Alemanha.\nA ninhada já pode ser vista explorando o terreno, sempre sob a supervisão atenta da mãe.\nA espécie de ave é nativa da África e está entre as que não voam.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/932930-ninhada-de-avestruz-explora-terreno-apos-nascimento.shtml\">Leia mais</a> (21/06/2011 - 10h31)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/932930-ninhada-de-avestruz-explora-terreno-apos-nascimento.shtml','2011-06-21 10:31:00'),(98,2,0,0,'Pinguim se perde na Antártida e para em praia da Nova Zelândia','Um pinguim-imperador da Antártida errou o caminho e apareceu em uma praia na Nova Zelândia. Esta é a primeira vez em 40 anos que um animal da espécie é visto no país.\nO pinguim, encontrado na segunda-feira (20) na costa de Kapiti, na ilha Norte, tem cerca de dez meses.\n<table>\n<tr>\n<td rowspan=\"3\"></td>\n<td>Richard Gill/Department of Conservation/Associated Press</td>\n<td rowspan=\"3\"></td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/ambiente/images/11172103.jpeg\" alt=\"&quot;Achei que estava vendo coisas&quot;, disse a mulher que avistou o pinguim-imperador (foto) na praia\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>&quot;Achei que estava vendo coisas&quot;, disse a mulher que avistou o pinguim-imperador (foto) na praia</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/932889-pinguim-se-perde-na-antartida-e-para-em-praia-da-nova-zelandia.shtml\">Leia mais</a> (21/06/2011 - 09h24)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/932889-pinguim-se-perde-na-antartida-e-para-em-praia-da-nova-zelandia.shtml','2011-06-21 09:24:00'),(99,2,0,0,'Químico que chegou mais perto do Nobel no país morre aos 90','Morreu na noite de domingo (19), no Rio de Janeiro, aos 90 anos, o químico naturalizado brasileiro Otto Richard Gottlieb, conhecido internacionalmente por seus trabalhos sobre produtos naturais e metabolismo de plantas.\nEle foi um dos primeiros grandes cientistas a chamar atenção para a sustentabilidade e a preservação de florestas, ainda na década de 1960.\nMais recentemente, nos anos de 1980, o químico mostrou a importância da manutenção dos entornos das florestas --justamente onde costuma ter início o processo de desmatamento.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/932761-quimico-que-chegou-mais-perto-do-nobel-no-pais-morre-aos-90.shtml\">Leia mais</a> (21/06/2011 - 08h51)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/932761-quimico-que-chegou-mais-perto-do-nobel-no-pais-morre-aos-90.shtml','2011-06-21 08:51:00'),(100,2,0,0,'Extinção da vida marinha pode ser sem precedentes, diz estudo','Um novo estudo indica que os ecossistemas marinhos enfrentam perigos ainda maiores do que os estimados até agora pelos cientistas e que correm risco de entrar em uma fase de extinção de espécies sem precedentes na história da humanidade.\nO levantamento vem de especialistas que integram o IPSO (sigla em inglês de Programa Internacional sobre o Estado dos Oceanos), entidade formada por cientistas e especialistas no assunto.\n<table>\n<tr>\n<td>IPSO/BBC</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/ciencia/images/11171370.jpeg\" alt=\"Substâncias poluidoras como plásticos, que estão sendo ingerido por peixes, contribuem com degradação\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Substâncias poluidoras como plásticos, que estão sendo ingerido por peixes, contribuem com degradação</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/932518-extincao-da-vida-marinha-pode-ser-sem-precedentes-diz-estudo.shtml\">Leia mais</a> (20/06/2011 - 15h49)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/932518-extincao-da-vida-marinha-pode-ser-sem-precedentes-diz-estudo.shtml','2011-06-20 15:49:00'),(101,2,0,0,'Usina de Belo Monte já faz desmate crescer em Altamira','O município de Altamira, no Pará, onde será construída a hidrelétrica de Belo Monte, foi o campeão de desmatamento na Amazônia em maio. Os dados são da ONG Imazon e podem refletir uma pressão sobre a floresta devido à expectativa de construção da usina, que recebeu licença de instalação no começo deste mês\nO SAD, sistema de monitoramento de desmatamento via satélite desenvolvido pelo Imazon, detectou um crescimento da devastação amazônica de 72% no mês passado em relação a maio de 2010. Em toda a região foram perdidos 165 quilômetros quadrados de floresta.\nHouve, porém, queda em relação a abril, quando o corte raso sofreu uma explosão de 362% e chegou a quase 300 quilômetros quadrados.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/932988-usina-de-belo-monte-ja-faz-desmate-crescer-em-altamira.shtml\">Leia mais</a> (21/06/2011 - 12h33)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/932988-usina-de-belo-monte-ja-faz-desmate-crescer-em-altamira.shtml','2011-06-21 12:33:00'),(102,2,0,0,'Japão descobre depósito de minerais raros no Pacífico','Pesquisadores japoneses dizem ter encontrado vastos depósitos de minerais de terras raras, utilizados em equipamentos de alta tecnologia, no solo do Oceano Pacífico.\nGeólogos estimam que existam atualmente 110 bilhões de toneladas de elementos raros no fundo do Pacífico.\nOs pesquisadores japoneses estimam ter encontrado entre 80 e 100 toneladas de minerais raros no leito oceânico a profundidades de entre 3,5 mil e 6 mil metros abaixo da superfície.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/938553-japao-descobre-deposito-de-minerais-raros-no-pacifico.shtml\">Leia mais</a> (04/07/2011 - 10h59)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/938553-japao-descobre-deposito-de-minerais-raros-no-pacifico.shtml','2011-07-04 10:59:00'),(103,2,0,0,'Extração de terras-raras no Pacífico pode reduzir danos ambientais na China','Algumas zonas do oceano Pacífico são muito ricas em terras-raras e poderiam constituir uma jazida inesperada destes metais necessários para a fabricação de produtos de alta tecnologia, revela um novo estudo.\nCarros elétricos, produtos eólicos, telas planas, discos rígidos de computadores e aparelhos de MP3: todos esses objetos indispensáveis precisam de terras-raras (17 metais, em particular o ítrio).\nAtualmente, 97% da produção de terras-raras procede de China, um país que possui um terço dos recursos mundiais e onde a extração desses minerais provoca grandes danos ao ambiente e aos moradores.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/938520-extracao-de-terras-raras-no-pacifico-pode-reduzir-danos-ambientais-na-china.shtml\">Leia mais</a> (04/07/2011 - 09h23)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/938520-extracao-de-terras-raras-no-pacifico-pode-reduzir-danos-ambientais-na-china.shtml','2011-07-04 09:23:00'),(104,2,0,0,'Material reciclado decora biblioteca infantil no Equador; veja','Do lixo à estante, esta é a ideia por trás da primeira biblioteca para crianças no Equador, na qual o uso de materiais reaproveitados mostra uma nova forma de fazer arquitetura, explicaram os responsáveis.\nCercas, poltronas, caixas de plástico e de madeira se transformam em móveis e objetos de decorações para este espaço exclusivo para crianças, aberto em um parque em Quito.\nO arquiteto espanhol Santiago Cirugeda, participante do projeto, disse que se trata de dar &quot;ordem ao lixo&quot;, pois foram utilizados materiais usados, que produzem uma menos perda de energia que um produto reciclável, já que não precisam de nenhuma transformação industrial, simplesmente de uma função diferente.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/multimidia/videocasts/937937-material-reciclado-decora-biblioteca-infantil-no-equador-veja.shtml\">Leia mais</a> (03/07/2011 - 18h33)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/multimidia/videocasts/937937-material-reciclado-decora-biblioteca-infantil-no-equador-veja.shtml','2011-07-03 18:33:00'),(105,2,0,0,'Salão do Turismo em julho vai destacar parques nacionais','Bastante procurado pelo público desde 2005, quando ocorreu pela primeira vez, o Salão do Turismo - Roteiros do Brasil vai destacar agora os parques nacionais.\n<a href=\"http://www1.folha.uol.com.br/turismo/937315-com-50-anos-parque-da-tijuca-oferece-circuito-de-atracoes.shtml\">Com 50 anos, parque da Tijuca oferece circuito de atrações</a><br/>\n<a href=\"http://www1.folha.uol.com.br/turismo/937353-replantado-ha-150-anos-parque-e-protetor-ecologico-do-rio.shtml\">Replantado há 150 anos, parque é protetor ecológico do Rio</a><br/>\n<a href=\"http://fotografia.folha.uol.com.br/galerias/3452-parque-da-tijuca#foto-68034\">Veja galeria de fotos do parque nacional da Tijuca</a>\nA sexta edição do evento terá lugar no Anhembi, em São Paulo, entre os dias 13 e 17 de julho.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/937730-salao-do-turismo-em-julho-vai-destacar-parques-nacionais.shtml\">Leia mais</a> (03/07/2011 - 08h30)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/937730-salao-do-turismo-em-julho-vai-destacar-parques-nacionais.shtml','2011-07-03 08:30:00'),(106,2,0,0,'Mato Grosso aprova lei para dar terra indígena a fazendeiros','O governo de Mato Grosso sancionou uma lei que autoriza o Estado a trocar com a União uma terra indígena por um parque estadual. Os índios se mudariam para o parque e sua terra ficaria com fazendeiros e posseiros que a ocupam ilegalmente.\nSe o ministro José Eduardo Cardozo (Justiça) acatar a ideia, será a primeira vez que um povo indígena é removido por um acordo desse tipo.\nA proposta foi feita no mês passado pelo governador Silval Barbosa (PMDB) a Cardoso. O peemedebista quer tirar 600 xavantes da terra indígena Marãiwatsédé (165 mil hectares), no nordeste do Estado, e entregar a área a 939 famílias de não índios.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/937960-mato-grosso-aprova-lei-para-dar-terra-indigena-a-fazendeiros.shtml\">Leia mais</a> (02/07/2011 - 10h15)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/937960-mato-grosso-aprova-lei-para-dar-terra-indigena-a-fazendeiros.shtml','2011-07-02 10:15:00'),(107,2,0,0,'Replantado há 150 anos, parque é protetor ecológico do Rio','A área que ocupa o parque da Tijuca completa 150 anos de replantio neste ano. Sim, replantado. De acordo com Loreto Figueira, bióloga e chefe do parque, quase toda a floresta da região havia sido devastada com os ciclos da madeira, da cana-de-açúcar e do café, entre os séculos 16 e 19.\n<a href=\"http://www1.folha.uol.com.br/turismo/937315-com-50-anos-parque-da-tijuca-oferece-circuito-de-atracoes.shtml\">Com 50 anos, parque da Tijuca oferece circuito de atrações</a><br/>\n<a href=\"http://www1.folha.uol.com.br/turismo/937363-parque-da-tijuca-se-diferencia-por-arqueologia-e-misticismo.shtml\">Parque da Tijuca se diferencia por arqueologia e misticismo</a><br/>\n<a href=\"http://fotografia.folha.uol.com.br/galerias/3452-parque-da-tijuca#foto-68034\">Veja galeria de fotos do parque nacional da Tijuca</a><br/>\n<a href=\"http://www.folha.com.br/tu937733\">Concurso busca música para homenagear Cristo Redentor</a><br/>\n<a href=\"http://www1.folha.uol.com.br/turismo/914531-aos-80-cristo-redentor-e-um-simbolo-do-brasil.shtml\">Aos 80, Cristo Redentor é um símbolo do Brasil</a>\nIsso teve consequências ambientais sobre o Rio --capital do país na época do Império--, como a falta de água, já que os rios passaram a secar. &quot;A floresta retém a água da chuva e mantém o manancial hídrico&quot;, explica a bióloga.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/937353-replantado-ha-150-anos-parque-e-protetor-ecologico-do-rio.shtml\">Leia mais</a> (02/07/2011 - 08h02)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/937353-replantado-ha-150-anos-parque-e-protetor-ecologico-do-rio.shtml','2011-07-02 08:02:00'),(108,2,0,0,'Rio+20 terá cúpula paralela de entidades da sociedade civil','Organizações da sociedade e movimentos ambientalistas se articulam para tentar influenciar as decisões da Conferência das Nações Unidas sobre Desenvolvimento Sustentável (Rio+20), que será realizada no Rio de Janeiro, em 2012.\nA ideia é reunir entidades para instalar a Cúpula dos Povos da Rio+20 por Justiça Social e Ambiental, que funcionará paralelamente à conferência. A cúpula também acompanhará os eventos preparatórios para a Rio+20.\nCerca de 150 entidades de 27 país querem garantir a aprovação de propostas para o fim de problemas ambientais que acentuam desigualdades sociais, além de chamar atenção para o mito da &quot;economia verde&quot;, segundo o representante dos povos indígenas Marcos Terena.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937882-rio20-tera-cupula-paralela-de-entidades-da-sociedade-civil.shtml\">Leia mais</a> (01/07/2011 - 19h11)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937882-rio20-tera-cupula-paralela-de-entidades-da-sociedade-civil.shtml','2011-07-01 19:11:00'),(109,2,0,0,'Brasil começa a definir temas para o Rio+20','O Brasil deverá defender, na Conferência das Nações Unidas sobre Desenvolvimento Sustentável (Rio+20), que ocorre no ano que vem, o desenvolvimento sustentável em conjunto com a erradicação da pobreza, afirmou nesta sexta-feira (1º) a ministra do Meio Ambiente, Izabella Teixeira.\n&quot;A ideia é trabalharmos sobre conteúdos. Temas que o Brasil quer formular no contexto da erradicação da pobreza, no contexto da economia verde e no arranjo adicional de governança e desenvolvimento sustentável&quot;, disse a ministra depois de deixar a reunião da Comissão Nacional da Rio+20.\nEsta foi a primeira vez que a comissão nacional se reuniu. O grupo vai discutir com órgãos do governo e com a sociedade civil os temas que serão tratados na Rio+20, em junho de 2012.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937880-brasil-comeca-a-definir-temas-para-o-rio20.shtml\">Leia mais</a> (01/07/2011 - 19h05)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937880-brasil-comeca-a-definir-temas-para-o-rio20.shtml','2011-07-01 19:05:00'),(110,2,0,0,'Guia completo que identifica aves brasileiras será lançado amanhã','O &quot;Guia Completo para Identificação das Aves do Brasil&quot;, em dois volumes, será lançado neste sábado (2), às 14h, no Museu de Zoologia da USP. A obra favorece os amantes da atividade de &quot;birdwatching&quot;, ou seja, a observação de aves pelo país.\nA publicação identifica todas as 2.907 espécies e subespécies de aves brasileiras, apresenta chaves de identificação para as ordens, famílias, gêneros, espécies e subespécies.\nPossui 2.800 ilustrações em cores e listagem com os nomes originais e sinônimos. Os <a href=\"https://www.ventoverde.com/site/guia-completo-para-identificacao-das-aves-do-brasil.html\">livros</a> custam R$ 480,00.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/937761-guia-completo-que-identifica-aves-brasileiras-sera-lancado-amanha.shtml\">Leia mais</a> (01/07/2011 - 18h09)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/937761-guia-completo-que-identifica-aves-brasileiras-sera-lancado-amanha.shtml','2011-07-01 18:09:00'),(111,2,0,0,'Pinguim que se perdeu não terá carona de volta para Antártida','A história do jovem pinguim-imperador que se perdeu e foi parar em uma praia na Nova Zelândia chega finalmente ao fim: o bicho sobreviveu e será solto no extremo sul do oceano Pacífico para que nade até a Antártida.\nCom isso, Happy Feet, como o pinguim passou a ser chamado, perdeu a sua carona e a chance de chegar em casa sem esforço.\nUma das ideias iniciais era levar o animal até a Antártida. Mas, além do problema de logística, havia a possibilidade de o pinguim-imperador ser infectado durante sua estada na Nova Zelândia, transmitindo alguma doença para outros pinguins.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937667-pinguim-que-se-perdeu-nao-tera-carona-de-volta-para-antartida.shtml\">Leia mais</a> (01/07/2011 - 15h57)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937667-pinguim-que-se-perdeu-nao-tera-carona-de-volta-para-antartida.shtml','2011-07-01 15:57:00'),(112,2,0,0,'Promotoria denuncia Usiminas por relatório irregular sobre CSA','O Ministério Público do Rio denunciou a Usiminas por apresentar auditoria ambiental considerado falsa e omissa sobre a operação parcial da CSA (Companhia Siderúrgica do Atlântico). O relatório seria usado no processo de licenciamento da siderúrgica, instalada na zona oeste do Rio.\n<a href=\"http://www1.folha.uol.com.br/cotidiano/933219-csa-deve-corrigir-problemas-ambientais-para-obter-licenca-no-rio.shtml\">CSA deve corrigir problemas ambientais para obter licença</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/927348-csa-e-denunciada-por-crimes-ambientais-pela-segunda-vez.shtml\">CSA é denunciada por crimes ambientais pela segunda vez</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/914049-minc-embarga-obras-e-ameaca-licenciamento-de-csa-no-rio.shtml\">Minc embarga obras e ameaça licenciamento de CSA no Rio</a>\nTambém foram denunciadas quatro pessoas que assinaram o documento: Bruno Menezes de Melo, Ricardo Salgado e Silva, Marta Russo Blazek e Monica Silveira e Consta Chang.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/937588-promotoria-denuncia-usiminas-por-relatorio-irregular-sobre-csa.shtml\">Leia mais</a> (01/07/2011 - 13h05)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/937588-promotoria-denuncia-usiminas-por-relatorio-irregular-sobre-csa.shtml','2011-07-01 13:05:00'),(113,2,0,0,'Ibama flagra uso de aviões em desmatamento na Amazônia','O Ibama identificou uma área de floresta amazônica, do tamanho de 180 campos de futebol, destruída pela ação de herbicidas.\nA terra, que pertence à União, fica ao sul do município amazonense de Canutama, na divisa com Rondônia. O responsável pelo crime ambiental ainda não foi identificado pelo órgão.\nEm sobrevoo de duas horas de helicóptero, na segunda semana de junho, analistas do Ibama observaram milhares de árvores em pé, mas desfolhadas e esbranquiçadas pela ação do veneno.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937477-ibama-flagra-uso-de-avioes-em-desmatamento-na-amazonia.shtml\">Leia mais</a> (01/07/2011 - 08h21)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937477-ibama-flagra-uso-de-avioes-em-desmatamento-na-amazonia.shtml','2011-07-01 08:21:00'),(114,2,0,0,'No verão, 25 cidades do Brasil terão sistema de alerta contra enchentes','Vinte e cinco cidades brasileiras vão ter, a partir deste verão, alertas contra enchentes e deslizamentos com até seis horas de antecedência.\nA promessa é do governo federal. Um decreto da presidente Dilma Rousseff editado hoje cria o Cemaden (Centro de Monitoramento e Alertas de Desastres Naturais), em Cachoeira Paulista (SP).\n<a href=\"http://polls.folha.com.br/poll/1118202/results\">Vote na enquete sobre alerta contra enchentes</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937462-no-verao-25-cidades-do-brasil-terao-sistema-de-alerta-contra-enchentes.shtml\">Leia mais</a> (01/07/2011 - 07h41)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/937462-no-verao-25-cidades-do-brasil-terao-sistema-de-alerta-contra-enchentes.shtml','2011-07-01 07:41:00'),(115,2,0,0,'Jararaca do Instituto Butantan terá o nome de Yubá','O filhote de jararaca-ilhoa do Instituto Butantan, na zona oeste de São Paulo, será chamado de Yubá, que significa &quot;amarelo&quot; em tupi-guarani.\nO nome foi escolhido pela internet e por urna colocada no prédio do Museu Biológico. Ao todo, 60 mil pessoas votaram durante duas semanas, tempo que durou o <a href=\"http://www1.folha.uol.com.br/bichos/930394-instituto-butantan-faz-votacao-para-escolher-nome-de-jararaca.shtml\">pleito</a>.\n&quot;A ação é para desmitificar o ser vivo serpente, que é associado a uma coisa ruim&quot;, comentou o diretor Giuseppe Puorto sobre a primeira votação on-line organizada pelo museu para batizar uma espécie.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/937215-jararaca-do-instituto-butantan-tera-o-nome-de-yuba.shtml\">Leia mais</a> (30/06/2011 - 22h20)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/937215-jararaca-do-instituto-butantan-tera-o-nome-de-yuba.shtml','2011-06-30 22:20:00'),(116,2,0,0,'Bebê tamanduá passeia nas costas da mãe','Um bebê de tamanduá que nasceu em março foi fotografado no Zoológico Edinburgh, na Escócia, nesta quinta-feira.\nA imagem mostra o filhote agarrado às costas da mãe, como é costume desses animais.\nAté os 18 meses de idade passam a maior parte do tempo montados. A cria ainda não tem nome.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/937261-bebe-tamandua-passeia-nas-costas-da-mae.shtml\">Leia mais</a> (30/06/2011 - 20h01)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/937261-bebe-tamandua-passeia-nas-costas-da-mae.shtml','2011-06-30 20:01:00'),(117,2,0,0,'Austrália prepara plano de US$ 3,2 bi para promover energias limpas','O governo australiano prepara um pacote de 3 bilhões de dólares locais (US$ 3,219 bilhões) para promover as energias limpas e financiar o fechamento das usinas de carvão, publicou nesta terça-feira a imprensa local.\nSegundo a proposta, as centrais obterão uma linha de crédito e garantias para seguir operando, mas deverão reduzir progressivamente tanto as emissões poluentes como sua capacidade, de acordo com o diário &quot;The Australian&quot;.\nFontes anônimas citadas pelo jornal indicaram que se não for implementado um fundo para financiar o fechamento das usinas elétricas de carvão e pagar pela redução de sua capacidade haverá &quot;falhas no sistema&quot; de abastecimento de energia no sudeste da Austrália.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/939008-australia-prepara-plano-de-us-32-bi-para-promover-energias-limpas.shtml\">Leia mais</a> (05/07/2011 - 01h47)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/939008-australia-prepara-plano-de-us-32-bi-para-promover-energias-limpas.shtml','2011-07-05 01:47:00'),(118,2,0,0,'Coleção apresenta temas das ciências biológicas e da saúde','Conheça alguns títulos da coleção <a href=\"http://livraria.folha.com.br/lista/?collection=Folha%20Explica\">&quot;Folha Explica&quot;</a> que apresentam temas importantes para as ciências biológicas e para a saúde. A série, composta por mais de 80 volumes breves, abrange de forma sintética diversas áreas do conhecimento e oferece condições para que o leitor fique bem informado. Cada livro resume o que de mais importante se sabe sobre o assunto.\n<table>\n<tr>\n<td>Divulgação</td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1011298/darwin\"><img src=\"http://f.i.uol.com.br/publifolha/images/0906619.jpg\" alt=\"Livro mostra como Darwin mudou o mundo com ideias revolucionárias\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1011298/darwin\">Livro mostra como Darwin mudou o mundo com ideias revolucionárias</a> </td>\n</tr>\n</table>\n<a href=\"http://livraria.folha.com.br/catalogo/1011298/darwin\"><b>&quot;Darwin&quot;</b></a> aborda questões essenciais dos mais de 150 anos de teoria da evolução por seleção natural, a grande contribuição do naturalista britânico para as ciências da vida e para o pensamento contemporâneo.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/907146-colecao-apresenta-temas-das-ciencias-biologicas-e-da-saude.shtml\">Leia mais</a> (04/07/2011 - 20h30)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/907146-colecao-apresenta-temas-das-ciencias-biologicas-e-da-saude.shtml','2011-07-04 20:30:00'),(119,2,0,0,'Capital da Dinamarca terá bairro em cima do oceano','Copenhague não tem mais para onde crescer sem invadir áreas verdes. Por isso, a prefeitura resolveu fazer um &quot;puxadinho&quot; no mar. A área será uma extensão de Nordhavnen, uma região portuária importante que fica no norte da Copenhague. Será o equivalente a 200 estádios de futebol construídos sobre o mar, por meio de aterros que criarão ilhotas.\nOs trechos habitados do arquipélago artificial serão cortados por canais e pontes.\nAs obras devem começar já neste ano. A previsão é que uma primeira parte fique pronta em 2025. Mas a conclusão do projeto deve acontecer somente em 2050.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/939653-capital-da-dinamarca-tera-bairro-em-cima-do-oceano.shtml\">Leia mais</a> (06/07/2011 - 10h57)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/939653-capital-da-dinamarca-tera-bairro-em-cima-do-oceano.shtml','2011-07-06 10:57:00'),(120,2,0,0,'Angra 3 vai custar quase R$ 10 bilhões e ficará pronta em 2015','Se não houver nenhum imprevisto pelo caminho, a usina de Angra 3 deve ficar pronta em 2015, três décadas após o início de sua construção. As obras devem custar R$ 9,95 bilhões, segundo a última revisão orçamentária feita pela Eletrosul, em junho de 2010.\nDe acordo com a Eletrosul, 70% dos gastos serão efetuados no país. O restante seria justamente a quantia pendente do financiamento indireto do governo alemão, por meio de subsídios à empresa que fornecerá equipamento à usina, a francesa Areva, que produzirá as peças na Alemanha, segundo a ONG Urgewald.\nO montante chegaria a 1,3 bilhão de euros (cerca de R$ 2,9 bilhões).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/939575-angra-3-vai-custar-quase-r-10-bilhoes-e-ficara-pronta-em-2015.shtml\">Leia mais</a> (06/07/2011 - 08h45)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/939575-angra-3-vai-custar-quase-r-10-bilhoes-e-ficara-pronta-em-2015.shtml','2011-07-06 08:45:00'),(121,2,0,0,'Vazamento de petróleo no Mar Amarelo pode causar danos a longo prazo','Os dois vazamentos de petróleo da estatal chinesa CNOOC na baía de Bohai, no Mar Amarelo, podem ser muito prejudiciais para a região a longo prazo, segundo especialistas citados pela agência oficial Xinhua.\n&quot;Devido ao frágil meio ambiente de Bohai --um mar fechado com limitada capacidade de &quot;autolimpeza&quot;--, o impacto do vazamento pode ser muito complicado&quot;, destacou Cui Wenlin, responsável de controle ambiental na Administração Oceânica Estatal da China (SOA).\nOutro encarregado da SOA (que gerencia as águas territoriais do país), Wang Bin, lembrou que &quot;a influência de um vazamento de petróleo em um ecossistema oceânico é longa e lenta&quot;.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/939562-vazamento-de-petroleo-no-mar-amarelo-pode-causar-danos-a-longo-prazo.shtml\">Leia mais</a> (06/07/2011 - 02h39)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/939562-vazamento-de-petroleo-no-mar-amarelo-pode-causar-danos-a-longo-prazo.shtml','2011-07-06 02:39:00'),(122,2,0,0,'Cruza de zebra e jumento nasce em zoo na China','O zoológico de Xiamen Haicang, no sudeste da China, anunciou o nascimento de uma rara cruza entre uma zebra e um jumento.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://www.bbc.co.uk/worldservice/emp/pop.shtml?l=pt&amp;t=video&amp;r=1&amp;p=/portuguese/meta/dps/2011/07/emp/110705_videozebrurrovaleebc.emp.xml\">Veja o vídeo</a>\nO &quot;zebrento&quot; ou &quot;jumebra&quot; quase morreu durante o parto, segundo funcionários do zoo.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/939331-cruza-de-zebra-e-jumento-nasce-em-zoo-na-china.shtml\">Leia mais</a> (05/07/2011 - 18h24)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/939331-cruza-de-zebra-e-jumento-nasce-em-zoo-na-china.shtml','2011-07-05 18:24:00'),(123,2,0,0,'Justiça determina recuperação de área de despejo na zona leste','Decisão da Justiça divulgada nesta terça-feira obrigou o a Prefeitura de São Paulo a elaborar um projeto de recuperação de uma área de proteção permanente da zona leste que há dez anos é usada como depósito irregular de entulho.\nA decisão, da juíza Márcia Helena Bosch, da 1ª Vara da Fazenda Pública, foi tomada após ação civil pública movida pelo Ministério Público. A juíza deu prazo de 30 dias para a apresentação do projeto. Cabe recurso.\nDe acordo com a Promotoria, a área, localizada no Jardim Savoy, na região de Itaquera, possui muita vegetação, cursos d\'águas e nascentes.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/939287-justica-determina-recuperacao-de-area-de-despejo-na-zona-leste.shtml\">Leia mais</a> (05/07/2011 - 17h44)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/939287-justica-determina-recuperacao-de-area-de-despejo-na-zona-leste.shtml','2011-07-05 17:44:00'),(124,2,0,0,'Macaco furta câmera e tira fotos dele sorrindo','Um macaco-de-celebes furtou uma câmera fotográfica e, antes de devolvê-la ao dono, tirou fotos dele mesmo.\nO símio ficou fascinado com sua imagem refletida na lente. &quot;Ele deve ter tirado centenas de imagens (...), mas não muitas focadas. Obviamente ainda não treinou muito&quot;, brincou o fotógrafo David Slater. &quot;Eu gostaria de ter ficado mais tempo. Ele provavelmente teria tirado fotos para todo um álbum de família.&quot;\nSlater contou, em entrevista ao jornal britânico &quot;Telegraph&quot;, que os macacos-de-celebes pularam ao redor do equipamento e se assustaram quando o botão de disparo da máquina funcionou.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/939258-macaco-furta-camera-e-tira-fotos-dele-sorrindo.shtml\">Leia mais</a> (05/07/2011 - 17h03)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/939258-macaco-furta-camera-e-tira-fotos-dele-sorrindo.shtml','2011-07-05 17:03:00'),(125,2,0,0,'Dilma volta a defender construção de hidrelétricas','A presidente Dilma Rousseff defendeu, em visita à usina de Santo Antônio nesta terça-feira (5), a construção de hidrelétricas como fonte de energia limpa e não poluente. Sem citar a usina de Belo Monte, criticada por ambientalistas por desviar o curso do rio Xingu, no Pará, a presidente disse que o Brasil é um país diferente por ter condições de construir hidrelétricas sem poluir o meio ambiente.\n&quot;Não somos iguais aos outros grandes países do mundo, porque temos imensa capacidade de termos potenciais hidrelétricos como esse aqui de Santo Antônio e, além disso, de sermos capazes porque temos consciência para usarmos esse potencial claramente em prol do meio ambiente também. Por que em prol do meio ambiente? Porque quando você não tem usina hidrelétrica, quando não se tem no país essa fonte de energia que é hidrelétrica, o que se usa no lugar? Se usa energia nuclear e energia térmica, de óleo diesel ou de qualquer derivado de petróleo. Isso significa que você está poluindo de uma forma inimaginável a natureza ou colocando em risco a própria vida da população.&quot;\nO evento marcou o processo de desvio do rio Madeira, etapa de construção da usina que antecede o enchimento do reservatório, permitindo os testes da turbinas e geração de energia a partir desse ano.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/939193-dilma-volta-a-defender-construcao-de-hidreletricas.shtml\">Leia mais</a> (05/07/2011 - 14h38)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/poder/939193-dilma-volta-a-defender-construcao-de-hidreletricas.shtml','2011-07-05 14:38:00'),(126,2,0,0,'Lula, FHC e Collor devem participar das discussões da Rio+20','Os ex-presidentes da República Luiz Inácio Lula da Silva, Fernando Henrique Cardoso, Fernando Collor de Mello e José Sarney (PMDB-AP) deverão participar de debates que integram a Conferência Rio+20, no período de 4 a 6 de junho de 2012, no Porto do Rio, a exemplo do que ocorreu em março, durante a visita do presidente dos Estados Unidos, Barack Obama, ao Brasil. A conferência será realizada de 28 de maio a 6 de junho do ano que vem.\nNo almoço oferecido a Obama, no Palácio Itamaraty em Brasília, todos os ex-presidentes foram convidados. O ex-presidente Itamar Franco (1992-1994), que morreu no último dia 2, também compareceu e elogiou a iniciativa da presidenta Dilma Rousseff de convidar seus antecessores para o almoço. Todos se sentaram à mesma mesa --Fernando Henrique, Collor, Sarney e Itamar. Lula não esteve presente.\nDe acordo com os organizadores da Rio+20, o conjunto de medidas adotadas no Brasil nos últimos anos para incentivar a economia verde, a preservação ambiental e o desenvolvimento sustentável resultam das ações de vários governos, consolidadas na gestão Dilma Rousseff.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/939708-lula-fhc-e-collor-devem-participar-das-discussoes-da-rio20.shtml\">Leia mais</a> (06/07/2011 - 13h05)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/939708-lula-fhc-e-collor-devem-participar-das-discussoes-da-rio20.shtml','2011-07-06 13:05:00'),(127,2,0,0,'Obras de Antonio Candido com 15% de desconto na Livraria da Folha','<table width=\"100\">\n<tr>\n<td></td>\n</tr>\n<tr>\n<td><a href=\"http://twitter.com/livrariafolha\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/10085353.gif\" alt=\"Siga a Livraria da Folha no Twitter\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://twitter.com/livrariafolha\">Siga a Livraria da Folha no Twitter</a> </td>\n</tr>\n</table>\nAntonio Candido (1918) é considerado o principal pensador da literatura brasileira vivo. Formado em sociologia, o intelectual abrirá a Flip (Festa Literária Internacional de Paraty), nesta terça-feira, no Rio de Janeiro.\nEm seus ensaios, o intelectual analisou algumas das principais obras e autores brasileiros, assim como a características da sociedade em que surgiram. Produziu uma inédita e imprescindível historicização da produção ficcional do país desde suas primeiras letras.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/939657-obras-de-antonio-candido-com-15-de-desconto-na-livraria-da-folha.shtml\">Leia mais</a> (06/07/2011 - 17h30)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/939657-obras-de-antonio-candido-com-15-de-desconto-na-livraria-da-folha.shtml','2011-07-06 17:30:00'),(128,2,0,0,'Ativistas protestam em Berlim contra financiamento a Angra 3','Ativistas antinucleares convocaram um protesto nesta quarta-feira em Berlim contra os planos do governo alemão de subsidiar indiretamente a construção da usina nuclear de Angra 3, no litoral do Rio de Janeiro.\nOs manifestantes, cujo protesto seria em frente à sede do governo, dizem ter reunido um abaixo-assinado com 125 mil assinaturas pedindo o fim do financiamento.\nA pouco menos de quatro meses do acidente na central nuclear de Fukushima, no Japão, que levou a Alemanha a anunciar o fechamento de todas as suas usinas até 2022, os ativistas querem que o governo de Angela Merkel desista de subsidiar a empresa francesa Areva, que vai fornecer equipamentos para Angra 3.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/939576-ativistas-protestam-em-berlim-contra-financiamento-a-angra-3.shtml\">Leia mais</a> (06/07/2011 - 17h26)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/939576-ativistas-protestam-em-berlim-contra-financiamento-a-angra-3.shtml','2011-07-06 17:26:00'),(129,2,0,0,'Reserva israelense sofre com vazamento de 1 mi de litros de gasolina','O vazamento de 1 milhão de litros de gasolina para aviões causou o maior desastre ecológico sofrido por uma reserva natural em Israel, informou nesta quinta-feira a imprensa local.\nO Ministério de Proteção ao Meio Ambiente ordenou à empresa Eilat-Ashkelon Pipeline que suspenda os trabalhos de reparação e manutenção do encanamento, cujo escape provocou danos irreparáveis à reserva natural de Nahal Zin, no deserto do Neguev (sul do país), indica o diário &quot;Yedioth Ahronoth&quot; em sua versão digital.\nO vazamento alcançou áreas com profundidade de cinco metros, segundo a pasta de Meio Ambiente e a Autoridade de Parques e Natureza de Israel, que consideram necessário extrair dezenas de milhares de metros cúbicos de terra contaminada na zona.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/940194-reserva-israelense-sofre-com-vazamento-de-1-mi-de-litros-de-gasolina.shtml\">Leia mais</a> (07/07/2011 - 08h41)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/940194-reserva-israelense-sofre-com-vazamento-de-1-mi-de-litros-de-gasolina.shtml','2011-07-07 08:41:00'),(130,2,0,0,'Não varra o lixo para debaixo do tapete','O lixo está à frente da sua casa. O caminhão passa e leva embora. O problema está resolvido.\nLedo engano.\nHá mais coisas o entre o saco de lixo e o aterro sanitário do que a vã filosofia possa imaginar.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/colunas/joseluizportella/940126-nao-varra-o-lixo-para-debaixo-do-tapete.shtml\">Leia mais</a> (07/07/2011 - 07h02)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/colunas/joseluizportella/940126-nao-varra-o-lixo-para-debaixo-do-tapete.shtml','2011-07-07 07:02:00'),(131,2,0,0,'Macacos-narigudos passam por check-up médico','Três macacos-narigudos passaram por um check-up, na terça-feira (5), no Zoológico de Cingapura.\nOs veterinários inspecionaram a saúde dos símios antes deles serem enviados ao Parque de Primatas de Apenheul, no Holanda, como parte de um experimento de intercâmbio e reprodução dos animais.\nO Zoológico de Cingapura é a primeira reserva selvagem a criar macacos-narigudos em cativeiro.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/940021-macacos-narigudos-passam-por-check-up-medico.shtml\">Leia mais</a> (06/07/2011 - 20h30)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/940021-macacos-narigudos-passam-por-check-up-medico.shtml','2011-07-06 20:30:00'),(132,2,0,0,'Vídeo registra tromba d\'água marinha no Panamá; veja','<p>\n<a href=\"http://storage.mais.uol.com.br/embed.swf?mediaId=11797219&amp;ver=1\">Vídeo</a>\nImagens registram um tromba d\'água marinha que se formou nesta semana no Oceano Pacífico, próximo do Arquipélago de Las Perlas, aproximadamente a 50 quilômetros da cidade do Panamá.As autoridades panamenhas não registraram danos materiais ou vítimas.\nA tromba d´água marinha é um fenómeno meteorológico semelhante a um tornado, onde uma massa de ar forma um vórtice que gira rapidamente em volta de si e liga a superfície da água à base de uma nuvem.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/multimidia/videocasts/940288-video-registra-tromba-dagua-marinha-no-panama-veja.shtml\">Leia mais</a> (07/07/2011 - 12h27)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/multimidia/videocasts/940288-video-registra-tromba-dagua-marinha-no-panama-veja.shtml','2011-07-07 12:27:00'),(133,2,0,0,'Aquário de Santos cuida de filhote de lobo-marinho','Um filhote de lobo-marinho é o mais novo morador do Aquário de Santos. O bebê com menos de um ano de idade chegou na noite de terça-feira (5).\nAinda não é possível identificar o sexo e a espécie, mas se a cria for um <i>Arctocephalus tropicalis</i>, permanecerá no parque santista, que neste ano perdeu os lobos-marinhos Alegra e Macaezinho.\nCom cerca de 60 centímetros de comprimento e pesando 10 quilos, o lobo-marinho está sendo tratado de uma infecção.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/939964-aquario-de-santos-cuida-de-filhote-de-lobo-marinho.shtml\">Leia mais</a> (07/07/2011 - 13h41)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/939964-aquario-de-santos-cuida-de-filhote-de-lobo-marinho.shtml','2011-07-07 13:41:00'),(134,2,0,0,'Suspeito de vender animais silvestres pelo Orkut é preso no RN','Um homem suspeito de vender animais silvestres pelo Orkut e enviá-los pelos Correios foi preso nesta quarta-feira (6) em Currais Novos, a 180 km de Natal (RN).\n<a href=\"http://www1.folha.uol.com.br/cotidiano/925724-policia-frustra-venda-de-animais-silvestres-em-sp.shtml\">Polícia frustra venda de animais silvestres em SP</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/885238-ong-de-sp-tenta-devolver-papagaio-a-mata-natal-no-ms.shtml\">ONG tenta devolver papagaio à mata natal no MS</a><br/>\n<a href=\"http://www1.folha.uol.com.br/cotidiano/795923-policia-rodoviaria-apreende-1000-canarios-com-comerciante-em-rodovia-de-ms.shtml\">Polícia apreende 1.000 canários em rodovia</a>\nSegundo o Ibama (Instituto do Meio Ambiente e Recursos Renováveis), Rafael Gomes de Medeiros, 22, vendia sapos, cobras, iguanas, lagartos e jabutis. Ele recebia entre R$ 200 e R$ 400 por animal.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/940525-suspeito-de-vender-animais-silvestres-pelo-orkut-e-preso-no-rn.shtml\">Leia mais</a> (07/07/2011 - 18h43)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/940525-suspeito-de-vender-animais-silvestres-pelo-orkut-e-preso-no-rn.shtml','2011-07-07 18:43:00'),(135,2,0,0,'Fêmea irlandesa deu origem a urso polar da atualidade, diz estudo','Uma análise do DNA de fósseis encontrados em cavernas da Irlanda mostra que os ursos polares da atualidade se originaram de um único ancestral.\nMais: ele seria uma fêmea de pelo marrom que teria cruzado com um urso polar, gerando filhotes híbridos.\nA pesquisa liderada por Ceiridwen Edwards, atualmente na Universidade de Oxford, mas no Trinity College Dublin quando desenvolveu o estudo, comparou dentes e ossos de 17 animais antigos com DNAs de ursos marrons e polares modernos ou que já estão extintos.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/940523-femea-irlandesa-deu-origem-a-urso-polar-da-atualidade-diz-estudo.shtml\">Leia mais</a> (07/07/2011 - 18h18)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/940523-femea-irlandesa-deu-origem-a-urso-polar-da-atualidade-diz-estudo.shtml','2011-07-07 18:18:00'),(136,2,0,0,'Cães mostram seus dotes em competição na França','A competição canina World Dog Show, inaugurada nesta quinta-feira, teve início na cidade francesa de Villepeinte, ao norte de Paris.\nPara divulgar o evento, com quatro dias de duração, a organização recorreu às redes sociais e incluiu uma transmissão ao vivo para quem curte esse tipo de prova.\n<table>\n<tr>\n<td rowspan=\"3\"></td>\n<td>Remy de la Mauviniere/Associated Press</td>\n<td rowspan=\"3\"></td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/bichos/images/11188497.jpeg\" alt=\"Cães da raça Schnauzer participam do World Dog Show, em Villepeinte, ao norte da França \" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Cães da raça Schnauzer participam do World Dog Show, em Villepeinte, ao norte da França </td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/940438-caes-mostram-seus-dotes-em-competicao-na-franca.shtml\">Leia mais</a> (07/07/2011 - 17h39)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/940438-caes-mostram-seus-dotes-em-competicao-na-franca.shtml','2011-07-07 17:39:00'),(137,2,0,0,'América Latina é 2º região que mais investe em energias renováveis','A América Latina foi em 2010 a segunda região do mundo que mais investiu no setor das energias renováveis, com aumento de 39% com relação ao ano anterior, segundo um relatório da Organização das Nações Unidas divulgado nesta quinta-feira (7).\nO setor das energias renováveis recebeu em 2010 no mundo todo investimentos no valor de US$ 211 bilhões, 32% a mais que em 2009 e 540 % acima do valor de 2004.\nO relatório do PNUMA (Programa das Nações Unidas para o Meio Ambiente) assinala que o aumento do número de fazendas eólicas da China e de pequenas plantas solares nos edifícios europeus foram os principais responsáveis pelo aumento significativo dos investimentos em 2010.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/940799-america-latina-e-2-regiao-que-mais-investe-em-energias-renovaveis.shtml\">Leia mais</a> (08/07/2011 - 10h42)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/940799-america-latina-e-2-regiao-que-mais-investe-em-energias-renovaveis.shtml','2011-07-08 10:42:00'),(138,2,0,0,'Grupo avaliará impacto de usinas hidrelétricas','A adesão é voluntária, mas pode ajudar a melhorar a imagem de consórcios e empresas responsáveis pela construção de hidrelétricas. Brasileiras disseram que querem passar pela avaliação, mas Belo Monte não está na lista.\nO convite é da Associação Internacional de Hidroeletrecidade (IHA), e a decisão de participar ou não do desafio é das próprias construtoras de usinas: demonstrar o quão sustentáveis são os projetos que levantam enormes barragens em rios para gerar uma energia renovável tida como limpa e responsável por 16% de toda a eletricidade produzida no mundo.\nO chamado Protocolo de Avaliação de Sustentabilidade de Hidrelétricas avalia novos projetos em quatro áreas vitais: social, econômica, ambiental e técnica. Em parceria com organizações como Transparência Internacional, WWF, Oxfam e Nature Conservancy, a IHA espera despertar mais engajamento no setor privado, para que ele se comprometa em projetos que tenham o menor impacto possível.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/dw/940885-grupo-avaliara-impacto-de-usinas-hidreletricas.shtml\">Leia mais</a> (08/07/2011 - 15h09)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/dw/940885-grupo-avaliara-impacto-de-usinas-hidreletricas.shtml','2011-07-08 15:09:00'),(139,2,0,0,'Erramos: Brasileiro cria sistema de tratamento de água com energia solar','Diferentemente do informado em <a href=\"http://www1.folha.uol.com.br/ambiente/943538-brasileiro-cria-sistema-de-tratamento-de-agua-com-energia-solar.shtml\">&quot;Brasileiro cria sistema de tratamento de água com energia solar&quot;</a> (Ambiente - 14/07/2011 - 14h50) Leonardo Lira é aluno do curso de engenharia do Instituto Federal de Goiás (IFG), e não da Universidade Federal de Goiás (UFG), como informava o texto da Agência Brasil. O texto foi corrigido.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944449-erramos-brasileiro-cria-sistema-de-tratamento-de-agua-com-energia-solar.shtml\">Leia mais</a> (15/07/2011 - 20h42)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944449-erramos-brasileiro-cria-sistema-de-tratamento-de-agua-com-energia-solar.shtml','2011-07-15 20:42:00'),(140,2,0,0,'Obra discute desmatamento e disputa territorial na Amazônia','<table>\n<tr>\n<td>Divulgação</td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1169095/\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/1119692.jpeg\" alt=\"Livro analisa situação atual da disputada região Amazônica\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/catalogo/1169095/\">Livro analisa situação atual da disputada região amazônica</a> </td>\n</tr>\n</table>\nO estudo <a href=\"http://livraria.folha.com.br/catalogo/1169095/\"><b>&quot;Território e Gestão Ambiental na Amazônia&quot;</b></a> (Annablume, 2011), da doutora em geografia Neli Aparecida de Mello-Théry, faz uma análise da situação política da região amazônica, com suas disputas de interesses e antagonismos, e sugere modelos de desenvolvimento e políticas públicas.\n<table width=\"100\">\n<tr>\n<td></td>\n</tr>\n<tr>\n<td><a href=\"http://twitter.com/livrariafolha\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/10085353.gif\" alt=\"Siga a Livraria da Folha no Twitter\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://twitter.com/livrariafolha\">Siga a Livraria da Folha no Twitter</a> </td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/943946-obra-discute-desmatamento-e-disputa-territorial-na-amazonia.shtml\">Leia mais</a> (15/07/2011 - 17h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/943946-obra-discute-desmatamento-e-disputa-territorial-na-amazonia.shtml','2011-07-15 17:00:00'),(141,2,0,0,'Estudo mostra que floresta absorve 1/3 do CO2 emitido no ar','As florestas do mundo absorvem um terço de dióxido de carbono (CO2) que é oriundo da queima de combustíveis fósseis na atmosfera, segundo um estudo internacional que alerta paralelamente para as consequências dramáticas do desmatamento no contexto do aquecimento global.\n&quot;Se amanhã suspendermos o desmatamento, as florestas existentes e aquelas em estado de reconstituição absorverão a metade das emissões de combustíveis fósseis&quot;, ressaltou Pep Canadell, coautor do estudo divulgado pela revista americana &quot;Science&quot;.\nAs florestas do planeta absorvem 2,4 bilhões de toneladas de carbono por ano, segundo este primeiro estudo com dados das contribuições das florestas boreais, tropicais e das regiões temperadas para o ciclo do carbono.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944075-estudo-mostra-que-floresta-absorve-13-do-co2-emitido-no-ar.shtml\">Leia mais</a> (15/07/2011 - 13h48)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944075-estudo-mostra-que-floresta-absorve-13-do-co2-emitido-no-ar.shtml','2011-07-15 13:48:00'),(142,2,0,0,'Angra 3 é muito cara, diz especialista em energia','A usina nuclear Angra 3, em construção pelo governo federal, é cara demais. Essa é a análise de Luiz Pinguelli Rosa, diretor da Coppe (Instituto Alberto Luiz Coimbra de Pós-Graduação e Pesquisa de Engenharia), da UFRJ (Universidade Federal do Rio de Janeiro), e um dos maiores especialistas em energia do país.\nEle foi convidado pela SBPC (Sociedade Brasileira para o Progresso da Ciência) para falar sobre o projeto da hidrelétrica de Belo Monte no último dia da reunião anual da instituição, em Goiânia. Mas aproveitou a oportunidade para criticar Angra 3 e pedir mais investimentos em energias &quot;alternativas&quot;.\n&quot;O governo já gastou US$ 700 milhões desde a ditadura militar com Angra 3. O custo para terminá-la é de US$ 6 bilhões. Angra 3 é cara demais&quot;, diz.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944066-angra-3-e-muito-cara-diz-especialista-em-energia.shtml\">Leia mais</a> (15/07/2011 - 13h29)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944066-angra-3-e-muito-cara-diz-especialista-em-energia.shtml','2011-07-15 13:29:00'),(143,2,0,0,'Presidente do Ibama causa polêmica em entrevista a TV australiana','O presidente do Ibama, Curt Trennepohl, causou polêmica ao dizer a uma equipe de TV australiana que seu trabalho não é cuidar do ambiente, e sim minimizar impactos ambientais. Depois, sem saber que estava sendo filmado, sugeriu que o Brasil faria com os índios a mesma coisa que a Austrália fez com os aborígenes, população nativa do país da Oceania.\nAs declarações foram dadas à repórter Allison Langdon, do programa &quot;60 Minutes&quot;, que fazia uma reportagem sobre a licença de instalação da usina de Belo Monte, assinada por Trennepohl.\n<table>\n<tr>\n<td>Eraldo Peres-1º.jun.2011/Associated Press</td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/ambiente/images/1119665.jpeg\" alt=\"Curt Trennepohl, presidente do Ibama, fez comentários polêmicos para equipe de televisão da Austrália\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Curt Trennepohl, presidente do Ibama, fez comentários polêmicos para equipe de televisão da Austrália</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/943942-presidente-do-ibama-causa-polemica-em-entrevista-a-tv-australiana.shtml\">Leia mais</a> (15/07/2011 - 08h16)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/943942-presidente-do-ibama-causa-polemica-em-entrevista-a-tv-australiana.shtml','2011-07-15 08:16:00'),(144,2,0,0,'Recanto jamaicano do filme \'Lagoa Azul\' atrai poucos curiosos','Em uma pequena lagoa da Jamaica cuja extensão chega a 122 metros, a luz do dia vai mudando a cor das águas de um trêmulo verde-jade para um azul-cobalto brilhante.\n<a href=\"http://fotografia.folha.uol.com.br/galerias/3676-lagoa-azul-da-jamaica\">Veja galeria de fotos de lagoa Azul da Jamaica</a>\nO local ficou famoso por ter sido palco das gravações do filme &quot;A Lagoa Azul&quot; (1980), protagonizado por Brooke Shields e Christopher Atkins --apesar de que também foram usadas cenas filmadas em Fiji e Vanuatu, na Oceania.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/943616-recanto-jamaicano-do-filme-lagoa-azul-atrai-poucos-curiosos.shtml\">Leia mais</a> (15/07/2011 - 08h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/943616-recanto-jamaicano-do-filme-lagoa-azul-atrai-poucos-curiosos.shtml','2011-07-15 08:00:00'),(145,2,0,0,'Oferta do dia: Jacques Derrida com 15% de desconto na Livraria da Folha','<table>\n<tr>\n<td>Alexis Duclos/AP</td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/lista/d69eb306\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/10280654.jpeg\" alt=\"Jacques Derrida é conhecido por ser o criador da desconstrução\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://livraria.folha.com.br/lista/d69eb306\">Jacques Derrida é conhecido por ser o criador da desconstrução</a> </td>\n</tr>\n</table>\n<table width=\"100\">\n<tr>\n<td></td>\n</tr>\n<tr>\n<td><a href=\"http://twitter.com/livrariafolha\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/10085353.gif\" alt=\"Siga a Livraria da Folha no Twitter\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://twitter.com/livrariafolha\">Siga a Livraria da Folha no Twitter</a> </td>\n</tr>\n</table>\nNascido na Argélia, em 15 de julho de 1930, Jacques Derrida é o filósofo --pseudofilósofo para alguns-- conhecido por ser o criador da desconstrução, uma metodologia de análise que decompõe o texto para encontrar fragilidades e falhas na argumentação.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/943399-oferta-do-dia-jacques-derrida-com-15-de-desconto-na-livraria-da-folha.shtml\">Leia mais</a> (15/07/2011 - 07h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/943399-oferta-do-dia-jacques-derrida-com-15-de-desconto-na-livraria-da-folha.shtml','2011-07-15 07:00:00'),(146,2,0,0,'Ação ambiental contra Belo Monte fica sem juiz','O juiz Hugo Sinvaldo Silva da Gama Filho, da 9ª Vara da Justiça Federal, em Belém (PA), alegou não ter competência para julgar a última ação civil pública contra a LI (Licença de Instalação) concedida pelo Ibama à Norte Energia S.A., responsável pela construção da Usina Hidrelétrica Belo Monte, no rio Xingu (PA).\nCom isso, fica afastado, por ora, o risco de qualquer nova paralisação da obra. A construção começou a ganhar ritmo nas últimas semanas, após a obtenção da licença que autorizou o início da obra.\n<a href=\"http://www1.folha.uol.com.br/mercado/937692-entrada-da-vale-em-consorcio-de-belo-monte-e-oficializada.shtml\">Entrada da Vale em consórcio de Belo Monte é oficializada</a><br/>\n<a href=\"http://www1.folha.uol.com.br/mercado/932988-usina-de-belo-monte-ja-faz-desmate-crescer-em-altamira.shtml\">Usina de Belo Monte já faz desmate crescer em Altamira</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/943570-acao-ambiental-contra-belo-monte-fica-sem-juiz.shtml\">Leia mais</a> (14/07/2011 - 15h44)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/mercado/943570-acao-ambiental-contra-belo-monte-fica-sem-juiz.shtml','2011-07-14 15:44:00'),(147,2,0,0,'Brasileiro cria sistema de tratamento de água com energia solar','O estudante de engenharia elétrica do IFG (Instituto Federal de Goiás) Leonardo Lira, 20, inventou um sistema para tratamento de água que não usa energia elétrica, não emite gás carbônico e retira material que pode poluir o meio ambiente. De baixo custo, o sistema pode ser utilizado por comunidades carentes sem acesso a saneamento básico.\nCom cinco tábuas de compensado revestidas de papel alumínio, Leonardo fez uma caixa sem tampa de aproximadamente um metro quadrado com as paredes abertas e inclinadas, uma espécie de concentrador que recebe luz do sol.\nNo interior da caixa, o estudante depositou quatro garrafas PET transparentes com capacidade para dois litros, cada, onde armazena a água para tratamento por três a seis horas.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/943538-brasileiro-cria-sistema-de-tratamento-de-agua-com-energia-solar.shtml\">Leia mais</a> (14/07/2011 - 14h50)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/943538-brasileiro-cria-sistema-de-tratamento-de-agua-com-energia-solar.shtml','2011-07-14 14:50:00'),(148,2,0,0,'Filhotes de guepardo são apresentados pela primeira vez','Os três filhotes de guepardos de dois meses de idade foram apresentados pela primeira vez nesta quinta-feira aos visitantes de um zoológico em Wuppertal, na Alemanha.\n<a href=\"http://www1.folha.uol.com.br/bichos/cademeubicho.shtml\">Envie a foto de seu bicho; sabia como</a><br/>\n<a href=\"http://www1.folha.uol.com.br/bichos/943512-gatinhos-gostam-de-dormir-juntos-veja-mascotes-da-semana.shtml\">Veja mascotes da semana</a><br/>\n<a href=\"http://fotografia.folha.uol.com.br/galerias/3534-orangotango-ganha-cobertor-no-rio\">Veja bichos da semana</a>\nOs irmãozinhos nasceram em cativeiro em 10 de maio.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/943437-filhotes-de-guepardo-sao-apresentados-pela-primeira-vez.shtml\">Leia mais</a> (14/07/2011 - 10h52)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bichos/943437-filhotes-de-guepardo-sao-apresentados-pela-primeira-vez.shtml','2011-07-14 10:52:00'),(149,2,0,0,'Estudo simulará aquecimento amazônico e suas consequências','Para descobrir como animais e plantas vão se virar diante do desafio do aquecimento global, cientistas do Inpa (Instituto Nacional de Pesquisas da Amazônia) vão recriar artificialmente o ambiente aquático amazônico num clima mais quente.\nA ideia é ter cenários baseados em três projeções do IPCC (painel do clima da ONU) para 2100, da mais branda à mais catastrófica.\nO projeto, diz seu coordenador, Adalberto Val, diretor do Inpa, é inédito no mundo. &quot;Muitos pesquisadores olham para os animais terrestres quando fazem projeções, mas se esquecem da vida aquática&quot;, afirma o biólogo.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/943422-estudo-simulara-aquecimento-amazonico-e-suas-consequencias.shtml\">Leia mais</a> (14/07/2011 - 10h10)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/943422-estudo-simulara-aquecimento-amazonico-e-suas-consequencias.shtml','2011-07-14 10:10:00'),(150,2,0,0,'Ursa enfrenta dois tigres com filhotes nas costas','Um fotógrafo conseguiu capturar o momento em que uma ursa enfrenta dois tigres para proteger os filhotes, que passaram todo o tempo agarrados às suas costas.\n<table>\n<tr>\n<td>Caters News</td>\n</tr>\n<tr>\n<td><a href=\"http://fotografia.folha.uol.com.br/galerias/3625-ursa-enfrenta-dois-tigres-com-filhotes-nas-costas\"><img src=\"http://f.i.uol.com.br/folha/homepage/images/11195105.jpeg\" alt=\"Ursa enfrenta dois tigres com filhotes nas costas; veja série de imagens\" border=\"0\" /></a></td>\n</tr>\n<tr>\n<td><a href=\"http://fotografia.folha.uol.com.br/galerias/3625-ursa-enfrenta-dois-tigres-com-filhotes-nas-costas\">Ursa enfrenta dois tigres com filhotes nas costas; veja série de imagens</a></td>\n</tr>\n</table>\nO confronto, que durou menos de três minutos, aconteceu na Reserva de Tigres de Ranthambore, no Rajastão, na Índia.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/943362-ursa-enfrenta-dois-tigres-com-filhotes-nas-costas.shtml\">Leia mais</a> (14/07/2011 - 08h35)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/943362-ursa-enfrenta-dois-tigres-com-filhotes-nas-costas.shtml','2011-07-14 08:35:00'),(151,2,0,0,'Greenpeace destrói plantações de trigo transgênico na Austrália','Ativistas da organização Greenpeace destruíram nesta quinta-feira plantações experimentais de trigo transgênico em um centro de pesquisa na Austrália, informou a imprensa local.\nOs ativistas invadiram a estação da Organização para a Pesquisa Industrial e Científica da Comunidade da Austrália (CSIRO, na sigla em inglês), em Ginninderra, próximo a Canberra, e destruíram toda a colheita do trigo transgênico experimental.\nO centro dedicava meio hectare à produção de trigo modificado geneticamente, no primeiro teste no exterior deste tipo de cultivo na Austrália, onde até agora não esteve autorizado.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/943346-greenpeace-destroi-plantacoes-de-trigo-transgenico-na-australia.shtml\">Leia mais</a> (14/07/2011 - 02h02)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/943346-greenpeace-destroi-plantacoes-de-trigo-transgenico-na-australia.shtml','2011-07-14 02:02:00'),(152,2,0,0,'Pescador pega pelo rabo tubarão de 2,5 metros de comprimento','Uma viagem de pescaria de dois amigos ganhou contornos dramáticos quando um deles fisgou um tubarão e lutou com o animal dentro da água, segurando-o pelo rabo.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://www.bbc.co.uk/worldservice/emp/pop.shtml?l=pt&amp;t=video&amp;r=1&amp;p=/portuguese/meta/dps/2011/07/emp/110713_tubarao_rc.emp.xml\">Veja o vídeo</a>\nO exemplar da espécie tubarão raposa (<i>Alopias vulpinus</i> tinha quase dois metros e meio de comprimento.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/943065-pescador-pega-pelo-rabo-tubarao-de-25-metros-de-comprimento.shtml\">Leia mais</a> (13/07/2011 - 17h09)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/943065-pescador-pega-pelo-rabo-tubarao-de-25-metros-de-comprimento.shtml','2011-07-13 17:09:00'),(153,2,0,0,'Brasil quer reservas para proteção de baleias no Atlântico Sul','Criar grandes zonas protegidas onde as baleias possam viver sem medo de arpões, mesmo que a moratória vigente sobre a caça de cetáceos seja suspensa, é o objetivo de países como Brasil e Argentina, conscientes de seu potencial turístico.\nDurante a reunião anual da CBI (Comissão Baleeira Internacional), que ocorre até quinta-feira na ilha de Jersey, Brasil e Argentina colocaram novamente na agenda do dia um projeto de refúgio para o Atlântico Sul, que se somaria a duas grandes reservas já existentes, no oceano Índico (desde 1979) e no oceano Austral (1994).\n&quot;A finalidade de uma reserva é fortalecer a moratória. Se um dia ela se abrir, serão conservadas grandes porções de oceanos fechadas à caça comercial&quot;, explica Vincent Ridoux, membro do comitê científico da CBI, a única instância de gestão dos grandes cetáceos.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/942983-brasil-quer-reservas-para-protecao-de-baleias-no-atlantico-sul.shtml\">Leia mais</a> (13/07/2011 - 14h43)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/942983-brasil-quer-reservas-para-protecao-de-baleias-no-atlantico-sul.shtml','2011-07-13 14:43:00'),(154,1,0,0,'Chamada de Trabalhos VI SoLiSC','<p>A Associação Software Livre Santa Catarina – SoLiSC – fez no último dia 29/06, no FISL abertura da chamada de trabalhos para o 6º SoLiSC – Congresso Catarinense de Software Livre.</p>\n<p>O Evento será realizado em São José/SC, no Centro&#8230;</p>','http://feedproxy.google.com/~r/VidaGeek/~3/IwU1hd9ZYPg/','2011-07-18 11:30:00'),(155,2,0,0,'Algas invadem praias francesas da Bretanha; veja o vídeo','Todos os anos, a região francesa da Bretanha sofre com o excesso de algas que se formam no mar e acabam nas praias, mas em 2011 o problema surgiu com mais força.\n<img src=\"http://f.i.uol.com.br/folha/multimidia/images/icn-videocast-14x14.gif\" alt=\"\" border=\"0\" /><a href=\"http://www.bbc.co.uk/worldservice/emp/pop.shtml?l=pt&amp;t=video&amp;p=/portuguese/meta/dps/2011/07/emp/110718_algas_franca_rc.emp.xml\">Veja o vídeo</a>\n<table>\n<tr>\n<td rowspan=\"3\"></td>\n<td>BBC</td>\n<td rowspan=\"3\"></td>\n</tr>\n<tr>\n<td><img src=\"http://f.i.uol.com.br/folha/ambiente/images/11199658.jpeg\" alt=\"Crescimento acima do normal de algas em praias francesas da Bretanha atingiu seu pico neste ano\" border=\"0\" /></td>\n</tr>\n<tr>\n<td>Crescimento acima do normal de algas em praias francesas da Bretanha atingiu seu pico neste ano</td>\n</tr>\n</table>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/945383-algas-invadem-praias-francesas-da-bretanha-veja-o-video.shtml\">Leia mais</a> (18/07/2011 - 20h20)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/945383-algas-invadem-praias-francesas-da-bretanha-veja-o-video.shtml','2011-07-18 20:20:00'),(156,2,0,0,'Odebrecht é multada em R$ 100 mil por assoreamento de rio em Santos','A construtora Odebrecht foi multada em R$ 100 mil nesta segunda-feira pela Secretaria Municipal de Meio Ambiente de Santos (litoral de São Paulo) por causa de um acidente nas obras de construção de um terminal do porto no final de semana.\nNo sábado, segundo a secretaria, parte do aterro das obras de construção de uma ponte do terminal da Embraport (Empresa Brasileira de Terminais Portuários), que só deve começar a operar em dois anos, rompeu-se.\nCom o acidente, cerca de 5.000 metros cúbicos de material foram despejados e assorearam um trecho do rio Sandi, próximo à ilha Diana, na área continental do município.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/945382-odebrecht-e-multada-em-r-100-mil-por-assoreamento-de-rio-em-santos.shtml\">Leia mais</a> (18/07/2011 - 18h58)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/cotidiano/945382-odebrecht-e-multada-em-r-100-mil-por-assoreamento-de-rio-em-santos.shtml','2011-07-18 18:58:00'),(157,2,0,0,'Filhotes de urso-polar morrem mais ao migrar, diz estudo','A mortalidade de filhotes de urso-polar que são obrigados a nadar longas distâncias com suas mães devido ao degelo do Ártico aparentemente é maior do que entre aqueles que não migram.\nO estudo recente, produzido pela organização ambientalista World Wildlife Fund, é o primeiro a mostrar a migração como um fator de grande risco às espécies mais jovens.\nSatélites foram usados para acompanhar 68 ursas-polares equipadas com colares GPS, entre 2004-2009, que tiveram de nadar longas distâncias.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/945316-filhotes-de-urso-polar-morrem-mais-ao-migrar-diz-estudo.shtml\">Leia mais</a> (18/07/2011 - 18h13)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/945316-filhotes-de-urso-polar-morrem-mais-ao-migrar-diz-estudo.shtml','2011-07-18 18:13:00'),(158,2,0,0,'Entidade encontra no Vietnã grupo de gibões ameaçados de extinção','A organização ambiental Conservation International descobriu, em um parque nacional do Vietnã, a maior população conhecida de uma espécie de gibão ameaçada de extinção.\nUsando uma técnica que consiste em usar o som produzido pela espécie, a entidade confirmou a existência de 455 animais no Parque Nacional de Pu Mat.\n<a href=\"http://www1.folha.uol.com.br/bichos/cademeubicho.shtml\">Envie a foto de seu bicho; sabia como</a><br/>\n<a href=\"http://www1.folha.uol.com.br/bichos/943512-gatinhos-gostam-de-dormir-juntos-veja-mascotes-da-semana.shtml\">Veja mascotes da semana</a><br/>\n<a href=\"http://fotografia.folha.uol.com.br/galerias/3534-orangotango-ganha-cobertor-no-rio\">Veja bichos da semana</a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/945194-entidade-encontra-no-vietna-grupo-de-giboes-ameacados-de-extincao.shtml\">Leia mais</a> (18/07/2011 - 16h29)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/bbc/945194-entidade-encontra-no-vietna-grupo-de-giboes-ameacados-de-extincao.shtml','2011-07-18 16:29:00'),(159,2,0,0,'Rio busca ter o segundo &quot;geoparque&quot; da Unesco nas Américas','O governo do Rio de Janeiro vai pleitear na Organização das Nações Unidas para a Educação, Ciência e Cultura (Unesco) a criação do Geoparque Costões e Lagunas, que abrangeria 15 municípios do litoral fluminense.\nA área considerada vai de Maricá, na região metropolitana; até São João da Barra, no norte fluminense.\nO projeto, se aprovado, dará ao país o segundo geoparque das Américas e o 78ª do mundo. O Geoparque de Araripe foi criado em 2006, no Ceará.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/945189-rio-busca-ter-o-segundo-geoparque-da-unesco-nas-americas.shtml\">Leia mais</a> (18/07/2011 - 15h28)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/turismo/945189-rio-busca-ter-o-segundo-geoparque-da-unesco-nas-americas.shtml','2011-07-18 15:28:00'),(160,2,0,0,'Governo faz mutirão contra impacto socioambiental em Belo Monte','O governo começa hoje (18) na região da hidrelétrica de Belo Monte, no rio Xingu (PA), uma força-tarefa para tentar reduzir os impactos socioambientais da obra. Onze municípios deverão ser atendidos pelo mutirão, que inclui medidas de regularização ambiental e fundiária e ações de saúde.\nDe acordo com o Ministério do Meio Ambiente, a operação deve atender a cerca de 300 mil habitantes da região da hidrelétrica, que serão afetados direta ou indiretamente pela construção do empreendimento. A concessão da licença de instalação para o início das obras já começou a atrair novos moradores e, até o fim da construção, pelo menos 100 mil pessoas devem migrar para a região.\nEm junho, o governo instalou na região a Casa do Governo Federal, para tentar melhorar o diálogo com as populações locais, que se manifestaram repetidamente contra a obra. A ideia, segundo o ministério, é manter uma instância do governo no local para acompanhar o cumprimento das condicionantes pelo consórcio responsável pelas obras e garantir a implementação do Plano de Desenvolvimento Regional do Xingu (PDRS), criado em outubro do ano passado.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/945106-governo-faz-mutirao-contra-impacto-socioambiental-em-belo-monte.shtml\">Leia mais</a> (18/07/2011 - 12h01)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/945106-governo-faz-mutirao-contra-impacto-socioambiental-em-belo-monte.shtml','2011-07-18 12:01:00'),(161,2,0,0,'Oferta do dia: obras sobre nazismo com 15% de desconto na Livraria da Folha','O primeiro volume de &quot;Minha Luta&quot; (Mein Kampf, no original, em alemão), manifesto pessoal escrito por Adolf Hitler (1889-1945), foi divulgado no dia 18 de julho de 1925. O livro contém as principais ideias do líder alemão, pensamentos antissemitas que mais tarde iriam culminar na ascensão do império nazista.\nPara rememorar este período tenebroso da história humana, cheio de assassinatos em massa perpetrados em nome de uma &quot;supremacia racial&quot; e que teve seu auge na Segunda Guerra Mundial (1939-1945), a <b>Livraria da Folha</b> faz uma seleção de livros sobre o nazismo com desconto temporário de 15%.\n<a href=\"http://livraria.folha.com.br/lista/ddb86c23\"><b>Veja livros sobre o nazismo com 15% de desconto</b></a>\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/944108-oferta-do-dia-obras-sobre-nazismo-com-15-de-desconto-na-livraria-da-folha.shtml\">Leia mais</a> (18/07/2011 - 09h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/944108-oferta-do-dia-obras-sobre-nazismo-com-15-de-desconto-na-livraria-da-folha.shtml','2011-07-18 09:00:00'),(162,2,0,0,'China inicia mercado de emissões de CO2 em caráter experimental','A China, o maior emissor de dióxido de carbono do mundo, lançará um programa experimental para estabelecer um mercado de emissões de CO2 e reduzir os gases poluentes em sua luta contra a mudança climática, destacou a agência oficial Xinhua.\nO plano, apresentado pelo vice-ministro da Comissão Nacional de Reforma e Desenvolvimento da China, Xie Zhenhua, inclui um aumento da diferença de tarifas entre as indústrias de alto consumo energético e o resto, assim como vantagens fiscais a projetos de conservação energética.\nAlém disso, haverá incentivos às companhias financeiras chinesas para que invistam em novas energias, em um país que já lidera mundialmente o investimento em renováveis.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/945014-china-inicia-mercado-de-emissoes-de-co2-em-carater-experimental.shtml\">Leia mais</a> (18/07/2011 - 01h51)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/945014-china-inicia-mercado-de-emissoes-de-co2-em-carater-experimental.shtml','2011-07-18 01:51:00'),(163,2,0,0,'Oferta do dia: livros sobre guerra com 15% de desconto','<table width=\"100\">\n<tr>\n<td></td>\n</tr>\n<tr>\n<td><a href=\"http://twitter.com/livrariafolha\"><img src=\"http://f.i.uol.com.br/livraria/capas/images/10085353.gif\" alt=\"Siga a Livraria da Folha no Twitter\" border=\"0\" /></a> </td>\n</tr>\n<tr>\n<td><a href=\"http://twitter.com/livrariafolha\">Siga a Livraria da Folha no Twitter</a> </td>\n</tr>\n</table>\nO dia 17 de julho de 1936 é uma data decisiva para o estouro da Guerra Civil Espanhola (1936-1939). Nesta ocasião, um grupo liderado pelo general Francisco Franco deu um golpe de estado no recém eleito governo espanhol e acirrou o conflito, que durou três anos, e dividiu o país em dois blocos, a Frente Nacionalista e a Frente Republicana. O primeiro era dominado por militares, fascistas e conservadores em geral, enquanto o segundo tinha combatentes democratas, socialistas e anarquistas.\nCom milhares de mortes, este fato histórico foi precursor da Segunda Guerra Mundial (1939-1945) e resultou em uma ditadura que dominou a Espanha nas décadas seguintes.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/944079-oferta-do-dia-livros-sobre-guerra-com-15-de-desconto.shtml\">Leia mais</a> (17/07/2011 - 09h00)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/livrariadafolha/944079-oferta-do-dia-livros-sobre-guerra-com-15-de-desconto.shtml','2011-07-17 09:00:00'),(164,2,0,0,'Litoral norte de SP sofre com invasões em áreas de Mata Atlântica','A perspectiva de uma vida a beira mar e a possibilidade de uma qualidade de vida melhor do que em outras regiões tornam atraentes as cidades do litoral norte de São Paulo. Essa qualidade também é causa das invasões e desmatamentos em uma região fundamental para a conservação da Mata Atlântica.\n&quot;É uma região extremamente importante do ponto de vista da conservação da biodiversidade e também, ao mesmo tempo, é uma das mais ameaçadas. Todo mundo gosta de praia, do litoral e todo mundo quer viver próximo&quot;, disse Márcia Hirota, diretora de gestão do conhecimento da organização da SOS Mata Atlântica.\nEm São Sebastião, um levantamento feito por associações de bairro constatou 100 invasões e construções irregulares erguidas em um período de um ano e meio.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944661-litoral-norte-de-sp-sofre-com-invasoes-em-areas-de-mata-atlantica.shtml\">Leia mais</a> (16/07/2011 - 14h16)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944661-litoral-norte-de-sp-sofre-com-invasoes-em-areas-de-mata-atlantica.shtml','2011-07-16 14:16:00'),(165,2,0,0,'Expedição vai mapear práticas sustentáveis no Pantanal','A pujança do Pantanal e o fascínio que sua natureza exerce sobre empresários do Sudeste ficam evidentes no campo de pouso da Estância Caiman: dois helicópteros e vários aviões se aglomeram na grama, a poucos metros de uma das imensas baías que fazem a fama da região.\nO 10 de julho era de comemoração: a 18ª Festa Pantaneira, cujo ponto alto não foi a prova de laço, como de costume. Em lugar de cavalos e bois, o lugar de honra estava ocupado por uma camionete paramentada com adesivos dos patrocinadores da Expedição Pantanal (Instituto SOS Pantanal, Fundação Toyota, Supermercados Comper e governo de Mato Grosso do Sul).\nAté dezembro, a equipe percorrerá 19 mil km, em nove rotas da bacia do rio Paraguai em Mato Grosso do Sul e Mato Grosso.\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944597-expedicao-vai-mapear-praticas-sustentaveis-no-pantanal.shtml\">Leia mais</a> (16/07/2011 - 08h27)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ambiente/944597-expedicao-vai-mapear-praticas-sustentaveis-no-pantanal.shtml','2011-07-16 08:27:00'),(166,2,0,0,'Crenças e preconceitos moldam reação das pessoas a prazer e dor','O psicólogo Paul Bloom explica em entrevista --a <a href=\"http://www1.folha.uol.com.br/fsp/ciencia/fe1907201102.htm\">íntegra</a> está disponível para assinantes do jornal e do UOL (empresa controlada pelo Grupo Folha, que edita a <b>Folha</b>)-- quais são os mecanismos do prazer humano quando bebemos um vinho, vemos uma obra de arte ou fazemos sexo.\nSegundo ele, o prazer é guiado pelo que sabemos, ou julgamos saber, sobre o objeto ou a pessoa com a qual interagimos.\nBloom é professor da prestigiosa Universidade Yale, nos EUA, e autor do livro &quot;How Pleasure Works&quot; (&quot;Como o Prazer Funciona&quot;).\n<a href=\"http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/945594-crencas-e-preconceitos-moldam-reacao-das-pessoas-a-prazer-e-dor.shtml\">Leia mais</a> (19/07/2011 - 10h39)','http://redir.folha.com.br/redir/online/ambiente/rss091/*http%3A//www1.folha.uol.com.br/ciencia/945594-crencas-e-preconceitos-moldam-reacao-das-pessoas-a-prazer-e-dor.shtml','2011-07-19 10:39:00');
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_field`
--

LOCK TABLES `form_field` WRITE;
/*!40000 ALTER TABLE `form_field` DISABLE KEYS */;
INSERT INTO `form_field` VALUES (1,1,'tags',1,0,NULL,1,'',0,0,NULL,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_response`
--

LOCK TABLES `form_response` WRITE;
/*!40000 ALTER TABLE `form_response` DISABLE KEYS */;
INSERT INTO `form_response` VALUES (1,1,20,'dsfasdfs dag ads adfs f'),(2,1,21,'1,2,3,4,5'),(3,1,22,'a,b,c,d'),(4,1,23,'x,y,z,w'),(5,1,24,'1 2 3 4 5'),(6,1,25,'agua, felicidade'),(7,1,26,''),(8,1,27,'a b s c d'),(9,1,28,''),(10,1,29,''),(11,1,30,'tag1,tag2'),(12,1,31,'Oi Mapa'),(13,1,32,'Oi Mapa'),(14,1,34,''),(15,1,35,''),(16,1,36,''),(17,1,37,'');
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
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident`
--

LOCK TABLES `incident` WRITE;
/*!40000 ALTER TABLE `incident` DISABLE KEYS */;
INSERT INTO `incident` VALUES (35,0,'en_US',0,'Meu Mapa','Mapa','2011-07-18 22:37:00',1,1,1,NULL,NULL,'0','2011-07-18 22:38:01',NULL,NULL,0),(36,0,'en_US',0,'Meu Mapa','Mapa','2011-07-18 22:38:00',1,1,1,NULL,NULL,'0','2011-07-18 22:38:36',NULL,NULL,0),(37,0,'en_US',0,'Mapa do João','Oi João','2011-07-19 10:52:00',1,1,1,NULL,NULL,'0','2011-07-19 10:52:26',NULL,NULL,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_category`
--

LOCK TABLES `incident_category` WRITE;
/*!40000 ALTER TABLE `incident_category` DISABLE KEYS */;
INSERT INTO `incident_category` VALUES (6,5,1),(7,6,1),(3,3,1),(4,4,1),(5,4,3),(8,6,3),(9,7,1),(10,8,1),(11,8,3),(12,9,1),(13,10,2),(14,11,3),(15,12,1),(16,13,1),(17,14,1),(18,14,3),(19,15,1),(20,16,1),(21,17,3),(22,18,1),(23,19,8),(24,19,7),(25,19,12),(26,19,13),(27,20,8),(28,20,7),(29,20,12),(30,20,13),(31,21,8),(32,21,7),(33,21,11),(34,21,9),(35,21,12),(36,21,13),(37,21,5),(38,21,6),(39,22,8),(40,22,7),(41,22,12),(42,23,8),(43,23,7),(44,23,11),(45,23,14),(46,23,5),(47,24,8),(48,24,7),(49,24,11),(50,24,9),(51,24,12),(52,24,14),(53,24,6),(54,25,7),(55,25,12),(56,26,5),(57,27,8),(58,27,7),(59,27,9),(60,27,12),(61,27,5),(62,28,11),(63,29,8),(64,30,8),(65,31,7),(66,32,7),(67,34,9),(68,35,9),(69,36,9),(70,37,11);
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
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_location`
--

LOCK TABLES `incident_location` WRITE;
/*!40000 ALTER TABLE `incident_location` DISABLE KEYS */;
INSERT INTO `incident_location` VALUES (1,36,192),(2,36,193),(3,36,194),(4,36,195),(5,36,196),(6,36,197),(7,36,198),(8,36,199),(9,36,200),(10,36,201),(11,36,202),(12,36,203),(13,36,204),(14,36,205),(15,36,206),(16,36,207),(17,36,208),(18,36,209),(19,36,210),(20,36,211),(21,36,212),(22,36,213),(23,36,214),(24,36,215),(25,36,216),(26,36,217),(27,36,218),(28,36,219),(29,36,220),(30,36,221),(31,36,222),(32,36,223),(33,36,224),(34,36,225),(35,36,226),(36,36,227),(37,36,228),(38,36,229),(39,36,230),(40,36,231),(41,36,232),(42,36,233),(43,36,234),(44,36,235),(45,36,236),(46,36,237),(47,36,238),(48,36,239),(49,36,240),(50,36,241),(51,36,242),(52,36,243),(53,36,244),(54,36,245),(55,36,246),(56,36,247),(57,36,248),(58,36,249),(59,36,250),(60,36,251),(61,36,252),(62,36,253),(63,36,254),(64,36,255),(65,36,256),(66,36,257),(67,36,258),(68,36,259),(69,36,260),(70,36,261),(71,36,262),(72,36,263),(73,36,264),(74,36,265),(75,36,266),(76,36,267),(77,36,268),(78,36,269),(79,36,270),(80,36,271),(81,36,272),(82,36,273),(83,36,274),(84,36,275),(85,36,276),(86,36,277),(87,36,278),(88,36,279),(89,36,280),(90,36,281),(91,36,282),(92,36,283),(93,36,284),(94,36,285),(95,36,286),(96,36,287),(97,36,288),(98,36,289),(99,36,290),(100,36,291),(101,36,292),(102,36,293),(103,36,294),(104,36,295),(105,36,296),(106,36,297);
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
  `layer_id` int(11) NOT NULL DEFAULT '0',
  `location_name` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `latitude` double NOT NULL DEFAULT '0',
  `longitude` double NOT NULL DEFAULT '0',
  `location_visible` tinyint(4) NOT NULL DEFAULT '1',
  `location_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=298 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (285,1,'Point 1',NULL,-23.463561,-46.753349,1,'2011-07-19 12:25:18'),(286,1,'Point 2',NULL,-23.506385,-46.754723,1,'2011-07-19 12:25:18'),(287,1,'Point 3',NULL,-23.480567,-46.706657,1,'2011-07-19 12:25:19'),(288,1,'Point 4',NULL,-23.462302,-46.682625,1,'2011-07-19 12:25:19'),(289,1,'Point 5',NULL,-23.503237,-46.681938,1,'2011-07-19 12:25:19'),(290,2,'Point 6',NULL,-23.490013,-46.561775,1,'2011-07-19 12:25:21'),(291,2,'Point 7',NULL,-23.523385,-46.607094,1,'2011-07-19 12:25:21'),(292,2,'Point 8',NULL,-23.552972,-46.686745,1,'2011-07-19 12:25:22'),(293,4,'Point 9',NULL,-23.564302,-46.537056,1,'2011-07-19 12:25:23'),(294,4,'Point 10',NULL,-23.558637,-46.815147,1,'2011-07-19 12:25:25'),(295,4,'Point 11',NULL,-23.558008,-46.784248,1,'2011-07-19 12:25:25'),(296,4,'Point 12',NULL,-23.571225,-46.762276,1,'2011-07-19 12:25:25'),(297,4,'Point 13',NULL,-23.571225,-46.734123,1,'2011-07-19 12:25:26');
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_layer`
--

DROP TABLE IF EXISTS `location_layer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location_layer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `layer_color` varchar(10) NOT NULL,
  `incident_id` int(11) unsigned NOT NULL,
  `layer_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_layer`
--

LOCK TABLES `location_layer` WRITE;
/*!40000 ALTER TABLE `location_layer` DISABLE KEYS */;
INSERT INTO `location_layer` VALUES (1,'00ff00',36,'Cidades'),(2,'0000ff',36,'arvores'),(4,'ff0000',36,'Layer Padrão');
/*!40000 ALTER TABLE `location_layer` ENABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,4,4,NULL,2,NULL,NULL,'http://www.youtube.com/watch?v=QW0i1U4u0KE&feature=aso',NULL,NULL,'2011-05-23 13:29:30',1),(2,4,4,NULL,1,NULL,NULL,'4_1_1306168170.png','4_1_1306168170_m.png','4_1_1306168170_t.png','2011-05-23 13:29:32',1),(3,11,11,NULL,4,NULL,NULL,'http://www.padboulevard.com.br/',NULL,NULL,'2011-05-25 01:40:12',1),(4,12,12,NULL,1,NULL,NULL,'12_1_1306287984.jpg','12_1_1306287984_m.jpg','12_1_1306287984_t.jpg','2011-05-25 01:46:25',1),(5,13,13,NULL,1,NULL,NULL,'13_1_1306451534.jpg','13_1_1306451534_m.jpg','13_1_1306451534_t.jpg','2011-05-26 23:12:15',1),(6,168,24,NULL,2,NULL,NULL,'video1',NULL,NULL,'2011-07-07 21:07:48',1),(7,168,24,NULL,2,NULL,NULL,'video2',NULL,NULL,'2011-07-07 21:07:48',1),(8,168,24,NULL,1,NULL,NULL,'24_1_1310083668.jpg','24_1_1310083668_m.jpg','24_1_1310083668_t.jpg','2011-07-07 21:07:48',1),(9,168,24,NULL,2,NULL,NULL,'sadfasdf',NULL,NULL,'2011-07-07 21:08:46',1),(10,168,24,NULL,2,NULL,NULL,'dfasdf',NULL,NULL,'2011-07-07 21:08:46',1),(11,168,24,NULL,2,NULL,NULL,'sdfasdf',NULL,NULL,'2011-07-07 21:08:46',1),(12,168,24,NULL,1,NULL,NULL,'24_1_1310083758.jpg','24_1_1310083758_m.jpg','24_1_1310083758_t.jpg','2011-07-07 21:09:19',1),(13,175,25,NULL,1,NULL,NULL,'25_1_1310084099.jpg','25_1_1310084099_m.jpg','25_1_1310084099_t.jpg','2011-07-07 21:14:59',1),(14,174,25,NULL,1,NULL,NULL,'25_1_1310084128.jpg','25_1_1310084128_m.jpg','25_1_1310084128_t.jpg','2011-07-07 21:15:29',1),(15,172,25,NULL,2,NULL,NULL,'video :-)',NULL,NULL,'2011-07-07 21:15:38',1),(16,177,27,NULL,2,NULL,NULL,'youtube eu sou feliz',NULL,NULL,'2011-07-08 09:45:37',1),(17,177,27,NULL,1,NULL,NULL,'27_1_1310129137.jpg','27_1_1310129137_m.jpg','27_1_1310129137_t.jpg','2011-07-08 09:45:37',1),(18,180,28,NULL,2,NULL,NULL,'http://www.youtube.com/watch?v=lUzHi0b4N2g&feature=topvideos_music',NULL,NULL,'2011-07-08 10:08:05',1);
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
INSERT INTO `scheduler` VALUES (1,'Feeds',1311089009,-1,-1,-1,0,'s_feeds',1),(2,'Alerts',1311089286,-1,-1,-1,-1,'s_alerts',1),(3,'Email',1306765753,-1,-1,-1,0,'s_email',1),(4,'Twitter',1306765753,-1,-1,-1,0,'s_twitter',1),(5,'Sharing',1306765753,-1,-1,-1,0,'s_sharing',1);
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
) ENGINE=MyISAM AUTO_INCREMENT=849 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduler_log`
--

LOCK TABLES `scheduler_log` WRITE;
/*!40000 ALTER TABLE `scheduler_log` DISABLE KEYS */;
INSERT INTO `scheduler_log` VALUES (1,1,'Feeds','200',1305745652),(2,2,'Alerts','200',1305745652),(3,1,'Feeds','200',1305753201),(4,2,'Alerts','200',1305753201),(5,1,'Feeds','200',1306154418),(6,2,'Alerts','200',1306154418),(7,2,'Alerts','200',1306154547),(8,2,'Alerts','200',1306155127),(9,2,'Alerts','200',1306155265),(10,2,'Alerts','200',1306155318),(11,2,'Alerts','200',1306155540),(12,1,'Feeds','200',1306155612),(13,2,'Alerts','200',1306155612),(14,2,'Alerts','200',1306155692),(15,2,'Alerts','200',1306155722),(16,2,'Alerts','200',1306155798),(17,2,'Alerts','200',1306155910),(18,2,'Alerts','200',1306156147),(19,2,'Alerts','200',1306156277),(20,2,'Alerts','200',1306156416),(21,2,'Alerts','200',1306156463),(22,2,'Alerts','200',1306156501),(23,2,'Alerts','200',1306156621),(24,2,'Alerts','200',1306156761),(25,2,'Alerts','200',1306156832),(26,2,'Alerts','200',1306156990),(27,2,'Alerts','200',1306157044),(28,2,'Alerts','200',1306157119),(29,2,'Alerts','200',1306157500),(30,2,'Alerts','200',1306157528),(31,2,'Alerts','200',1306157795),(32,2,'Alerts','200',1306157852),(33,2,'Alerts','200',1306157894),(34,2,'Alerts','200',1306157946),(35,2,'Alerts','200',1306158014),(36,2,'Alerts','200',1306158085),(37,2,'Alerts','200',1306158154),(38,2,'Alerts','200',1306158181),(39,2,'Alerts','200',1306158306),(40,2,'Alerts','200',1306158413),(41,2,'Alerts','200',1306158421),(42,2,'Alerts','200',1306158487),(43,2,'Alerts','200',1306158540),(44,2,'Alerts','200',1306158542),(45,2,'Alerts','200',1306158639),(46,2,'Alerts','200',1306158778),(47,2,'Alerts','200',1306158781),(48,2,'Alerts','200',1306158869),(49,2,'Alerts','200',1306158953),(50,2,'Alerts','200',1306159016),(51,2,'Alerts','200',1306159024),(52,2,'Alerts','200',1306159160),(53,1,'Feeds','200',1306159292),(54,2,'Alerts','200',1306159292),(55,2,'Alerts','200',1306159334),(56,2,'Alerts','200',1306159445),(57,2,'Alerts','200',1306159527),(58,2,'Alerts','200',1306159667),(59,2,'Alerts','200',1306159695),(60,2,'Alerts','200',1306159755),(61,2,'Alerts','200',1306159829),(62,2,'Alerts','200',1306159872),(63,2,'Alerts','200',1306159924),(64,2,'Alerts','200',1306159984),(65,2,'Alerts','200',1306160087),(66,2,'Alerts','200',1306160335),(67,2,'Alerts','200',1306160345),(68,2,'Alerts','200',1306160400),(69,2,'Alerts','200',1306160402),(70,2,'Alerts','200',1306161732),(71,2,'Alerts','200',1306161805),(72,2,'Alerts','200',1306161870),(73,2,'Alerts','200',1306161918),(74,2,'Alerts','200',1306161963),(75,2,'Alerts','200',1306162024),(76,2,'Alerts','200',1306162082),(77,2,'Alerts','200',1306162154),(78,2,'Alerts','200',1306162201),(79,2,'Alerts','200',1306162318),(80,2,'Alerts','200',1306162483),(81,2,'Alerts','200',1306162501),(82,2,'Alerts','200',1306162583),(83,2,'Alerts','200',1306162794),(84,1,'Feeds','200',1306162825),(85,2,'Alerts','200',1306162825),(86,2,'Alerts','200',1306162930),(87,2,'Alerts','200',1306164178),(88,1,'Feeds','200',1306168056),(89,2,'Alerts','200',1306168056),(90,2,'Alerts','200',1306168173),(91,2,'Alerts','200',1306168355),(92,2,'Alerts','200',1306168391),(93,2,'Alerts','200',1306168452),(94,2,'Alerts','200',1306168502),(95,2,'Alerts','200',1306168577),(96,2,'Alerts','200',1306168629),(97,2,'Alerts','200',1306168680),(98,2,'Alerts','200',1306168683),(99,2,'Alerts','200',1306168741),(100,2,'Alerts','200',1306168815),(101,2,'Alerts','200',1306169197),(102,2,'Alerts','200',1306169242),(103,2,'Alerts','200',1306169343),(104,2,'Alerts','200',1306169408),(105,2,'Alerts','200',1306169488),(106,2,'Alerts','200',1306169539),(107,2,'Alerts','200',1306169758),(108,2,'Alerts','200',1306169808),(109,2,'Alerts','200',1306169886),(110,2,'Alerts','200',1306169981),(111,1,'Feeds','200',1306170004),(112,2,'Alerts','200',1306170004),(113,1,'Feeds','200',1306170005),(114,2,'Alerts','200',1306170005),(115,2,'Alerts','200',1306170083),(116,2,'Alerts','200',1306170163),(117,2,'Alerts','200',1306170205),(118,2,'Alerts','200',1306170252),(119,2,'Alerts','200',1306170363),(120,2,'Alerts','200',1306170427),(121,2,'Alerts','200',1306170529),(122,2,'Alerts','200',1306170547),(123,2,'Alerts','200',1306170630),(124,2,'Alerts','200',1306170677),(125,2,'Alerts','200',1306170733),(126,2,'Alerts','200',1306170781),(127,2,'Alerts','200',1306171147),(128,2,'Alerts','200',1306171350),(129,2,'Alerts','200',1306171576),(130,2,'Alerts','200',1306171693),(131,2,'Alerts','200',1306171765),(132,2,'Alerts','200',1306171813),(133,2,'Alerts','200',1306171936),(134,2,'Alerts','200',1306172057),(135,2,'Alerts','200',1306172114),(136,2,'Alerts','200',1306172239),(137,2,'Alerts','200',1306172297),(138,2,'Alerts','200',1306172535),(139,2,'Alerts','200',1306172595),(140,2,'Alerts','200',1306172642),(141,2,'Alerts','200',1306172726),(142,2,'Alerts','200',1306172774),(143,2,'Alerts','200',1306173278),(144,2,'Alerts','200',1306173307),(145,2,'Alerts','200',1306173494),(146,2,'Alerts','200',1306173541),(147,1,'Feeds','200',1306173748),(148,2,'Alerts','200',1306173748),(149,1,'Feeds','200',1306177578),(150,2,'Alerts','200',1306177578),(151,1,'Feeds','200',1306266279),(152,2,'Alerts','200',1306266279),(153,2,'Alerts','200',1306266408),(154,2,'Alerts','200',1306266766),(155,3,'Email','200',1306266766),(156,4,'Twitter','200',1306266766),(157,5,'Sharing','200',1306266766),(158,2,'Alerts','200',1306266933),(159,2,'Alerts','200',1306267059),(160,2,'Alerts','200',1306267093),(161,2,'Alerts','200',1306267145),(162,1,'Feeds','200',1306267288),(163,2,'Alerts','200',1306267288),(164,1,'Feeds','200',1306267288),(165,2,'Alerts','200',1306267288),(166,3,'Email','200',1306267288),(167,3,'Email','200',1306267288),(168,4,'Twitter','200',1306267288),(169,5,'Sharing','200',1306267288),(170,4,'Twitter','200',1306267288),(171,5,'Sharing','200',1306267288),(172,2,'Alerts','200',1306267747),(173,2,'Alerts','200',1306267832),(174,2,'Alerts','200',1306267939),(175,2,'Alerts','200',1306268130),(176,2,'Alerts','200',1306268184),(177,2,'Alerts','200',1306268279),(178,2,'Alerts','200',1306268306),(179,2,'Alerts','200',1306268355),(180,2,'Alerts','200',1306268462),(181,2,'Alerts','200',1306268695),(182,2,'Alerts','200',1306268710),(183,2,'Alerts','200',1306268761),(184,2,'Alerts','200',1306268861),(185,2,'Alerts','200',1306268890),(186,2,'Alerts','200',1306270373),(187,2,'Alerts','200',1306270388),(188,2,'Alerts','200',1306270504),(189,1,'Feeds','200',1306277861),(190,2,'Alerts','200',1306277861),(191,3,'Email','200',1306277861),(192,4,'Twitter','200',1306277861),(193,5,'Sharing','200',1306277861),(194,1,'Feeds','200',1306280902),(195,2,'Alerts','200',1306280902),(196,3,'Email','200',1306280902),(197,4,'Twitter','200',1306280902),(198,5,'Sharing','200',1306280902),(199,1,'Feeds','200',1306281936),(200,2,'Alerts','200',1306281936),(201,3,'Email','200',1306281936),(202,4,'Twitter','200',1306281936),(203,5,'Sharing','200',1306281936),(204,1,'Feeds','200',1306287065),(205,2,'Alerts','200',1306287065),(206,3,'Email','200',1306287065),(207,4,'Twitter','200',1306287065),(208,5,'Sharing','200',1306287065),(209,2,'Alerts','200',1306287288),(210,2,'Alerts','200',1306287424),(211,2,'Alerts','200',1306287613),(212,2,'Alerts','200',1306287865),(213,2,'Alerts','200',1306287987),(214,2,'Alerts','200',1306288090),(215,2,'Alerts','200',1306288141),(216,2,'Alerts','200',1306288203),(217,1,'Feeds','200',1306332492),(218,2,'Alerts','200',1306332492),(219,3,'Email','200',1306332492),(220,4,'Twitter','200',1306332492),(221,5,'Sharing','200',1306332492),(222,1,'Feeds','200',1306332494),(223,2,'Alerts','200',1306332494),(224,3,'Email','200',1306332494),(225,4,'Twitter','200',1306332494),(226,5,'Sharing','200',1306332494),(227,2,'Alerts','200',1306332607),(228,2,'Alerts','200',1306332783),(229,2,'Alerts','200',1306332884),(230,2,'Alerts','200',1306332925),(231,2,'Alerts','200',1306333027),(232,2,'Alerts','200',1306333086),(233,2,'Alerts','200',1306333141),(234,2,'Alerts','200',1306333216),(235,2,'Alerts','200',1306333270),(236,2,'Alerts','200',1306333382),(237,2,'Alerts','200',1306333448),(238,2,'Alerts','200',1306333699),(239,2,'Alerts','200',1306333778),(240,2,'Alerts','200',1306333859),(241,2,'Alerts','200',1306334033),(242,2,'Alerts','200',1306335204),(243,2,'Alerts','200',1306335326),(244,2,'Alerts','200',1306335377),(245,2,'Alerts','200',1306335561),(246,1,'Feeds','200',1306335689),(247,2,'Alerts','200',1306335689),(248,3,'Email','200',1306335689),(249,4,'Twitter','200',1306335689),(250,5,'Sharing','200',1306335689),(251,1,'Feeds','200',1306335728),(252,2,'Alerts','200',1306335728),(253,3,'Email','200',1306335728),(254,4,'Twitter','200',1306335728),(255,5,'Sharing','200',1306335728),(256,2,'Alerts','200',1306335837),(257,2,'Alerts','200',1306336067),(258,2,'Alerts','200',1306336216),(259,2,'Alerts','200',1306336263),(260,2,'Alerts','200',1306336321),(261,2,'Alerts','200',1306336386),(262,2,'Alerts','200',1306336448),(263,2,'Alerts','200',1306336927),(264,2,'Alerts','200',1306337107),(265,1,'Feeds','200',1306451474),(266,1,'Feeds','200',1306451474),(267,2,'Alerts','200',1306451474),(268,2,'Alerts','200',1306451474),(269,3,'Email','200',1306451474),(270,3,'Email','200',1306451474),(271,4,'Twitter','200',1306451474),(272,5,'Sharing','200',1306451474),(273,4,'Twitter','200',1306451474),(274,5,'Sharing','200',1306451474),(275,2,'Alerts','200',1306451536),(276,2,'Alerts','200',1306451616),(277,2,'Alerts','200',1306451669),(278,2,'Alerts','200',1306451704),(279,1,'Feeds','200',1306541516),(280,2,'Alerts','200',1306541516),(281,3,'Email','200',1306541516),(282,4,'Twitter','200',1306541516),(283,5,'Sharing','200',1306541516),(284,1,'Feeds','200',1306725343),(285,2,'Alerts','200',1306725343),(286,3,'Email','200',1306725343),(287,4,'Twitter','200',1306725343),(288,5,'Sharing','200',1306725343),(289,2,'Alerts','200',1306725381),(290,1,'Feeds','200',1306763792),(291,2,'Alerts','200',1306763792),(292,3,'Email','200',1306763792),(293,4,'Twitter','200',1306763792),(294,5,'Sharing','200',1306763792),(295,1,'Feeds','200',1306765738),(296,2,'Alerts','200',1306765738),(297,3,'Email','200',1306765738),(298,4,'Twitter','200',1306765738),(299,5,'Sharing','200',1306765738),(300,2,'Alerts','200',1306765746),(301,1,'Feeds','200',1306765753),(302,2,'Alerts','200',1306765753),(303,3,'Email','200',1306765753),(304,4,'Twitter','200',1306765753),(305,5,'Sharing','200',1306765753),(306,2,'Alerts','200',1306765821),(307,1,'Feeds','200',1308012040),(308,2,'Alerts','200',1308012040),(309,2,'Alerts','200',1308012118),(310,2,'Alerts','200',1308012121),(311,2,'Alerts','200',1308012236),(312,2,'Alerts','200',1308012435),(313,2,'Alerts','200',1308012493),(314,2,'Alerts','200',1308012660),(315,2,'Alerts','200',1308013067),(316,2,'Alerts','200',1308013105),(317,2,'Alerts','200',1308013173),(318,1,'Feeds','200',1308013216),(319,2,'Alerts','200',1308013216),(320,2,'Alerts','200',1308013263),(321,2,'Alerts','200',1308013360),(322,2,'Alerts','200',1308013777),(323,2,'Alerts','200',1308013833),(324,2,'Alerts','200',1308014020),(325,2,'Alerts','200',1308014107),(326,2,'Alerts','200',1308014246),(327,2,'Alerts','200',1308014516),(328,2,'Alerts','200',1308014554),(329,2,'Alerts','200',1308014614),(330,2,'Alerts','200',1308014772),(331,2,'Alerts','200',1308014824),(332,2,'Alerts','200',1308014896),(333,2,'Alerts','200',1308015267),(334,2,'Alerts','200',1308015869),(335,2,'Alerts','200',1308016135),(336,2,'Alerts','200',1308016168),(337,2,'Alerts','200',1308016393),(338,1,'Feeds','200',1308016806),(339,2,'Alerts','200',1308016806),(340,1,'Feeds','200',1308591551),(341,2,'Alerts','200',1308591551),(342,2,'Alerts','200',1308591706),(343,2,'Alerts','200',1308591957),(344,2,'Alerts','200',1308592001),(345,2,'Alerts','200',1308592034),(346,2,'Alerts','200',1308592135),(347,2,'Alerts','200',1308592403),(348,2,'Alerts','200',1308592681),(349,2,'Alerts','200',1308592762),(350,1,'Feeds','200',1308593502),(351,2,'Alerts','200',1308593502),(352,2,'Alerts','200',1308593531),(353,2,'Alerts','200',1308593655),(354,2,'Alerts','200',1308593727),(355,2,'Alerts','200',1308593836),(356,2,'Alerts','200',1308594015),(357,2,'Alerts','200',1308594072),(358,2,'Alerts','200',1308594148),(359,2,'Alerts','200',1308594182),(360,1,'Feeds','200',1308670404),(361,2,'Alerts','200',1308670404),(362,2,'Alerts','200',1308670559),(363,2,'Alerts','200',1308670676),(364,2,'Alerts','200',1308670775),(365,2,'Alerts','200',1308671600),(366,2,'Alerts','200',1308671780),(367,1,'Feeds','200',1308672118),(368,2,'Alerts','200',1308672118),(369,2,'Alerts','200',1308672131),(370,2,'Alerts','200',1308672231),(371,2,'Alerts','200',1308672247),(372,2,'Alerts','200',1308672312),(373,2,'Alerts','200',1308672392),(374,2,'Alerts','200',1308672508),(375,2,'Alerts','200',1308672573),(376,2,'Alerts','200',1308672611),(377,2,'Alerts','200',1308672732),(378,2,'Alerts','200',1308672901),(379,2,'Alerts','200',1308673222),(380,2,'Alerts','200',1308674527),(381,2,'Alerts','200',1308674609),(382,2,'Alerts','200',1308674641),(383,2,'Alerts','200',1308675197),(384,2,'Alerts','200',1308675454),(385,2,'Alerts','200',1308675499),(386,2,'Alerts','200',1308675584),(387,1,'Feeds','200',1308675636),(388,2,'Alerts','200',1308675636),(389,2,'Alerts','200',1308676897),(390,2,'Alerts','200',1308678397),(391,2,'Alerts','200',1308678717),(392,2,'Alerts','200',1308678807),(393,2,'Alerts','200',1308678846),(394,2,'Alerts','200',1308678905),(395,1,'Feeds','200',1308679641),(396,2,'Alerts','200',1308679641),(397,2,'Alerts','200',1308679786),(398,2,'Alerts','200',1308680145),(399,2,'Alerts','200',1308680173),(400,1,'Feeds','200',1309819639),(401,2,'Alerts','200',1309819639),(402,2,'Alerts','200',1309819720),(403,1,'Feeds','200',1309820420),(404,2,'Alerts','200',1309820420),(405,1,'Feeds','200',1309873915),(406,2,'Alerts','200',1309873915),(407,2,'Alerts','200',1309874039),(408,2,'Alerts','200',1309874272),(409,1,'Feeds','200',1309874527),(410,2,'Alerts','200',1309874527),(411,2,'Alerts','200',1309875053),(412,2,'Alerts','200',1309875065),(413,2,'Alerts','200',1309875262),(414,2,'Alerts','200',1309875375),(415,2,'Alerts','200',1309875444),(416,2,'Alerts','200',1309875510),(417,2,'Alerts','200',1309875640),(418,2,'Alerts','200',1309875729),(419,2,'Alerts','200',1309875926),(420,2,'Alerts','200',1309877144),(421,1,'Feeds','200',1309878006),(422,2,'Alerts','200',1309878006),(423,2,'Alerts','200',1309879501),(424,2,'Alerts','200',1309880571),(425,2,'Alerts','200',1309880583),(426,2,'Alerts','200',1309880977),(427,2,'Alerts','200',1309881244),(428,2,'Alerts','200',1309881336),(429,2,'Alerts','200',1309881363),(430,2,'Alerts','200',1309881455),(431,2,'Alerts','200',1309881584),(432,1,'Feeds','200',1309882270),(433,2,'Alerts','200',1309882270),(434,2,'Alerts','200',1309882341),(435,2,'Alerts','200',1309882465),(436,2,'Alerts','200',1309882505),(437,2,'Alerts','200',1309882896),(438,2,'Alerts','200',1309882938),(439,2,'Alerts','200',1309883094),(440,2,'Alerts','200',1309883109),(441,2,'Alerts','200',1309883163),(442,2,'Alerts','200',1309883226),(443,2,'Alerts','200',1309883284),(444,2,'Alerts','200',1309883370),(445,2,'Alerts','200',1309883429),(446,2,'Alerts','200',1309883671),(447,2,'Alerts','200',1309883832),(448,2,'Alerts','200',1309883905),(449,2,'Alerts','200',1309883956),(450,2,'Alerts','200',1309884349),(451,2,'Alerts','200',1309884402),(452,2,'Alerts','200',1309884476),(453,2,'Alerts','200',1309884654),(454,2,'Alerts','200',1309884907),(455,1,'Feeds','200',1309885246),(456,2,'Alerts','200',1309885246),(457,2,'Alerts','200',1309885433),(458,2,'Alerts','200',1309885478),(459,2,'Alerts','200',1309885625),(460,2,'Alerts','200',1309885883),(461,2,'Alerts','200',1309886019),(462,2,'Alerts','200',1309886075),(463,2,'Alerts','200',1309886160),(464,2,'Alerts','200',1309886226),(465,2,'Alerts','200',1309886351),(466,2,'Alerts','200',1309886470),(467,2,'Alerts','200',1309886728),(468,2,'Alerts','200',1309886852),(469,2,'Alerts','200',1309887045),(470,2,'Alerts','200',1309887062),(471,2,'Alerts','200',1309887209),(472,2,'Alerts','200',1309887265),(473,2,'Alerts','200',1309887316),(474,2,'Alerts','200',1309887428),(475,1,'Feeds','200',1309964644),(476,2,'Alerts','200',1309964645),(477,2,'Alerts','200',1309964704),(478,2,'Alerts','200',1309965139),(479,2,'Alerts','200',1309965628),(480,2,'Alerts','200',1309965664),(481,2,'Alerts','200',1309966127),(482,2,'Alerts','200',1309966953),(483,2,'Alerts','200',1309967048),(484,2,'Alerts','200',1309967106),(485,2,'Alerts','200',1309967170),(486,2,'Alerts','200',1309967237),(487,2,'Alerts','200',1309967286),(488,2,'Alerts','200',1309967362),(489,2,'Alerts','200',1309967474),(490,2,'Alerts','200',1309967555),(491,1,'Feeds','200',1309969770),(492,2,'Alerts','200',1309969770),(493,2,'Alerts','200',1309969851),(494,2,'Alerts','200',1309969921),(495,2,'Alerts','200',1309971210),(496,2,'Alerts','200',1309971276),(497,2,'Alerts','200',1309971310),(498,2,'Alerts','200',1309971471),(499,2,'Alerts','200',1309971502),(500,2,'Alerts','200',1309971595),(501,1,'Feeds','200',1309971727),(502,2,'Alerts','200',1309971727),(503,2,'Alerts','200',1309971817),(504,2,'Alerts','200',1309971846),(505,2,'Alerts','200',1309971941),(506,2,'Alerts','200',1309972093),(507,2,'Alerts','200',1309972215),(508,2,'Alerts','200',1309972260),(509,2,'Alerts','200',1309972273),(510,2,'Alerts','200',1309972401),(511,2,'Alerts','200',1309972580),(512,2,'Alerts','200',1309972625),(513,2,'Alerts','200',1309972713),(514,2,'Alerts','200',1309972759),(515,1,'Feeds','200',1309976895),(516,2,'Alerts','200',1309976895),(517,2,'Alerts','200',1309978457),(518,2,'Alerts','200',1309978525),(519,2,'Alerts','200',1309978573),(520,2,'Alerts','200',1309978622),(521,2,'Alerts','200',1309978691),(522,1,'Feeds','200',1309978902),(523,2,'Alerts','200',1309978902),(524,2,'Alerts','200',1309978989),(525,2,'Alerts','200',1309979053),(526,2,'Alerts','200',1309979357),(527,2,'Alerts','200',1309979432),(528,1,'Feeds','200',1309982867),(529,2,'Alerts','200',1309982867),(530,2,'Alerts','200',1309982937),(531,2,'Alerts','200',1309984394),(532,2,'Alerts','200',1309984460),(533,2,'Alerts','200',1309984561),(534,2,'Alerts','200',1309984634),(535,2,'Alerts','200',1309984689),(536,2,'Alerts','200',1309984758),(537,2,'Alerts','200',1309985688),(538,2,'Alerts','200',1309985727),(539,2,'Alerts','200',1309985768),(540,2,'Alerts','200',1309985835),(541,2,'Alerts','200',1309985892),(542,2,'Alerts','200',1309985957),(543,1,'Feeds','200',1309986017),(544,2,'Alerts','200',1309986017),(545,2,'Alerts','200',1309986139),(546,2,'Alerts','200',1309986551),(547,2,'Alerts','200',1309986827),(548,2,'Alerts','200',1309986845),(549,2,'Alerts','200',1309987207),(550,2,'Alerts','200',1309987418),(551,2,'Alerts','200',1309987739),(552,2,'Alerts','200',1309987741),(553,2,'Alerts','200',1309987837),(554,2,'Alerts','200',1309987887),(555,2,'Alerts','200',1309987948),(556,2,'Alerts','200',1309987988),(557,2,'Alerts','200',1309988133),(558,2,'Alerts','200',1309988234),(559,2,'Alerts','200',1309988493),(560,2,'Alerts','200',1309988521),(561,1,'Feeds','200',1309991554),(562,2,'Alerts','200',1309991554),(563,1,'Feeds','200',1310046100),(564,2,'Alerts','200',1310046100),(565,1,'Feeds','200',1310050087),(566,2,'Alerts','200',1310050087),(567,1,'Feeds','200',1310053639),(568,2,'Alerts','200',1310053639),(569,2,'Alerts','200',1310053970),(570,2,'Alerts','200',1310054263),(571,2,'Alerts','200',1310054316),(572,2,'Alerts','200',1310054345),(573,1,'Feeds','200',1310054426),(574,2,'Alerts','200',1310054426),(575,2,'Alerts','200',1310054622),(576,2,'Alerts','200',1310054674),(577,2,'Alerts','200',1310054814),(578,2,'Alerts','200',1310054910),(579,2,'Alerts','200',1310055012),(580,2,'Alerts','200',1310055696),(581,2,'Alerts','200',1310055749),(582,2,'Alerts','200',1310055885),(583,2,'Alerts','200',1310055974),(584,2,'Alerts','200',1310056041),(585,2,'Alerts','200',1310056203),(586,2,'Alerts','200',1310056554),(587,2,'Alerts','200',1310056583),(588,2,'Alerts','200',1310056790),(589,2,'Alerts','200',1310057103),(590,2,'Alerts','200',1310057164),(591,2,'Alerts','200',1310057336),(592,2,'Alerts','200',1310057357),(593,2,'Alerts','200',1310057419),(594,1,'Feeds','200',1310058497),(595,2,'Alerts','200',1310058497),(596,2,'Alerts','200',1310058603),(597,2,'Alerts','200',1310059092),(598,2,'Alerts','200',1310059465),(599,2,'Alerts','200',1310059531),(600,2,'Alerts','200',1310059739),(601,2,'Alerts','200',1310060005),(602,2,'Alerts','200',1310060177),(603,2,'Alerts','200',1310060450),(604,2,'Alerts','200',1310060713),(605,2,'Alerts','200',1310060812),(606,2,'Alerts','200',1310060933),(607,2,'Alerts','200',1310060970),(608,2,'Alerts','200',1310061033),(609,2,'Alerts','200',1310061290),(610,2,'Alerts','200',1310061479),(611,2,'Alerts','200',1310061508),(612,2,'Alerts','200',1310061541),(613,1,'Feeds','200',1310061648),(614,2,'Alerts','200',1310061648),(615,2,'Alerts','200',1310061806),(616,2,'Alerts','200',1310061923),(617,2,'Alerts','200',1310062025),(618,1,'Feeds','200',1310066096),(619,2,'Alerts','200',1310066096),(620,2,'Alerts','200',1310068795),(621,1,'Feeds','200',1310068942),(622,2,'Alerts','200',1310068942),(623,2,'Alerts','200',1310068987),(624,2,'Alerts','200',1310069176),(625,2,'Alerts','200',1310069222),(626,2,'Alerts','200',1310069484),(627,2,'Alerts','200',1310069731),(628,2,'Alerts','200',1310069807),(629,2,'Alerts','200',1310069835),(630,2,'Alerts','200',1310069889),(631,2,'Alerts','200',1310069959),(632,2,'Alerts','200',1310070013),(633,2,'Alerts','200',1310070065),(634,2,'Alerts','200',1310070149),(635,2,'Alerts','200',1310070266),(636,2,'Alerts','200',1310070372),(637,2,'Alerts','200',1310070465),(638,2,'Alerts','200',1310070545),(639,2,'Alerts','200',1310070634),(640,2,'Alerts','200',1310070764),(641,2,'Alerts','200',1310070800),(642,2,'Alerts','200',1310070850),(643,2,'Alerts','200',1310071005),(644,2,'Alerts','200',1310071083),(645,2,'Alerts','200',1310071148),(646,2,'Alerts','200',1310071240),(647,2,'Alerts','200',1310071320),(648,2,'Alerts','200',1310071324),(649,2,'Alerts','200',1310071427),(650,2,'Alerts','200',1310071474),(651,2,'Alerts','200',1310071620),(652,2,'Alerts','200',1310071664),(653,2,'Alerts','200',1310071687),(654,2,'Alerts','200',1310071743),(655,2,'Alerts','200',1310071814),(656,2,'Alerts','200',1310071866),(657,2,'Alerts','200',1310071931),(658,2,'Alerts','200',1310072008),(659,1,'Feeds','200',1310077872),(660,2,'Alerts','200',1310077872),(661,1,'Feeds','200',1310077874),(662,2,'Alerts','200',1310077874),(663,2,'Alerts','200',1310078158),(664,2,'Alerts','200',1310078228),(665,2,'Alerts','200',1310078357),(666,2,'Alerts','200',1310078405),(667,2,'Alerts','200',1310078469),(668,2,'Alerts','200',1310078546),(669,2,'Alerts','200',1310078684),(670,2,'Alerts','200',1310078731),(671,2,'Alerts','200',1310078777),(672,2,'Alerts','200',1310078821),(673,2,'Alerts','200',1310078889),(674,2,'Alerts','200',1310078954),(675,2,'Alerts','200',1310079062),(676,2,'Alerts','200',1310079171),(677,2,'Alerts','200',1310079211),(678,2,'Alerts','200',1310079246),(679,2,'Alerts','200',1310079328),(680,2,'Alerts','200',1310079371),(681,2,'Alerts','200',1310079421),(682,2,'Alerts','200',1310079500),(683,2,'Alerts','200',1310079548),(684,1,'Feeds','200',1310079652),(685,2,'Alerts','200',1310079652),(686,2,'Alerts','200',1310079670),(687,2,'Alerts','200',1310079850),(688,2,'Alerts','200',1310080049),(689,2,'Alerts','200',1310080081),(690,2,'Alerts','200',1310080159),(691,2,'Alerts','200',1310080247),(692,2,'Alerts','200',1310080302),(693,2,'Alerts','200',1310080320),(694,2,'Alerts','200',1310080336),(695,2,'Alerts','200',1310080387),(696,2,'Alerts','200',1310080557),(697,2,'Alerts','200',1310080565),(698,2,'Alerts','200',1310080635),(699,2,'Alerts','200',1310080740),(700,2,'Alerts','200',1310080749),(701,2,'Alerts','200',1310080869),(702,2,'Alerts','200',1310080930),(703,2,'Alerts','200',1310080988),(704,2,'Alerts','200',1310081044),(705,2,'Alerts','200',1310081103),(706,2,'Alerts','200',1310081163),(707,2,'Alerts','200',1310081221),(708,2,'Alerts','200',1310081285),(709,2,'Alerts','200',1310081413),(710,2,'Alerts','200',1310081487),(711,2,'Alerts','200',1310081543),(712,1,'Feeds','200',1310083407),(713,2,'Alerts','200',1310083407),(714,2,'Alerts','200',1310083450),(715,2,'Alerts','200',1310083530),(716,2,'Alerts','200',1310083578),(717,2,'Alerts','200',1310083626),(718,2,'Alerts','200',1310083727),(719,2,'Alerts','200',1310083760),(720,2,'Alerts','200',1310083844),(721,2,'Alerts','200',1310083879),(722,2,'Alerts','200',1310084035),(723,2,'Alerts','200',1310084050),(724,2,'Alerts','200',1310084101),(725,2,'Alerts','200',1310084269),(726,2,'Alerts','200',1310084286),(727,2,'Alerts','200',1310084354),(728,1,'Feeds','200',1310128796),(729,2,'Alerts','200',1310128796),(730,2,'Alerts','200',1310129063),(731,2,'Alerts','200',1310129139),(732,2,'Alerts','200',1310129161),(733,2,'Alerts','200',1310129785),(734,1,'Feeds','200',1310130115),(735,2,'Alerts','200',1310130115),(736,2,'Alerts','200',1310130146),(737,2,'Alerts','200',1310130294),(738,2,'Alerts','200',1310130312),(739,2,'Alerts','200',1310130487),(740,2,'Alerts','200',1310131243),(741,2,'Alerts','200',1310131491),(742,2,'Alerts','200',1310131795),(743,2,'Alerts','200',1310132806),(744,1,'Feeds','200',1310137612),(745,2,'Alerts','200',1310137612),(746,2,'Alerts','200',1310137720),(747,2,'Alerts','200',1310137743),(748,1,'Feeds','200',1310149210),(749,2,'Alerts','200',1310149211),(750,1,'Feeds','200',1310779136),(751,2,'Alerts','200',1310779136),(752,2,'Alerts','200',1310779145),(753,2,'Alerts','200',1310779320),(754,1,'Feeds','200',1311037470),(755,2,'Alerts','200',1311037470),(756,2,'Alerts','200',1311037709),(757,2,'Alerts','200',1311037758),(758,2,'Alerts','200',1311037911),(759,2,'Alerts','200',1311037994),(760,2,'Alerts','200',1311038041),(761,2,'Alerts','200',1311039004),(762,2,'Alerts','200',1311039074),(763,2,'Alerts','200',1311039326),(764,2,'Alerts','200',1311039407),(765,2,'Alerts','200',1311039424),(766,2,'Alerts','200',1311039483),(767,2,'Alerts','200',1311039549),(768,2,'Alerts','200',1311040249),(769,2,'Alerts','200',1311040261),(770,1,'Feeds','200',1311078940),(771,2,'Alerts','200',1311078940),(772,2,'Alerts','200',1311078991),(773,2,'Alerts','200',1311079372),(774,2,'Alerts','200',1311079408),(775,2,'Alerts','200',1311079451),(776,2,'Alerts','200',1311079506),(777,2,'Alerts','200',1311079808),(778,2,'Alerts','200',1311079905),(779,2,'Alerts','200',1311079923),(780,2,'Alerts','200',1311079991),(781,2,'Alerts','200',1311080042),(782,2,'Alerts','200',1311080109),(783,2,'Alerts','200',1311080211),(784,2,'Alerts','200',1311080234),(785,2,'Alerts','200',1311080289),(786,2,'Alerts','200',1311080371),(787,1,'Feeds','200',1311080426),(788,2,'Alerts','200',1311080426),(789,2,'Alerts','200',1311080487),(790,2,'Alerts','200',1311080640),(791,2,'Alerts','200',1311080746),(792,2,'Alerts','200',1311080764),(793,2,'Alerts','200',1311080834),(794,2,'Alerts','200',1311080880),(795,2,'Alerts','200',1311080930),(796,2,'Alerts','200',1311081370),(797,2,'Alerts','200',1311081422),(798,2,'Alerts','200',1311081496),(799,2,'Alerts','200',1311081890),(800,2,'Alerts','200',1311081919),(801,2,'Alerts','200',1311081962),(802,2,'Alerts','200',1311082036),(803,2,'Alerts','200',1311082081),(804,2,'Alerts','200',1311082310),(805,2,'Alerts','200',1311082422),(806,2,'Alerts','200',1311082569),(807,2,'Alerts','200',1311082774),(808,2,'Alerts','200',1311082823),(809,2,'Alerts','200',1311082880),(810,2,'Alerts','200',1311082976),(811,2,'Alerts','200',1311083035),(812,2,'Alerts','200',1311083197),(813,2,'Alerts','200',1311083239),(814,2,'Alerts','200',1311083281),(815,2,'Alerts','200',1311083348),(816,2,'Alerts','200',1311083484),(817,2,'Alerts','200',1311083522),(818,2,'Alerts','200',1311083650),(819,2,'Alerts','200',1311083966),(820,1,'Feeds','200',1311084117),(821,2,'Alerts','200',1311084117),(822,2,'Alerts','200',1311084161),(823,2,'Alerts','200',1311084197),(824,2,'Alerts','200',1311084424),(825,2,'Alerts','200',1311084486),(826,2,'Alerts','200',1311084552),(827,2,'Alerts','200',1311084604),(828,2,'Alerts','200',1311084687),(829,2,'Alerts','200',1311084720),(830,2,'Alerts','200',1311084782),(831,2,'Alerts','200',1311085146),(832,2,'Alerts','200',1311085271),(833,2,'Alerts','200',1311085691),(834,2,'Alerts','200',1311085777),(835,2,'Alerts','200',1311085826),(836,2,'Alerts','200',1311085886),(837,2,'Alerts','200',1311085922),(838,2,'Alerts','200',1311085990),(839,2,'Alerts','200',1311086180),(840,2,'Alerts','200',1311086272),(841,2,'Alerts','200',1311086284),(842,2,'Alerts','200',1311086662),(843,1,'Feeds','200',1311089009),(844,2,'Alerts','200',1311089009),(845,2,'Alerts','200',1311089042),(846,2,'Alerts','200',1311089104),(847,2,'Alerts','200',1311089255),(848,2,'Alerts','200',1311089286);
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tokens`
--

LOCK TABLES `user_tokens` WRITE;
/*!40000 ALTER TABLE `user_tokens` DISABLE KEYS */;
INSERT INTO `user_tokens` VALUES (1,1,'2a4dc598ea59dc708ff981b28ea59c17bb68acba','GiAs99cabmHeJiDFSikZNnzfm3PAZxsj',1306160095,1307369695),(2,1,'2a4dc598ea59dc708ff981b28ea59c17bb68acba','kmeE3NwK5R1JbqYufQnCLUFtoyMPQC5h',1306162337,1307371937),(3,1,'2a4dc598ea59dc708ff981b28ea59c17bb68acba','HaFOEEhXg7UYdKrSzJjR0UyWVN18I7Zh',1306178308,1307387908),(4,1,'2a4dc598ea59dc708ff981b28ea59c17bb68acba','qjUz3wNEbLY6ihmFGo4fN14a6XY0B66Y',1306333845,1307543445),(5,1,'76a89b4b576d97733b64e11ceee438097cad88da','B23wuLlBoxFhTZQwZ4Q8e4STqNCJGgST',1306333878,1307543478),(6,1,'72184714002490a22d3c49cbd08b7aff47fea104','ScM0xOawFDKaYb74XtsCvzrZPCRQxHYd',1308013740,1309223340),(7,1,'c510ffce4e62204929207083f8771697a15ffa64','gawkBb8M4ejgaA9yuvRrk4Kc4Dc5jqa5',1309874554,1311084154),(8,1,'d2d78a0ba72dc8d5f04f756243e1ef8392342a26','ilDKNrHGgih1tQEEoUDDYNXxL7bvdtMo',1310077898,1311287498);
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
INSERT INTO `users` VALUES (1,'Administrator','david@ushahidi.com','admin','bae4b17e9acbabf959654a4c496e577003e0b887c6f52803d7',128,1310133887,0,'2011-07-08 14:04:47');
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

-- Dump completed on 2011-07-19 12:35:51
