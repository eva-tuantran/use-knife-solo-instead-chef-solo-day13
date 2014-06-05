<?php

/**
 * Fleamarket Controller.
 *
 * @extends  Controller_Template
 */
class Controller_Fleamarket extends Controller_Base_Template
{
    protected $_secure_actions = array(
        'index', 'confirm', 'thanks'
    );
    protected $_login_actions = array(
        'index', 'confirm', 'thanks',
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
        $fleamarket = null;
        $fleamarket_images = null;

        if ($fleamarket_id) {
            $fleamarket = \Model_Fleamarket::findByUserId(
                $fleamarket_id, $user_id
            );

            if (! $fleamarket) {
                return $this->forward('errors/notfound', 404);
            }
        }

        if (\Input::post('fleamarket_id')) {
            $fleamarket_id = \Input::post('fleamarket_id');
        }

        $this->setAssets();
        $fieldsets = $this->getFieldsets();

        $view_model = \ViewModel::forge('fleamarket/index');
        $view_model->set('location_id', \Input::post('location_id'), false);
        $view_model->set('fleamarket_id', $fleamarket_id, false);
        $view_model->set('fleamarket_about_id', \Input::post('fleamarket_about_id'), false);
        $view_model->set('fleamarket', $fleamarket, false);
        $view_model->set('fieldsets', $fieldsets, false);
        $view_model->set('fleamarket_images', $this->getFleamarketImages($fleamarket_id), false);
        $view_model->set('delete_image', \Session::get_flash('delete_image'), false);
        $view_model->set('upload_file_errors', \Session::get_flash('upload_file_errors'), false);
        $this->template->content = $view_model;
    }

    /**
     * 確認画面
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function post_confirm()
    {
        $fieldsets = $this->getFieldsets();

        $is_valid = $this->validateAll($fieldsets);
        $this->setFieldsets($fieldsets);
        $delete_image = \Input::post('deleteImage');
        \Session::set_flash('delete_image', $delete_image);

        // アップロードファイル処理
        list($is_upload, $upload_files) = $this->moveImages();
        if (! $is_valid || ! $is_upload) {
            $errors = $this->getFleamarketImageErrors($upload_files);
            \Session::set_flash('upload_file_errors', $errors);
            \Response::redirect('fleamarket/');
        }

        $fleamarket_id = \Input::post('fleamarket_id');

        $view_model = \ViewModel::forge('fleamarket/confirm');
        $view_model->set('location_id', \Input::post('location_id'), false);
        $view_model->set('fleamarket_id', $fleamarket_id, false);
        $view_model->set('fleamarket_about_id', \Input::post('fleamarket_about_id'), false);
        $view_model->set('fieldsets', $fieldsets, false);
        $view_model->set('fleamarket_images', $this->getFleamarketImages($fleamarket_id), false);
        $view_model->set('upload_files', $upload_files, false);
        $view_model->set('delete_image', $delete_image, false);
        $this->template->content = $view_model;
    }

    /**
     * 登録処理
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function post_thanks()
    {
        if (! Security::check_token()) {
            Response::redirect('errors/doubletransmission');
        }

        try {
            $db = \Database_Connection::instance('master');
            \DB::start_transaction();

            $fieldsets = $this->getFieldsets();

            $location = $this->saveLocation($fieldsets['location']);
            $fleamarket = $this->saveFleamarket(
                $fieldsets['fleamarket'], $location->location_id
            );
            $fleamarket_about = $this->saveFleamarketAbout(
                $fieldsets['fleamarket_about'], $fleamarket->fleamarket_id
            );
            $this->deleteFleamarketImage($fleamarket->fleamarket_id);
            $this->saveFleamarketImage($fleamarket->fleamarket_id);

            \DB::commit_transaction();
        } catch (\Exception $e) {
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
        \Asset::js('https://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3-https.js', array(), 'add_js');
    }

    /**
     * フリマイメージ画像情報を取得する
     *
     * @access private
     * @param mixed $fleamarket_id フリマID
     * @return void
     * @author ida
     */
    private function getFleamarketImages($fleamarket_id)
    {
        $fleamarket_images = \Session::get_flash('fleamarket_images');
        if (! $fleamarket_images) {
            $fleamarket_images = \Model_Fleamarket_Image::findByFleamarketId(
                $fleamarket_id
            );
        }

        return $fleamarket_images;
    }

    /**
     * アップロードのエラーを取得する
     *
     * @access private
     * @param array $upload_files アップロードファイル情報
     * @return void
     * @author ida
     */
    private function getFleamarketImageErrors($upload_files)
    {
        if (! $upload_files) {
            return null;
        }

        $errors = array();
        foreach ($upload_files as $upload_file) {
            foreach ($upload_file['errors'] as $error) {
                if ($error['error'] != \Upload::UPLOAD_ERR_NO_FILE) {
                    $errors[$upload_file['field']][] = $error;
                }
            }
        }

        return $errors;
    }

