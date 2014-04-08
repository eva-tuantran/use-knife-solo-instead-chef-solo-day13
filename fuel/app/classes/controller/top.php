<?php

/**
 * トップページ
 *
 * @ida
 */
class Controller_Top extends Controller_Base_Template
{
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

        $view_model->set('news_headlines', \Model_News::getHeadlines());
        $view_model->set(
            'upcomming', \ViewModel::forge('component/upcomming'), false
        );
        $view_model->set(
            'calendar', \ViewModel::forge('component/calendar'), false
        );
        $view_model->set(
            'popular_ranking', \ViewModel::forge('component/popular'), false
        );
        $view_model->set(
            'latest', \ViewModel::forge('component/latest'), false
        );

        Asset::js('jquery.carouFredSel.js', array(), 'add_js');
        Asset::js('jquery.rwdImageMaps.min.js', array(), 'add_js');
        Asset::js('top.js', array(), 'add_js');
        Asset::css('top.css', array(), 'add_css');

        $this->template->content = $view_model;
    }
}
