<?php

/**
 * View_Admin_Fleamarket_Confirm ViewModel
 *
 * @author ida
 */
class View_Admin_Fleamarket_Confirm extends \ViewModel
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
        $this->entry_styles = \Config::get('master.entry_styles');
        $this->event_statuses = \Model_Fleamarket::getEventStatuses();
        $this->locations = \Model_Location::find('all');
    }
}
