<?php

/**
 * 予約履歴管理
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */
class Controller_Admin_Entry extends Controller_Admin_Base_Template
{
    protected $_secure_actions = array(
        'list', 'csv', 'sendmail', 'cancel'
    );

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
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');

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
        $view_model->set('conditions', $conditions, false);
        $view_model->set('total_count', $total_count);
        $this->template->content = $view_model;
    }

    /**
     * 特定の出店予約にメールを送信する
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_sendmail()
    {
        $this->template = '';

        $entry_id = \Input::get('entry_id');
        $mails = \Input::get('mails');

        $status = 400;
        if (! empty($entry_id) && ! empty($mails)) {
            try {
                $entry = \Model_Entry::find($entry_id);
                $user = \Model_User::find($entry->user_id);
                foreach ($mails as $mail) {
                    switch ($mail) {
                        case 'reservation':
                            $entry->sendmail($user, 'reservation');
                            break;
                        default:
                            break;
                    }
                }
                $status = 200;
            } catch (\Exception $e) {
                $status = 400;
            }
        }

        return $this->responseJson(array('status' => $status));
    }

    /**
     * 指定した出店予約をキャンセルする
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function action_cancel()
    {
        $this->template = '';

        $entry_id = \Input::get('entry_id');
        $sendmail = \Input::get('sendmail');

        $status = 400;
        if (! empty($entry_id)) {
            try {
                $entry = \Model_Entry::find($entry_id);
                $entry->cancel($entry_id, $this->administrator->administrator_id);
                if ($sendmail == 1) {
                    $email_template_params = array(
                        'nick_name' => $entry->user->nick_name,
                        'fleamarket.name' => $entry->fleamarket->name,
                    );
                    $entry->user->sendmail('common/user_cancel_fleamarket', $email_template_params);
                }
                $status = 200;
            } catch (\SystemException $e) {
                $status = 300;
            } catch (\Exception $e) {
                $status = 400;
            }
        }

        return $this->responseJson(array('status' => $status));
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

        $prefectures = \Config::get('master.prefectures');
        $entry_styles = \Config::get('master.entry_styles');
        $entry_statuses = \Model_Entry::getEntryStatuses();
        $gender_list = \Model_User::getGenderList();

        foreach ($fleamarket->entries as $entry) {
            if ($entry->user && $entry->fleamarket_entry_style) {
                $prefecture_id = $entry->user->prefecture_id;
                if (! isset($prefectures[$prefecture_id])) {
                    $prefecture_name = '-';
                } else {
                    $prefecture_name = $prefectures[$prefecture_id];
                }
                $data[] = array(
                    $entry->created_at,
                    $fleamarket->event_date,
                    $fleamarket->name,
                    $entry->user->user_id,
                    $entry->reservation_number,
                    $entry_styles[$entry->fleamarket_entry_style->entry_style_id],
                    $entry->user->last_name . $entry->user->first_name,
                    $entry->user->zip,
                    $prefecture_name,
                    $entry->user->address,
                    $entry->user->tel,
                    @$gender_list[$entry->user->gender],
                    $entry->user->email,
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
        $conditions = \Input::post('c', array());

        $result = array();
        foreach ($conditions as $field => $value) {
            if ($value !== '') {
                $result[$field] = $value;
            }
        }

        $fleamarket_id = \Input::param('fleamarket_id');
        if (! empty($fleamarket_id)) {
            $result['fleamarket_id'] = $fleamarket_id;
        }

        $user_id = \Input::param('user_id');
        if (! empty($user_id)) {
            $result['user_id'] = $user_id;
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
