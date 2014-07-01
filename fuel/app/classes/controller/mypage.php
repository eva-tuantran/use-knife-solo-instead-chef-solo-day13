<?php

/**
 * マイページ
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
        'list',
        'passwordchange',
    );

    protected $_secure_actions = array(
        'index',
        'password',
        'account',
        'save',
        'list',
        'passwordchange',
    );

    public function before()
    {
        parent::before();

        if (! $this->login_user) {
            throw new \SystemException(\Model_Error::ER00701);
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
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.carouFredSel.js', array(), 'add_js');

        $fleamarkets_all['reserved']     = $this->login_user->getReservedEntries(1, 3);
        $fleamarkets_all['waiting']      = $this->login_user->getWaitingEntries(1, 3);
        $fleamarkets_all['mylist']       = $this->login_user->getFavorites(1, 3);
        $fleamarkets_all['myfleamarket'] = $this->login_user->getMyFleamarkets(1, 3);

        $fleamarkets_view = array();
        foreach ($fleamarkets_all as $type => $fleamarkets) {
            foreach ($fleamarkets as $fleamarket) {
                $fleamarkets_view[$type][] = ViewModel::forge('component/fleamarket')
                    ->set('type', $type)
                    ->set('fleamarket', $fleamarket)
                    ->set('user', $this->login_user)
                    ->set('no_box', true);
            }
        };

        $view_model = View::forge('mypage/index');
        $view_model->set('fleamarkets_view', $fleamarkets_view, false);
        $view_model->set('news_headlines', \Model_News::getHeadlines());
        $view_model->set('calendar', \ViewModel::forge('component/calendar'), false);
        $view_model->set(
            'search',
            \ViewModel::forge('component/search')->set('is_top', false),
            false
        );
        $view_model->set('popular_ranking', \ViewModel::forge('component/popular'), false);
        $view_model->set('fleamarket_latest', \ViewModel::forge('component/latest'), false);
        $this->template->content = $view_model;
    }

    /**
     * マイリスト/出店予約したフリマ/開催投稿したフリマ一覧ページ
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function action_list()
    {
        \Asset::css('jquery-ui.min.css', array(), 'add_css');
        \Asset::js('jquery-ui.min.js', array(), 'add_js');

        $pagination_param = 'p';
        $item_per_page = 10;

        $page = Input::get($pagination_param, 1);
        $type = Input::get('type');
        switch ($type) {
            case 'finished':
                $fleamarkets = $this->login_user->getFinishedEntries($page, $item_per_page);
                $count       = $this->login_user->getFinishedEntryCount();
                break;
            case 'reserved':
                $fleamarkets = $this->login_user->getReservedEntries($page, $item_per_page);
                $count       = $this->login_user->getReservedEntryCount();
                break;
            case 'waiting':
                $fleamarkets = $this->login_user->getWaitingEntries($page, $item_per_page);
                $count       = $this->login_user->getWaitingEntryCount();
                break;
            case 'mylist':
                $fleamarkets = $this->login_user->getFavorites($page, $item_per_page);
                $count       = $this->login_user->getFavoriteCount();
                break;
            case 'myfleamarket':
                $fleamarkets = $this->login_user->getMyFleamarkets($page, $item_per_page);
                $count       = $this->login_user->getMyFleamarketCount();
                break;
            default:
                return \Response::redirect('/mypage');
        }

        $num_links = 5;
        $pagination = \Pagination::forge('mypage/list',
            array(
                'uri_segment' => $pagination_param,
                'num_links'   => $num_links,
                'per_page'    => $item_per_page,
                'total_items' => $count,
            ));

        $fleamarkets_view = array();
        foreach ($fleamarkets as $fleamarket) {
            $fleamarkets_view[] = \ViewModel::forge('component/fleamarket')
                ->set('type', $type)
                ->set('fleamarket', $fleamarket)
                ->set('user', $this->login_user);
        };

        $view_model = \View::forge('mypage/list');
        $view_model->set('type', $type, false);
        $view_model->set('pagination', $pagination, false);
        $view_model->set('user', $this->login_user, false);
        $view_model->set('fleamarkets_view', $fleamarkets_view, false);
        $view_model->set('calendar', \ViewModel::forge('component/calendar'), false);
        $view_model->set('prefectures', \Config::get('master.prefectures'), false);
        $view_model->set('regions', \Config::get('master.regions'), false);
        $this->template->content = $view_model;
    }

    /**
     * 出店予約のキャンセル
     *
     * @access public
     * @param
     * @return void
     * @author shimma
     * @autho ida
     */
    public function get_cancel()
    {
        $entry_id = \Input::get('entry_id');
        $cancel = \Input::get('cancel');

        if (! $entry_id || ! $cancel) {
            \Session::set_flash('notice', \STATUS_FLEAMARKET_CANCEL_FAILED);
            \Response::redirect('/mypage', 'refresh');
        }

        $entry = \Model_Entry::find($entry_id);
        if (! $this->login_user->cancelEntry($entry_id, $this->login_user->user_id)) {
            \Session::set_flash('notice', \STATUS_FLEAMARKET_CANCEL_FAILED);
        } else {
            \Session::set_flash('notice', \STATUS_FLEAMARKET_CANCEL_SUCCESS);
            $entry = \Model_Entry::find($entry_id);
            $email_template_params = array(
                'nick_name' => $this->login_user->nick_name,
                'fleamarket.name' => $entry->fleamarket->name,
            );
            $this->login_user->sendmail('common/user_cancel_fleamarket', $email_template_params);
        };

        //処理ページを見せ1秒後にマイページにリダイレクトさせる
        $this->setLazyRedirect('/mypage');
        $view = \View::forge('mypage/cancel');
        $view->set('cancel', $cancel);
        $this->template->content = $view;
    }

    /**
     * ユーザのアカウント情報の変更ページ
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function action_account()
    {
        Asset::js('jquery.noty.packaged.min.js', array(), 'add_js');
        Asset::js('https://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3-https.js', array(), 'add_js');

        $data = array();
        $status_code = \Session::get_flash('status_code');
        $data['info_message'] = $this->getStatusMessage($status_code);
        $fieldset = $this->createFieldsetAccount();

        $view = \View::forge('mypage/account', $data);
        $view->set('fieldset', $fieldset, false);
        $view->set('prefectures', Config::get('master.prefectures'), false);
        $view->set('status_code', $status_code, false);
        $this->template->content = $view;
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
        $fieldset = $this->createFieldsetAccount();
        $validation = $fieldset->validation();

        if (! $validation->run()) {
            \Session::set_flash('mypage.fieldset', $fieldset);
            \Session::set_flash('status_code', \STATUS_PROFILE_CHANGE_FAILED);
        } else {
            $update_data = array_filter($validation->validated(), 'strlen');
            $update_data['updated_user'] = $this->login_user->user_id;
            $this->login_user->set($update_data);
            $this->login_user->save();
            \Session::set_flash('status_code', \STATUS_PROFILE_CHANGE_SUCCESS);
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

        $this->template->content = \View::forge('mypage/password');
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

        if (! \Security::check_token()) {
            \Session::set_flash('status_code', \STATUS_PASSWORD_CHANGE_TIMEOUT);
            \Response::redirect('/mypage/password');
        }

        $validation = $fieldset->validation();
        \Session::set_flash('mypage.password.fieldset', $fieldset);

        if (! $validation->run()) {
            \Session::set_flash('status_code', \STATUS_PASSWORD_CHANGE_FAILED);
            \Response::redirect('/mypage/password');
        }

        try {
            if (! \Auth::change_password($fieldset->input('password'), $fieldset->input('new_password'))) {
                \Session::set_flash('status_code', \STATUS_PASSWORD_CHANGE_FAILED);
                \Response::redirect('/mypage/password');
            } else {
                \Session::set_flash('status_code', \STATUS_PASSWORD_CHANGE_SUCCESS);
                \Response::redirect('/mypage');
            }
        } catch (Exception $e) {
            throw new \SystemException(\Model_Error::ER00702);
        }
    }

    /**
     * アカウント変更用のFieldset
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function createFieldsetAccount()
    {
        $fieldset = \Session::get_flash('mypage.fieldset');

        if (! $fieldset) {
            $fieldset = \Model_User::createFieldset()->populate($this->login_user);
            $fieldset->field('password')->set_type(false);
        }

        $fieldset->repopulate();

        return $fieldset;
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
        $fieldset = \Session::get_flash('mypage.password.fieldset');

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
