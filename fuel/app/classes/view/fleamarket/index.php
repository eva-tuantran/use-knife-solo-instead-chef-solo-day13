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
        $this->hours = $this->config['hours'];
        $this->minutes = $this->config['minutes'];
        $this->prefectures = $this->config['prefectures'];
    }
}
