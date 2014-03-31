<?php

/**
 * View_Component_Latest ViewModel
 *
 * @author ida
 */
class View_Component_Latest extends ViewModel
{
    /**
     * 検索結果1ページあたりの行数
     *
     * @var int
     */
    private $result_per_page = 10;

    /**
     * 最新のフリマ画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function view()
    {
        $fleamarket_list = \Model_Fleamarket::findLatest(
            $this->result_per_page
        );

        $this->fleamarket_list = $fleamarket_list;
        $this->event_statuses = \Model_Fleamarket::getEventStatuses();
        $this->week_list = \Config::get('master.week');
        $this->prefectures = \Config::get('master.prefectures');
    }
}