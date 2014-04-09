<?php
/**
 * 各種静的コンテンツ用コントローラ
 *
 * @author nakata
 */

class Controller_Info extends Controller_Base_Template
{

    public function before()
    {
        Asset::css('info.css', array(), 'add_css');
        parent::before();
    }


    public function action_index()
    {
        $this->template->content = View::forge('info/index');
    }


    public function action_staff()
    {
        $this->template->content = View::forge('info/staff');
    }


}
