<?php

/**
 * View_Admin_Locatin_Index ViewModel
 *
 * @author ida
 */
class View_Admin_Location_Index extends \ViewModel
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
        $this->location_id = \Input::get('location_id');
        $this->prefectures = \Config::get('master.prefectures');
    }
}
