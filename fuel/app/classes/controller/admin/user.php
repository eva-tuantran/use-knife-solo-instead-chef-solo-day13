<?php
/**
 *
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Admin_User extends Controller_Admin_Base_Template
{
    protected $user = null;

    public function before()
    {
        parent::before();
        if (Input::param('user_id')) {
            $this->user =
                Model_User::find(Input::param('user_id'));
        }
    }

    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $this->setAssets();
        $view = View::forge('admin/user/index');
        $fieldset = $this->getFieldset();
        $view->set('fieldset', $fieldset, false);
        $view->set('user', $this->user, false);
        $this->template->content = $view;
    }
    /**
     * 確認画面
     *
     * @access public
     * @return void
     */
    public function post_confirm()
    {
        $fieldset = $this->getFieldset();
        Session::set_flash('admin.user.fieldset', $fieldset);

        if (! $fieldset->validation()->run()) {
            return Response::redirect('admin/user/?user_id=' . Input::param('user_id',''));
        }

        $view = View::forge('admin/user/confirm');
        $view->set('fieldset', $fieldset, false);
        $view->set('user', $this->user, false);

        $this->template->content = $view;
    }

    /**
     * 完了画面
     *
     * @access public
     * @return void
     */
    public function post_thanks()
    {
        if (! Security::check_token()) {
            return Response::redirect('errors/doubletransmission');
        }

        $view = View::forge('admin/user/thanks');
        $this->template->content = $view;

        try {
            $user = $this->registerUser();
        } catch ( Exception $e ) {
            throw $e;
            //$view->set('error', $e, false);
        }
    }

    private function getFieldset()
    {
        if ($this->request->action == 'index') {
            $fieldset = Session::get_flash('admin.user.fieldset');
            if (! $fieldset) {
                $fieldset = $this->createFieldset();
            }
        } elseif ($this->request->action == 'confirm') {
            $fieldset = $this->createFieldset();
        } elseif ($this->request->action == 'thanks') {
            $fieldset = Session::get_flash('admin.user.fieldset');
        }
        return $fieldset;
    }

    /**
     * fieldsetの作成
     *
     * @access private
     * @return Fieldsetオブジェクト
     */
    private function createFieldset()
    {
        if ($this->user) {
            $fieldset = Fieldset::forge('user');
            $fieldset->add_model($this->user)->populate($this->user,true);
        } else {
            $fieldset = Model_User::createFieldset(true);
        }

        $fieldset->repopulate();

        return $fieldset;
    }

    /**
     * users テーブルへの登録
     *
     * @access private
     * @return Model_Userオブジェクト
     */
    private function registerUser()
    {
        $data = $this->getUserData();
        if (! $data) {
            throw new Exception(\Model_Error::ER00402);
        } else {
            if (Input::param('user_id')) {
                $user = Model_User::find(Input::param('user_id'));
            } else {
                $user = Model_User::forge();
            }
            if ($user) {
                $user->set($data);
                $user->save();
            }
            return $user;
        }
    }

    /**
     * セッションからuserのデータを取得、整形
     *
     * @access private
     * @return array userのデータ
     */
    private function getUserData()
    {
        $fieldset = $this->getFieldset();

        if (! $fieldset) {
            return false;
        }

        $input = $fieldset->validation()->validated();

        return $input;
    }

    public function setAssets()
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::css('jquery-ui-timepicker.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker-ja.js', array(), 'add_js');
    }

    public function action_list()
    {
        $view = View::forge('admin/user/list');
        $this->template->content = $view;

        $total = Model_User::findByKeywordCount(
            Input::all()
        );

        Pagination::set_config(array(
            'uri_segment'    => 4,
            'num_links'      => 10,
            'per_page'       => 100,
            'total_items'    => $total,
            'name'           => 'pagenation',
        ));

        $users = Model_User::findByKeyword(
            Input::all(),
            Pagination::get('per_page'),
            Pagination::get('offset')
        );

        $view->set('users', $users, false);
    }

    public function action_force_login()
    {
        Auth::force_login(Input::param('user_id'));
        Session::set('admin.user.nomail', (bool)Input::param('nomail'));
        return Response::redirect('/');
    }
}
