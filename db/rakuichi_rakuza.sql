-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: rakuichi_rakuza
-- ------------------------------------------------------
-- Server version	5.1.73-log

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
-- Table structure for table `administrator_permissions`
--

DROP TABLE IF EXISTS `administrator_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrator_permissions` (
  `administrator_permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `administrator_id` int(11) NOT NULL,
  `permission` varchar(50) NOT NULL COMMENT 'contoroller.actionの形式',
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`administrator_permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrators` (
  `administrator_id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(50) NOT NULL COMMENT '姓',
  `first_name` varchar(50) NOT NULL COMMENT '名',
  `last_name_kana` varchar(50) NOT NULL,
  `first_name_kana` varchar(50) NOT NULL,
  `tel` varchar(20) DEFAULT NULL COMMENT '電話番号',
  `mobile_tel` varchar(20) DEFAULT NULL COMMENT '携帯電話番号',
  `email` varchar(255) DEFAULT NULL COMMENT 'メールアドレス',
  `mobile_email` varchar(255) DEFAULT NULL COMMENT '携帯メールアドレス',
  `password` char(50) DEFAULT NULL COMMENT 'sha1で登録',
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`administrator_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `branch_abouts`
--

DROP TABLE IF EXISTS `branch_abouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch_abouts` (
  `branch_about_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`branch_about_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branches` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '開催地名',
  `zip` char(9) NOT NULL COMMENT '郵便番号',
  `prefecture_id` tinyint(4) NOT NULL COMMENT '都道府県',
  `address` varchar(255) NOT NULL COMMENT '都道府県以外の住所',
  `tel` varchar(20) DEFAULT NULL COMMENT '電話番号',
  `fax` varchar(20) DEFAULT NULL COMMENT 'FAX番号',
  `website` varchar(255) DEFAULT NULL COMMENT 'WEBサイト',
  `shop_manager_name` varchar(50) DEFAULT NULL COMMENT '店長名(店舗のみ)',
  `owner_name` varchar(50) DEFAULT NULL COMMENT '店長名(店舗のみ)',
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '0:本社,0以外:店舗',
  `name` varchar(50) DEFAULT NULL COMMENT '企業名,店舗名',
  `zip` char(9) DEFAULT NULL COMMENT '郵便番号',
  `prefecture_id` tinyint(4) DEFAULT NULL COMMENT '都道府県',
  `address` varchar(255) DEFAULT NULL COMMENT '都道府県以外の住所',
  `tel` varchar(20) DEFAULT NULL COMMENT '電話番号',
  `fax` varchar(20) DEFAULT NULL COMMENT 'FAX番号',
  `email` varchar(255) DEFAULT NULL COMMENT 'メールアドレス',
  `website` varchar(255) DEFAULT NULL COMMENT 'WEBサイト',
  `owner_name` varchar(50) DEFAULT NULL COMMENT '担当者名',
  `owner_department_name` varchar(50) DEFAULT NULL COMMENT '担当者部署',
  `owner_post` varchar(50) DEFAULT NULL COMMENT '担当者役職',
  `owner_tel` varchar(20) DEFAULT NULL COMMENT '担当者電話番号',
  `owner_mobile_tel` varchar(20) DEFAULT NULL COMMENT '担当者携帯電話番号',
  `owner_email` varchar(255) DEFAULT NULL COMMENT '担当者メールアドレス',
  `ad_agency_name` varchar(50) DEFAULT NULL COMMENT '広告代理店名(本社・本店のみ)',
  `ad_agency_margin` float DEFAULT NULL COMMENT 'マージン率(本社・本店のみ)',
  `description` text COMMENT '備考',
  `created_user` int(11) DEFAULT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `inquiry_type` tinyint(4) NOT NULL COMMENT 'お問合せ区分 1:ホームページについて,2:フリーマーケットについて,3:楽市楽座について,4:開催可否の診断希望,5:その他お問合せ\n',
  `inquiry_datetime` datetime NOT NULL COMMENT 'お問合せ日時',
  `subject` varchar(255) NOT NULL,
  `contents` text NOT NULL COMMENT 'お問合せ内容',
  `first_name` varchar(50) DEFAULT NULL COMMENT '姓',
  `last_name` varchar(50) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL COMMENT '自宅電話',
  `email` varchar(255) DEFAULT NULL COMMENT 'メールアドレス',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entries`
--

DROP TABLE IF EXISTS `entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entries` (
  `entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fleamarket_id` int(11) NOT NULL,
  `fleamarket_entry_style_id` int(11) NOT NULL,
  `reservation_number` varchar(20) NOT NULL COMMENT '予約番号',
  `item_category` varchar(50) NOT NULL COMMENT '出品物の種類',
  `item_genres` varchar(255) NOT NULL COMMENT '出品物のジャンル',
  `reserved_booth` tinyint(4) NOT NULL COMMENT '予約ブース数',
  `link_from` varchar(50) NOT NULL COMMENT 'フリーマーケット開催を知った導線',
  `remarks` varchar(511) DEFAULT NULL COMMENT '予約時メッセージ',
  `device` tinyint(4) NOT NULL DEFAULT '1' COMMENT '登録タイプ 0:不明,1:WEB,2:電話',
  `entry_status` tinyint(4) NOT NULL COMMENT 'エントリーステータス 1:エントリ,2:キャンセル待ち,3:キャンセル',
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`entry_id`),
  KEY `idx_entries_01` (`user_id`,`fleamarket_id`,`fleamarket_entry_style_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3303 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fleamarket_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`favorite_id`),
  KEY `idx_favorites_01` (`fleamarket_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=462 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fleamarket_abouts`
--

DROP TABLE IF EXISTS `fleamarket_abouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fleamarket_abouts` (
  `fleamarket_about_id` int(11) NOT NULL AUTO_INCREMENT,
  `fleamarket_id` int(11) NOT NULL,
  `about_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`fleamarket_about_id`),
  KEY `idx_fleamarket_abouts_01` (`fleamarket_id`,`about_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7136 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fleamarket_entry_styles`
--

DROP TABLE IF EXISTS `fleamarket_entry_styles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fleamarket_entry_styles` (
  `fleamarket_entry_style_id` int(11) NOT NULL AUTO_INCREMENT,
  `fleamarket_id` int(11) NOT NULL,
  `entry_style_id` tinyint(4) NOT NULL COMMENT '1:''手持ち出店,2:手持ち出店(プロ),3:手持ち出店(手作り品),4:車出店,5:車出店(プロ),6:車出店(手作り品),7:企業手持ち出店,8:企業車出店,9:飲食店',
  `booth_fee` int(11) NOT NULL COMMENT '出店料',
  `max_booth` int(11) NOT NULL COMMENT '最大ブース数（出店形態別）',
  `reservation_booth_limit` int(11) NOT NULL COMMENT '1人が予約できるブース数上限（出店形態別））',
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`fleamarket_entry_style_id`),
  KEY `idx_fleamarket_entry_styles_01` (`fleamarket_id`,`entry_style_id`)
) ENGINE=InnoDB AUTO_INCREMENT=871 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fleamarket_images`
--

DROP TABLE IF EXISTS `fleamarket_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fleamarket_images` (
  `fleamarket_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `fleamarket_id` int(11) NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`fleamarket_image_id`),
  KEY `idx_fleamarket_images_01` (`fleamarket_id`,`priority`)
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fleamarkets`
--

DROP TABLE IF EXISTS `fleamarkets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fleamarkets` (
  `fleamarket_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `group_code` char(6) NOT NULL COMMENT '同開催を一意にするコード',
  `name` varchar(127) NOT NULL COMMENT 'フリ―マーケット名称',
  `promoter_name` varchar(127) DEFAULT NULL COMMENT '主催者名',
  `event_number` int(11) DEFAULT NULL COMMENT '開催回数',
  `event_date` date NOT NULL COMMENT '開催日',
  `event_time_start` time NOT NULL COMMENT '開催開始時間',
  `event_time_end` time NOT NULL COMMENT '開催終了時間',
  `event_status` tinyint(4) NOT NULL COMMENT '開催状況 1:開催予定,2:予約受付中,3:受付終了,4:開催終了,5:中止',
  `event_reservation_status` tinyint(4) NOT NULL COMMENT '予約状況 1.まだまだあります 2.残り僅か！ 3.満員',
  `headline` varchar(127) DEFAULT NULL COMMENT '見出し',
  `information` varchar(255) DEFAULT NULL,
  `description` text COMMENT '説明',
  `reservation_serial` int(11) DEFAULT '1' COMMENT 'エントリ予約採番',
  `reservation_start` datetime DEFAULT NULL COMMENT 'ブース予約開始日',
  `reservation_end` datetime DEFAULT NULL COMMENT 'ブース予約終了日',
  `reservation_tel` varchar(20) NOT NULL COMMENT '予約受付電話番号',
  `reservation_email` varchar(255) NOT NULL COMMENT '予約受付メールアドレス',
  `website` varchar(255) DEFAULT NULL COMMENT 'WEBサイト',
  `item_categories` varchar(255) NOT NULL COMMENT '出店可能な出品物の種類',
  `link_from_list` varchar(511) DEFAULT NULL COMMENT 'フリーマーケット開催を知った導線リスト',
  `pickup_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'ピックアップ 0:対象外,1:対象',
  `shop_fee_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '出店料 0:有料,1:無料',
  `car_shop_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '車出店 0:NG,1:OK',
  `pro_shop_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'プロ出店 0:NG,1:OK',
  `charge_parking_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '有料駐車場 0:なし,1:あり',
  `free_parking_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '無料駐車場 0:なし,1:あり',
  `rainy_location_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '雨天開催会場 0:NG 1:OK',
  `donation_fee` int(11) DEFAULT NULL COMMENT '寄付金',
  `donation_point` varchar(50) DEFAULT NULL COMMENT '寄付先',
  `register_type` tinyint(4) DEFAULT NULL COMMENT '登録タイプ 1:運営者,2:ユーザ投稿',
  `display_flag` tinyint(4) DEFAULT NULL COMMENT '表示 0:非表示,1:表示',
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`fleamarket_id`),
  KEY `idx_fleamarkets_01` (`register_type`,`event_date`),
  KEY `idx_fleamarkets_02` (`event_date`),
  KEY `idx_fleamarkets_03` (`event_status`)
) ENGINE=InnoDB AUTO_INCREMENT=11133 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL COMMENT 'register_typeが運営者の時セット',
  `name` varchar(50) NOT NULL COMMENT '開催地名',
  `zip` char(9) NOT NULL COMMENT '郵便番号',
  `prefecture_id` tinyint(4) NOT NULL COMMENT '都道府県',
  `address` varchar(255) NOT NULL COMMENT '都道府県以外の住所',
  `googlemap_address` varchar(255) DEFAULT NULL COMMENT '住所を入力',
  `register_type` tinyint(4) DEFAULT NULL COMMENT '登録タイプ 1:運営者,2:ユーザ投稿',
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`location_id`),
  KEY `idx_locations_01` (`location_id`,`prefecture_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10398 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mail_magazine_users`
--

DROP TABLE IF EXISTS `mail_magazine_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_magazine_users` (
  `mail_magazine_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_magazine_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `send_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '送信ステータス 0:未送信(未処理),1:送信済,2:送信エラー',
  `error` varchar(255) DEFAULT NULL,
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`mail_magazine_user_id`),
  KEY `idx_mail_magazine_users_01` (`mail_magazine_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=585301 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mail_magazines`
--

DROP TABLE IF EXISTS `mail_magazines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_magazines` (
  `mail_magazine_id` int(11) NOT NULL AUTO_INCREMENT,
  `send_datetime` datetime DEFAULT NULL,
  `mail_magazine_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'メールマガジンタイプ 1全員,2:希望者全員,3:出店予約者',
  `query` text NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL COMMENT '本文が格納されたディレクトリ',
  `additional_serialize_data` varchar(512) DEFAULT NULL,
  `send_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '送信ステータス 0:送信待ち,1:送信中,2:送信済,3エラー終了,9:キャンセル',
  `created_user` int(11) NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`mail_magazine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_service_prefectures`
--

DROP TABLE IF EXISTS `user_service_prefectures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_service_prefectures` (
  `user_service_prefecture_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_service_id` int(11) NOT NULL,
  `prefecture_id` tinyint(4) NOT NULL COMMENT '都道府県',
  `description` varchar(511) NOT NULL COMMENT '地区、詳細、備考',
  `created_user` int(11) DEFAULT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`user_service_prefecture_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2043 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_services`
--

DROP TABLE IF EXISTS `user_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_services` (
  `user_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `shop_genre` tinyint(4) NOT NULL COMMENT '1:アロマ,2:アンケート調査,3:お笑い,4:カフェ,5:ダンス,6:フリーマーケットの冠協賛,7:フリーマーケットへのチラシ,8:記載,9:マッサージ.10:似顔絵,11:加工食品販売,12:占い,13:大道芸,14:契約推進,15:実演販売,16:屋台,17:歌・バンド・演奏,18:移動販売車,19:農産物販売,99:その他',
  `items` varchar(511) NOT NULL COMMENT '販売商品',
  `description` text NOT NULL COMMENT '備考（補足など）',
  `created_user` int(11) DEFAULT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`user_service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1016 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_tokens`
--

DROP TABLE IF EXISTS `user_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_tokens` (
  `user_token_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '会員ID',
  `hash` varchar(40) NOT NULL COMMENT 'activateに利用するhash文字列。ランダムのmd5を想定。',
  `expired_at` datetime NOT NULL COMMENT 'トークンの有効期限をセットします。利用終了後はUpdateをし、現在の時間を入力することで無効化させます。',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`user_token_id`),
  KEY `idx_expired_at` (`expired_at`),
  KEY `idx_hash` (`hash`)
) ENGINE=InnoDB AUTO_INCREMENT=1863 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '10000000から採番',
  `user_old_id` int(11) DEFAULT NULL COMMENT '旧楽市楽座のユーザID',
  `nick_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL COMMENT '姓',
  `first_name` varchar(50) NOT NULL COMMENT '名',
  `last_name_kana` varchar(50) NOT NULL COMMENT '姓カナ',
  `first_name_kana` varchar(50) NOT NULL COMMENT '名カナ',
  `birthday` date DEFAULT NULL COMMENT '誕生日',
  `gender` tinyint(4) DEFAULT NULL COMMENT '性別 1:男性,2:女性',
  `zip` char(9) NOT NULL COMMENT '郵便番号',
  `prefecture_id` tinyint(4) NOT NULL COMMENT '都道府県',
  `address` varchar(255) NOT NULL COMMENT '都道府県以外の住所',
  `tel` varchar(20) DEFAULT NULL COMMENT '自宅電話',
  `mobile_tel` varchar(20) DEFAULT NULL COMMENT '携帯電話',
  `email` varchar(255) DEFAULT NULL COMMENT 'メールアドレス',
  `mobile_email` varchar(255) DEFAULT NULL COMMENT '携帯メールアドレス',
  `device` tinyint(4) DEFAULT NULL COMMENT '1:sp,2:fp,3:pc,4:phone',
  `mm_flag` tinyint(4) DEFAULT '0' COMMENT 'メールマガジン 0:不要,1:必要',
  `mm_device` tinyint(4) DEFAULT '0' COMMENT 'メールマガジン送信先 1:pc,2:mobile',
  `mm_error_flag` tinyint(4) DEFAULT '0' COMMENT 'メールマガジン送信エラー 0:エラーなし,1:鰓ーあり:',
  `mobile_carrier` tinyint(4) DEFAULT NULL COMMENT '携帯キャリア 1:docomo,2:au,3:softbank,4:その他',
  `mobile_uid` varchar(20) DEFAULT NULL,
  `password` char(50) DEFAULT NULL COMMENT 'fuelのauthを利用して「hash_pbkdf2 + base64」で暗号化します。基本的には44文字で収まると思いますが、余裕持たせて50にしてあります。',
  `admin_memo` text COMMENT '管理者メモ',
  `organization_flag` tinyint(4) DEFAULT '0' COMMENT '企業・団体 0:個人,1:企業・団体',
  `register_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '登録ステータス 0:仮登録,1:本登録.2:退会,3:強制退会',
  `last_login` datetime DEFAULT NULL COMMENT '最終ログイン時刻',
  `created_user` int(11) DEFAULT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` int(11) DEFAULT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` datetime NOT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  PRIMARY KEY (`user_id`),
  KEY `idx_user_old_id` (`user_old_id`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10110493 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-16 12:22:23
