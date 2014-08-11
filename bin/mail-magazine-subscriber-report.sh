#!/bin/sh

mail_to=afml_mkt@aucfan.com
subject="rakuichi rakuza mailmagazine active user report"

echo "SELECT COUNT(*) AS active_mail_magazine_subscribers FROM users WHERE mm_flag = 1 AND mm_error_flag != 1" \
    | mysql -uroot rakuichi_rakuza \
    | mail -s "$subject" $mail_to
