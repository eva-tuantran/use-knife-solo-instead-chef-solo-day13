<?php

/**
 * View_Top_Index ViewModel
 *
 * @author ida
 */
class View_Top_Index extends ViewModel
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
        $this->regions = \Config::get('master.regions');
        $this->region_prefectures = \Config::get('master.region_prefectures');
        $this->prefectures = \Config::get('master.prefectures');
    }
}