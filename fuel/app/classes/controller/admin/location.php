<?php

/**
 * 会場管理
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */
class Controller_Admin_Location extends Controller_Admin_Base_Template
{

    /**
     * 検索結果1ページあたりの行数
     *
     * @var int
     */
    private $result_per_page = 50;

    /**
     * 会場情報
     *
     * @var object
     */
    protected $location = null;

    public function before()
    {
        parent::before();
    }

    /**
     * 一覧
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function action_list()
    {
        $conditions = $this->getCondition();
        $condition_list = \Model_Location::createAdminSearchCondition($conditions);
        $total_count = \Model_Location::getCountByAdminSearch($condition_list);

        // ページネーション設定
        $pagination = \Pagination::forge(
            'location_pagination',
            $this->getPaginationConfig($total_count)
        );

        $location_list = \Model_Location::findAdminBySearch(
            $condition_list,
            $pagination->current_page,
            $this->result_per_page
        );

        $view_model = \ViewModel::forge('admin/location/list');
        $view_model->set('location_list', $location_list, false);
        $view_model->set('pagination', $pagination, false);
        $view_model->set('conditions', $conditions, false);
        $this->template->content = $view_model;
    }

    /**
     * 入力
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function action_index()
    {
        if (\Input::get('location_id')) {
            $this->location = \Model_Location::find(\Input::get('location_id'));
        }

        $view_model = \ViewModel::forge('admin/location/index');
        $fieldset = $this->getFieldset();
        $view_model->set('fieldset', $fieldset, false);
        $view_model->set('location', $this->location, false);
        $this->template->content = $view_model;
    }

    /**
     * 確認
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function post_confirm()
    {
        if (\Input::post('location_id')) {
            $this->location = \Model_Location::find(\Input::post('location_id'));
        }

        $fieldset = $this->getFieldset();
        \Session::set_flash('admin.location.fieldset', $fieldset);

        if (! $fieldset->validation()->run()) {
            \Response::redirect('admin/location/?location_id=' . \Input::param('location_id',''));
        }

        $view_model = \ViewModel::forge('admin/location/confirm');
        $view_model->set('fieldset', $fieldset, false);
        $view_model->set('location', $this->location, false);
        $this->template->content = $view_model;
    }

    /**
     * 完了
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    public function post_thanks()
    {
        if (! Security::check_token()) {
            \Response::redirect('errors/doubletransmission');
        }

        try {
            $location = $this->registerLocation();
        } catch ( Exception $e ) {
            throw $e;
        }

        $view = View::forge('admin/location/thanks');
        $this->template->content = $view;
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

        if (! isset($result['register_type'])) {
            $result['register_type'] = \Model_Location::REGISTER_TYPE_ADMIN;
        }

        return $result;
    }

    /**
     * フィールドセットを取得する
     *
     * @access public
     * @param
     * @return void
     * @author kobayashi
     */
    private function getFieldset()
    {
        if ($this->request->action == 'index') {
            $fieldset = \Session::get_flash('admin.location.fieldset');
            if (! $fieldset) {
                $fieldset = $this->createFieldset();
            }
        } elseif ($this->request->action == 'confirm') {
            $fieldset = $this->createFieldset();
        } elseif ($this->request->action == 'thanks') {
            $fieldset = \Session::get_flash('admin.location.fieldset');
        }

        return $fieldset;
    }

    /**
     * フィールドセットを生成する
     *
     * @access private
     * @return Fieldsetオブジェクト
     */
    private function createFieldset()
    {
        if ($this->location) {
            $fieldset = \Fieldset::forge('location');
            $fieldset->add_model($this->location)->populate($this->location, true);
        } else {
            $fieldset = \Model_Location::createFieldset(true);
        }
        $fieldset->repopulate();

        return $fieldset;
    }

    /**
     * 会場情報を登録する
     *
     * @access private
     * @param
     * @return object
     * @author kobayashi
     */
    private function registerLocation()
    {
        $data = $this->getLocationData();
        if (! $data) {
            throw new \Exception(\Model_Error::ER00402);
        }

        if (\Input::param('location_id')) {
            $location = \Model_Location::find(\Input::post('location_id'));
            $data['updated_user'] = $this->administrator->administrator_id;
            unset($data['register_type']);
            unset($data['created_at']);
            unset($data['created_user']);
        } else {
            $location = \Model_Location::forge();
            $data['created_user'] = $this->administrator->administrator_id;
            $data['register_type'] = \Model_Location::REGISTER_TYPE_ADMIN;
        }


        if ($location) {
            $location->set($data)->save();
        }

        return $location;
    }

    /**
     * セッションから会場情報を取得する
     *
     * @access private
     * @param
     * @return array
     * @author kobayashi
     */
    private function getLocationData()
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
            'pagination_url' => 'admin/location/list',
            'uri_segment'    => 4,
            'num_links'      => 10,
            'per_page'       => $this->result_per_page,
            'total_items'    => $count,
        );
    }
}
