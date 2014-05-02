<?php

return array(
    'from'      => 'info@rakuichi-rakuza.jp',
    'from_name' => '楽市楽座 運営事務局',
    'subject'   => '【自動返信】キャンセル待ち予約完了メール',
    'bcc'       => array('rakuichi-test@aucfan.com'),
    'body'      => <<<'EOT'


##user.last_name####user.first_name## 様


楽市楽座運営事務局 です。

この度は、フリーマーケット楽市楽座へのご出店予約をいただき、
ありがとうございました。

このメールは、ご予約内容に関する大切なメールです。
印刷するかご予約番号をお控えのうえ、当日受付時にご提示ください。

ご予約内容は下記の通りとなります。
━━━━━━━━━━━━━━━━━━━━━━━━━━━

##user.last_name####user.first_name## 様

会員番号： ##user.user_id##


●ご予約内容------------------------

　・予約ステータス： キャンセル待ち
　・イベント： ##fleamarket.name##
　・出店形式： ##fleamarket_entry_style.entry_style_name##

★キャンセルが発生して、空き出店枠が出た際には、再度
　メールにてその旨を通知いたします★
　
●開催情報-------------------------

▼フリマ開催名
##fleamarket.name##

▼開催日程
##fleamarket.event_date##

▼開催時間
##fleamarket.event_time_start##〜##fleamarket.event_time_end##

▼会場名
##location.name##

▼住所
〒##location.zip## ##location.address##

▼交通・アクセス
##fleamarket_about_1.description##

▼出店形態
##fleamarket_entry_styles.entry_style_name##
 
▼出店料金
##fleamarket_entry_styles.fee##

▼募集ブース
##fleamarket_about_3.description##

▼開催時間について
##fleamarket_about_2.description##

▼出店料金について
##fleamarket_about_5.description##
    
▼出店に際してのご注意
##fleamarket_about_6.description##

▼駐車場について
##fleamarket_about_7.description##
 
●ご予約の変更・キャンセルについて。------------------------- 

・ウェブサイトにログイン後、マイページにて予約の変更・取消が可能です。


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
