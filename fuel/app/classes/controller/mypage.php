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

    protected $user;

    /**
     * before
     *
     * @access public
     * @return void
     * @author shimma
     *
     * @todo ログイン通過にも関わらずインスタンスが取れなかった時はエラーを吐いて表示させる実装に切り替える
     */
    public function before()
    {
        parent::before();

        $this->user = Auth::get_user_instance();
        if (! $this->user) {
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
        $entries = $this->user->getEntries(20);

        $this->template->content = ViewModel::forge('mypage/index')->set('entries', $entries);
        $this->setMetaTag('mypage/index');
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
        $fieldset = Fieldset::forge();
        $fieldset->add_model('Model_User')->populate($this->user);

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
        $status_code = Session::get_flash('status_code');
        $data['info_message'] = $this->getStatusMessage($status_code);

        $fieldset = Fieldset::forge()->add_model('Model_User')->populate($this->user);
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
            Session::set_flash('mypage.fieldset', $fieldset);
            Session::set_flash('status_code', \STATUS_PROFILE_CHANGE_FAILED);
        } else {
            $user = Auth::get_user_instance();
            $update_data = array_filter($validation->validated(), 'strlen');
            $update_data['updated_user'] = Auth::get_user_id();
            $user->set($update_data);
            $user->save();
            Session::set_flash('status_code', \STATUS_PROFILE_CHANGE_SUCCESS);
        }

        return \Response::redirect('/mypage/account');
    }

}
