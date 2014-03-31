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
        Asset::js('jquery.carouFredSel.js', array(), 'add_js');
        Asset::js('jquery.rwdImageMaps.min.js', array(), 'add_js');

        $view_model = ViewModel::forge('top/index');

        $upcomming_fleamarket_list = \Model_Fleamarket::findUpcoming(
            $this->upcomming_number
        );

        $view_model_calendar = ViewModel::forge('component/calendar');
        $view_model_calendar->set('year', date('Y'));
        $view_model_calendar->set('month', date('n'));

        $view_model->set(
            'upcomming_fleamarket_list', $upcomming_fleamarket_list, false
        );
        $view_model->set('prefectures', \Config::get('master.prefectures'), false);
        $view_model->set('news_headlines', \Model_News::getHeadlines());
        $view_model->set('calendar', $view_model_calendar, false);
        $view_model->set(
            'popular_ranking', ViewModel::forge('component/popular'), false
        );
        $view_model->set(
            'fleamarket_latest', ViewModel::forge('component/latest'), false
        );
        $this->template->content = $view_model;
    }
}
