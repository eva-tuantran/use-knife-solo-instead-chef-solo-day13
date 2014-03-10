<?php

/**
 * ログイン画面
 *
 * @author Ricky <master@mistdev.com>
 */
class Controller_Login extends Controller_Template
{
    //SSL設定の項目です。テスト期間につきSSLは利用していません。
    // public $_secure = array('index', 'auth');

    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $return_url = Input::get('rurl');

        $data = array(
            'info_message'  => '',
            'error_message' => '',
            'return_url'    => $return_url,
        );

        $auth_info = Session::get_flash('auth_info');
        switch ($auth_info) {
            case 'login_denied':
                $data['error_message'] = 'ログインできません。';
                Session::destroy();
                break;
            case 'session_expired':
                $data['error_message'] = 'セッションが切れました。';
                Session::destroy();
                break;
        }

        if (Auth::check()) {
            $data['info_message'] = Auth::get_screen_name().' さんとしてログインしています';
        }

        $this->template->title = 'Login';
        $this->template->content = View::forge('login/index', $data);
    }

    /**
     * ユーザ認証をします
     *
     * @access public
     * @return void
     */
    public function action_auth()
    {
        /**
         * loginから来る正常なauth以外は弾きます
         */
        if (Input::method() !== 'POST' || !Security::check_token()) {
            Response::redirect('/login');
        }

        $rurl = Input::get('rurl');
        $validation = self::create_validation();

        /**
         * ログイン確認をします。
         */
        if ($validation->run() && Auth::instance()->login(Input::post('email'), Input::post('password'))) {
            $return_url = '/mypage';
            if (!empty($rurl)) {
                $return_url = $rurl;
            }
            Session::set_flash('auth_info', 'login_success');
        } else {
            $return_url = '/login';
            if (!empty($rurl)) {
                $return_url = "/login?rurl=$rurl";
            }
            Session::set_flash('auth_info', 'login_denied');
        }

        Response::redirect($return_url);
        die;
    }

    /**
     * ログイン用のValidationをレスポンスします
     *
     * @access public
     * @return Validation $validation
     */
    public static function create_validation()
    {
        $validation = Validation::forge();
        $validation->add('email', 'Email')->add_rule('required');
        $validation->add('password', 'Password')->add_rule('required');

        return $validation;
    }

    /**
     * ログアウトします
     * Auth::logout()を利用し、失敗した場合は強制的にSessionを削除します。
     *
     * @access public
     * @return void
     */
    public function action_out()
    {
        if (!Auth::logout()) {
            Session::destroy();
        }

        Session::set_flash('auth_info', 'logout_success');
        Response::redirect('login');
    }

}
