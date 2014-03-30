<?php

/**
 * トップページ
 *
 * @ida
 */
class Controller_Top extends Controller_Base_Template
{
    /**
     * 近日開催のフリーマーケット件数
     */
    private $upcomming_number = 1;

    public function before()
    {
        parent::before();
    }

    /**
     * トップページ
     *
     * @access public
     * @return void
     * @author ida
     * @author shimma
     */
    public function action_index()
    {
        $view_model = ViewModel::forge('top/index');

        $upcomming_fleamarket_list = \Model_Fleamarket::findUpcoming(
            $this->upcomming_number
        );

        $view_model->set('upcomming_fleamarket_list', $upcomming_fleamarket_list, false);
        $view_model->set('prefectures', Config::get('master.prefectures'), false);
        $view_model->set('news_headlines', Model_News::getHeadlines());
        $this->template->content = $view_model;
    }


}
