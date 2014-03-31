<?php

/**
 * Fleamarket Controller.
 *
 * @extends  Controller_Template
 */
class Controller_Fleamarket extends Controller_Base_Template
{
    protected $_login_actions = array(
        'index', 'confirm', 'thanks',
    );

    public function before()
    {
        parent::before();
    }

    /**
     * フリーマーケット入力画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_index()
    {
        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::css('jquery-ui-timepicker.css', array(), 'add_css');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker-ja.js', array(), 'add_js');
        Asset::js('http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js', array(), 'add_js');

        $view_model = ViewModel::forge('fleamarket/index');

        $fleamarket_fieldset = $this->getFleamarketFieldset();
        $fleamarket_about_fieldset = $this->getFleamarketAboutFieldset();
        $location_fieldset = $this->getLocationFieldset();
        $view_model->set('fleamarket_fieldset', $fleamarket_fieldset, false);
        $view_model->set(
            'fleamarket_about_fieldset', $fleamarket_about_fieldset, false
        );
        $view_model->set('location_fieldset', $location_fieldset, false);

        $this->setMetaTag('fleamarket/index');
        $this->template->content = $view_model;
    }

    /**
     * 入力内容の確認画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function post_confirm()
    {
        $input = Input::post();

        $fleamarket_fieldset = $this->getFleamarketFieldset($input['f']);
        $fleamarket_about_fieldset = $this->getFleamarketAboutFieldset(
            $input['fa']
        );
        $location_fieldset = $this->getLocationFieldset($input['l']);

        $fleamarket_fieldset->validation()->add_callable('Custom_Validation');
        $location_fieldset->validation()->add_callable('Custom_Validation');

        $fleamarket_validation_result =
            $fleamarket_fieldset->validation()->run($input['f']);
        $fleamarket_about_validation_result =
            $fleamarket_about_fieldset->validation()->run($input['fa']);
        $location_validation_result =
            $location_fieldset->validation()->run($input['l']);

        Session::set_flash('fleamarket.fieldset', $fleamarket_fieldset);
        Session::set_flash(
            'fleamarket_about.fieldset', $fleamarket_about_fieldset
        );
        Session::set_flash('location.fieldset', $location_fieldset);

        if (! ($fleamarket_validation_result
            && $fleamarket_about_validation_result
            && $location_validation_result)
        ) {
            Response::redirect('fleamarket/index');
        }

        $view_model = ViewModel::forge('fleamarket/confirm');
        $view_model->set('fleamarket_fieldset', $fleamarket_fieldset, false);
        $view_model->set(
            'fleamarket_about_fieldset', $fleamarket_about_fieldset, false
        );
        $view_model->set('location_fieldset', $location_fieldset, false);

        $this->setMetaTag('fleamarket/confirm');
        $this->template->content = $view_model;
    }

    /**
     * 登録処理
     *
     * @TODO: 登録ユーザIDの取得の実装
     * @access public
     * @return void
     * @author ida
     */
    public function post_thanks()
    {
        if (! Security::check_token()) {
            Response::redirect('errors/doubletransmission');
        }

        try {
            \DB::start_transaction();

            $created_user_id = 0;//Auth::get_user_id();

            $location_data = $this->getLocationData($created_user_id);
            $location = \Model_Location::forge();
            $location->set($location_data);
            $location->save();

            $fleamarket_data = $this->getFleamarketData(
                $location->location_id, $created_user_id
            );
            $fleamarket = \Model_Fleamarket::forge();
            $fleamarket->set($fleamarket_data);
            $fleamarket->save();

            $fleamarket_about_data = $this->getFleamarketAboutData(
                $fleamarket->fleamarket_id, $created_user_id
            );
            $fleamarket_about = \Model_Fleamarket_About::forge();
            $fleamarket_about->set($fleamarket_about_data);
            $fleamarket_about->save();

            \DB::commit_transaction();
        } catch (Exception $e) {
            \DB::rollback_transaction();
            Response::redirect('errors/index');
        }

        $view_model = ViewModel::forge('fleamarket/thanks');
        $this->setMetaTag('fleamarket/thanks');
        $this->template->content = $view_model;
    }

    /**
     * 開催地情報を取得する
     *
     * @access private
     * @param mixed $created_user 登録するユーザID
     * @return array
     * @author ida
     */
    private function getLocationData($created_user)
    {
        $data = array();
        $fieldset = Session::get_flash('location.fieldset');
        if ($fieldset) {
            $input = $fieldset->validation()->validated();
            $input['created_user'] = $created_user;
            $data = $this->createLocation($input);
        }

        return $data;
    }

    /**
     * 開催地情報の登録用配列を生成する
     *
     * @access private
     * @param array $data 入力データの配列
     * @return array
     * @author ida
     */
    private function createLocation($data)
    {
        $prefectures = Config::get('master.prefectures');
        $prefecture = $prefectures[$data['prefecture_id']];

        $address = $prefecture . $data['address'];
        $location = array(
            'name'          => $data['name'],
            'zip'           => $data['zip'],
            'prefecture_id' => $data['prefecture_id'],
            'address'       => $data['address'],
            'googlemap_address' => $address,
            'register_type' => \Model_Location::REGISTER_TYPE_USER,
            'created_user'  => $data['created_user'],
        );

        return $location;
    }

