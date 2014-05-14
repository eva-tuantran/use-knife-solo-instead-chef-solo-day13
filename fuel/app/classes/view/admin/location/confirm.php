<?php

/**
 * View_Admin_Locatin_Confirm ViewModel
 *
 * @author ida
 */
class View_Admin_Location_Confirm extends \ViewModel
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
        $this->location_id = \Input::post('location_id');
        $this->prefectures = \Config::get('master.prefectures');
    }
}
