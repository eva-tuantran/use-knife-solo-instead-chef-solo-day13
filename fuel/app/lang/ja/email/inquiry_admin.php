<?php

return array(
    'from'      => 'info@rakuichi-rakuza.jp',
    'from_name' => '楽市楽座 運営事務局',
    'email'     => array('h_kobayashi@aucfan.com'),
    'subject'   => 'お問い合わせフォーム(admin向け)',
    'body'      => <<<'EOT'
(admin向け)
お問い合わせの種類 {inquiry_type_label}
件名 {subject}
メールアドレス {email}
電話番号 {tel}
内容 {contents}
EOT
);