    /**
     * フリーマーケット情報を取得する
     *
     * @access private
     * @param mixed $created_user 登録するユーザID
     * @return array
     * @author ida
     */
    private function getFleamarketData($location_id, $created_user)
    {
        $data = array();
        $fieldset = Session::get_flash('fleamarket.fieldset');
        if ($fieldset) {
            $input = $fieldset->validation()->validated();
            $input['location_id'] = $location_id;
            $input['created_user'] = $created_user;
            $data = $this->createFleamarket($input);
        }

        return $data;
    }

    /**
     * フリーマーケット情報の登録用配列を生成する
     *
     * @access private
     * @param array $data 入力データの配列
     * @return array
     * @author ida
     */
    private function createFleamarket($data)
    {
        $fleamarket = array(
            'location_id'       => $data['location_id'],
            'group_code'        => '',
            'name'              => $data['name'],
            'promoter_name'     => $data['promoter_name'],
            'event_number'      => 1,
            'event_date'        => $data['event_date'],
            'event_time_start'  => $data['event_time_start'],
            'event_time_end'    => $data['event_time_end'],
            'event_status'      => \Model_Fleamarket::EVENT_STATUS_SCHEDULE,
            'headline'          => '',
            'information'       => '',
            'description'       => $data['description'],
            'reservation_serial'    => 0,
            'reservation_start' => null,
            'reservation_end'   => null,
            'reservation_tel'   => $data['reservation_tel'],
            'reservation_email' => $data['reservation_email'],
            'website'           => $data['website'],
            'item_categories'   => '',
            'link_from_list'    => '',
            'pickup_flag'       => 0,
            'shop_fee_flag'     => 0,
            'car_shop_flag'     => 0,
            'pro_shop_flag'     => 0,
            'charge_parking_flag'   => 0,
            'free_parking_flag' => 0,
            'rainy_location_flag'   => 0,
            'donation_fee'      => 0,
            'donation_point'    => '',
            'register_type'     => \Model_Fleamarket::REGISTER_TYPE_USER,
            'display_flag'      => \Model_Fleamarket::DISPLAY_FLAG_ON,
            'created_user'      => $data['created_user'],
        );

        return $fleamarket;
    }

    /**
     * フリーマーケット説明情報を取得する
     *
     * @access private
     * @param mixed $fleamarket_id フリーマーケットID
     * @param mixed $created_user 登録するユーザID
     * @return array
     * @author ida
     */
    private function getFleamarketAboutData($fleamarket_id, $created_user)
    {
        $data = array();
        $fieldset = Session::get_flash('fleamarket_about.fieldset');
        if ($fieldset) {
            $about_titles = \Model_Fleamarket_About::getAboutTitles();
            $input = $fieldset->validation()->validated();
            $input['fleamarket_id'] = $fleamarket_id;
            $input['title'] = $about_titles[\Model_Fleamarket_About::ACCESS];
            $input['created_user'] = $created_user;
            $data = $this->createFleamarketAbout($input);
        }

        return $data;
    }

    /**
     * フリーマーケット説明情報の登録用配列を生成する
     *
     * @access private
     * @param array $data 入力データの配列
     * @return array
     * @author ida
     */
    private function createFleamarketAbout($data)
    {
        $fleamarket_about = array(
            'fleamarket_id' => $data['fleamarket_id'],
            'about_id'      => \Model_Fleamarket_About::ACCESS,
            'title'         => $data['title'],
            'description'   => $data['description'],
            'created_user'  => $data['created_user'],
        );

        return $fleamarket_about;
    }

    /**
     * 各モデルから
     *
     * @access private
     * @param array $input 入力した値
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function getFleamarketFieldset($input = array())
    {
        $fieldset = Session::get_flash('fleamarket.fieldset');
        if (! $fieldset) {
            $fieldset = \Model_Fleamarket::createFieldset();
        }

        if ($input) {
            $fieldset->populate($input);
        } else {
            $fieldset->repopulate();
        }

        return $fieldset;
    }

    /**
     * フリーマーケット説明情報のフィールドセットを取得する
     *
     * @access private
     * @param array $input 入力した値
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function getFleamarketAboutFieldset($input = array())
    {
        $fieldset = Session::get_flash('fleamarket_about.fieldset');
        if (! $fieldset) {
            $fieldset = \Model_Fleamarket_About::createFieldset();
        }

        if ($input) {
            $fieldset->populate($input);
        } else {
            $fieldset->repopulate();
        }

        return $fieldset;
    }

    /**
     * 各モデルから
     *
     * @access private
     * @param array $input 入力した値
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function getLocationFieldset($input = array())
    {
        $fieldset = Session::get_flash('location.fieldset');
        if (! $fieldset) {
            $fieldset = \Model_Location::createFieldset();
        }

        if ($input) {
            $fieldset->populate($input);
        } else {
            $fieldset->repopulate();
        }

        return $fieldset;
    }
}
