<?php

/**
 * View_Search_Top ViewModel
 *
 * @author ida
 */
class View_Search_Top extends ViewModel
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
        $this->title = 'フリーマーケット検索';
        $this->prefectures = Config::get('master.prefectures');
        $this->regions = Config::get('master.regions');
    }
}
