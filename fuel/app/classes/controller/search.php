<?php
use \Controller\Base_Template;

/**
 * Search Controller.
 *
 * @extends  Controller_Base_Template
 */
class Controller_Search extends Controller_Base_Template
{
    /**
     * 検索結果1ページあたりの行数
     *
     * @var int
     */
    private $search_result_per_page = 20;

    public function before()
    {
        parent::before();
    }

    /**
     * フリーマーケット検索結果画面
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_index($area = null)
    {
        if (empty($area)) {
            $area = 'all';
        }

        $this->setHtmlReplace(array(
            'AREA' => $area,
            'AREA_NAME' => $this->getAreaName($area),
        ));

        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');

        list($conditions, $add_conditions) = $this->getCondition($area);

        // 検索条件から表示するフリーマーケット情報の取得
        $condition_list = \Model_Fleamarket::createSearchCondition(
            array_merge($conditions, $add_conditions)
        );


        // ページネーション設定
        $total_count = \Model_Fleamarket::getCountBySearch($condition_list);
        $pagination = \Pagination::forge(
            'fleamarket_pagination',
            $this->getPaginationConfig($total_count, $area)
        );

        $fleamarket_list = \Model_Fleamarket::findBySearch(
            $condition_list, $pagination->current_page, $this->search_result_per_page
        );

        $view_model = \ViewModel::forge('search/index');
        $view_model->set('conditions', $conditions, false);
        $view_model->set('add_conditions', $add_conditions, false);
        $view_model->set('fleamarket_list', $fleamarket_list, false);
        $view_model->set('pagination', $pagination, false);
        $view_model->set('user', $this->login_user, false);
        $this->template->content = $view_model;
    }

    /**
     * フリーマーケット詳細表示画面
     *
     * @access public
     * @param mixed $fleamarket_id フリーマーケットID
     * @return void
     * @author ida
     */
    public function get_detail($fleamarket_id)
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');

        if (! $fleamarket_id) {
            return $this->forward('errors/notfound', 404);
        }

        $fleamarket = \Model_Fleamarket::findDetail($fleamarket_id);
        if (! $fleamarket) {
            return $this->forward('errors/notfound', 404);
        }
        $this->setHtmlReplace(array(
            'AREA' => $this->getArea($fleamarket['prefecture_id']),
            'AREA_NAME' => $this->getAreaName($fleamarket['prefecture_id']),
            'FLEAMARKET_NAME' => $fleamarket['name'],
            'LOCATION_ID' => $fleamarket['location_id'],
            'LOCATION_NAME' => $fleamarket['location_name'],
        ));

        $fleamarket_abouts = \Model_Fleamarket_About::findByFleamarketId(
            $fleamarket_id
        );

        $fleamarket_images = \Model_Fleamarket_Image::findByFleamarketId(
            $fleamarket_id
        );

        $entry_styles = \Model_Fleamarket_Entry_Style::findByFleamarketId(
            $fleamarket_id
        );

        $entries = \Model_Entry::getTotalEntryByFleamarketId(
            $fleamarket_id
        );
        $fleamarket['entries'] = $entries;

        $view_model = \ViewModel::forge('search/detail');
        $view_model->set('fleamarket', $fleamarket, false);
        $view_model->set('fleamarket_images', $fleamarket_images, false);
        $view_model->set('fleamarket_abouts', $fleamarket_abouts, false);
        $view_model->set(
            'fleamarket_entry_styles', $entry_styles, false
        );
        $view_model->set('entries', $entries, false);
        $view_model->set(
            'prefectures', \Config::get('master.prefectures'), false
        );
        $view_model->set('user', $this->login_user, false);

        $this->template->content = $view_model;
    }

    /**
     * 検索条件を取得する
     *
     * @access private
     * @param string $area 指定エリア
     * @return array
     * @author ida
     */
    private function getCondition($area)
    {
        $conditions = Input::get('c', array());

        $conditions['area'] = $area;

        if (empty($conditions['keyword'])) {
            unset($conditions['keyword']);
        }

        $add_conditions = Input::get('ac', array());
        if (isset($conditions['shop_fee'])
            && $conditions['shop_fee'] == \Model_Fleamarket::SHOP_FEE_FLAG_FREE
        ) {
            $add_conditions['shop_fee'][] = \Model_Fleamarket::SHOP_FEE_FLAG_FREE;
            unset($conditions['shop_fee']);
        }

        return array($conditions, $add_conditions);
    }

    /**
     * ページネーション設定を取得する
     *
     * @access private
     * @param int $count 総行数
     * @param string $area 指定エリア
     * @return array
     * @author ida
     */
    private function getPaginationConfig($count, $area)
    {
        $search_result_per_page = Input::post('search_result_per_page');
        if ($search_result_per_page) {
            $this->search_result_per_page = $search_result_per_page;
        }

        return array(
            'uri_segment' => 'p',
            'num_links' => 5,
            'per_page' => $this->search_result_per_page,
            'total_items' => $count,
        );
    }
}
