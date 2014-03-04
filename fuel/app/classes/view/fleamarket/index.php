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
        $this->prefectures = $this->app_config['prefectures'];
        $this->event_abouts = $this->app_config['event_abouts'];
    }
}
