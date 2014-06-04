<?php

/**
 * Fleamarket Controller.
 *
 * @extends  Controller_Template
 */
class Controller_Fleamarket extends Controller_Base_Template
{
    protected $_secure_actions = array(
        'index',
        'confirm',
        'thanks'
    );
    protected $_login_actions = array(
        'index',
        'confirm',
        'thanks',
    );

    public function before()
    {
        parent::before();
    }

    /**
     * フリマ情報入力
     *
     * @access public
     * @param mixed $fleamarket_id フリマID
     * @return void
     * @author ida
     */
    public function action_index($fleamarket_id = null)
    {
        $user_id = $this->login_user->user_id;
        if ($fleamarket_id) {
            $fleamarket = \Model_Fleamarket::findByUserId(
                $fleamarket_id, $user_id
            );

            if (! $fleamarket) {
                \Response::redirect('errors/notfound', 'location', 301);
            }
        }

        $this->setAssets();

        $view_model = \ViewModel::forge('fleamarket/index');
        $view_model->set('fleamarket_id', $fleamarket_id, false);
        $view_model->set('user_id', $user_id, false);
        $view_model->set('location_fieldset', $this->getLocationFieldset(), false);
        $view_model->set('fleamarket_fieldset', $this->getFleamarketFieldset(), false);
        $view_model->set('fleamarket_about_fieldset', $this->getFleamarketAboutFieldset(), false);
        $view_model->set('fleamarket_image_fieldset', $this->getFleamarketImageFieldset(), false);

        $this->template->content = $view_model;
    }

