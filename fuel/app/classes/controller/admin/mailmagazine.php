<?php

/**
 * メルマガ管理
 *
 * @extends Controller_Admin_Base_Template
 * @author ida
 */
class Controller_Admin_Mailmagazine extends Controller_Admin_Base_Template
{
    /**
     * 検索結果1ページあたりの行数
     *
     * @var int
     */
    private $result_per_page = 50;

    public function before()
    {
        parent::before();
    }

    /**
     * 一覧画面
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_list()
    {
        \Session::delete('mail_magazine.input_data');

        $conditions = $this->getCondition();
        $condition_list = \Model_Mail_Magazine::createAdminSearchCondition($conditions);
        $total_count = \Model_Mail_Magazine::getCountByAdminSearch($condition_list);

        // ページネーション設定
        $pagination = \Pagination::forge(
            'mail_magazine_pagination',
            $this->getPaginationConfig($total_count)
        );

        $mail_magazine_list = \Model_Mail_Magazine::findAdminBySearch(
            $condition_list,
            $pagination->current_page,
            $this->result_per_page
        );

        $view_model = \ViewModel::forge('admin/mailmagazine/list');
        $view_model->set('mail_magazine_list', $mail_magazine_list, false);
        $view_model->set('pagination', $pagination, false);
        $view_model->set('conditions', $conditions, false);
        $this->template->content = $view_model;
    }

    /**
     * 送信先ユーザ一覧画面
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_userlist($mail_magazine_id = null)
    {
        $total_count = \Model_Mail_Magazine_User::getCountByMailMagazineId($mail_magazine_id);

        // ページネーション設定
        $pagination = \Pagination::forge(
            'mail_magazine_user_pagination',
            $this->getPaginationConfig($total_count)
        );

        $mail_magazine_user_list = \Model_Mail_Magazine_User::findListByMailMagazineId(
            $mail_magazine_id,
            $pagination->current_page,
            $this->result_per_page
        );

        $view_model = \ViewModel::forge('admin/mailmagazine/userlist');
        $view_model->set('mail_magazine_id', $mail_magazine_id);
        $view_model->set(
            'mail_magazine_user_list', $mail_magazine_user_list, false
        );
        $view_model->set('pagination', $pagination, false);
        $this->template->content = $view_model;
    }

    /**
     * 入力画面
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_index()
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');

        $data = $this->getInputData(true);
        $errors = $this->getErrorMessage();

        $view_model = \ViewModel::forge('admin/mailmagazine/index');
        $view_model->set('data', $data, false);
        $view_model->set('errors', $errors);
        $this->template->content = $view_model;
    }

    /**
     * 確認画面
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_confirm()
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');

        $data = \Input::post();
        $fieldset = $this->getFieldset($data['mail_magazine_type']);

        $validation = $fieldset->validation();
        // @todo メルマガタイプごとに フリマIDをセットしないと！
        $validation_result = $validation->run($data);

        if (! $validation_result) {
            $this->setInputData($validation->input());
            $this->setErrorMessage($validation->error_message());

            \Response::redirect('admin/mailmagazine/index');
        }

        $view_model = \ViewModel::forge('admin/mailmagazine/confirm');
        $valid_data = $validation->validated();
        list($view_model, $replace_data) = $this->setupData(
            $view_model, $valid_data
        );
        $valid_data['query'] = \DB::last_query();

        $this->setInputData($valid_data);
        $this->template->content = $view_model;
    }

    /**
     * テスト送信
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_test()
    {
        $this->template = '';

        $to = \Input::post('deliveredTo');

        $input_data = $this->getInputData();

        $replace_data = array();
        $replace_data['user'] = $this->administrator;

        $mail_magazine_type = $input_data['mail_magazine_type'];
        switch ($mail_magazine_type) {
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                $fleamarket = \Model_Fleamarket::find($input_data['reserved_fleamarket_id']);
                $replace_data['fleamarket'] = $fleamarket;
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_WAITING_ENTRY:
                $fleamarket = \Model_Fleamarket::find($input_data['waiting_fleamarket_id']);
                $replace_data['fleamarket'] = $fleamarket;
                break;
        }

        $from_email = $input_data['from_email'];
        $from_name = $input_data['from_name'];
        $subject = trim($input_data['subject']);
        $body = $input_data['body'];
        $pattern = \Model_Mail_Magazine::getPatternParameter($mail_magazine_type);
        list($pattern, $replacement) = \Model_Mail_Magazine::createReplaceParameter(
            $body, $pattern, $replace_data
        );
        $body = \Model_Mail_Magazine::replaceByParam($body, $pattern, $replacement);

        $success = false;
        $message = '';
        if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
            try {
                $success = \Model_Mail_Magazine::sendMail(
                    $from_name, $from_email, $to, $subject, $body
                );
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $success = false;
            }
        } else {
            $message = '差出人メールアドレスが正しくありません';
        }

        $response = array();
        if ($success) {
            $response = array('status' => 200);
        } else {
            $response = array('status' => 400, 'message' => $message);
        }

        return $this->responseJson($response);
    }

    /**
     * 登録＆送信
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_thanks()
    {
        if (! Security::check_token()) {
            \Response::redirect('errors/doubletransmission');
        }

        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');

        $input_data = $this->getInputData(true);
        $input_data['created_user'] = $this->administrator->administrator_id;
        $input_data['send_status'] = \Model_Mail_Magazine::SEND_STATUS_WAITING;
        $additional_data = $this->getAdditionalData($input_data);
        $input_data['additional_serialize_data'] = serialize($additional_data);

        try {
            $db = Database_Connection::instance('master');
            \DB::start_transaction();

            $mail_magazine = \Model_Mail_Magazine::forge();
            $mail_magazine->set($input_data)->save();

            // メルマガ対象ユーザ登録
            $query = $input_data['query'];
            $users = \DB::query($query)->execute();
            foreach ($users as $user) {
                $data = array(
                    'mail_magazine_id' => $mail_magazine->mail_magazine_id,
                    'user_id' => $user['user_id'],
                    'send_status' => \Model_Mail_Magazine_User::SEND_STATUS_WAITING,
                    'created_user' => $this->administrator->administrator_id,
                );

                $mail_magazine_user = \Model_Mail_Magazine_User::forge();
                $mail_magazine_user->set($data)->save();
            }

            \DB::commit_transaction();
        } catch (\Exception $e) {
            \DB::rollback_transaction();
            throw new \SystemException(\Model_Error::ER00000);
        }

        $view_model = \ViewModel::forge('admin/mailmagazine/thanks');
        list($view_model, $replace_data) = $this->setupData($view_model, $input_data);

        // タスク実行
        $oil_path = realpath(APPPATH . '/../../') . DS;
        $param = $mail_magazine->mail_magazine_id . ' ' . $this->administrator->administrator_id;
        exec('php ' . $oil_path . 'oil refine mail_magazine ' . $param . ' > /dev/null &');

        $view_model->set('mail_magazine', $mail_magazine, true);
        $this->template->content = $view_model;
    }

    /**
     * 送信確認
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_checkprocess()
    {
        $this->template = '';

        $success = false;
        $message = '';
        $mail_magazine_id = \Input::get('mail_magazine_id');
        try {
            $is_process = \Model_Mail_Magazine::isProcess($mail_magazine_id);
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        $response = array();
        if ($success) {
            if ($is_process) {
                $response = array('status' => 200);
            } else {
                $response = array('status' => 300);
            }
        } else {
            $response = array('status' => 400, 'message' => $message);
        }

        return $this->responseJson($response);
    }

    /**
     * 送信中止
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function action_stop()
    {
        $this->template = '';

        $success = false;
        $mail_magazine_id = \Input::post('mail_magazine_id');
        try {
            $is_process = \Model_Mail_Magazine::isProcess(
                $mail_magazine_id
            );
            if ($is_process) {
                \Model_Mail_Magazine::cancelProcess($mail_magazine_id);
            }
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        $response = array();
        if ($success) {
            if ($is_process) {
                $response = array('status' => 200);
            } else {
                $response = array('status' => 300);
            }
        } else {
            $response = array('status' => 400, 'message' => $message);
        }

        return $this->responseJson($response);
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

        return $result;
    }

    /**
     * 表示に必要なデータを取得し設定する
     *
     * @access private
     * @param object $view_model ビューモデル
     * @param array $input_data 入力データ
     * @return array
     * @author ida
     */
    private function setupData($view_model, $data)
    {
        $replace_data = array();
        $replace_data['user'] = $this->administrator;

        $mail_magazine_type = $data['mail_magazine_type'];
        switch ($mail_magazine_type) {
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                $users = \Model_User::getActiveUsers();
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                $users = \Model_User::getMailMagazineUserBy(
                    $data['prefecture_id'], $data['organization_flag']
                );

                $view_model->set(
                    'prefectures', \Config::get('master.prefectures'), false
                );
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                $fleamarket_id = $data['reserved_fleamarket_id'];
                $users = \Model_Entry::getEntriesByFleamarketId(
                    $fleamarket_id, \Model_Entry::ENTRY_STATUS_RESERVED
                );
                $fleamarket = \Model_Fleamarket::find($fleamarket_id);
                $replace_data['fleamarket'] = $fleamarket;

                $view_model->set('fleamarket', $fleamarket, false);
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_WAITING_ENTRY:
                $fleamarket_id = $data['waiting_fleamarket_id'];
                $users = \Model_Entry::getEntriesByFleamarketId(
                    $fleamarket_id, \Model_Entry::ENTRY_STATUS_WAITING
                );
                $fleamarket = \Model_Fleamarket::find($fleamarket_id);
                $replace_data['fleamarket'] = $fleamarket;

                $view_model->set('fleamarket', $fleamarket, false);
                break;
        }
        $view_model->set('users', $users, false);

        $body = $data['body'];
        $pattern = \Model_Mail_Magazine::getPatternParameter($mail_magazine_type);
        list($pattern, $replacement) = \Model_Mail_Magazine::createReplaceParameter(
            $body, $pattern, $replace_data
        );
        $body = \Model_Mail_Magazine::replaceByParam($body, $pattern, $replacement);
        $view_model->set('body', $body, false);
        $view_model->set('input_data', $data, false);

        return array($view_model, $replace_data);
    }

