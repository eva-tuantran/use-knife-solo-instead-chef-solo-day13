SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `rakuichi_rakuza` ;
CREATE SCHEMA IF NOT EXISTS `rakuichi_rakuza` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `rakuichi_rakuza` ;

-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`users` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT COMMENT '10000000から採番',
  `user_old_id` INT NULL COMMENT '旧楽市楽座のユーザID',
  `nick_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL COMMENT '姓',
  `first_name` VARCHAR(50) NOT NULL COMMENT '名',
  `last_name_kana` VARCHAR(50) NOT NULL COMMENT '姓カナ',
  `first_name_kana` VARCHAR(50) NOT NULL COMMENT '名カナ',
  `birthday` DATE NULL COMMENT '誕生日',
  `gender` TINYINT NULL COMMENT '性別 1:男性,2:女性',
  `zip` CHAR(9) NOT NULL COMMENT '郵便番号',
  `prefecture_id` TINYINT NOT NULL COMMENT '都道府県',
  `address` VARCHAR(255) NOT NULL COMMENT '都道府県以外の住所',
  `tel` VARCHAR(20) NULL COMMENT '自宅電話',
  `mobile_tel` VARCHAR(20) NULL COMMENT '携帯電話',
  `email` VARCHAR(255) NULL COMMENT 'メールアドレス',
  `mobile_email` VARCHAR(255) NULL COMMENT '携帯メールアドレス',
  `device` TINYINT NULL COMMENT '登録元 0:不明,1:WEB,3:電話',
  `mm_flag` TINYINT NULL DEFAULT 0 COMMENT 'メールマガジン 0:不要,1:必要',
  `mm_device` TINYINT NULL DEFAULT 0 COMMENT 'メールマガジン送信先 1:pc,2:mobile',
  `mm_error_flag` TINYINT NULL DEFAULT 0 COMMENT 'メールマガジン送信エラー 0:エラーなし,1:鰓ーあり:',
  `mobile_carrier` TINYINT NULL COMMENT '携帯キャリア 1:docomo,2:au,3:softbank,4:その他',
  `mobile_uid` VARCHAR(20) NULL,
  `password` CHAR(50) NULL COMMENT 'fuelのauthを利用して「hash_pbkdf2 + base64」で暗号化します。基本的には44文字で収まると思いますが、余裕持たせて50にしてあります。',
  `admin_memo` TEXT NULL COMMENT '管理者メモ',
  `organization_flag` TINYINT NULL DEFAULT 0 COMMENT '企業・団体 0:個人,1:企業・団体',
  `register_status` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '登録ステータス 0:仮登録,1:本登録.2:退会,3:強制退会',
  `last_login` DATETIME NULL COMMENT '最終ログイン時刻',
  `created_user` INT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`user_id`),
  INDEX `idx_user_old_id` (`user_old_id` ASC),
  INDEX `idx_email` (`email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 10000000;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`user_services`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`user_services` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`user_services` (
  `user_service_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `shop_genre` TINYINT NOT NULL COMMENT '1:アロマ,2:アンケート調査,3:お笑い,4:カフェ,5:ダンス,6:フリーマーケットの冠協賛,7:フリーマーケットへのチラシ,8:記載,9:マッサージ.10:似顔絵,11:加工食品販売,12:占い,13:大道芸,14:契約推進,15:実演販売,16:屋台,17:歌・バンド・演奏,18:移動販売車,19:農産物販売,99:その他',
  `items` VARCHAR(511) NOT NULL COMMENT '販売商品',
  `description` TEXT NOT NULL COMMENT '備考（補足など）',
  `created_user` INT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`user_service_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`user_service_prefectures`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`user_service_prefectures` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`user_service_prefectures` (
  `user_service_prefecture_id` INT NOT NULL AUTO_INCREMENT,
  `user_service_id` INT NOT NULL,
  `prefecture_id` TINYINT NOT NULL COMMENT '都道府県',
  `description` VARCHAR(511) NOT NULL COMMENT '地区、詳細、備考',
  `created_user` INT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`user_service_prefecture_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`locations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`locations` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`locations` (
  `location_id` INT NOT NULL AUTO_INCREMENT,
  `branch_id` INT NULL COMMENT 'register_typeが運営者の時セット',
  `name` VARCHAR(50) NOT NULL COMMENT '開催地名',
  `zip` CHAR(9) NOT NULL COMMENT '郵便番号',
  `prefecture_id` TINYINT NOT NULL COMMENT '都道府県',
  `address` VARCHAR(255) NOT NULL COMMENT '都道府県以外の住所',
  `googlemap_address` VARCHAR(255) NULL COMMENT '住所を入力',
  `register_type` TINYINT NULL COMMENT '登録タイプ 1:運営者,2:ユーザ投稿',
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`location_id`),
  INDEX `idx_locations_01` (`location_id` ASC, `prefecture_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`fleamarkets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`fleamarkets` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`fleamarkets` (
  `fleamarket_id` INT NOT NULL AUTO_INCREMENT,
  `location_id` INT NOT NULL,
  `group_code` CHAR(6) NOT NULL COMMENT '同開催を一意にするコード',
  `name` VARCHAR(127) NOT NULL COMMENT 'フリ―マーケット名称',
  `promoter_name` VARCHAR(127) NULL COMMENT '主催者名',
  `event_number` INT NULL COMMENT '開催回数',
  `event_date` DATE NOT NULL COMMENT '開催日',
  `event_time_start` TIME NOT NULL COMMENT '開催開始時間',
  `event_time_end` TIME NOT NULL COMMENT '開催終了時間',
  `event_status` TINYINT NOT NULL COMMENT '開催状況 1:開催予定,2:予約受付中,3:受付終了,4:開催終了,5:中止',
  `event_reservation_status` TINYINT NOT NULL COMMENT '予約状況 1.まだまだあります 2.残り僅か！ 3.満員',
  `headline` VARCHAR(127) NULL COMMENT '見出し',
  `information` VARCHAR(255) NULL,
  `description` TEXT NULL COMMENT '説明',
  `reservation_serial` INT NULL DEFAULT 1 COMMENT 'エントリ予約採番',
  `reservation_start` DATETIME NULL COMMENT 'ブース予約開始日',
  `reservation_end` DATETIME NULL COMMENT 'ブース予約終了日',
  `reservation_tel` VARCHAR(20) NOT NULL COMMENT '予約受付電話番号',
  `reservation_email` VARCHAR(255) NOT NULL COMMENT '予約受付メールアドレス',
  `website` VARCHAR(255) NULL COMMENT 'WEBサイト',
  `item_categories` VARCHAR(255) NOT NULL COMMENT '出店可能な出品物の種類',
  `link_from_list` VARCHAR(511) NULL COMMENT 'フリーマーケット開催を知った導線リスト',
  `pickup_flag` TINYINT NOT NULL DEFAULT 0 COMMENT 'ピックアップ 0:対象外,1:対象',
  `shop_fee_flag` TINYINT NOT NULL DEFAULT 0 COMMENT '出店料 0:無料,1:有料',
  `car_shop_flag` TINYINT NOT NULL DEFAULT 0 COMMENT '車出店 0:NG,1:OK',
  `pro_shop_flag` TINYINT NOT NULL DEFAULT 0 COMMENT 'プロ出店 0:NG,1:OK',
  `charge_parking_flag` TINYINT NOT NULL DEFAULT 0 COMMENT '有料駐車場 0:なし,1:あり',
  `free_parking_flag` TINYINT NOT NULL DEFAULT 0 COMMENT '無料駐車場 0:なし,1:あり',
  `rainy_location_flag` TINYINT NOT NULL DEFAULT 0 COMMENT '雨天開催会場 0:対象 1:対象外',
  `donation_fee` INT NULL COMMENT '寄付金',
  `donation_point` VARCHAR(50) NULL COMMENT '寄付先',
  `register_type` TINYINT NULL COMMENT '登録タイプ 1:運営者,2:ユーザ投稿',
  `display_flag` TINYINT NULL COMMENT '表示 0:非表示,1:表示',
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`fleamarket_id`),
  INDEX `idx_fleamarkets_01` (`register_type` ASC, `event_date` ASC),
  INDEX `idx_fleamarkets_02` (`event_date` ASC),
  INDEX `idx_fleamarkets_03` (`event_status` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`entries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`entries` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`entries` (
  `entry_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `fleamarket_id` INT NOT NULL,
  `fleamarket_entry_style_id` INT NOT NULL,
  `reservation_number` VARCHAR(20) NOT NULL COMMENT '予約番号',
  `item_category` VARCHAR(50) NOT NULL COMMENT '出品物の種類',
  `item_genres` VARCHAR(255) NOT NULL COMMENT '出品物のジャンル',
  `reserved_booth` TINYINT NOT NULL COMMENT '予約ブース数',
  `link_from` VARCHAR(50) NOT NULL COMMENT 'フリーマーケット開催を知った導線',
  `remarks` VARCHAR(511) NULL COMMENT '予約時メッセージ',
  `device` TINYINT NOT NULL DEFAULT 1 COMMENT '登録タイプ 0:不明,1:WEB,2:電話',
  `entry_status` TINYINT NOT NULL COMMENT 'エントリーステータス 1:エントリ,2:キャンセル待ち,3:キャンセル',
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`entry_id`),
  INDEX `idx_entries_01` (`user_id` ASC, `fleamarket_id` ASC, `fleamarket_entry_style_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`companies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`companies` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`companies` (
  `company_id` INT NOT NULL AUTO_INCREMENT,
  `parent_id` INT NOT NULL DEFAULT 0 COMMENT '0:本社,0以外:店舗',
  `name` VARCHAR(50) NULL COMMENT '企業名,店舗名',
  `zip` CHAR(9) NULL COMMENT '郵便番号',
  `prefecture_id` TINYINT NULL COMMENT '都道府県',
  `address` VARCHAR(255) NULL COMMENT '都道府県以外の住所',
  `tel` VARCHAR(20) NULL COMMENT '電話番号',
  `fax` VARCHAR(20) NULL COMMENT 'FAX番号',
  `email` VARCHAR(255) NULL COMMENT 'メールアドレス',
  `website` VARCHAR(255) NULL COMMENT 'WEBサイト',
  `owner_name` VARCHAR(50) NULL COMMENT '担当者名',
  `owner_department_name` VARCHAR(50) NULL COMMENT '担当者部署',
  `owner_post` VARCHAR(50) NULL COMMENT '担当者役職',
  `owner_tel` VARCHAR(20) NULL COMMENT '担当者電話番号',
  `owner_mobile_tel` VARCHAR(20) NULL COMMENT '担当者携帯電話番号',
  `owner_email` VARCHAR(255) NULL COMMENT '担当者メールアドレス',
  `ad_agency_name` VARCHAR(50) NULL COMMENT '広告代理店名(本社・本店のみ)',
  `ad_agency_margin` FLOAT NULL COMMENT 'マージン率(本社・本店のみ)',
  `description` TEXT NULL COMMENT '備考',
  `created_user` INT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`company_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`branches`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`branches` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`branches` (
  `branch_id` INT NOT NULL AUTO_INCREMENT,
  `company_id` INT NOT NULL,
  `name` VARCHAR(50) NOT NULL COMMENT '開催地名',
  `zip` CHAR(9) NOT NULL COMMENT '郵便番号',
  `prefecture_id` TINYINT NOT NULL COMMENT '都道府県',
  `address` VARCHAR(255) NOT NULL COMMENT '都道府県以外の住所',
  `tel` VARCHAR(20) NULL COMMENT '電話番号',
  `fax` VARCHAR(20) NULL COMMENT 'FAX番号',
  `website` VARCHAR(255) NULL COMMENT 'WEBサイト',
  `shop_manager_name` VARCHAR(50) NULL COMMENT '店長名(店舗のみ)',
  `owner_name` VARCHAR(50) NULL COMMENT '店長名(店舗のみ)',
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`branch_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`administrators`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`administrators` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`administrators` (
  `administrator_id` INT NOT NULL AUTO_INCREMENT,
  `last_name` VARCHAR(50) NOT NULL COMMENT '姓',
  `first_name` VARCHAR(50) NOT NULL COMMENT '名',
  `last_name_kana` VARCHAR(50) NOT NULL,
  `first_name_kana` VARCHAR(50) NOT NULL,
  `tel` VARCHAR(20) NULL COMMENT '電話番号',
  `mobile_tel` VARCHAR(20) NULL COMMENT '携帯電話番号',
  `email` VARCHAR(255) NULL COMMENT 'メールアドレス',
  `mobile_email` VARCHAR(255) NULL COMMENT '携帯メールアドレス',
  `password` CHAR(50) NULL COMMENT 'sha1で登録',
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`administrator_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`administrator_permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`administrator_permissions` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`administrator_permissions` (
  `administrator_permission_id` INT NOT NULL AUTO_INCREMENT,
  `administrator_id` INT NOT NULL,
  `permission` VARCHAR(50) NOT NULL COMMENT 'contoroller.actionの形式',
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`administrator_permission_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`contacts` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`contacts` (
  `contact_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `inquiry_type` TINYINT NOT NULL COMMENT 'お問合せ区分 1:ホームページについて,2:フリーマーケットについて,3:楽市楽座について,4:開催可否の診断希望,5:その他お問合せ\n',
  `inquiry_datetime` DATETIME NOT NULL COMMENT 'お問合せ日時',
  `subject` VARCHAR(255) NOT NULL,
  `contents` TEXT NOT NULL COMMENT 'お問合せ内容',
  `first_name` VARCHAR(50) NULL COMMENT '姓',
  `last_name` VARCHAR(50) NULL,
  `tel` VARCHAR(20) NULL COMMENT '自宅電話',
  `email` VARCHAR(255) NULL COMMENT 'メールアドレス',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`contact_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`fleamarket_entry_styles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`fleamarket_entry_styles` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`fleamarket_entry_styles` (
  `fleamarket_entry_style_id` INT NOT NULL AUTO_INCREMENT,
  `fleamarket_id` INT NOT NULL,
  `entry_style_id` TINYINT NOT NULL COMMENT '1:\'手持ち出店,2:手持ち出店(プロ),3:手持ち出店(手作り品),4:車出店,5:車出店(プロ),6:車出店(手作り品),7:企業手持ち出店,8:企業車出店,9:飲食店',
  `booth_fee` INT NOT NULL COMMENT '出店料',
  `max_booth` INT NOT NULL COMMENT '最大ブース数（出店形態別）',
  `reservation_booth_limit` INT NOT NULL COMMENT '1人が予約できるブース数上限（出店形態別））',
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`fleamarket_entry_style_id`),
  INDEX `idx_fleamarket_entry_styles_01` (`fleamarket_id` ASC, `entry_style_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`branch_abouts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`branch_abouts` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`branch_abouts` (
  `branch_about_id` INT NOT NULL AUTO_INCREMENT,
  `branch_id` INT NOT NULL,
  `title` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL,
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`branch_about_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`fleamarket_abouts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`fleamarket_abouts` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`fleamarket_abouts` (
  `fleamarket_about_id` INT NOT NULL AUTO_INCREMENT,
  `fleamarket_id` INT NOT NULL,
  `about_id` INT NOT NULL,
  `title` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL,
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`fleamarket_about_id`),
  INDEX `idx_fleamarket_abouts_01` (`fleamarket_id` ASC, `about_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`user_tokens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`user_tokens` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`user_tokens` (
  `user_token_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL COMMENT '会員ID',
  `hash` VARCHAR(40) NOT NULL COMMENT 'activateに利用するhash文字列。ランダムのmd5を想定。',
  `expired_at` DATETIME NOT NULL COMMENT 'トークンの有効期限をセットします。利用終了後はUpdateをし、現在の時間を入力することで無効化させます。',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`user_token_id`),
  INDEX `idx_expired_at` (`expired_at` ASC),
  INDEX `idx_hash` (`hash` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`fleamarket_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`fleamarket_images` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`fleamarket_images` (
  `fleamarket_image_id` INT NOT NULL AUTO_INCREMENT,
  `fleamarket_id` INT NOT NULL,
  `priority` TINYINT NOT NULL,
  `file_name` VARCHAR(255) NULL,
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`fleamarket_image_id`),
  INDEX `idx_fleamarket_images_01` (`fleamarket_id` ASC, `priority` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`favorites`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`favorites` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`favorites` (
  `favorite_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `fleamarket_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`favorite_id`),
  INDEX `idx_favorites_01` (`fleamarket_id` ASC, `user_id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`mail_magazines`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`mail_magazines` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`mail_magazines` (
  `mail_magazine_id` INT NOT NULL AUTO_INCREMENT,
  `send_datetime` DATETIME NULL,
  `mail_magazine_type` TINYINT NOT NULL DEFAULT 0 COMMENT 'メールマガジンタイプ 1全員,2:希望者全員,3:出店予約者',
  `query` TEXT NOT NULL COMMENT '送信者を取得するSQL',
  `from_email` VARCHAR(255) NOT NULL COMMENT '差出人メールアドレス',
  `from_name` VARCHAR(255) NOT NULL COMMENT '差出人',
  `subject` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL COMMENT '本文',
  `additional_serialize_data` VARCHAR(1023) NULL COMMENT 'メール本文に掲載する情報を取得するためのパラメータをserializeして保存',
  `send_status` TINYINT NOT NULL DEFAULT 0 COMMENT '送信ステータス 0:保存,1:送信待ち,2:送信中,3:正常終了,4:異常終了,9:キャンセル',
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`mail_magazine_id`),
  INDEX `idx_mail_magazines_01` (`mail_magazine_type` ASC, `send_status` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rakuichi_rakuza`.`mail_magazine_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rakuichi_rakuza`.`mail_magazine_users` ;

CREATE TABLE IF NOT EXISTS `rakuichi_rakuza`.`mail_magazine_users` (
  `mail_magazine_user_id` INT NOT NULL AUTO_INCREMENT,
  `mail_magazine_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `send_status` TINYINT NOT NULL DEFAULT 0 COMMENT '送信ステータス 0:未送信(未処理),1:送信済,2:送信エラー',
  `error` VARCHAR(255) NULL,
  `created_user` INT NOT NULL COMMENT '作成したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `updated_user` INT NULL COMMENT '更新したユーザID、一般ユーザ:10000000以上,管理者：10000000未満',
  `created_at` DATETIME NOT NULL COMMENT '作成日時',
  `updated_at` DATETIME NULL COMMENT '更新日時',
  `deleted_at` DATETIME NULL COMMENT '削除日時',
  PRIMARY KEY (`mail_magazine_user_id`),
  INDEX `idx_mail_magazine_users_01` (`mail_magazine_id` ASC, `user_id` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
