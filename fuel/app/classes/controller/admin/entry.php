<?php
/**
 *
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Admin_Entry extends Controller_Admin_Base_Template
{
    /**
     * 検索結果1ページあたりの行数
     *
     * @var int
     */
    private $result_per_page = 50;

    /**
     * 予約履歴一覧
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function action_list()
    {
        $conditions = $this->getCondition();
        $condition_list = \Model_Entry::createAdminSearchCondition($conditions);

        $total_count = \Model_Entry::getCountByAdminSearch($condition_list);

        // ページネーション設定
        $pagination = \Pagination::forge(
            'entry_pagination',
            $this->getPaginationConfig($total_count)
        );

        $entry_list = \Model_Entry::findAdminBySearch(
            $condition_list,
            $pagination->current_page,
            $this->result_per_page
        );

        $view_model = \ViewModel::forge('admin/entry/list');
        if (\Input::param('fleamarket_id')) {
            $fleamarket = \Model_Fleamarket::find(\Input::param('fleamarket_id'));
            $view_model->set('fleamarket', $fleamarket, false);
        }
        if (\Input::param('user_id')) {
            $user = \Model_User::find(Input::param('user_id'));
            $view_model->set('user', $user, false);
        }
        $view_model->set('entry_list', $entry_list, false);
        $view_model->set('pagination', $pagination, false);
        $view_model->set('item_categories', \Model_Entry::getItemCategoryDefine());
        $view_model->set('entry_statuses', \Model_Entry::getEntryStatuses());
        $view_model->set('total_count', $total_count);
        $this->template->content = $view_model;
    }

    /**
     * 予約履歴CSV出力
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function action_csv()
    {
        $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
        $csv = Lang::load('admin/csv');

        $data = array($csv['header']);

        $prefectures = Config::get('master.prefectures');
        $entry_styles = Config::get('master.entry_styles');
        $entry_statuses = \Model_Entry::getEntryStatuses();

        foreach ($fleamarket->entries as $entry) {
            if ($entry->user && $entry->fleamarket_entry_style) {
                $prefecture_id = $entry->user->prefecture_id;
                if (! isset($prefectures[$prefecture_id])) {
                    $prefecture_name = '-';
                } else {
                    $prefecture_name = $prefectures[$prefecture_id];
                }
                $data[] = array(
                    $fleamarket->created_at,
                    $fleamarket->event_date,
                    $fleamarket->name,
                    $entry->user->user_id,
                    $entry->reservation_number,
                    $entry_styles[$entry->fleamarket_entry_style->entry_style_id],
                    $entry->user->last_name . $entry->user->first_name,
                    $entry->user->zip,
                    $prefecture_name,
                    $entry->user->address,
                    $entry->user->email,
                    $entry->user->mobile_email,
                    $entry_statuses[$entry->entry_status]
                );
            }
        }

        return $this->response_csv($data, $fleamarket->name);
    }

    /**
     * CSV出力
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function action_index()
    {
        $view = View::forge('admin/entry/index');
        $this->template->content = $view;
    }

    /**
     * CSV出力
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    protected function response_csv($data, $fleamarket_name)
    {
        $csv = mb_convert_encoding(
            Format::forge($data)->to_csv(),
            'SJIS-win',
            'UTF-8'
        );

        $file_name = $fleamarket_name . '_エントリ一覧.csv';
        $response = new Response($csv, 200, array(
            'Content-Type'        => 'application/csv',
            'Content-Disposition' => 'attachment; filename="' . $file_name . '"',
        ));

        return $response;
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
        $conditions = Input::all();

        $result = array();
        foreach ($conditions as $field => $value) {
            if ($value !== '') {
                $result[$field] = $value;
            }
        }

        return $result;
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
        $result_per_page = \Input::post('result_per_page');
        if ($result_per_page) {
            $this->result_per_page = $result_per_page;
        }

        return array(
            'pagination_url' => 'admin/entry/list',
            'uri_segment'    => 4,
            'num_links'      => 10,
            'per_page'       => $this->result_per_page,
            'total_items'    => $count,
        );
    }
}
