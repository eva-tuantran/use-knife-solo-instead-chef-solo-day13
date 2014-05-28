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

