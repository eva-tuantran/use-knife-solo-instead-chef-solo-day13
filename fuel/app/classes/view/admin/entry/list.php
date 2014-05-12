<?php

/**
 * View_Admin_Entry_List ViewModel
 *
 * @author ida
 */
class View_Admin_Entry_List extends \ViewModel
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
    }
}
