<?php

class Controller_Base extends Controller_Template
{

    public function before()
    {
        parent::before();
        $this->current_user = Auth::check() ? Model_User::find_by_username(Auth::get_screen_name()) : null;
        View::set_global('current_user', $this->current_user);

    }

}
