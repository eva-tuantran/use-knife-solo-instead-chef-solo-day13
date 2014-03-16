<?php

/**
 * Base Controller.
 *
 * @extends  Controller_Template
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
     * リダイレクト先のSSLホスト名
     *
     * @var string
     * @access protected
     * @author shimma
     */
    protected $_ssl_host = 'ssl.rakuichi-rakuza.jp';


    /**
     * 事前処理
     *
     * アクション実行前の共通処理
     *
     * @access public
     * @return void
     * @author ida
     * @author shimma
     */
    public function before()
    {
        $should_be_secure = in_array($this->request->action, $this->_secure_actions);
        $is_secure = isset($_SERVER['HTTPS']);
        $use_ssl = \Config::get('use_ssl');

        if ($should_be_secure && ! $is_secure && $use_ssl) {
            $this->redirect_to_protocol('https');
        } elseif (! $should_be_secure && $is_secure) {
            $this->redirect_to_protocol('http');
        }

        if (in_array($this->request->action, $this->_login_actions) && !Auth::check()) {
            $referrer = \Input::referrer();
            return \Response::redirect('/login?rurl='.$referrer);
        }

Asset::js('holder.js', array(), 'add_js');
        parent::before();
    }

    /**
     * http/httpsの引数で現状のURIを引き継いでリダイレクトします
     *
     * @access private
     * @return void
     * @author shimma
     */
    private function redirect_to_protocol($protocol = 'http')
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
}
