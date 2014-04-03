<?php

/**
 * View_Component_Upcomming ViewModel
 *
 * 近日開催のフリーマーケット一覧
 *
 * @author ida
 */
class View_Component_Upcomming extends ViewModel
{
    /**
     * 取得する件数
     *
     * @var int
     */
    private $result_number = 1;

    /**
     * 近日開催のフリマ画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function view()
    {
        if (isset($this->number) && is_int($this->number)) {
            $this->result_number = $this->number;
        }

        $fleamarket_list =  \Model_Fleamarket::findUpcoming(
            $this->result_number
        );

        $this->fleamarket_list = $fleamarket_list;
        $this->event_statuses = \Model_Fleamarket::getEventStatuses();
        $this->week_list = \Config::get('master.week');
        $this->prefectures = \Config::get('master.prefectures');
    }
}