<?php

/**
 * The Error Handling Controller.
 *
 * @package  app
 * @extends  Controller_Template
 */
class Controller_Error extends Controller_Template
{

    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $this->template->title = 'エラーが発生しました';
        $this->template->content = View::forge('error/forbidden', array(404));
    }

    public function action_forbidden()
    {
        $this->template->title = '許可されておりません';
        $this->template->content = View::forge('error/forbidden', 403);
    }

    public function action_notfound()
    {
        $this->template->title = '該当ページが見つかりませんでした';
        $this->template->content = View::forge('error/forbidden', 404);
    }

}
