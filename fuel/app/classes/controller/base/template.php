<?php

/**
 * Base Controller.
 *
 * @author shimma
 */
class Controller_Base_Template extends Controller_Template
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
     * ログインが必須のアクション配列
     *
     * @var array
     * @access protected
     * @author ida
     */
    protected $_login_actions = array();


    /**
     * ログインしていない事が必須のアクション配列
     *
     * @var array
     * @access protected
     * @author ida
     */
    protected $_nologin_actions = array();

    /**
     * リダイレクト先のSSLホスト名
     * 基本的にconfigのssl_connection内部の引数の値をデフォルトとして設定します
     *
     * @var string
     * @access protected
     * @author shimma
     */
    protected $_ssl_host;


    /**
     * メタタグの指定
     * FuelPHPのmetaに準拠したarrayを設定します
     * http://fuelphp.com/docs/classes/html.html#/method_meta
     *
     * @var mixed
     * @access protected
     * @author shimma
     */
    protected $meta = array();


    /**
     * ログインしているユーザインスタンスです
     *
     * @var mixed
     * @access protected
     * @author shimma
     */
    protected $login_user;


    public function before()
    {
        parent::before();

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

        if (in_array($this->request->action, $this->_login_actions) && !Auth::check()) {
            return \Response::redirect('/login?rurl='.$_SERVER['REQUEST_URI']);
        }

        if (in_array($this->request->action, $this->_nologin_actions) && Auth::check()) {
            return \Response::redirect('/mypage');
        }

        Lang::load('meta');
        $this->login_user = Auth::get_user_instance();

        $segments = $this->request->route->segments;
        $this->template->is_top = false;
        if (! isset($segments[0]) || $segments[0] == 'top') {
            $this->template->is_top = true;
        }

        if ($segments) {
            if (count($segments) == 1 ){
                $segments[] = 'index';
            }
            $this->setMetaTag("$segments[0]/$segments[1]");
        } else {
            $this->setMetaTag('default');
        }
    }


    public function after($response)
    {
        $this->template->meta = $this->meta;

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
     * meta tag 関連を lang より設定
     *
     * @access protected
     * @return void
     * @author kobayasi
     * @author shimma
     */
    protected function setMetaTag($path)
    {
        $meta = Lang::get($path);
        $this->meta[] = array('name' => 'keyword',     'content' => $meta['keyword']);
        $this->meta[] = array('name' => 'description', 'content' => $meta['description']);
        $this->template->title = $meta['title'];
    }


    /**
     * 遅延リダイレクトを行います。
     * Viewを表示後、timerで指定の秒数後にリダイレクト処理を行います。
     *
     * @access protected
     * @return void
     * @author shimma
     */
    protected function setLazyRedirect($url, $timer = 1)
    {
        if (! is_numeric($timer)) {
            return false;
        }
        $this->meta[] = array('http-equiv' => 'refresh', 'content' => "${timer}; URL=${url}");
    }


    /**
     * ステータス変更文字列を取得します。
     *
     * @param int $i
     * @access protected
     * @return String $status_message
     * @author shimma
     */
    protected function getStatusMessage($i = '')
    {
        if (! $i) {
            return '';
        }

        Lang::load('status');
        return Lang::get($i);
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
        $response = new Response(json_encode($data), 200);
        $response->set_header('Content-Type', 'application/json');
        if ($send) {
            $response->send(true);
            exit;
        }
        return $response;
    }

}
