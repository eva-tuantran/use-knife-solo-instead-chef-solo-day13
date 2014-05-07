<?php

return array(
    'from'      => 'admin@rakuichi-rakuza.jp',
    'from_name' => '楽市楽座 運営事務局',
    'email'     => array('info@rakuichi-rakuza.jp'),
    'bcc'       => array('rakuichi-test@aucfan.com'),
    'subject'   => 'お問い合わせ(ID:##contact_id##):「##inquiry_type_label##」- ##last_name## 様',
    'body'      => <<<'EOT'
以下の内容でお問い合わせフォームからの送信を受け付けました。
内容をご確認下さい。
━━━━━━━━━━━━━━━━━━━━━━━━

(admin向け)
お問い合わせの種類 ##inquiry_type_label##
名前 ##last_name## ##first_name##
件名 ##subject##
メールアドレス ##email##
電話番号 ##tel##
内容 ##contents##
EOT
);

