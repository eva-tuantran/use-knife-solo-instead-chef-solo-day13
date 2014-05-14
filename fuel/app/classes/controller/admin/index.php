<?php

/**
 * 管理機能TOP
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */
class Controller_Admin_Index extends Controller_Admin_Base_Template
{
    /**
     * 初期画面
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function action_index()
    {
        $this->template->content = \ViewModel::forge('admin/index/index');
    }

    /**
     * ログイン画面
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function get_login()
    {
        $this->template->content = \View::forge('admin/index/login');
    }

    /**
     * ログイン処理
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function post_login()
    {
        $administrator = \Model_Administrator::query()
            ->where('email', \Input::post('email'))
            ->where('password', \Auth::hash_password(\Input::post('password')))
            ->get_one();

        if ($administrator) {
            \Session::set('admin.administrator',$administrator);
            \Response::redirect('/admin/index');
        }

        $view = \View::forge('admin/index/login');
        $view->set('failed', true ,false);
        $this->template->content = $view;
    }

    /**
     * ログアウト処理
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function action_logout()
    {
        \Session::destroy();
        \Response::redirect('admin/index/login');
    }
}