    /**
     * フィールドセットをセッションに保存する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function setFieldsets($fieldsets)
    {
        foreach ($fieldsets as $key => $fieldset) {
            \Session::set_flash($key . '.fieldset', $fieldset);
        }
    }

    /**
     * フィールドセットを取得する
     *
     * @access private
     * @param
     * @return void
     * @author kobayashi
     */
    private function getFieldsets()
    {
        return array(
            'location' => $this->getLocationFieldset(),
            'fleamarket' => $this->getFleamarketFieldset(),
            'fleamarket_about' => $this->getFleamarketAboutFieldset(),
        );
    }

    /**
     * 会場情報登録・更新
     *
     * @access private
     * @param object $fieldset フィールドセット
     * @param mixed $location_id 会場ID
     * @return bool
     * @author ida
     */
    private function saveLocation($fieldset)
    {
        $location_data = $this->createLocation($fieldset);

        if (! empty($location_data['location_id'])) {
            $location = \Model_Location::find($location_data['location_id']);
        } else {
            $location = \Model_Location::forge();
        }
        unset($location_data['location_id']);

        if ($location->set($location_data)->save()) {
            return $location;
        } else {
            throw new Exception;
        }
    }

    /**
     * フリマ情報登録・更新
     *
     * @access private
     * @param object $fieldset フィールドセット
     * @param mixed $fleamarket_id フリマID
     * @return bool
     * @author ida
     */
    private function saveFleamarket($fieldset, $location_id = null)
    {
        $fleamarket_data = $this->createFleamarket(
            $fieldset, $location_id
        );

        if (! empty($fleamarket_data['fleamarket_id'])) {
            $fleamarket = \Model_Fleamarket::find($fleamarket_data['fleamarket_id']);
        } else {
            $fleamarket = \Model_Fleamarket::forge();
        }
        unset($fleamarket_data['fleamarket_id']);

        if ($fleamarket->set($fleamarket_data)->save()) {
            return $fleamarket;
        } else {
            throw new Exception;
        }
    }

    /**
     * フリマ説明情報登録・更新
     *
     * @access private
     * @param object $fieldset フィールドセット
     * @param mixed $fleamarket_about_id フリマ説明ID
     * @return bool
     * @author ida
     */
    private function saveFleamarketAbout($fieldset, $fleamarket_id = null)
    {
        $fleamarket_about_data = $this->createFleamarketAbout(
            $fieldset, $fleamarket_id
        );

        if (! empty($fleamarket_about_data['fleamarket_about_id'])) {
            $fleamarket_about = \Model_Fleamarket_About::find(
                $fleamarket_about_data['fleamarket_about_id']
            );
        } else {
            $fleamarket_about = \Model_Fleamarket_About::forge();
        }
        unset($fleamarket_about_data['fleamarket_about_id']);

        if ($fleamarket_about->set($fleamarket_about_data)->save()) {
            return $fleamarket_about;
        } else {
            throw new Exception;
        }
    }

    /**
     * フリマイメージ画像情報登録・更新
     *
     * @access private
     * @param mixed $fleamarket_id フリマID
     * @return bool
     * @author ida
     */
    private function saveFleamarketImage($fleamarket_id)
    {
        $upload_files = \Session::get_flash('upload_files');

        if (! $upload_files) {
            return;
        }

        foreach ($upload_files as $file) {
            $priority = str_replace('image_', '', $file['field']);
            $fleamarket_image_data = array(
                'priority' => $priority,
                'file_name' => $file['saved_as'],
            );
            $fleamarket_image = \Model_Fleamarket_Image::query()
                ->where('fleamarket_id', $fleamarket_id)
                ->where('priority', $priority)
                ->get_one();

            if ($fleamarket_image) {
                $fleamarket_image_data['updated_user'] = $this->login_user->user_id;
            }else{
                $fleamarket_image = \Model_Fleamarket_Image::forge();
                $fleamarket_image_data['fleamarket_id'] = $fleamarket_id;
                $fleamarket_image_data['created_user'] = $this->login_user->user_id;
            }
            $fleamarket_image->set($fleamarket_image_data)->save();
        }

        $tmp_path = \Config::get('master.image_path.temporary_user');
        $src_path = DOCROOT . $tmp_path;
        $store_path = \Config::get('master.image_path.store');
        $dest_path = DOCROOT . $store_path . $fleamarket_id . '/';

        \Model_Fleamarket_Image::storeUploadFile($upload_files, $src_path, $dest_path);
    }

