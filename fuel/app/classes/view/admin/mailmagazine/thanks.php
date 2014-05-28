<?php

/**
 * View_Admin_Mailmagazine_Thanks ViewModel
 *
 * @author ida
 */
class View_Admin_Mailmagazine_Thanks extends \ViewModel
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
    }
}
