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
        $this->item_categories = \Model_Entry::getItemCategories();
        $this->entry_statuses = \Model_Entry::getEntryStatuses();
    }
}