    /**
     * フリマイメージ画像情報を削除する
     *
     * @access private
     * @param mixed $fleamarket_id フリマID
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function deleteFleamarketImage($fleamarket_id)
    {
        $delete_image = \Session::get_flash('delete_image');

        if (! $delete_image) {
            return null;
        }

        foreach ($delete_image as $key => $priority) {
            $fleamarket_image = \Model_Fleamarket_Image::query()
                ->where('fleamarket_id', $fleamarket_id)
                ->where('priority', $priority)
                ->get_one();

            $fleamarket_image->delete();
        }
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
            $fieldset->validation()->add_callable('Custom_Validation');
        }

        $input = \Input::post('l');
        if (! empty($input)) {
            $fieldset->populate($input, true);
        }

        return $fieldset;
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

        $input = \Input::post('f');
        if (! empty($input)) {
            $fieldset->populate($input);
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
    private function getFleamarketAboutFieldset()
    {
        $fieldset = \Session::get_flash('fleamarket_about.fieldset');
        if (! $fieldset) {
            $fieldset = \Model_Fleamarket_About::createFieldset();
        }

        $input = \Input::post('fa');
        if (! empty($input)) {
            $fieldset->populate($input);
        }

        return $fieldset;
    }

    private function validateAll($fieldsets)
    {
        $location_input = \Input::post('l');
        $is_valid[] = $fieldsets['location']->validation()->run($location_input);

        // 出店予約のバリデーション整合性のためセット
        $fleamarket_input = \Input::post('f');
        $fleamarket_input['event_status'] = \Model_Fleamarket::EVENT_STATUS_SCHEDULE;
        $fleamarket_input['event_reservation_status'] = \Model_Fleamarket::EVENT_RESERVATION_STATUS_ENOUGH;
        $is_valid[] = $fieldsets['fleamarket']->validation()->run($fleamarket_input);

        $fleamarket_about_input = \Input::post('fa');
        $is_valid[] = $fieldsets['fleamarket_about']->validation()->run($fleamarket_about_input);

        return ! in_array(false, $is_valid);
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
            'path' => DOCROOT . \Config::get('master.image_path.temporary_user'),
            'max_size' => 1024000,
            'create_path' => true,
        );
        list($is_upload, $upload_files) = \Model_Fleamarket_Image::moveUploadedFile($options);
        \Session::set_flash('upload_files', $upload_files);

        return array($is_upload, $upload_files);
    }

    /**
     * 会場情報の登録用配列を生成する
     *
     * @access private
     * @param object $fieldset フィールドセット
     * @return array
     * @author ida
     */
    private function createLocation($fieldset)
    {
        $data = $fieldset->validation()->validated();

        $prefectures = \Config::get('master.prefectures');
        $prefecture = $prefectures[$data['prefecture_id']];
        $address = $prefecture . $data['address'];

        $location_id = \Input::post('location_id');
        $location = array(
            'location_id'   => $location_id,
            'name'          => $data['name'],
            'zip'           => $data['zip'],
            'prefecture_id' => $data['prefecture_id'],
            'address'       => $data['address'],
            'googlemap_address' => $address,
            'register_type' => \Model_Location::REGISTER_TYPE_USER,
            'created_user'  => $this->login_user->user_id,
        );
        if ($location_id) {
            $location['updated_user'] = $this->login_user->user_id;
        } else {
            $location['created_user'] = $this->login_user->user_id;
        }

        return $location;
    }

    /**
     * フリマ情報の登録用配列を生成する
     *
     * @access private
     * @param object $fieldset フィールドセット
     * @param mixed $location_id 開催地ID
     * @return array
     * @author ida
     */
    private function createFleamarket($fieldset, $location_id)
    {
        $data = $fieldset->validation()->validated();

        $fleamarket_id = \Input::post('fleamarket_id');
        $fleamarket = array(
            'fleamarket_id'     => $fleamarket_id,
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
            'reservation_serial'    => 1,
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
        );
        if ($fleamarket_id) {
            $fleamarket['updated_user'] = $this->login_user->user_id;
        } else {
            $fleamarket['created_user'] = $this->login_user->user_id;
        }

        return $fleamarket;
    }

    /**
     * フリマ説明情報の登録用配列を生成する
     *
     * @access private
     * @param object $fieldset フィールドセット
     * @param mixed $fleamarket_id フリーマーケットID
     * @return array
     * @author ida
     */
    private function createFleamarketAbout($fieldset, $fleamarket_id)
    {
        $data = $fieldset->validation()->validated();

        $fleamarket_about = array();
        if (! empty($data['description'])) {
            $fleamarket_about_id = \Input::post('fleamarket_about_id');
            $about_titles = \Model_fleamarket_About::getAboutTitles();
            $fleamarket_about = array(
                'fleamarket_about_id' => $fleamarket_about_id,
                'fleamarket_id' => $fleamarket_id,
                'about_id'      => \Model_Fleamarket_About::ACCESS,
                'title'         => $about_titles[\Model_fleamarket_About::ACCESS],
                'description'   => $data['description'],
            );
            if ($fleamarket_about_id) {
                $fleamarket_about['updated_user'] = $this->login_user->user_id;
            } else {
                $fleamarket_about['created_user'] = $this->login_user->user_id;
            }
        }

        return $fleamarket_about;
    }
}
