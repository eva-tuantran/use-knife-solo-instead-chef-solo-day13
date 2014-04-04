<?php

class Controller_Admin extends Controller_Admin_Base_Template
{
    public function action_index()
    {
        $this->template->content = View::forge('admin/index');
    }
}
