<?php

/**
 * Error Handling Controller.
 *
 * @package  app
 * @extends  Controller_Template
 */
class Controller_Errors extends Controller_Template
{
    /**
     * システムエラー
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_index($error_code, $error_message)
    {
        $this->template->title = $error_code;
        $this->template->content = View::forge(
            'errors/index',
            array(
                'error_code' => $error_code,
                'error_message' => $error_message
            )
        );
    }

    /**
     * 拾いきれてないエラー
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_error()
    {
        $error_code = \Model_Error::ER00000;
        $error_list = Lang::load('error/user', $error_code);
        $error_message = $error_list[$error_code];

        $this->template->title = $error_code;
        $this->template->content = View::forge(
            'errors/index',
            array(
                'error_code' => $error_code,
                'error_message' => $error_message
            )
        );
    }

    /**
     * アクセス禁止
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_forbidden()
    {
        $this->template->title = 'アクセスが許可されておりません';
        $this->template->content = View::forge(
            'errors/content',
            array(
                'error_code' => '',
                'error_message' => 'アクセスが許可されておりません'
            )
        );
    }

    /**
     * ページ未検出
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_notfound()
    {
        $this->template->title = '該当ページが見つかりませんでした';
        $this->template->content = View::forge(
            'errors/content',
            array(
                'error_code' => '',
                'error_message' => '該当ページが見つかりませんでした'
            )
        );
    }

    /**
     * 不正なリクエスト
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_badrequest()
    {
        $this->template->title = '不正なアクセスです';
        $this->template->content = View::forge(
            'errors/content',
            array(
                'error_code' => '',
                'error_message' => '不正なアクセスです'
            )
        );
    }

    /**
     * 二重送信
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_doublesubmit()
    {
        $this->template->title = '2重投稿です';
        $this->template->content = View::forge(
            'errors/content',
            array(
                'error_code' => '',
                'error_message' => '2重投稿です'
            )
        );
    }
}
