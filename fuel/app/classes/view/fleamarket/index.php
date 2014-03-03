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
        $this->title = 'フリーマーケット情報の入力';
        $this->event_hours = $this->app_config['event_hours'];
        $this->event_minutes = $this->app_config['event_minutes'];
        $this->prefectures = $this->app_config['prefectures'];
        $this->event_abouts = $this->app_config['event_abouts'];
    }
}
