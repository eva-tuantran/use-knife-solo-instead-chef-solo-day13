<?php

/**
 * View_Admin_Mailmagazine_Userlist ViewModel
 *
 * @author ida
 */
class View_Admin_Mailmagazine_Userlist extends \ViewModel
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
        $this->mail_magazine = \Model_Mail_Magazine::find($this->mail_magazine_id);
        $this->send_status = \Model_Mail_Magazine_User::getSendStatuses();
    }
}
