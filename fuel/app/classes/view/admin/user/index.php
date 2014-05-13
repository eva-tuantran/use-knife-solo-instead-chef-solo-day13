<?php

/**
 * View_Admin_User_Index ViewModel
 *
 * @author ida
 */
class View_Admin_User_Index extends \ViewModel
{
    /**
     * view method
     *
     * @access public
     * @return void
     * @author ida
     */
    public function view()
    {
        $this->user_id = \Input::get('user_id');
        $this->prefectures = \Config::get('master.prefectures');
        $this->devices = \Model_User::getDevices();
        $this->register_statuses = \Model_User::getRegisterStatuses();
    }
}
