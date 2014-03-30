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

    /**
     * before
     *
     * @access public
     * @return void
     * @author shimma
     */
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
     */
    public function action_index()
    {
        $view_model = ViewModel::forge('mypage/index');
        $view_model->set('prefectures', Config::get('master.prefectures'), false);
        $view_model->set('entries', $this->login_user->getEntries());
        $view_model->set('mylists', $this->login_user->getFavorites());
        $this->template->content = $view_model;
    }


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
     * パスワード変更ページ
     *
     * @access public
     * @return void
     * @author shimma
     *
     * @todo 作りかけ
     */
    public function action_password()
    {
        $fieldset = Fieldset::forge();
        $fieldset->add_model('Model_User')->populate($this->login_user);

        $this->template->content = View::forge('mypage/index');
        $this->template->content->set('dump', $fieldset->build('test'), false);
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
        $fieldset = Fieldset::forge()->add_model('Model_User');
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

}
