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
     * 近日開催のフリーマーケット件数
     */
    private $upcomming_number = 1;
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
        $view_model = ViewModel::forge('top/index');

        $upcomming_fleamarket_list = \Model_Fleamarket::findUpcoming(
            $this->upcomming_number
        );
        $prefectures = Config::get('master.prefectures');

        $view_model->set(
            'upcomming_fleamarket_list', $upcomming_fleamarket_list, false
        );
        $view_model->set('prefectures', $prefectures, false);

        $this->setMetaTag('top/index');
        $this->template->content = $view_model;
    }
}
