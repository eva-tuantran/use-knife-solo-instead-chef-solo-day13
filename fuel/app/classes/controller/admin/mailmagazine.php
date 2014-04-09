<?php

/**
 * Controller_Admin_Mailmagazine Controller
 *
 * @extends  Controller_Base_Template
 * @author ida
 */
class Controller_Admin_Mailmagazine extends Controller_Admin_Base_Template
{
    public function before()
    {
        parent::before();
    }

    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $view = \View::forge('admin/mailmagazine/index');
        $this->template->content = $view;
    }

    /**
     * テスト送信
     *
     * @access public
     * @return void
     */
    public function action_test()
    {
        $this->template = '';
        $error = $this->upload();

        $response = array();
        if (! $error) {
            $response = array('status' => 200);
        } else {
            $response = array('status' => 400, $error);
        }

        return $this->response_json();
    }

    /**
     * テスト送信
     *
     * @access public
     * @return void
     */
    public function action_send()
    {
        $view = \View::forge('admin/mailmagazine/index');
        $this->template->content = $view;
    }

    /**
     * アップロード処理
     */
    private function upload()
    {
        $config = array(
            'path' => DOCROOT . DS . 'files' . DS . 'public' . DS . 'files' . DS . 'mailmagazine' . DS,
            'create_path' => true,
            'ext_whitelist' => array('txt'),
            'type_whitelist' => array('text'),
        );

        Upload::process($config);

        if (Upload::is_valid()) {
            Upload::save();
        }

        return var_export($_FILES, true);
    }

    /**
     * ユーザーにメールを送信
     *
     * @access protected
     * @param $name メールの識別子 $params 差し込むデータ $to 送り先(指定しなければ langの値を使用)
     * @return void
     * @author kobayasi
     */
    private function sendMailByParams($file, $to = null, $subject = null, $params = array())
    {
        if (! $to) {
            return false;
        }

        $config = array(
            'from'      => 'info@rakuichi-rakuza.jp',
            'from_name' => '楽市楽座 運営事務局',
            'subject'   => '【楽市楽座】メールマガジン',
            'body'      => ''
        );

        $email->from($config['from'], $config['from_name']);
        $email->subject(Lang::get('subject'));
        $email->body($this->createMailBody(Lang::get('body'), $params));

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
        foreach ($params as $key => $value) {
            $body = str_replace("##{$key}##", $value, $body);
        }

        return mb_convert_encoding($body, 'jis');
    }
}
