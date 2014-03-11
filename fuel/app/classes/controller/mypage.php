<?php

/**
 * 会員ページ
 *
 * @author Ricky <master@mistdev.com>
 */
class Controller_Mypage extends Controller_Template
{

    public function before()
    {
        parent::before();

        if (!Auth::check()) {
            Response::redirect('/login');
        }
        Asset::js('holder.js', array(), 'add_js');
    }

    /**
     * ユーザ情報をSTG用に全て取得してpopulate
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $user = Model_User::find(Auth::get_user_id());

        $fieldset = Fieldset::forge();
        $fieldset->add_model('Model_User')->populate($user);

        $this->template->title   = '楽市楽座トップページ';
        $this->template->content = View::forge('mypage/index');
        $this->template->content->set('dump', $fieldset->build('test'), false);
    }

}
