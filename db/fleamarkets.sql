-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: rakuichi-rakuza
-- ------------------------------------------------------
-- Server version   5.1.73

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
-- Dumping data for table `fleamarkets`
--

LOCK TABLES `fleamarkets` WRITE;
/*!40000 ALTER TABLE `fleamarkets` DISABLE KEYS */;
INSERT INTO `fleamarkets` VALUES (1,1,'','北海道フリマ','A',1,'2014-03-10','08:30:00','15:30:00',1,'','','BB',0,NULL,NULL,'','','','','',0,0,0,0,0,1,0,'',2,1,0,NULL,'2014-03-03 17:46:55',NULL,NULL),(2,4,'','青森フリマ','A',1,'2014-03-09','09:30:00','15:45:00',1,'','','BB',0,NULL,NULL,'','','','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'2014-03-03 17:53:25',NULL,NULL),(3,7,'','秋田フリマ','フリマ同好会',1,'2014-03-29','08:35:00','15:30:00',1,'','','BB',0,NULL,NULL,'','','','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'2014-03-03 17:57:14',NULL,NULL),(4,8,'','岩手フリマ','楽市楽座',1,'2014-03-29','08:30:00','15:30:00',1,'','','初開催のフリマです。\r\nみなさまのお越しをお待ちしております。\r\n\r\n',0,NULL,NULL,'012-3456-7890','example@abc.com','http://www.example.com','','',0,1,0,1,0,0,0,'',2,1,0,NULL,'2014-03-04 11:32:44',NULL,NULL),(5,11,'','宮城フリマ','A',1,'2014-03-21','08:30:00','15:30:00',1,'','','A',0,NULL,NULL,'023-4567-4568','','','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'2014-03-04 16:22:05',NULL,NULL),(6,12,'','山形フリマ','A',1,'2014-03-22','08:30:00','15:30:00',1,'','','A',0,NULL,NULL,'023-4567-4568','','','','',0,0,0,0,0,0,NULL,'',2,1,0,NULL,'0000-00-00 00:00:00',NULL,NULL),(7,13,'','福島フリマ','A',1,'2014-03-29','13:30:00','15:30:00',1,'','','A',0,NULL,NULL,'023-4567-4568','','','','',0,0,0,0,0,0,NULL,'',2,1,0,NULL,'0000-00-00 00:00:00',NULL,NULL),(8,14,'','茨城フリマ','A',1,'2014-03-29','12:00:00','15:30:00',1,'','','A',0,NULL,NULL,'023-4567-4568','','','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'0000-00-00 00:00:00',NULL,NULL),(9,15,'','栃木フリマ','A',1,'2014-03-29','08:30:00','15:30:00',1,'','','A',0,NULL,NULL,'023-4567-4568','','','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'2014-03-04 09:19:13',NULL,NULL),(10,34,'','群馬フリマ','C',1,'2014-04-30','08:30:00','15:30:00',1,'','','あれこれ\r\nそれあれ',0,NULL,NULL,'012-3456-3333','aaa@example.com','http://www.example.com','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'2014-03-05 04:16:18',NULL,NULL),(11,35,'','埼玉フリマ','ZZ',1,'2014-04-26','08:30:00','15:30:00',1,'','','A',0,NULL,NULL,'03-4321-1234','zz.tomo@gmail.com','http://flea.com','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'2014-03-05 04:25:16',NULL,NULL),(12,36,'','東京フリマ','ZZ',1,'2014-04-26','08:30:00','15:30:00',1,'','','A',0,NULL,NULL,'03-4321-1234','zz.tomo@gmail.com','http://flea.com','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'2014-03-05 04:27:01',NULL,NULL),(13,37,'','千葉フリマ','越谷氏',1,'2014-04-12','08:30:00','15:30:00',1,'','','越谷レイクタウンでフリマ開催',0,NULL,NULL,'03-4567-4567','aaabbb@gmail.com','','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'2014-03-06 08:46:05',NULL,NULL),(22,74,'','アニメフリマ','アニメ屋本舗',1,'2014-05-03','11:00:00','16:00:00',1,'','','アニメ専門フリマ',0,NULL,NULL,'012-3456-7890','contact@anim.com','http://www.anim.com','','',0,0,0,1,1,1,0,'',2,1,0,NULL,'2014-03-12 13:10:57',NULL,NULL),(23,75,'','A','A',1,'2014-03-15','09:00:00','17:00:00',1,'','','A',0,NULL,NULL,'012-3456-7890','example@abc.com','http://www.example.com','','',0,0,0,0,0,0,0,'',2,1,0,NULL,'2014-03-12 17:58:34',NULL,NULL);
/*!40000 ALTER TABLE `fleamarkets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,NULL,'AA','1000001',1,'札幌市','札幌市',2,0,NULL,'2014-03-03 17:46:55',NULL,NULL),(4,NULL,'AA','1000001',1,'札幌市','札幌市',2,0,NULL,'2014-03-03 17:53:25',NULL,NULL),(7,NULL,'幕張','1000001',1,'札幌市','札幌市',2,0,NULL,'2014-03-03 17:57:14',NULL,NULL),(8,NULL,'どこそこ','1000001',13,'中野区中の','中野区中の',2,0,NULL,'2014-03-04 11:32:44',NULL,NULL),(11,NULL,'A','1000001',1,'札幌市','札幌市',2,0,NULL,'2014-03-04 16:22:05',NULL,NULL),(12,NULL,'A','1000001',1,'札幌市','札幌市',2,0,NULL,'0000-00-00 00:00:00',NULL,NULL),(13,NULL,'A','1000001',1,'札幌市','札幌市',2,0,NULL,'0000-00-00 00:00:00',NULL,NULL),(14,NULL,'A','1000001',1,'札幌市','札幌市',2,0,NULL,'0000-00-00 00:00:00',NULL,NULL),(15,NULL,'A','1000001',1,'札幌市','札幌市',2,0,NULL,'2014-03-04 09:19:13',NULL,NULL),(34,NULL,'CCC','1000001',1,'函館市','函館市',2,0,NULL,'2014-03-05 04:16:18',NULL,NULL),(35,NULL,'どこそこスーパー','3702222',10,'安中市','群馬県安中市',2,0,NULL,'2014-03-05 04:25:16',NULL,NULL),(36,NULL,'どこそこスーパー','3702222',10,'安中市','群馬県安中市',2,0,NULL,'2014-03-05 04:27:01',NULL,NULL),(37,NULL,'越谷レイクタウン','3430826',11,'越谷市東町4-50','埼玉県越谷市東町4-50',2,0,NULL,'2014-03-06 08:46:05',NULL,NULL),(74,NULL,'アニメ屋本舗駐車場','2068666',13,'多摩市関戸六丁目12番地1','東京都多摩市関戸六丁目12番地1',2,0,NULL,'2014-03-12 13:10:57',NULL,NULL),(75,NULL,'あっち','1560043',13,'杉並区','東京都杉並区',2,0,NULL,'2014-03-12 17:58:34',NULL,NULL);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `fleamarket_abouts`
--

LOCK TABLES `fleamarket_abouts` WRITE;
/*!40000 ALTER TABLE `fleamarket_abouts` DISABLE KEYS */;
INSERT INTO `fleamarket_abouts` VALUES (1,4,1,'最寄り駅または交通アクセス','渋谷駅徒歩5分',0,NULL,'2014-03-03 17:53:25',NULL,NULL),(2,4,2,'開催時間について','8:00受付開始',0,NULL,'2014-03-03 17:53:25',NULL,NULL),(3,4,3,'募集ブース数について','車出店30',0,NULL,'2014-03-03 17:53:25',NULL,NULL),(4,4,4,'出店形態について','車出店手作り・プロ',0,NULL,'2014-03-03 17:53:25',NULL,NULL),(5,4,5,'出店料金について','プロのみ500円',0,NULL,'2014-03-03 17:53:25',NULL,NULL),(6,4,6,'出店に際してのご注意','暴れないように！',0,NULL,'2014-03-03 17:53:25',NULL,NULL),(7,4,7,'駐車場について','なし',0,NULL,'2014-03-03 17:53:25',NULL,NULL),(8,5,0,'最寄り駅または交通アクセス','渋谷駅徒歩5分',0,NULL,'2014-03-03 17:57:14',NULL,NULL),(9,5,0,'開催時間について','8:00受付開始',0,NULL,'2014-03-03 17:57:14',NULL,NULL),(10,5,0,'募集ブース数について','車出店30',0,NULL,'2014-03-03 17:57:14',NULL,NULL),(11,5,0,'出店形態について','車出店手作り・プロ',0,NULL,'2014-03-03 17:57:14',NULL,NULL),(12,5,0,'出店料金について','プロのみ500円',0,NULL,'2014-03-03 17:57:14',NULL,NULL),(13,5,0,'出店に際してのご注意','暴れないように！',0,NULL,'2014-03-03 17:57:14',NULL,NULL),(14,5,0,'駐車場について','なし',0,NULL,'2014-03-03 17:57:14',NULL,NULL),(15,6,0,'最寄り駅または交通アクセス','JR中野駅より徒歩10分',0,NULL,'2014-03-04 11:32:44',NULL,NULL),(16,6,0,'開催時間について','9:30～17:00',0,NULL,'2014-03-04 11:32:44',NULL,NULL),(17,6,0,'募集ブース数について','全20ブース',0,NULL,'2014-03-04 11:32:44',NULL,NULL),(18,6,0,'出店形態について','車（プロ）10ブース\r\n手作り（プロ）10ブース',0,NULL,'2014-03-04 11:32:44',NULL,NULL),(19,6,0,'出店料金について','プロのみ3,000円',0,NULL,'2014-03-04 11:32:44',NULL,NULL),(20,6,0,'出店に際してのご注意','倒れる危険性のあるハンガーラックは固定をお願いします。\r\n',0,NULL,'2014-03-04 11:32:44',NULL,NULL),(21,6,0,'駐車場について','ありません。近隣に有料駐車場はあります。',0,NULL,'2014-03-04 11:32:44',NULL,NULL),(22,32,0,'最寄り駅または交通アクセス','アップデートテスト',0,NULL,'2014-03-05 04:27:01','2014-03-12 11:13:23',NULL),(23,32,0,'開催時間について','アップデートテスト',0,NULL,'2014-03-05 04:27:01','2014-03-12 11:13:23',NULL),(24,32,0,'募集ブース数について','アップデートテスト',0,NULL,'2014-03-05 04:27:01','2014-03-12 11:13:23',NULL),(25,32,0,'出店形態について','アップデートテスト',0,NULL,'2014-03-05 04:27:01','2014-03-12 11:13:23',NULL),(26,32,0,'出店料金について','アップデートテスト',0,NULL,'2014-03-05 04:27:01','2014-03-12 11:13:23',NULL),(27,32,0,'出店に際してのご注意','アップデートテスト',0,NULL,'2014-03-05 04:27:01','2014-03-12 11:15:05',NULL);
/*!40000 ALTER TABLE `fleamarket_abouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `fleamarket_entry_styles`
--

LOCK TABLES `fleamarket_entry_styles` WRITE;
/*!40000 ALTER TABLE `fleamarket_entry_styles` DISABLE KEYS */;
INSERT INTO `fleamarket_entry_styles` VALUES (1,1,1,2000,30,0,NULL,'2014-03-11 11:38:41',NULL,NULL),(2,1,4,3000,40,0,NULL,'2014-03-11 11:38:41',NULL,NULL);
/*!40000 ALTER TABLE `fleamarket_entry_styles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-13  9:48:19
