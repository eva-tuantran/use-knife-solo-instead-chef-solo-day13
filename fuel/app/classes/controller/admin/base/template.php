<?php

class Controller_Admin_Base_Template extends Controller_Template
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

        if ($this->request->action != 'login') {
            $this->administrator = \Session::get('admin.administrator');
            if (! $this->administrator) {
                \Response::redirect('admin/index/login');
            }
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

    public function after($response)
    {
        return parent::after($response);
    }


    /**
     * JSON で返却 $send が true だと send して exit します
     *
     * @param $data 返却する値 $send
     * @access protected
     * @return Response
     * @author kobayasi
     */
    protected function response_json($data = false, $send = false)
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
