<?php

/**
 * Controller_Admin_Mailmagazine Controller
 *
 * @extends Controller_Admin_Base_Template
 * @author ida
 */
class Controller_Admin_Mailmagazine extends Controller_Admin_Base_Template
{
    /**
     * メールマガジン関係のファイルを置くパス
     *
     * @var atring
     */
    private $root_dir = null;

    /**
     * メール設定
     *
     * @var array
     */
    private $mail_config = array();

    public function before()
    {
        parent::before();
        $this->root_dir = DOCROOT . DS . 'files' . DS . 'mailmagazine' . DS;

        $from_name = $this->convertEncoding('楽市楽座 運営事務局');
        $this->mail_config = array(
            'from'      => 'info@rakuichi-rakuza.jp',
            'from_name' => $from_name
        );
    }

    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $subject = \Session::get('mailmagazine.subject', null);
        \Session::delete('mailmagazine.subject');

        $view = \View::forge('admin/mailmagazine/index');
        $view->set('subject', $subject);

        $this->template->content = $view;
    }

    /**
     * 確認画面
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        $subject = Input::post('subject');

        $this->upload();
        $errors = \Upload::get_errors();
        if ($errors || $subject == '') {
            \Session::set('mailmagazine.subject', $subject);
            \Response::redirect('index');
        }

        $file = \Upload::get_files('body');
        $path = $file['saved_to'] . $file['saved_as'];
        $body = file_get_contents($path);

        $replace = array('user_name' => '楽市楽座 太郎');
        $body = $this->replaceByParam(
            $this->convertEncoding($body, 'UTF-8'), $replace
        );

        \Session::set('mailmagazine.subject', $subject);
        \Session::set('mailmagazine.file_path', $path);

        $view = \View::forge('admin/mailmagazine/confirm');
        $view->set('subject', $subject);
        $view->set('body', $body);

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

        $to = Input::post('deliveredTo');
        $subject = \Session::get('mailmagazine.subject');
        $path = \Session::get('mailmagazine.file_path');

        $to = trim($to);
        $subject = trim($subject);

        $body = file_get_contents($path);
        $replace = array(
            'user_name' => '楽市楽座 太郎'
        );

        $body = $this->replaceByParam(
            $this->convertEncoding($body, 'UTF-8'), $replace
        );
        $body = $this->convertEncoding($body, 'JIS');

        $success = false;
        $message = '';
        if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
            try {
                $success = $this->sendMail($to, $subject, $body);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $success = false;
            }
        } else {
            $message = '送信先メールアドレスが正しくありません';
        }

        $response = array();
        if ($success) {
            $response = array('status' => 200);
        } else {
            $response = array('status' => 400, 'message' => $message);
        }

        return $this->response_json($response);
    }

    /**
     * 送信
     *
     * @access public
     * @return void
     */
    public function action_send()
    {
        set_time_limit(0);

        $this->template = '';

        $subject = \Session::get('mailmagazine.subject');
        $path = \Session::get('mailmagazine.file_path');

        $subject = trim($subject);

        $body = file_get_contents($path);
        $body = $this->convertEncoding($body, 'UTF-8');

        $success = false;
        $stop = false;
        $message = '';
        if (($users = $this->getUsers())) {
            try {
                $this->processStart();
                $logfile = $this->getLogFile();
                foreach ($users as $user) {
                    if (! $this->isProcess()) {
                        $stop = true;
                        break;
                    }

                    $to = trim($user['email']);
                    $user_name = $user['last_name'] . ' ' . $user['first_name'];
                    $user_name = $this->convertEncoding($user_name);
                    $replace = array(
                        'user_name' => '楽市楽座 太郎'
                    );
                    $body = $this->replaceByParam($body, $replace);

                    $this->sendMail($to, $subject, $body);
                    fwrite($logfile, $user['user_id'] . "\n");
                }
                $success = true;
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $success = false;
            }
            \File::close_file($logfile);
            if (! $stop) {
                $this->processStop();
            }
        } else {
            $message = 'メールマガジン送信希望者が居ません';
            $success = false;
        }

        $response = array();
        if ($success) {
            $response = array('status' => 200);
        } elseif ($stop) {
            $response = array('status' => 300);
        } else {
            $response = array('status' => 400, 'message' => $message);
        }

        return $this->response_json($response);
    }

    /**
     * 送信中止
     *
     * @access public
     * @return void
     */
    public function action_stop()
    {
        $this->template = '';

        $success = false;
        try {
            $this->processStop();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        $response = array();
        if ($success) {
            $response = array('status' => 200);
        } else {
            $response = array('status' => 400, 'message' => $message);
        }

        return $this->response_json($response);
    }

    /**
     * アップロード処理
     *
     * @access private
     * @param
     * @return void
     * @author ida
     */
    private function upload()
    {
        $config = array(
            'path' => $this->root_dir,
            'create_path' => true,
            'ext_whitelist' => array('txt'),
            'type_whitelist' => array('text'),
        );

        \Upload::process($config);

        if (\Upload::is_valid()) {
            \Upload::save();
        }
    }

    /**
     * ファイル処理
     *
     * @access private
     * @param
     * @return void
     * @author ida
     */
    private function getLogFile()
    {
        $dir = $this->root_dir;
        $file_name = 'log' . date('YmdHis');
        $path = $dir . $file_name;

        \File::create($dir, $file_name);

        return \File::open_file($path);
    }

    /**
     * 送信実行確認ファイル処理
     *
     * @access private
     * @param　boolean $delete 削除（中止）
     * @return void
     * @author ida
     */
    private function processStart()
    {
        $file_name = 'process';
        $result = \File::create($this->root_dir, $file_name);

        return $result;
    }

    /**
     * 送信実行確認ファイル処理
     *
     * @access private
     * @param　boolean $delete 削除（中止）
     * @return void
     * @author ida
     */
    private function processStop($delete = false)
    {
        $file_name = 'process';
        $result = \File::delete($this->root_dir . $file_name);

        return $result;
    }

    /**
     * ファイル処理
     *
     * @access private
     * @param
     * @return void
     * @author ida
     */
    private function isProcess($stop = false)
    {
        $dir =  $this->root_dir;
        $file_name = 'process';

        return file_exists($dir . $file_name);
    }

    /**
     * 文字コードを変換する
     *
     * @access private
     * @param string $str 変換する文字列
     * @param string $encode 変換後の文字コード
     * @return string
     * @author ida
     */
    private function convertEncoding($str = null, $encode = 'JIS')
    {
        if ($str) {
            $encoding_list = 'sjis-win, sjis, UTF-8';
            $original_encode = mb_detect_encoding($str, $encoding_list, true);

            $str = mb_convert_encoding($str, $encode, $original_encode);
        }

        return $str;
    }

    /**
     * ユーザーにメールを送信
     *
     * @access protected
     * @param $name メールの識別子 $params 差し込むデータ $to 送り先(指定しなければ langの値を使用)
     * @return void
     * @author ida
     */
    private function sendMail($to = null, $subject = null, $body = null) {
        if (! $to || ! $subject || ! $body) {
            return false;
        }

        $email = \Email::forge();
        $email->from(
            $this->mail_config['from'],
            $this->mail_config['from_name']
        );
        $email->to($to);
        $email->subject($subject);
        $email->body($body);

        try {
            $email->send();
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }

    /**
     * 文字列内を指定されたパラメータで置換する
     *
     * @access private
     * @param string $str 文字列
     * @param array $params 変換パラメータ
     * @return string
     * @author ida
     */
    private function replaceByParam($str = null, $replace = array())
    {
        if ($str && $replace) {
            foreach ($replace as $key => $value) {
                $str = str_replace("##{$key}##", $value, $str);
            }
        }

        return $str;
    }

    /**
     * メールマガジン対象者を取得する
     *
     * @access private
     * @param
     * @return object
     * @author ida
     */
    private function getUsers()
    {
        $users = \Model_User::find('all', array(
            'select' => array('user_id', 'last_name', 'first_name', 'email'),
            'where' => array(
                array('mm_flag', 1),
                array('register_status', \Model_User::REGISTER_STATUS_ACTIVATED),
            ),
        ));

        return $users;
    }
}
