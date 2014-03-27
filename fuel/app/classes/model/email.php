<?php

/**
 * メール送信
 *
 * @author kobayasi
 */

class Model_Email extends \Model
{
    /**
     * ユーザーにメールを送信
     *
     * @para $name メールの識別子 $params 差し込むデータ $to 送り先(指定しなければ langの値を使用)
     * @access protected
     * @return void
     * @author kobayasi
     */
    public function sendMailByParams($name,$params = array(), $to = null)
    {
        Lang::load("email/{$name}");

        $email = Email::forge();
        $email->from(Lang::get('from'),Lang::get('from_name'));
        $email->subject(Lang::get('subject'));
        $email->body($this->createMailBody(Lang::get('body'),$params));

        if (! $to) {
            $to = Lang::get('email');
        }

        $email->to($to);
        $email->send();
    }

    /**
     * メール本文の作成
     *
     * @para $contact Model_Contact
     * @access protected
     * @return string
     * @author kobayasi
     */
    private function createMailBody($body,$params)
    {
        foreach ( $params as $key => $value ) {
            $body = str_replace("##{$key}##",$value,$body);
        }
        return mb_convert_encoding($body,'jis');
    }
}

