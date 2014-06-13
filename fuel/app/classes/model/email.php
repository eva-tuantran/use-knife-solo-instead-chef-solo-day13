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
     * @para $name メールの識別子 $params 差し込むデータ $to 送り先(指定しなければ langの値を使用) $options Fuel準拠のEmailオプション
     * @access protected
     * @return bool
     * @author kobayasi
     * @author shimma
     */
    public function sendMailByParams($name, $params = array(), $to = null, $options = null)
    {
        Lang::load("email/{$name}");

        $email = Email::forge();
        $email->from(Lang::get('from'), Lang::get('from_name'));
        $email->subject($this->renderTemplate(Lang::get('subject'), $params, false));
        $email->body($this->renderTemplate(Lang::get('body'), $params));

        if (! $to) {
            $to = Lang::get('email');
        }
        $email->to($to);

        if (Lang::get('bcc') != '') {
            $email->bcc(Lang::get('bcc'));
        }

        if (! empty($options)) {
            foreach ($options as $option => $value) {
                if (empty($value)) {
                    continue;
                }
                switch ($option) {
                    case 'bcc':
                        $email->bcc($value);
                        break;
                    case 'reply_to':
                        $email->reply_to($value);
                        break;
                    case 'subject':
                        $email->subject($value);
                        break;
                }
            }
        }

        return $email->send();
    }

    /**
     * メール本文の作成
     *
     * @para $contact Model_Contact
     * @access protected
     * @return string
     * @author kobayasi
     */
    private function renderTemplate($body, $params, $with_convert = true)
    {
        foreach ( $params as $key => $value ) {
            $body = str_replace("##{$key}##",$value,$body);
        }

        if ($with_convert) {
            $body = mb_convert_encoding($body, 'iso-2022-jp', 'utf-8');
        }

        return $body;
    }
}

