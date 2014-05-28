<?php

/**
 * View_Admin_User_List ViewModel
 *
 * @author ida
 */
class View_Admin_User_List extends \ViewModel
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
        $this->prefectures = \Config::get('master.prefectures');
        $this->gender_list = \Model_User::getGenderList();
        $this->devices = \Model_User::getDevices();
        $this->register_statuses = \Model_User::getRegisterStatuses();
    }
}
