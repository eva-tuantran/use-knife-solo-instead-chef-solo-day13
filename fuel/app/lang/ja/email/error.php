<?php

return array(
    'from'      => 'system-notice@rakuichi-rakuza.jp',
    'from_name' => 'rakuichi system',
    'email'     => array('rakuichi-test@aucfan.com'),
    'subject'   => '楽市楽座System Error',
    'body'      => <<<'EOT'
以下のエラーが発生しました。ご確認下さい。
--
エラーコード:
##error_message## (##error_code##)

ファイル名:
##file## (line: ##line##)

URL:
##url##

日時:
##occurred_at##

ユーザID:
##user_id##
EOT
);
