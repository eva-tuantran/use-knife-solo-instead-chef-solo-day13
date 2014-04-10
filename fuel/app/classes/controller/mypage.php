<?php

/**
 * 会員ページ
 *
 * @author shimma
 */
class Controller_Mypage extends Controller_Base_Template
{

    protected $_login_actions = array(
        'index',
        'password',
        'account',
        'save',
    );

    protected $_secure_actions = array(
        'index',
        'password',
        'account',
        'save',
    );

    public function before()
    {
        parent::before();

        if (! $this->login_user) {
            return \Response::redirect('/login');
        }
    }

    /**
     * メインページ
     *
     * @access public
     * @return void
     * @author shimma
     *
     * @todo メインページのテンプレートからJSを分離
     */
    public function action_index()
    {
        Asset::js('jquery.carouFredSel.js', array(), 'add_js');
        $view_model = ViewModel::forge('mypage/index');
        $view_model->set('prefectures', Config::get('master.prefectures'), false);
        $view_model->set('regions', Config::get('master.regions'), false);

        $view_model->set('entries', $this->login_user->getEntries(1, 3));
        $view_model->set('mylists', $this->login_user->getFavorites(1, 3));
        $view_model->set('myfleamarkets', $this->login_user->getMyFleamarkets(1, 3));

        $view_model->set('news_headlines', Model_News::getHeadlines());
        $view_model->set('calendar', ViewModel::forge('component/calendar'), false);
        $view_model->set('popular_ranking', ViewModel::forge('component/popular'), false);
        $view_model->set('fleamarket_latest', ViewModel::forge('component/latest'), false);
        $this->template->content = $view_model;
    }

    /**
     * マイリスト/出店予約したフリマ/開催投稿したフリマ一覧ページ
     *
     * - マイリストを出す(pagenationなし)
     * - pagination付ける
     * - 条件分岐して出す
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function action_list()
    {
        $view_model = ViewModel::forge('mypage/list');

        $page = Input::get('page', 1);
        switch (Input::get('type')) {
            case 'mylist':
                $fleamarkets = $this->login_user->getFavorites($page, 3);
                break;
            case 'entry':
                $fleamarkets = $this->login_user->getEntries($page, 3);
                break;
            case 'myfleamarket':
                $fleamarkets = $this->login_user->getMyFleamarkets($page, 3);
                break;
            default:
                return \Response::redirect('/mypage');
        }

        $view_model->set('fleamarkets', $fleamarkets);
        $view_model->set('calendar', ViewModel::forge('component/calendar'), false);
        $view_model->set('prefectures', Config::get('master.prefectures'), false);
        $view_model->set('regions', Config::get('master.regions'), false);
        $this->template->content = $view_model;

        //// ページネーション設定
        //$pagination = Pagination::forge(
        //    'fleamarket_pagination',
        //    $this->getPaginationConfig($total_count)
        //);
        // $view_model->set('pagination', $pagination, false);
    }


//    /**
//     * ページネーション設定を取得する
//     *
//     * @access private
//     * @param int $count 総行数
//     * @return array
//     * @author ida
//     */
//    private function getPaginationConfig($count)
//    {
//        $search_result_per_page = Input::post('search_result_per_page');
//        if ($search_result_per_page) {
//            $this->search_result_per_page = $search_result_per_page;
//        }
//
//        return array(
//            'pagination_url' => 'search',
//            'uri_segment' => 2,
//            'num_links' => 5,
//            'per_page' => $this->search_result_per_page,
//            'total_items' => $count,
//        );
//    }
//
//
//    /**
//     * 出店予約したフリマ一覧
//     *
//     * @access public
//     * @return void
//     * @author shimma
//     */
//    public function action_entries()
//    {
//        $view_model = ViewModel::forge('mypage/index');
//        $this->template->content = $view_model;
//    }
//
//    /**
//     * 開催投稿したフリマ一覧
//     *
//     * @access public
//     * @return void
//     * @author shimma
//     */
//    public function action_myfleamarkets()
//    {
//        $view_model = ViewModel::forge('mypage/index');
//        $this->template->content = $view_model;
//    }
//







