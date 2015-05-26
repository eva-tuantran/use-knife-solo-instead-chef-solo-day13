<?php

return array(
    'from'      => 'info@rakuichi-rakuza.jp',
    'from_name' => '楽市楽座 運営事務局',
    'subject'   => '【楽市楽座】##fleamarket.name##キャンセルに伴う空枠追加のご連絡',
    'bcc'       => array('rakuichi-test@aucfan.com'),
    'body'      => <<<'EOT'
##user.last_name####user.first_name## 様

楽市楽座運営事務局 です。

フリーマーケット楽市楽座へのご出店申込をいただき、
ありがとうございます。

この度、キャンセル待ちでのお申込を頂いた会場にてキャンセルに伴う
空き枠が発生しましたのでご連絡を差しあげます。

尚、キャンセル待ちのお客様が多数いらっしゃる場合は、出店予約が先着
順となり、必ずしもご希望に添えない場合がございますのでご了承ください。

ご予約内容は下記の通りとなります。
━━━━━━━━━━━━━━━━━━━━━━━━━━━

##user.last_name####user.first_name## 様

会員番号： ##user.user_id##


●ご予約内容------------------------

　・予約ステータス： キャンセル待ち
　・イベント： ##fleamarket.name##
　・出店形式： ##fleamarket_entry_style.entry_style_name##

●出店予約の方法について。-------------------------

・以下のURLから出店予約が可能です。

    http://www.rakuichi-rakuza.jp/reservation?fleamarket_id=##fleamarket.fleamarket_id##

━━━━━━━━━━━━━━━━━━━━━━━━

この自動通知メールは楽市楽座より自動的に送信されています。
このメールに返信しないようお願いいたします。

なお、このメールに心当たりのない場合や、ご不明な点がある場合は、
お手数ですが下記お問い合わせ窓口にお問い合わせください。
●楽市楽座お問合わせ窓口：info@rakuichi-rakuza.jp
◆◇◆━━━━━━━━━━━━━━━━━━━━━━━━
フリーマーケットの全国開催情報・出店予約サイト
フリーマーケット楽市楽座
    〔URL〕http://www.rakuichi-rakuza.jp/
━━━━━━━━━━━━━━━━━━━━━━━━◆◇◆
EOT
);
