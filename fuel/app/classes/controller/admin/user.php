<?php
/**
 *
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Admin_User extends Controller_Admin_Base_Template
{
    protected $_secure_actions = array(
        'list', 'index', 'confirm', 'thanks',
    );

    /**
     * 検索結果1ページあたりの行数
     *
     * @var int
     */
    private $result_per_page = 50;

    /**
     *
     * @var object
     */
    protected $user = null;

    public function before()
    {
        parent::before();
    }

    /**
     * ユーザ一覧
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function action_list()
    {
        $conditions = $this->getCondition();
        $condition_list = \Model_User::createAdminSearchCondition($conditions);
        $total_count = \Model_User::getCountByAdminSearch($condition_list);

        // ページネーション設定
        $pagination = \Pagination::forge(
            'user_pagination',
            $this->getPaginationConfig($total_count)
        );

        $user_list = \Model_User::findAdminBySearch(
            $condition_list,
            $pagination->current_page,
            $this->result_per_page
        );

        $view_model = \ViewModel::forge('admin/user/list');
        $view_model->set('user_list', $user_list, false);
        $view_model->set('pagination', $pagination, false);
        $view_model->set('conditions', $conditions, false);
        $this->template->content = $view_model;
    }

    /**
     * 編集画面
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function action_index()
    {
        if (\Input::get('user_id')) {
            $this->user = \Model_User::find(\Input::get('user_id'));
        }

        $this->setAssets();

        $view_model = \ViewModel::forge('admin/user/index');
        $fieldset = $this->getFieldset();
        $view_model->set('fieldset', $fieldset, false);
        $view_model->set('user', $this->user, false);
        $this->template->content = $view_model;
    }
    /**
     * 確認画面
     *
     * @access public
     * @param
     * @return void
     * @autjor kobayashi
     */
    public function post_confirm()
    {
        if (\Input::post('user_id')) {
            $this->user = \Model_User::find(\Input::post('user_id'));
        }

       $fieldset = $this->getFieldset();
        \Session::set_flash('admin.user.fieldset', $fieldset);

        if (! $fieldset->validation()->run()) {
            \Response::redirect(
                'admin/user/?user_id=' . \Input::post('user_id','')
            );
        }

        $view_model = \ViewModel::forge('admin/user/confirm');
        $view_model->set('fieldset', $fieldset, false);
        $view_model->set('user', $this->user, false);
        $this->template->content = $view_model;
    }

    /**
     * 完了画面
     *
     * @access public
     * @param
     * @return void
     * @autjor kobayashi
     */
    public function post_thanks()
    {
        if (! \Security::check_token()) {
            \Response::redirect('errors/doubletransmission');
        }

        try {
            $user = $this->registerUser();
        } catch ( Exception $e ) {
            throw $e;
        }

        $view = \View::forge('admin/user/thanks');
        $this->template->content = $view;
    }

    /**
     * 指定したユーザで強制ログイン
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function action_force_login()
    {
        \Auth::force_login(\Input::param('user_id'));
        \Session::set('admin.user.nomail', (bool) Input::param('nomail'));
        \Response::redirect('/');
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
        $conditions = Input::post('c', array());

        $result = array();
        foreach ($conditions as $field => $value) {
            if ($value !== '') {
                $result[$field] = $value;
            }
        }

        return $result;
    }

    /**
     * アセットを設定する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function setAssets()
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::css('jquery-ui-timepicker.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker-ja.js', array(), 'add_js');
    }

    /**
     * フィールドセットを取得する
     *
     * @access public
     * @param
     * @return void
     * @autjor kobayashi
     */
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
     * フィールドセットの作成
     *
     * @access private
     * @param
     * @return object
     * @author kobayashi
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
     * ユーザ情報の登録
     *
     * @access private
     * @param
     * @return object
     * @author kobayashi
     * @author ida
     */
    private function registerUser()
    {
        $data = $this->getUserData();
        if (! $data) {
            throw new Exception(\Model_Error::ER00402);
        }

        $user_id = \Input::post('user_id');
        if (! empty($user_id)) {
            $user = \Model_User::find(\Input::post('user_id'));
        } else {
            $user = \Model_User::forge();
        }

        if (! empty($user_id)) {
            unset($data['password']);
        } else {
            $data['password'] = $user->setPassword($data['password']);
        }
        unset($data['mm_flag']);
        unset($data['mm_device']);
        unset($data['mm_error_flag']);
        unset($data['mobile_carrier']);
        unset($data['mobile_uid']);
        unset($data['last_login']);

        if ($user) {
            $user->set($data)->save();
        }

        return $user;
    }

    /**
     * セッションからユーザ情報を取得する
     *
     * @access private
     * @param
     * @return array
     * @author kobayashi
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
            'pagination_url' => 'admin/user/list',
            'uri_segment'    => 4,
            'num_links'      => 10,
            'per_page'       => $this->result_per_page,
            'total_items'    => $count,
        );
    }
}
