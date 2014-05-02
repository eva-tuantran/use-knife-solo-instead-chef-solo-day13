<?php

/**
 * View_Admin_Mailmagazine_Index ViewModel
 *
 * @author ida
 */
class View_Admin_Mailmagazine_Index extends \ViewModel
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
        $this->mail_magazine_types = \Model_Mail_Magazine::getMailMagazinTypes();
        $this->fleamarket_list = \Model_Fleamarket::findUpcoming(20);
    }
}
