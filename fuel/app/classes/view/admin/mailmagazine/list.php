<?php

/**
 * View_Admin_Mailmagazine_List ViewModel
 *
 * @author ida
 */
class View_Admin_Mailmagazine_List extends \ViewModel
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
        $this->mail_magazine_types = \Model_Mail_Magazine::getMailMagazinTypes();
        $this->send_statuses = \Model_Mail_Magazine::getSendStatuses();
    }
}
