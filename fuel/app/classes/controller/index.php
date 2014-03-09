<?php

/**
 * トップページ
 *
 * @author Ricky <master@mistdev.com>
 */
class Controller_Index extends Controller_Template
{

    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $this->template->title   = '楽市楽座トップページ';
        $this->template->content = View::forge('index/index');
    }

}
