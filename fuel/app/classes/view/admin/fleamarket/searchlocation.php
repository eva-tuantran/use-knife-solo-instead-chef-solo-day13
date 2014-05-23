<?php

/**
 * View_Admin_Fleamarket_Index ViewModel
 *
 * @author ida
 */
class View_Admin_Fleamarket_Searchlocation extends \ViewModel
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
    }
}
