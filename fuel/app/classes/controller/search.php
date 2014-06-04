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
     * @param int $page ページ番号
     * @return void
     * @author ida
     */
    public function get_index($page = null)
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');

        if (! $page) {
            $page = 1;
        }

        list($conditions, $add_conditions) = $this->getCondition();

        // 検索条件から表示するフリーマーケット情報の取得
        $condition_list = \Model_Fleamarket::createSearchCondition(
            array_merge($conditions, $add_conditions)
        );

        $total_count = \Model_Fleamarket::getCountBySearch($condition_list);
        $fleamarket_list = \Model_Fleamarket::findBySearch(
            $condition_list, $page, $this->search_result_per_page
        );

        // ページネーション設定
        $pagination = \Pagination::forge(
            'fleamarket_pagination',
            $this->getPaginationConfig($total_count)
        );

        $view_model = ViewModel::forge('search/index');
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
            Response::redirect('errors/notfound');
        }

        $fleamarket = \Model_Fleamarket::findDetail($fleamarket_id);
        if (! $fleamarket) {
            Response::redirect('errors/notfound');
        }

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

        $view_model = ViewModel::forge('search/detail');
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
     * 都道府県一覧を取得する
     *
     * jsonで返す
     *
     * @access public
     * @param
     * @return void
     * author ida
     */
    public function get_prefecture()
    {
        $region_id = Input::get('region_id');

        $region_prefectures = \Config::get('master.region_prefectures');
        $prefectures = \Config::get('master.prefectures');

        $result = array();
        if ($region_id) {
            $region_prefecture = $region_prefectures[$region_id];
            foreach ($region_prefecture as $prefecture_id) {
                $result[$prefecture_id] = $prefectures[$prefecture_id];
            }
        }

        if (! $result) {
            $result = $prefectures;
        }

        $this->responseJson($result, true);
    }

    /**
     * 検索条件を取得する
     *
     * @access private
     * @param
     * @return array
     * @author ida
     */
    private function getCondition()
    {
        $conditions = Input::get('c', array());

        if (isset($conditions['keyword'])
            && $conditions['keyword'] == ''
        ) {
            unset($conditions['keyword']);
        }

        if (isset($conditions['prefecture'])
            && $conditions['prefecture'] == ''
        ) {
            unset($conditions['prefecture']);
        }

        if (isset($conditions['region'])
            && $conditions['region'] == ''
        ) {
            unset($conditions['region']);
        }

        $prefecure = Input::get('prefecture');
        if ($prefecure != '') {
            $alphabet_prefectures = \Config::get('master.alphabet_prefectures');
            $prefecture_id = array_search($prefecure, $alphabet_prefectures);
            $conditions = array('prefecture' => $prefecture_id);
        }

        $calendar = Input::get('calendar');
        if ($calendar) {
            $conditions = array('calendar' => $calendar);
        }

        $upcomming = Input::get('upcomming');
        if ($upcomming) {
            $conditions = array('upcomming' => $upcomming);
        }

        $reservation = Input::get('reservation');
        if ($reservation) {
            $conditions = array('reservation' => $reservation);
        }

        $add_conditions = Input::get('ac', array());
        if (isset($conditions['shop_fee'])
            && $conditions['shop_fee'] == \Model_Fleamarket::SHOP_FEE_FLAG_FREE
        ) {
            $add_conditions['shop_fee'][] = \Model_Fleamarket::SHOP_FEE_FLAG_FREE;
            unset($conditions['shop_fee']);
        }

        if (empty($add_conditions['event_status'])) {
            $add_conditions['event_status'] = array(
                \Model_Fleamarket::EVENT_STATUS_SCHEDULE,
                \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT,
            );
        }

        return array($conditions, $add_conditions);
    }

    /**
     * ページネーション設定を取得する
     *
     * @access private
     * @param int $count 総行数
     * @return array
     * @author ida
     */
    private function getPaginationConfig($count)
    {
        $search_result_per_page = Input::post('search_result_per_page');
        if ($search_result_per_page) {
            $this->search_result_per_page = $search_result_per_page;
        }

        return array(
            'pagination_url' => 'search',
            'uri_segment' => 2,
            'num_links' => 5,
            'per_page' => $this->search_result_per_page,
            'total_items' => $count,
        );
    }
}