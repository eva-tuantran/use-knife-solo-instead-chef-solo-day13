<?php

/**
 * fleamarket confirm ViewModel
 *
 * @author ida
 */
class View_Fleamarket_Confirm extends ViewModel
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
        $this->prefectures = Config::get('master.prefectures');
    }
}
