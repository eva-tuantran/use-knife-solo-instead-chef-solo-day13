<?php

/**
 * View_Admin_Locatin_List ViewModel
 *
 * @author ida
 */
class View_Admin_Location_List extends \ViewModel
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
        $this->register_types = \Model_Location::getRegisterTypes();
    }
}