    /**
     * 追加条件のデータを取得する
     *
     * @access private
     * @param array $input_data 入力データ
     * @return array
     * @author ida
     */
    private function getAdditionalData($input_data)
    {
        $additional_data = array();
        $mail_magazine_type = $input_data['mail_magazine_type'];

        switch ($mail_magazine_type) {
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                $additional_data = array(
                    'prefecture_id' => $input_data['prefecture_id'],
                    'organization_flag' => $input_data['organization_flag'],
                );
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                $additional_data = array(
                    'fleamarket_id' => $input_data['reserved_fleamarket_id']
                );
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_WAITING_ENTRY:
                $additional_data = array(
                    'fleamarket_id' => $input_data['waiting_fleamarket_id']
                );
                break;
        }

        return $additional_data;
    }

    /**
     * フィールドセットを取得する
     *
     * @access private
     * @param mixed $mail_magazine_type メールマガジンタイプ
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function getFieldset($mail_magazine_type = null)
    {
        $fieldset = \Model_Mail_Magazine::createFieldset();

        switch ($mail_magazine_type) {
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                $fieldset->add('prefecture_id')
                    ->add_rule('checkbox_require', 1)
                    ->add_rule('checkbox_values', \Config::get('master.prefectures'));
                $fieldset->add('organization_flag')
                    ->add_rule('required')
                    ->add_rule('valid_string', array('numeric'));
                $fieldset->validation()->add_callable('Custom_Validation');
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                $fieldset->add('reserved_fleamarket_id')
                    ->add_rule('required')
                    ->add_rule('valid_string', array('numeric'));
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_WAITING_ENTRY:
                $fieldset->add('waiting_fleamarket_id')
                    ->add_rule('required')
                    ->add_rule('valid_string', array('numeric'));
                break;
        }

        return $fieldset;
    }

    /**
     * 入力値をセッションに保存する
     *
     * @access private
     * @param array $input_data 入力データ
     * @return void
     * @author ida
     */
    private function setInputData($input_data)
    {
        \Session::set('mail_magazine.input_data', $input_data);
    }

    /**
     * 入力値をセッションから取得する
     *
     * @access private
     * @param bool $is_delete 削除
     * @return array
     * @author ida
     */
    private function getInputData($is_delete = false)
    {
        $input_data = \Session::get('mail_magazine.input_data', null, true);
        if ($is_delete) {
            \Session::delete('mail_magazine.input_data');
        }

        if (! $input_data) {
            $fieldset = \Model_Mail_Magazine::createFieldset();
            $input_data = $fieldset->repopulate()->input();
        }

        return $input_data;
    }

    /**
     * バリデーションエラーをセッションに保存
     *
     * @access private
     * @param array $errors エラー
     * @return void
     * @author ida
     */
    private function setErrorMessage($errors = array())
    {
        \Session::set_flash('mail_magazine.errors', $errors);
    }

    /**
     * バリデーションエラーをセッションから取得
     *
     * @access private
     * @param
     * @return array
     * @author ida
     */
    private function getErrorMessage()
    {
        return \Session::get_flash('mail_magazine.errors');
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
            'pagination_url' => 'admin/mailmagazine/list',
            'uri_segment'    => 4,
            'num_links'      => 10,
            'per_page'       => $this->result_per_page,
            'total_items'    => $count,
        );
    }
}
