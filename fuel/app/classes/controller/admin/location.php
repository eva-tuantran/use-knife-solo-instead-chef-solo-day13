<?php
/**
 *
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Admin_Location extends Controller_Admin_Base_Template
{
    protected $location = null;

    public function before()
    {
        parent::before();
        if (Input::param('location_id')) {
            $this->location =
                Model_Location::find(Input::param('location_id'));
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
        $view = View::forge('admin/location/index');
        $fieldset = $this->getFieldset();
        $view->set('fieldset', $fieldset, false);
        $view->set('location', $this->location, false);
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
        Session::set_flash('admin.location.fieldset', $fieldset);

        if (! $fieldset->validation()->run()) {
            return Response::redirect('admin/location/?location_id=' . Input::param('location_id',''));
        }

        $view = View::forge('admin/location/confirm');
        $view->set('fieldset', $fieldset, false);
        $view->set('location', $this->location, false);

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

        $view = View::forge('admin/location/thanks');
        $this->template->content = $view;

        try {
            $location = $this->registerLocation();
        } catch ( Exception $e ) {
            throw $e;
            //$view->set('error', $e, false);
        }
    }

    private function getFieldset()
    {
        if ($this->request->action == 'index') {
            $fieldset = Session::get_flash('admin.location.fieldset');
            if (! $fieldset) {
                $fieldset = $this->createFieldset();
            }
        } elseif ($this->request->action == 'confirm') {
            $fieldset = $this->createFieldset();
        } elseif ($this->request->action == 'thanks') {
            $fieldset = Session::get_flash('admin.location.fieldset');
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
        if ($this->location) {
            $fieldset = Fieldset::forge('location');
            $fieldset->add_model($this->location)->populate($this->location,true);
        } else {
            $fieldset = Model_Location::createFieldset(true);
        }

        $fieldset->repopulate();

        return $fieldset;
    }

    /**
     * locations テーブルへの登録
     *
     * @access private
     * @return Model_Locationオブジェクト
     */
    private function registerLocation()
    {
        $data = $this->getLocationData();
        if (! $data) {
            throw new Exception(\Model_Error::ER00402);
        } else {
            if (Input::param('location_id')) {
                $location = Model_Location::find(Input::param('location_id'));
                $data['updated_user'] = $this->administrator->administrator_id;
            } else {
                $location = Model_Location::forge();
                $data['created_user'] = $this->administrator->administrator_id;
                $data['updated_user'] = $this->administrator->administrator_id;
            }

            $data['register_type'] = Model_Location::REGISTER_TYPE_ADMIN;

            if ($location) {
                $location->set($data);
                $location->save();
            }
            return $location;
        }
    }

    /**
     * セッションからlocationのデータを取得、整形
     *
     * @access private
     * @return array locationのデータ
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
        $view = View::forge('admin/location/list');
        $this->template->content = $view;
        $locations = Model_Location::find('all');
        $view->set('locations', $locations, false);
    }
}
