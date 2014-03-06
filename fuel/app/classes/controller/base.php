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
    protected $postActions = array();

    /**
     * ログインが必須のアクション配列
     *
     * @var array
     */
    protected $loginActions = array();

    /**
     * 未ログインOKのアクション配列
     *
     * @var array
     */
    protected $nologinActions = array();

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
            && in_array($action, $this->postActions)
        ) {
            Response::redirect('errors/badrequest');
        }

        if (in_array($action, $this->loginActions) && !Auth::check()) {
            Response::redirect('auth/login');
        }

        if (in_array($action, $this->nologinActions) && Auth::check()) {
            Response::redirect('auth/logined');
        }
    }
}
