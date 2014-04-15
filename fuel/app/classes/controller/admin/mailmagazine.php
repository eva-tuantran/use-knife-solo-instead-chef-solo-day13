<?php

/**
 * Controller_Admin_Mailmagazine Controller
 *
 * @extends Controller_Admin_Base_Template
 * @author ida
 */
class Controller_Admin_Mailmagazine extends Controller_Admin_Base_Template
{
    /**
     * メール送信の動作チェック用ファイル名
     */
    private $process_file_name = 'process_mail_magazine';

    public function before()
    {
        parent::before();

        // @todo テスト用
        $user = new stdClass;
        $user->user_id = 1;
        $user->last_name = '楽市';
        $user->first_name = '楽座';
        $this->login_user = $user;
    }

    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $input_data = $this->getInputData();
        $errors = $this->getErrorMessage();

        $view = \View::forge('admin/mailmagazine/index');
        $view->set('prefectures', \Config::get('master.prefectures'), false);
        $view->set('fleamarket_list', \Model_Fleamarket::findUpcoming(20), false);
        $view->set('input_data', $input_data, false);
        $view->set('errors', $errors);

        $this->template->content = $view;
    }

    /**
     * 確認画面
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        $input_data = \Input::post();
        $fieldset = $this->getFieldset($input_data['mail_magazine_type']);

        $validation = $fieldset->validation();
        $validation_result = $validation->run($input_data);

        if (! $validation_result) {
            $input_data = $validation->input();
            $input_data['fleamarket_id'] = \Input::post('fleamarket_id');
            $input_data['prefecture_id'] = \Input::post('prefecture_id');

            $this->setInputData($input_data);
            $this->setErrorMessage($validation->error_message());

            \Response::redirect('admin/mailmagazine/index');
        }

        $input_data = $validation->validated();
        $input_data['fleamarket_id'] = \Input::post('fleamarket_id');
        $input_data['prefecture_id'] = \Input::post('prefecture_id');

        $replace_data = array();
        $replace_data['user'] = (array) $this->login_user;

        $view = \View::forge('admin/mailmagazine/confirm');
        $type = $input_data['mail_magazine_type'];
        if ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL) {
            $users = \Model_User::getActiveUsers();
            $input_data['query'] = \DB::last_query();
            $view->set('users', $users, false);

            $view->set('prefectures', \Config::get('master.prefectures'), false);
        } elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST) {
            $users = \Model_User::getUsersByPrefectureID(
                $input_data['prefecture_id']
            );
            $input_data['query'] = \DB::last_query();
            $view->set('users', $users, false);

            $view->set('prefectures', \Config::get('master.prefectures'), false);
        } elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY) {
            $users = \Model_Entry::getEntriesByFleamarketId(
                $input_data['fleamarket_id']
            );
            $input_data['query'] = \DB::last_query();
            $view->set('users', $users, false);

            $fleamarket = \Model_Fleamarket::find($input_data['fleamarket_id']);
            $view->set('fleamarket', $fleamarket, false);
            $replace_data['fleamarket'] = $fleamarket;
        }

        $body = $input_data['body'];
        $pattern = \Model_Mail_Magazine::getPatternParameter($type);

        list($pattern, $replacement) = \Model_Mail_Magazine::createReplaceParameter(
            $body, $pattern, $replace_data
        );
        $body = \Model_Mail_Magazine::replaceByParam($body, $pattern, $replacement);

        $view->set('body', $body, false);
        $view->set('input_data', $input_data, false);

        $this->setInputData($input_data);

        $this->template->content = $view;
    }

    /**
     * テスト送信
     *
     * @access public
     * @return void
     */
    public function action_test()
    {
        $this->template = '';

        $to = Input::post('deliveredTo');

        $input_data = $this->getInputData();

        $replace_data = array();
        $replace_data['user'] = (array) $this->login_user;

        $type = $input_data['mail_magazine_type'];
        if ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL) {
            $users = \Model_User::getActiveUsers();
        } elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST) {
            $users = \Model_User::getUsersByPrefectureID(
                $input_data['prefecture_id']
            );
        } elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY) {
            $users = \Model_Entry::getEntriesByFleamarketId(
                $input_data['fleamarket_id']
            );

            $fleamarket = \Model_Fleamarket::find($input_data['fleamarket_id']);
            $replace_data['fleamarket'] = $fleamarket;
        }

        $from_email = $input_data['from_email'];
        $from_name = $input_data['from_name'];

        $subject = trim($input_data['subject']);

        $body = $input_data['body'];
        $pattern = \Model_Mail_Magazine::getPatternParameter($type);
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
            $message = '送信先メールアドレスが正しくありません';
        }

        $response = array();
        if ($success) {
            $response = array('status' => 200);
        } else {
            $response = array('status' => 400, 'message' => $message);
        }

        return $this->response_json($response);
    }

    /**
     * 送信
     *
     * @access public
     * @return void
     */
    public function action_thanks()
    {
        if (! Security::check_token()) {
            Response::redirect('errors/doubletransmission');
        }

        $input_data = $this->getInputData();
        $input_data['created_user'] = $this->login_user->user_id;
        $input_data['send_status'] = \Model_Mail_Magazine::SEND_STATUS_WAITING;
        $added_info = array(
            'fleamarket' => array(
                'fleamarket_id' => $input_data['fleamarket_id']
            )
        );
        $input_data['additional_serialize_data'] = serialize($added_info);

        $mail_magazine = \Model_Mail_Magazine::forge($input_data);
        $mail_magazine->save();

        $replace_data = array();
        $replace_data['user'] = (array) $this->login_user;

        $view = \View::forge('admin/mailmagazine/thanks');
        $type = $input_data['mail_magazine_type'];
        if ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL) {
            $users = \Model_User::getActiveUsers();
            $view->set('users', $users, false);

            $view->set('prefectures', \Config::get('master.prefectures'), false);
        } elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST) {
            $users = \Model_User::getUsersByPrefectureID(
                $input_data['prefecture_id']
            );
            $view->set('users', $users, false);

            $view->set('prefectures', \Config::get('master.prefectures'), false);
        } elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY) {
            $users = \Model_Entry::getEntriesByFleamarketId(
                $input_data['fleamarket_id']
            );
            $view->set('users', $users, false);

            $fleamarket = \Model_Fleamarket::find($input_data['fleamarket_id']);
            $view->set('fleamarket', $fleamarket, false);
            $replace_data['fleamarket'] = $fleamarket;
        }

        $body = $input_data['body'];
        $pattern = \Model_Mail_Magazine::getPatternParameter($type);
        list($pattern, $replacement) = \Model_Mail_Magazine::createReplaceParameter(
            $body, $pattern, $replace_data
        );
        $body = \Model_Mail_Magazine::replaceByParam($body, $pattern, $replacement);
        $view->set('body', $body, false);

        $view->set('input_data', $input_data, false);

        // タスク実行
        $oil_path = realpath(APPPATH . '/../../') . DS;
        exec('php ' . $oil_path . 'oil refine mail_magazine ' . $mail_magazine->mail_magazine_id . ' > /dev/null &');

        $this->template->content = $view;
    }

    /**
     * 送信確認
     *
     * @access public
     * @return void
     */
    public function action_checkprocess()
    {
        $this->template = '';

        $success = false;
        $message = '';
        try {
            $is_process = \Model_Mail_Magazine::isProcess();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        $response = array();
        if ($success) {
            if (! $is_process) {
                $response = array('status' => 200);
            } else {
                $response = array('status' => 300);
            }
        } else {
            $response = array('status' => 400, 'message' => $message);
        }

        return $this->response_json($response);
    }

    /**
     * 送信中止
     *
     * @access public
     * @return void
     */
    public function action_stop()
    {
        $this->template = '';

        $success = false;
        try {
            \Model_Mail_Magazine::stopProcess();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        $response = array();
        if ($success) {
            $response = array('status' => 200);
        } else {
            $response = array('status' => 400, 'message' => $message);
        }

        return $this->response_json($response);
    }

    /**
     * fieldsetを取得する
     *
     * @access private
     * @param mixed $mail_magazine_type メールマガジンタイプ
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function getFieldset($mail_magazine_type = null)
    {
        $fieldset = \Model_Mail_Magazine::createFieldset();

        if ($mail_magazine_type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST) {
            $fieldset->add('prefecture_id')
                ->add_rule('valid_string', array('numeric'));
        } else if ($mail_magazine_type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY) {
            $fieldset->add('fleamarket_id')
                ->add_rule('required')
                ->add_rule('valid_string', array('numeric'));
        }

        return $fieldset;
    }

    /**
     * 入力値をセッションに保存する
     *
     * @access private
     * @param object $fieldset fieldsetオブジェクト
     * @return void
     * @author ida
     */
    private function setInputData($input)
    {
        \Session::set('mailmagazine.input_data', $input);
    }

    /**
     * 入力値をセッションから取得する
     *
     * @access private
     * @param
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function getInputData($delete = false)
    {
        $input_data = \Session::get('mailmagazine.input_data');
        if ($delete) {
            \Session::delete('mailmagazine.input_data');
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
        \Session::set_flash('mailmagazine.errors', $errors);
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
        return \Session::get_flash('mailmagazine.errors');
    }

    /**
     * ログインしているユーザの名前を取得する
     *
     * @access private
     * @param
     * @return string
     * @author ida
     */
    private function getLoginUserName()
    {
        $login_user = $this->login_user;
        $user_name = $login_user->last_name . ' ' . $login_user->first_name;

        return $user_name;
    }
}
