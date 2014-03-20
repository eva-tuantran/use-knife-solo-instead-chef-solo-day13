<?php
use \Controller\Base_Template;

/**
 * Search Controller.
 *
 * @extends  Controller_Base_Template
 */
class Controller_Top extends Controller_Base_Template
{
    /**
     * 事前処理
     *
     * アクション実行前の共通処理
     *
     * @access public
     * @return void
     * @author ida
     */
    public function before()
    {
        parent::before();
    }

    /**
     * フリーマーケット検索画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_index()
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery.js', array(), 'add_js');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');

        $view_model = ViewModel::forge('top/index');

        $prefectures = Config::get('master.prefectures');
        $view_model->set('prefectures', $prefectures, false);
        $this->template->title = 'フリーマーケット検索';
        $this->template->content = $view_model;
    }


}