    /**
     * フリーマーケットのキャンセル
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function get_cancel()
    {
        $fleamarket_id = Input::get('fleamarket_id');

        if (! $fleamarket_id) {
            Session::set_flash('notice', \STATUS_FLEAMARKET_CANCEL_FAILED);

            return \Response::redirect('/mypage', 'refresh');
        }

        if (! $this->login_user->cancelEntry($fleamarket_id)) {
            Session::set_flash('notice', \STATUS_FLEAMARKET_CANCEL_FAILED);
        } else {
            Session::set_flash('notice', \STATUS_FLEAMARKET_CANCEL_SUCCESS);
            $email_template_params = array(
                'nick_name' => $this->login_user->nick_name,
            );
            $this->login_user->sendmail('common/user_cancel_fleamarket', $email_template_params);
        };

        //処理ページを見せ1秒後にマイページにリダイレクトさせる
        $this->setLazyRedirect('/mypage');
        $this->template->content = View::forge('mypage/cancel');
   }
    /**
     * ユーザのアカウント情報の変更ページ
     *
     * @access public
     * @return void
     * @author shimma
     *
     * @todo デザインがまとまりしだいfieldsetのbuildから切り替え
     */
    public function action_account()
    {
        $data = array();
        $status_code = Session::get_flash('status_code');
        $data['info_message'] = $this->getStatusMessage($status_code);

        $fieldset = Fieldset::forge()->add_model('Model_User')->populate($this->login_user);
        $fieldset->field('password')->set_type(false);
        $fieldset->add('submit', '', array('type' => 'submit','value' => '保存する'));

        $this->template->content = View::forge('mypage/account', $data);
        $this->template->content->set('user_account_form', $fieldset->build('/mypage/save'), false);
    }

    /**
     * 変更内容保存
     *
     * @todo save失敗の処理を検討する
     * @todo ユーザインプットの更新でarray_filterで果たしていいのか再検討
     * @todo CSRF実装検討
     * @access public
     * @return void
     * @author shimma
     */
    public function post_save()
    {
        $fieldset = Model_User::createFieldset();
        $fieldset->repopulate();
        $validation = $fieldset->validation();

        if (! $validation->run()) {
            Session::set_flash('mypage.fieldset', $fieldset);
            Session::set_flash('status_code', \STATUS_PROFILE_CHANGE_FAILED);
        } else {
            $update_data = array_filter($validation->validated(), 'strlen');
            $update_data['updated_user'] = $this->login_user->user_id;
            $this->login_user->set($update_data);
            $this->login_user->save();
            Session::set_flash('status_code', \STATUS_PROFILE_CHANGE_SUCCESS);
        }

        return \Response::redirect('/mypage/account');
    }

    /**
     * パスワード変更ページ
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function action_password()
    {
        $fieldset = $this->createFieldsetPassword();

        $this->template->content = View::forge('mypage/password');
        $this->template->content->set('input', $fieldset->input());
        $this->template->content->set('error', $fieldset->validation()->error_message());
    }

    /**
     * パスワード変更ページ変更処理
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function post_passwordchange()
    {
        $fieldset = $this->createFieldsetPassword();

        if (! Security::check_token()) {
            Session::set_flash('status_code', \STATUS_PASSWORD_CHANGE_TIMEOUT);

            return \Response::redirect('/mypage/password');
        }

        $validation = $fieldset->validation();
        Session::set_flash('mypage.password.fieldset', $fieldset);

        if (! $validation->run()) {
            Session::set_flash('status_code', \STATUS_PASSWORD_CHANGE_FAILED);

            return \Response::redirect('/mypage/password');
        }

        try {
            if (! Auth::change_password($fieldset->input('password'), $fieldset->input('new_password'))) {
                Session::set_flash('status_code', \STATUS_PASSWORD_CHANGE_FAILED);

                return \Response::redirect('/mypage/password');
            } else {
                Session::set_flash('status_code', \STATUS_PASSWORD_CHANGE_SUCCESS);

                return \Response::redirect('/mypage');
            }
        } catch (Exception $e) {
            throw new SystemException('パスワード変更に失敗しました');
        }
    }

    /**
     * パスワード変更用のFieldset
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function createFieldsetPassword()
    {
        $fieldset = Session::get_flash('mypage.password.fieldset');

        if (! $fieldset) {
            $fieldset = \Fieldset::forge('mypage.password');

            $fieldset->add('password', 'Passowrd')
                ->add_rule('required')
                ->add_rule('min_length', '6')
                ->add_rule('max_length', '50');
            $fieldset->add('new_password', 'New Passowrd')
                ->add_rule('required')
                ->add_rule('min_length', '6')
                ->add_rule('max_length', '50');
            $fieldset->add('new_password2', 'New Passowrd2')
                ->add_rule('required')
                ->add_rule('match_field', 'new_password');
        }

        $fieldset->repopulate();

        return $fieldset;
    }

}
