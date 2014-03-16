<?php

/**
 * ログイン画面
 *
 */
class Controller_Login extends Controller_Base_Template
{
    protected $_secure_actions = array('index', 'auth', 'out');

    /**
     * 初期画面
     *
     * @access public
     * @return void
     * @author shimma
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

        $this->template->title = 'Login';
        $this->template->content = View::forge('login/index', $data);
    }

    /**
     * ユーザ認証をします
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function post_auth()
    {
        if (!Security::check_token()) {
            Response::redirect('/login');
        }

        $rurl = Input::get('rurl');
        $fieldset = self::createFieldset();
        $validation = $fieldset->validation();

        if (!$validation->run()) {
            Session::set_flash('login.fieldset', $fieldset);
            return Response::redirect("login?rurl=$rurl");
        }

        if (!Auth::instance()->login(Input::post('email'), Input::post('password'))) {
            Session::set_flash('auth_info', 'login_denied');
            Session::set_flash('login.fieldset', $fieldset);
            return Response::redirect("/login?rurl=$rurl");
        }

        $return_url = empty($rurl) ? '/mypage/' : $rurl;
        Session::set_flash('auth_info', 'login_success');

        return Response::redirect($return_url);
    }


    /**
     * ログイン用のFieldsetをレスポンスします
     *
     * @access public
     * @return Fieldset fieldset
     * @author shimma
     */
    public static function createFieldset()
    {
        $fieldset = Session::get_flash('login.fieldset');

        if (! $fieldset) {
            $fieldset = \Fieldset::forge();
            $fieldset->add('email', 'Email')
                ->add_rule('required')
                ->add_rule('valid_email');
            $fieldset->add('password', 'Password')
                ->add_rule('required');
        }

        return $fieldset;
    }

    /**
     * ログアウトします
     * Auth::logout()を利用し、失敗した場合は強制的にSessionを削除します。
     *
     * @access public
     * @return void
     * @author shimma
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
