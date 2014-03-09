<?php

/**
 * 全共通のController_Templateの拡張
 *
 * Controller_Template自体を拡張する仕様ですが、
 * Controller_Base的なファイルを作成して進めるのであればそちらでも問題ありません
 * (そのタイミングでこちらのファイルを削除)
 *
 * @author Ricky <master@mistdev.com>
 * @todo ベースコントローラが出来ればそちらに下記のmethodの移動
 */
class Controller_Template extends Fuel\Core\Controller_Template
{

    /**
     * SSL通信対象のアクション名を配列で記載します
     *
     * @var array
     * @access public
     */
    public $_secure = array();


    /**
     * リダイレクト先のSSLホスト名
     *
     * @var string
     * @access public
     */
    public $_ssl_host = 'ssl.rakuichi-rakuza.jp';


    /**
     * 要求するプロトコルと一致しない場合はリダイレクト処理をします。
     * 一致する場合はそのまま描画処理を実行します。
     *
     * @access private
     * @return void
     */
    public function before()
    {
        $should_be_secure = in_array($this->request->action, $this->_secure);
        $is_secure = isset($_SERVER['HTTPS']);

        if ($should_be_secure && ! $is_secure) {
            $this->redirect_to_protocol('https');
        }
        else if (! $should_be_secure && $is_secure) {
            $this->redirect_to_protocol('http');
        }

        parent::before();
    }

    /**
     * http/httpsの引数で現状のURIを引き継いでリダイレクトします
     *
     * @access private
     * @return void
     */
    private function redirect_to_protocol($protocol = 'http')
    {
        switch($protocol){
            case 'https':
                $http_host = $this->_ssl_host;
                break;
            default:
                $http_host = $_SERVER['HTTP_HOST'];
        }

        $url = $protocol . '://' . $http_host . $_SERVER['REQUEST_URI'];
        Response::redirect($url, 'location', 301);
        die;
    }

}
