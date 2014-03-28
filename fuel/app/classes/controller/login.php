<?php

/**
 * ログイン画面
 *
 * @author shimma
 */
class Controller_Login extends Controller_Base_Template
{
    protected $_secure_actions = array(
        'index',
        'auth',
        'out',
    );

    protected $_nologin_actions = array(
        'index',
    );


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

        $status = Session::get_flash('status');
        $data['info_message'] = $this->getStatusMessage($status);

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
        if (! Security::check_token()) {
            return \Response::redirect('/login');
        }

        $rurl = Input::get('rurl');
        $fieldset = $this->createFieldset();
        $fieldset->repopulate();
        $validation = $fieldset->validation();

        if (! $validation->run()) {
            Session::set_flash('login.fieldset', $fieldset);
            Session::set_flash('status', \STATUS_LOGIN_DENIED);
            return \Response::redirect("login?rurl=$rurl");
        }

        if (! Auth::instance()->login(Input::post('email'), Input::post('password'))) {
            Session::set_flash('login.fieldset', $fieldset);
            Session::set_flash('status', \STATUS_LOGIN_DENIED);
            return \Response::redirect("/login?rurl=$rurl");
        }

        $return_url = empty($rurl) ? '/mypage/' : $rurl;
        Session::set_flash('status', \STATUS_LOGIN_SUCCESS);

        return \Response::redirect($return_url);
    }


    /**
     * ログイン用のFieldsetをレスポンスします
     *
     * @access public
     * @return Fieldset fieldset
     * @author shimma
     */
    public function createFieldset()
    {
        $fieldset = Session::get_flash('login.fieldset');

        if (! $fieldset) {
            $fieldset = \Fieldset::forge('login');
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
        if (! Auth::logout()) {
            Session::destroy();
        }

        Session::set_flash('status', \STATUS_LOGOUT_SUCCESS);
        return \Response::redirect('login');
    }

}