    /**
     * 確認画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function post_confirm()
    {
        $fleamarket_id      = Input::post('fleamarket_id');
        $fleamarket_about_id = Input::post('fleamarket_about_id');
        $fleamarket_about   = Input::post('fa');
        $location_id        = Input::post('location_id');
        $location           = Input::post('l');

        $location_fieldset = $this->getLocationFieldset();
        $fleamarket_about_fieldset = $this->getFleamarketAboutFieldset();


        $fleamarket_about_validation = $fleamarket_about_fieldset->validation();
        $fleamarket_about_result = $fleamarket_about_validation->run(
            $fleamarket_about
        );

        $location_validation = $location_fieldset->validation();
        $location_validation->add_callable('Custom_Validation');
        $location_result = $location_validation->run($location);

        if (! ($location_result
            && $fleamarket_result && $fleamarket_about_result)
        ) {
            $fleamarket = $fleamarket_validation->input();
            $fleamarket['fleamarket_id'] = $fleamarket_id;
            Session::set_flash('fleamarket.data', $fleamarket);
            Session::set_flash(
                'fleamarket.error_message',
                $fleamarket_validation->error_message()
            );

            $fleamarket_about = $fleamarket_about_validation->input();
            $fleamarket_about['fleamarket_about_id'] = $fleamarket_about_id;
            Session::set_flash('fleamarket_about.data', $fleamarket_about);
            Session::set_flash(
                'fleamarket_about.error_message',
                $fleamarket_about_validation->error_message()
            );

            $location = $location_validation->input();
            $location['location_id'] = $location_id;
            Session::set_flash('location.data', $location);
            Session::set_flash(
                'location.error_message',
                $location_validation->error_message()
            );

            Response::redirect('fleamarket');
        }

        $this->moveImages();

        $fleamarket = $fleamarket_validation->validated();
        $fleamarket['fleamarket_id'] = $fleamarket_id;
        $fleamarket_about = $fleamarket_about_validation->validated();
        $fleamarket_about['fleamarket_about_id'] = $fleamarket_about_id;
        $location = $location_validation->validated();
        $location['location_id'] = $location_id;

        Session::set_flash('fleamarket.data', $fleamarket);
        Session::set_flash('fleamarket_about.data', $fleamarket_about);
        Session::set_flash('location.data', $location);

        $view_model = \ViewModel::forge('fleamarket/confirm');
        $view_model->set('fleamarket', $fleamarket, false);
        $view_model->set('fleamarket_about', $fleamarket_about, false);
        $view_model->set('location', $location, false);

        $this->template->content = $view_model;
    }

    private function validateFleamarket()
    {
        $fleamarket         = Input::post('f');
        $fleamarket_fieldset = $this->getFleamarketFieldset();
        $fleamarket_validation = $fleamarket_fieldset->validation();
        $fleamarket_validation->add_callable('Custom_Validation');
        // 出店予約のバリデーション整合性のためセット
        $fleamarket['event_status'] = \Model_Fleamarket::EVENT_STATUS_SCHEDULE;
        $fleamarket['event_reservation_status'] =
            \Model_Fleamarket::EVENT_RESERVATION_STATUS_ENOUGH;

        return $fleamarket_validation->run($fleamarket);
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
            $db = Database_Connection::instance('master');
            \DB::start_transaction();

            $fleamarket_id = Input::post('fleamarket_id');
            $fleamarket_about_id = Input::post('fleamarket_about_id');
            $location_id = Input::post('location_id');
            $user_id = $this->login_user->user_id;

            // 開催地情報登録・更新
            $location_data = $this->createLocation($user_id);
            if ($location_id) {
                $location = \Model_Location::find($location_id);
            } else {
                $location = \Model_Location::forge();
            }
            $location->set($location_data)->save();

            // フリーマーケット情報登録・更新
            $fleamarket_data = $this->createFleamarket(
                $location->location_id, $user_id
            );
            if ($fleamarket_id) {
                $fleamarket = \Model_Fleamarket::find($fleamarket_id);
            } else {
                $fleamarket = \Model_Fleamarket::forge();
            }
            $fleamarket->set($fleamarket_data)->save();

            // フリーマーケット説明情報登録・更新
            $fleamarket_about_data = $this->createFleamarketAbout(
                $fleamarket->fleamarket_id, $user_id
            );
            if ($fleamarket_about_data) {
                if ($fleamarket_about_id) {
                    $fleamarket_about = \Model_Fleamarket_About::find(
                        $fleamarket_about_id
                    );
                } else {
                    $fleamarket_about = \Model_Fleamarket_About::forge();
                }
                $fleamarket_about->set($fleamarket_about_data)->save();
            }

            \DB::commit_transaction();
        } catch (Exception $e) {
            \DB::rollback_transaction();
            throw new SystemException(\Model_Error::ER00905);
        }

        $this->template->content = \ViewModel::forge('fleamarket/thanks');
    }

    /**
     * js、cssを追加する
     *
     * @access private
     * @param
     * @return void
     * @author ida
     */
    private function setAssets()
    {
        \Asset::css('jquery-ui.min.css', array(), 'add_css');
        \Asset::css('jquery-ui-timepicker.css', array(), 'add_css');
        \Asset::js('jquery-ui.min.js', array(), 'add_js');
        \Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');
        \Asset::js('jquery-ui-timepicker.js', array(), 'add_js');
        \Asset::js('jquery-ui-timepicker-ja.js', array(), 'add_js');
        \Asset::js('http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js', array(), 'add_js');
    }


    /**
     * アップロードファイルを指定のフォルダに移動する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function moveImages()
    {
        $options = array(
            'path' => DOCROOT . \Config::get('master.image_path.'),
        );
        $result = \Model_Fleamarket_Image::move($options);

        return $result;
    }

    /**
     * フリマ情報を取得する
     *
     * @access private
     * @param
     * @return array
     * @author ida
     */
    private function getFleamarketData()
    {
        $data = \Session::get_flash('fleamarket.data');
        if (! $data) {
            $fieldset = \Session::get_flash('fleamarket.fieldset');
            if (! $fieldset) {
                $fieldset = \Model_Fleamarket::createFieldset();
            }
            $data = $fieldset->repopulate()->input();
        }

        return $data;
    }

    /**
     * フリマ説明情報を取得する
     *
     * @access private
     * @param
     * @return array
     * @author ida
     */
    private function getFleamarketAboutData()
    {
        $data = \Session::get_flash('fleamarket_about.data');
        if (! $data) {
            $fieldset = \Session::get_flash('fleamarket_about.fieldset');
            if (! $fieldset) {
                $fieldset = \Model_Fleamarket_About::createFieldset();
            }
            $data = $fieldset->repopulate()->input();
        }

        return $data;
    }

