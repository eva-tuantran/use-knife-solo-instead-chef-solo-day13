<?php

/**
 * fleamarket index ViewModel
 *
 * @author ida
 */
class View_Fleamarket_Index extends ViewModel
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
        $this->fleamarket_about_titles = \Model_Fleamarket_About::getAboutTitles();
        $this->fleamarket_about_names = \Model_Fleamarket_About::getAboutNames();
        $this->prefectures = Config::get('master.prefectures');
    }
}
