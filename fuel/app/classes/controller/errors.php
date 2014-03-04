<?php

/**
 * The Error Handling Controller.
 *
 * @package  app
 * @extends  Controller_Template
 */
class Controller_Errors extends Controller_Template
{

    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $this->template->title = 'エラーが発生しました';
        $this->template->content = View::forge(
            'errors/content',
            array('message' => 'エラーが発生しました')
        );
    }

    public function action_forbidden()
    {
        $this->template->title = 'アクセスが許可されておりません';
        $this->template->content = View::forge(
            'errors/content',
            array('message' => 'アクセスが許可されておりません')
        );
    }

    public function action_notfound()
    {
        $this->template->title = '該当ページが見つかりませんでした';
        $this->template->content = View::forge(
            'errors/content',
            array('message' => '該当ページが見つかりませんでした')
        );
    }

}
