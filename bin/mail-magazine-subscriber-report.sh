#!/bin/sh

mail_to=afml_mkt@aucfan.com
subject="rakuichi rakuza mailmagazine active user report"
user=rr_admin
pass=f8f4316c0ad0ce4939fd2966b9aff60e271ffe68
rds=rakuichi-rakuza.cnceg4b5jglv.ap-northeast-1.rds.amazonaws.com

active_mail_magazine_subscribers=$(echo "SELECT COUNT(*) FROM users WHERE mm_flag = 1 AND mm_error_flag != 1 AND deleted_at IS NULL" | mysql -u${user} -p${pass} -h $rds rakuichi_rakuza -N)
rakuichi_rakuza_user_all=$(echo "SELECT COUNT(*) FROM users WHERE deleted_at IS NULL" | mysql -u${user} -p${pass} -h $rds rakuichi_rakuza -N)

echo -e "active_mail_magazine_subscribers:${active_mail_magazine_subscribers}\nall_users:${rakuichi_rakuza_user_all}" |  mail -s "$subject" $mail_to
