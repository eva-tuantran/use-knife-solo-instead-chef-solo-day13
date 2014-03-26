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
     * フリーマーケット検索結果画面
     *
     * @access public
     * @param mixed $page ページ番号
     * @return void
     * @author ida
     */
    public function get_index($page = null)
    {
        if (! $page) {
            $page = 1;
        }

        $base_conditions = Input::get('conditions', array());
        $date = Input::get('d');
        if ($date) {
            $base_conditions = array('date' => $date,);
        }
        $add_conditions = Input::get('add_conditions', array());
        if (isset($base_conditions['shop_fee'])
            && $base_conditions['shop_fee'] == \Model_Fleamarket::SHOP_FEE_FLAG_FREE
        ) {
            $add_conditions['shop_fee'][] = \Model_Fleamarket::SHOP_FEE_FLAG_FREE;
            unset($base_conditions['shop_fee']);
        }

        $conditions = array_merge($base_conditions, $add_conditions);

        // 検索条件から表示するフリーマーケット情報の取得
        $condition_list = \Model_Fleamarket::createSearchConditionList($conditions);
        $total_count = \Model_Fleamarket::findBySearchCount($condition_list);
        $fleamarket_list = \Model_Fleamarket::findBySearch(
            $condition_list, $page, $this->search_result_per_page
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
        $view_model->set('add_conditions', $add_conditions, false);
        $view_model->set('pagination', $pagination, false);
        $view_model->set('fleamarket_list', $fleamarket_list, false);
        $view_model->set('entry_styles', $entry_styles, false);

        $this->setMetaTag('search/index');
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
        if (! $fleamarket_id) {
            Response::redirect('errors/notfound');
        }

        $fleamarket = \Model_Fleamarket::findByDetail($fleamarket_id);
        $fleamarket_abouts = \Model_Fleamarket_About::findByFleamarketId(
            $fleamarket_id
        );

        $entry_styles = \Model_Fleamarket_Entry_Style::findByFleamarketId(
            $fleamarket_id
        );

        $entries = \Model_Entry::getTotalEntryByFlearmarketId(
            $fleamarket_id
        );
        $fleamarket['entries'] = $entries;

        $view_model = ViewModel::forge('search/detail');
        $view_model->set('fleamarket', $fleamarket, false);
        $view_model->set('fleamarket_abouts', $fleamarket_abouts, false);
        $view_model->set(
            'fleamarket_entry_styles', $entry_styles, false
        );
        $view_model->set('entries', $entries, false);

        $this->setMetaTag('search/detail');
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
        if (! $fleamarket_list) {
            return false;
        }

        $entry_style_fields = array(
            'field' => array(
                'entry_style_id',
                'booth_fee',
                'max_booth',
                'reservation_booth_limit',
            )
        );
        foreach ($fleamarket_list as &$fleamarket) {
            $entry_styles = \Model_Fleamarket_Entry_Style::findByFleamarketId(
                $fleamarket['fleamarket_id'], $entry_style_fields
            );
            $fleamarket['entry_styles'] = $entry_styles;

            $entries = \Model_Entry::getTotalEntryByFlearmarketId(
                $fleamarket['fleamarket_id']
            );
            $fleamarket['entries'] = $entries;
        }

        return $fleamarket_list;
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