    /**
     * 会場情報を取得する
     *
     * @access private
     * @param
     * @return array
     * @author ida
     */
    private function getLocationData()
    {
        $data = Session::get_flash('location.data');
        if (! $data) {
            $fieldset = \Session::get_flash('location.fieldset');
            if (! $fieldset) {
                $fieldset = \Model_Location::createFieldset();
            }
            $data = $fieldset->repopulate()->input();
        }

        return $data;
    }

    /**
     * フリマ情報の登録用配列を生成する
     *
     * @access private
     * @param mixed $location_id 開催地ID
     * @param mixed $user_id ユーザID
     * @return array
     * @author ida
     */
    private function createFleamarket($location_id, $user_id)
    {
        $data = \Session::get_flash('fleamarket.data');
        $fleamarket = array(
            'location_id'       => $location_id,
            'group_code'        => '',
            'name'              => $data['name'],
            'promoter_name'     => $data['promoter_name'],
            'event_number'      => 1,
            'event_date'        => $data['event_date'],
            'event_time_start'  => $data['event_time_start'],
            'event_time_end'    => $data['event_time_end'],
            'event_status'      => $data['event_status'],
            'event_reservation_status' => $data['event_reservation_status'],
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
            'created_user'      => $user_id,
        );

        return $fleamarket;
    }

    /**
     * フリマ説明情報の登録用配列を生成する
     *
     * @access private
     * @param mixed $fleamarket_id フリーマーケットID
     * @param mixed $user_id ユーザID
     * @return array
     * @author ida
     */
    private function createFleamarketAbout($fleamarket_id, $user_id)
    {
        $data = Session::get_flash('fleamarket_about.data');

        $fleamarket_about = array();
        if (! empty($data['description'])) {
            $about_titles = \Model_fleamarket_About::getAboutTitles();
            $fleamarket_about = array(
                'fleamarket_id' => $fleamarket_id,
                'about_id'      => \Model_Fleamarket_About::ACCESS,
                'title'         => $about_titles[\Model_fleamarket_About::ACCESS],
                'description'   => $data['description'],
                'created_user'  => $user_id,
            );
        }

        return $fleamarket_about;
    }

    /**
     * 会場情報の登録用配列を生成する
     *
     * @access private
     * @param mixed $user_id ユーザID
     * @return array
     * @author ida
     */
    private function createLocation($user_id)
    {
        $data = \Session::get_flash('location.data');
        $prefectures = \Config::get('master.prefectures');
        $prefecture = $prefectures[$data['prefecture_id']];
        $address = $prefecture . $data['address'];
        $location = array(
            'name'          => $data['name'],
            'zip'           => $data['zip'],
            'prefecture_id' => $data['prefecture_id'],
            'address'       => $data['address'],
            'googlemap_address' => $address,
            'register_type' => \Model_Location::REGISTER_TYPE_USER,
            'created_user'  => $user_id,
        );

        return $location;
    }

    /**
     * フリマ情報のフィールドセットを取得する
     *
     * @access private
     * @param
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function getFleamarketFieldset()
    {
        $fieldset = \Session::get_flash('fleamarket.fieldset');
        if (! $fieldset) {
            $fieldset = \Model_Fleamarket::createFieldset();
            $fieldset->add('agreement', '利用規約')->add_rule('required');
        }

        return $fieldset;
    }

    /**
     * フリマ説明情報のフィールドセットを取得する
     *
     * @access private
     * @param
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function getFleamarketAboutFieldset($input = array())
    {
        $fieldset = \Session::get_flash('fleamarket_about.fieldset');
        if (! $fieldset) {
            $fieldset = \Model_Fleamarket_About::createFieldset();
        }

        return $fieldset;
    }

    /**
     * 会場情報のフィールドセットを取得する
     *
     * @access private
     * @param
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function getLocationFieldset()
    {
        $fieldset = \Session::get_flash('location.fieldset');
        if (! $fieldset) {
            $fieldset = \Model_Location::createFieldset();
        }

        return $fieldset;
    }

    /**
     * エラーメッセージを取得する
     *
     * @access private
     * @param string セッション名
     * @return array
     * @author ida
     */
    private function getErrorMessage($name = null)
    {
        $error_message = array();
        if (! $name) {
            return $error_message;
        }

        return \Session::get_flash($name . '.error_message', array());
    }
}
