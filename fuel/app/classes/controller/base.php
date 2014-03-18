<?php

/**
 * Base Controller.
 *
 * @extends  Controller_Template
 */
class Controller_Base extends Controller_Template
{
    /**
     * postが必須のアクション配列
     *
     * @var array
     */
    protected $post_actions = array();

    /**
     * ログインが必須のアクション配列
     *
     * @var array
     */
    protected $login_actions = array();

    /**
     * 未ログインOKのアクション配列
     *
     * @var array
     */
    protected $nologin_actions = array();

    /**
     * 事前処理
     *
     * アクション実行前の共通処理
     *
     * @access public
     * @return void
     * @author ida
     */
    public function before()
    {
        parent::before();

        $action = Request::active()->action;

        if (Input::method() !== 'POST'
            && in_array($action, $this->post_actions)
        ) {
            Response::redirect('errors/badrequest');
        }

        if (in_array($action, $this->login_actions) && !Auth::check()) {
            Response::redirect('auth/login');
        }

        if (in_array($action, $this->nologin_actions) && Auth::check()) {
            Response::redirect('auth/logined');
        }
    }
}
