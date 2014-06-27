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
        parent::before();
        Asset::css('info.css', array(), 'add_css');
    }

    public function action_index()
    {
        $this->template->content = View::forge('info/index');
    }


    public function action_staff()
    {
        $this->template->content = View::forge('info/staff');
    }


    public function action_food()
    {
        $this->template->content = View::forge('info/food');
    }


    public function action_corporation()
    {
        $this->template->content = View::forge('info/corporation');
    }


    public function action_visitor()
    {
        $this->template->content = View::forge('info/visitor');
    }


    public function action_agreement()
    {
        $this->template->content = View::forge('info/agreement');
    }


    public function action_manager()
    {
        $this->template->content = View::forge('info/manager');
    }


    public function action_policy()
    {
        $this->template->content = View::forge('info/policy');
    }

    public function action_question()
    {
        $this->template->content = View::forge('info/question');
    }


}
