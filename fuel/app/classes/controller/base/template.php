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
     * metaタグの指定
     *
     * FuelPHPのmetaに準拠したarrayを設定します
     * http://fuelphp.com/docs/classes/html.html#/method_meta
     *
     * @var array
     * @access protected
     * @author shimma
     */
    protected $meta = array();

    /**
     * パンくずリスト
     *
     * @var array
     * @access protected
     * @author ida
     */
    protected $crumbs = array();

    /**
     * metaタグ・パンくずリストの置換文字
     *
     * @var array
     * @access protected
     * @author ida
     */
    protected $html_replacement = array();

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

        $this->login_user = Auth::get_user_instance();

        $segments = $this->request->route->segments;
        $this->template->is_top = false;
        if (! isset($segments[0]) || $segments[0] == 'top') {
            $this->template->is_top = true;
        }

        $page = 'default';
        if ($segments) {
            if (count($segments) == 1){
                $segments[] = 'index';
            }
            $page = $segments[0] . '/' . $segments[1];
        }

        $this->setMetaTag($page);
        $this->setBreadcrumb($page);
    }

    public function after($response)
    {
        $this->createMeta();
        $this->createBreadcrumb();
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
     * エリア・都道府県変換
     *
     * @access public
     * @apram array $replacement
     * @return string
     * @author ida
     */
    protected function getAreaName($area = null)
    {
        if (empty($area)) {
            return '';
        }

        if (false !== ($key = array_search($area, \Config::get('master.alphabet_regions')))) {
            $list = \Config::get('master.regions');
        } elseif (false !== ($key = array_search($area, \Config::get('master.alphabet_prefectures')))) {
            $list = \Config::get('master.prefectures');
        } elseif (false !== array_key_exists($area, \Config::get('master.prefectures'))) {
            $key = $area;
            $list = \Config::get('master.prefectures');
        }

        return isset($list[$key]) ? $list[$key] : '';
    }

    /**
     * エリア・都道府県変換
     *
     * @access public
     * @apram array $replacement
     * @return string
     * @author ida
     */
    protected function changeAreaNameToId($area = null)
    {
        if (empty($area)) {
            return '';
        }

        if (false !== ($key = array_search($area, \Config::get('master.alphabet_regions')))) {
            $list = \Config::get('master.regions');
        } elseif (false !== ($key = array_search($area, \Config::get('master.alphabet_prefectures')))) {
            $list = \Config::get('master.prefectures');
        } elseif (false !== array_key_exists($area, \Config::get('master.prefectures'))) {
            $key = $area;
            $list = \Config::get('master.prefectures');
        }

        return isset($list[$key]) ? $list[$key] : '';
    }

    /**
     * meta tag 関連を lang より設定
     *
     * @access protected
     * @return void
     * @author kobayasi
     * @author shimma
     */
    protected function setMetaTag($page)
    {
        $meta = \Lang::get('meta.' . $page);
        $this->meta = $meta;
    }

    /**
     * パンくずリスト設定する
     *
     * @access protected
     * @apram array $replacement
     * @return string
     * @author ida
     */
    protected function setBreadcrumb($page)
    {
        $crumbs = \Lang::get('crumb.crumbs.'. $page);
        $this->crumbs = $crumbs;
    }

    /**
     * meta文字・パンくずのリプレイス文字を設定する
     *
     * @access public
     * @apram array $replacement
     * @return void
     * @author ida
     */
    protected function setHtmlReplace($replacement)
    {
        foreach ($replacement as $key => $value) {
            $this->html_replacement[] = array($key => $value);
        }
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

        \Lang::load('status');
        return Lang::get($i);
    }

    /**
     * アプリケーション内で転送する
     *
     * @access protected
     * @param string $url 転送先URL
     * @param int $status ステータスコード
     * @return object
     * @author ida
     */
    protected function forward($url, $status = 200)
    {
        $this->response_status = $status;
        return \Request::forge($url)->execute();
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

    /**
     * metaタグの文言を生成する
     *
     * @access private
     * @param
     * @return void
     * @author ida
     */
    private function createMeta()
    {
        if (! empty($this->html_replacement)) {
            foreach ($this->html_replacement as $replcae) {
                list($key, $value) = each($replcae);
                foreach ($this->meta as $name => $word) {
                    $this->meta[$name] = str_replace('##' . $key . '##', $value, $word);
                }
            }
        }

        $meta[] = array('name' => 'keyword', 'content' => $this->meta['keyword']);
        $meta[] = array('name' => 'description','content' => $this->meta['description']);
        $this->template->title = $this->meta['title'];
        $this->template->description = $this->meta['description'];
        $this->template->meta = $meta;
    }

    /**
     * metaタグの文言を生成する
     *
     * @access private
     * @param
     * @return void
     * @author ida
     */
    private function createBreadcrumb()
    {
        if (! empty($this->html_replacement)) {
            foreach ($this->html_replacement as $replcae) {
                list($key, $value) = each($replcae);
                foreach ($this->crumbs as $name => $word) {
                    $this->crumbs[$name] = str_replace('##' . $key . '##', $value, $word);
                }
            }
        }

        $this->template->set('crumbs', $this->crumbs, false);
    }

}
