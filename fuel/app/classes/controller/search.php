<?php
use Fuel\Core\DB;
use \Controller\Base;
use \Model\Fleamarket;
use \Model\Fleamarket_Entry_Style;
use \Model\Entry;
use \Model\Location;

/**
 * Search Controller.
 *
 * @extends  Controller_Template
 */
class Controller_Search extends Controller_Base
{
    /**
     * postが必須のアクション配列
     *
     * @var array
     */
    protected $post_actions = array();

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

        $this->template->title = 'フリーマーケット検索';
        $view_model = ViewModel::forge('search/top');
        $this->template->content = $view_model;
    }

    /**
     * フリーマーケット検索結果画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_index()
    {
        $this->template->title = 'フリーマーケット検索結果';
        $fleamarket_list = Fleamarket::findJoinLocationBy(
            $this->createCondition()
        );

        $fleamarket_list = $this->getFleamarketRelatedData($fleamarket_list);
        $view_model = ViewModel::forge('search/index');
        $view_model->set('fleamarket_list', $fleamarket_list, false);
        $this->template->content = $view_model;
    }

    /**
     * フリーマーケット詳細表示画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_detail($fleamarket_id)
    {
        $this->template->title = 'フリーマーケット詳細情報';
        $fleamarket = Fleamarket::findJoins($fleamarket_id);

        $view_model = ViewModel::forge('search/detail');
        $view_model->set('fleamarket', $fleamarket, false);
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
        if (!is_array($fleamarket_list) || count($fleamarket_list) ==0) {
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
     * @return array 検索条件
     * @author void
     */
    private function createCondition()
    {
        $data = Input::post();
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

        if (isset($data['region']) && $data['region'] !== '') {
            $prefectures = $this->getPrefectureByRegion($data['region']);
            $conditions[] = array('prefecture_id', 'in', $prefectures);
        }

        if (isset($data['shop_fee']) && $data['shop_fee'] !== '') {
            $conditions[] = array('shop_fee_flag', '=', $data['shop_fee']);
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
                'charge_parking', '=', $data['charge_parking']
            );
        }

        if (isset($data['free_parking']) && $data['free_parking'] !== '') {
            $conditions[] = array('free_parking', '=', $data['free_parking']);
        }

        return $conditions;
    }

    /**
     * エリアから都道府県IDを取得する
     *
     * @access private
     * @param mixed リージョンID
     * @return array
     * @author ida
     */
    private function getPrefectureByRegion($region_id = null)
    {
        $region_prefectures = Config::get('master.region_prefectures');
        return $region_prefectures[$region_id];
    }
}