<?php
use \Controller\Base_Template;
use \Model\Fleamarket;
use \Model\Fleamarket_Entry_Style;
use \Model\Entry;
use \Model\Location;

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
    const SEARCH_RESULT_PER_PAGE = 1;

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
    public function action_top()
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery.js', array(), 'add_js');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');

        $view_model = ViewModel::forge('search/top');

        $this->template->title = 'フリーマーケット検索';
        $this->template->content = $view_model;
    }

    /**
     * フリーマーケット検索結果画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function post_index($page = null)
    {
        Asset::js('jquery.js', array(), 'add_js');

        if ($page == '') {
            $page = 1;
        }

        $base_conditions = Input::post('conditions');
        $filters = Input::post('filters', array());
        $conditions = array_merge($base_conditions, $filters);

        // 検索条件から表示するフリーマーケット情報の取得
        $condition_list = $this->createConditionList($conditions);
        $total_count = Fleamarket::findBySearchCount($condition_list);
        $fleamarket_list = Fleamarket::findBySearch(
            $condition_list, $page, self::SEARCH_RESULT_PER_PAGE
        );
        $fleamarket_list = $this->getFleamarketRelatedData($fleamarket_list);

        // ページネーション設定
        $pagination = Pagination::forge(
            'fleamarket_pagination',
            $this->getPaginationConfig($total_count)
        );
        $entry_styles = Config::get('master.entry_styles');

        $view_model = ViewModel::forge('search/index');
        $view_model->set('base_conditions', $base_conditions, false);
        $view_model->set('filters', $filters, false);
        $view_model->set('pagination', $pagination, false);
        $view_model->set('fleamarket_list', $fleamarket_list, false);
        $view_model->set('entry_styles', $entry_styles, false);

        $this->template->title = 'フリーマーケット検索結果';
        $this->template->content = $view_model;
    }

    /**
     * フリーマーケット詳細表示画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function get_detail($fleamarket_id)
    {
        $fleamarket = Fleamarket::findJoins($fleamarket_id);

        $view_model = ViewModel::forge('search/detail');
        $view_model->set('fleamarket', $fleamarket, false);

        $this->template->title = 'フリーマーケット詳細情報';
        $this->template->content = $view_model;
    }

    /**
     * フリーマーケット情報に紐づくフリーマーケット出店形態情報を取得する
     *
     * @access private
     * @param array $fleamarket_list フリーマーケット情報
     * @return array
     * @author ida
     */
    private function getFleamarketRelatedData($fleamarket_list = array())
    {
        if (!is_array($fleamarket_list) || count($fleamarket_list) == 0) {
            return $fleamarket_list;
        }

        $entry_style_fields = array(
            'field' => array(
                'entry_style_id', 'booth_fee', 'reservation_booth_limit'
            )
        );
        foreach ($fleamarket_list as &$fleamarket) {
            $fleamarket['entry_styles'] = Fleamarket_Entry_Style::find(
                $fleamarket['fleamarket_id'], $entry_style_fields
            );

            $fleamarket['entries'] = Entry::getTotalEntryByFlearmarketId(
                $fleamarket['fleamarket_id']
            );
        }

        return $fleamarket_list;
    }

    /**
     * 検索条件を取得する
     *
     * @access private
     * @param array $data 選択された検索条件
     * @return array 検索条件
     * @author void
     */
    private function createConditionList($data)
    {
        $conditions = array();

        if (isset($data['event_date']) && $data['event_date'] !== '') {
            $conditions[] = array(
                'DATE_FORMAT(event_date, \'%Y/%m/%d\')',
                '=',
                $data['event_date']
            );
        }

        if (isset($data['keyword']) && $data['keyword'] !== '') {
            $conditions[] = array(
                'f.name', 'like', '%' . $data['keyword'] . '%'
            );
        }

        if (isset($data['prefecture']) && $data['prefecture'] !== '') {
            $conditions[] = array('prefecture_id', '=', $data['prefecture']);
        }

        if (isset($data['shop_fee']) && $data['shop_fee'] !== '') {
            $operator = '=';
            if (is_array($data['shop_fee'])) {
                $operator = 'IN';
            }
            $conditions[] = array(
                'shop_fee_flag', $operator, $data['shop_fee']
            );
        }

        if (isset($data['car_shop']) && $data['car_shop'] !== '') {
            $conditions[] = array('car_shop_flag', '=', $data['car_shop']);
        }

        if (isset($data['pro_shop']) && $data['pro_shop'] !== '') {
            $conditions[] = array('pro_shop_flag', '=', $data['pro_shop']);
        }

        if (isset($data['rainy_location']) && $data['rainy_location'] !== '') {
            $conditions[] = array(
                'rainy_location_flag', '=', $data['rainy_location']
            );
        }

        if (isset($data['charge_parking']) && $data['charge_parking'] !== '') {
            $conditions[] = array(
                'charge_parking_flag', '=', $data['charge_parking']
            );
        }

        if (isset($data['free_parking']) && $data['free_parking'] !== '') {
            $conditions[] = array(
                'free_parking_flag', '=', $data['free_parking']
            );
        }

        if (isset($data['event_status']) && is_array($data['event_status'])) {
            $operator = '=';
            if (is_array($data['event_status'])) {
                $operator = 'IN';
            }
            $conditions[] = array(
                'f.event_status', $operator, $data['event_status']
            );
        }

        if (isset($data['entry_style']) && is_array($data['entry_style'])) {
            $operator = '=';
            if (is_array($data['entry_style'])) {
                $operator = 'IN';
            }
            $conditions[] = array(
                'fes.entry_style_id', $operator, $data['entry_style']
            );
        }

        return $conditions;
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
        return array(
            'pagination_url' => 'search/index',
            'uri_segment' => 3,
            'num_links' => 5,
            'per_page' => self::SEARCH_RESULT_PER_PAGE,
            'total_items' => $count,
        );
    }
}