<?php

class Controller_Admin_Base_Template extends \Controller_Template
{
    /**
     * SSL通信対象のアクション名を配列で記載します
     *
     * @var array
     * @access protected
     * @author shimma
     */
    protected $_secure_actions = array();

    /**
     * リダイレクト先のSSLホスト名
     * 基本的にconfigのssl_connection内部の引数の値をデフォルトとして設定します
     *
     * @var string
     * @access protected
     * @author ida
     */
    protected $_ssl_host;

    /**
     * ログインしている管理者インスタンスです
     *
     * @var mixed
     * @access protected
     * @author ida
     */
    protected $administrator = null;

    public function before()
    {
        $this->template = 'admin/template';
        parent::before();

        $this->template->is_login = false;
        if ($this->request->action !== 'login') {
            $this->administrator = \Session::get('admin.administrator');
            if (! $this->administrator) {
                \Response::redirect('admin/index/login');
            }
            $this->template->is_login = isset($this->administrator);
        }

        $should_be_secure = in_array($this->request->action, $this->_secure_actions);
        $is_secure        = isset($_SERVER['HTTPS']);
        $use_ssl          = \Config::get('ssl_connection.use');
        if (! $this->_ssl_host) {
            $this->_ssl_host = \Config::get('ssl_connection.default_host');

            if (! $this->_ssl_host) {
                $this->_ssl_host = $_SERVER['HTTP_HOST'];
            }
        }

        if ($should_be_secure && ! $is_secure && $use_ssl) {
            $this->redirectToProtocol('https');
        } elseif (! $should_be_secure && $is_secure) {
            $this->redirectToProtocol('http');
        }

    }

    public function after($response)
    {
        return parent::after($response);
    }

    /**
     * http/httpsの引数で現状のURIを引き継いでリダイレクトします
     *
     * @access private
     * @return void
     * @author shimma
     */
    private function redirectToProtocol($protocol = 'http')
    {
        switch ($protocol) {
            case 'https':
                $server_host = $this->_ssl_host;
                break;
            default:
                $server_host = $_SERVER['HTTP_HOST'];
        }

        $url = $protocol . '://' . $server_host . $_SERVER['REQUEST_URI'];

        return \Response::redirect($url, 'location', 301);
    }

    /**
     * JSONで返答する
     *
     * $sendがtrueの時、返答して終わる
     * $sendがfalseの時、レスポンスオブジェクを返す
     *
     * @access protected
     * @param mixed $data 返答する値
     * @param bool $send 送信フラグ
     * @return Response
     * @author kobayasi
     */
    protected function responseJson($data = false, $send = false)
    {
        $response = new \Response(json_encode($data), 200);
        $response->set_header('Content-Type', 'application/json');
        if ($send) {
            $response->send(true);
            exit;
        }

        return $response;
    }
}
