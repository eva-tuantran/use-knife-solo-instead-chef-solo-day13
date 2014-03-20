<?php

/**
 * 会員ページ
 *
 */
class Controller_Mypage extends Controller_Base_Template
{

    protected $_login_actions = array('index', 'password', 'account', 'save');

    protected $_secure_actions = array('index', 'password', 'account', 'save');

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
        $user = Model_User::find(Auth::get_user_id());

        $fieldset = Fieldset::forge();
        $fieldset->add_model('Model_User')->populate($user);

        $this->setMetaTag('mypage/index');
        $this->template->content = View::forge('mypage/index');
        $this->template->content->set('dump', $fieldset->build('test'), false);
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
        $user = Model_User::find(Auth::get_user_id());

        $fieldset = Fieldset::forge();
        $fieldset->add_model('Model_User')->populate($user);

        $this->template->content = View::forge('mypage/index');
        $this->template->content->set('dump', $fieldset->build('test'), false);
    }

    /**
     * ユーザのアカウント情報の変更ページ
     *
     * @todo Model_Userでfieldsetを作成するのか、ここで作成するか検討
     * @access public
     * @return void
     * @author shimma
     */
    public function action_account()
    {
        $data = array();
        $account_info = Session::get_flash('account_info');
        switch ($account_info) {
            case 'status_changed':
                $data['info_message'] = 'ユーザ情報変更しました';
                break;
            case 'status_change_faild':
                $data['info_message'] = 'ユーザ情報変更を失敗しました';
                break;
        }

        $user = Auth::get_user_instance();
        $fieldset = Fieldset::forge()->add_model('Model_User')->populate($user);
        $fieldset->field('password')->set_type(false);
        $fieldset->add('submit', '', array('type' => 'submit','value' => '保存する'));

        $this->setMetaTag('mypage/account');
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
            exit("項目エラー:".$validation->show_errors());
        } else {
            $user = Auth::get_user_instance();
            $update_data = array_filter($validation->validated(), 'strlen');
            $update_data['updated_user'] = Auth::get_user_id();
            $user->set($update_data);
            $user->save();
            Session::set_flash('account_info', 'status_changed');

            return \Response::redirect('/mypage/account');
        }
    }

}
