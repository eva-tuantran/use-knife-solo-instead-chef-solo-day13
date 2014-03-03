<?php
use Fuel\Core\DB;
use \Model\Fleamarkets;
use \Model\Fleamarketabouts;
use \Model\Locations;

/**
 * Fleamarket Controller.
 *
 * @extends  Controller_Template
 */
class Controller_Fleamarket extends Controller_Template
{
    /**
     * 共通定義を保持
     *
     * @access private
     * @author ida
     */
    private $app = null;

    /**
     * beforeメソッド
     *
     * @access public
     * @return void
     * @author ida
     */
    public function before()
    {
        parent::before();
        $this->app_config = Config::load('app_config');
    }

    /**
     * フリマ登録画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_index()
    {
        $session_fleamark = Session::get_flash('fleamarket');

/*
print '<hr>';
if (isset($session_fleamark['back'])) {
var_dump($session_fleamark['back']);
}
print '<hr>';
if (isset($session_fleamark['data'])) {
var_dump($session_fleamark['data']);
}
print '<hr>';
*/
if (isset($session_fleamark['errors'])) {
var_dump($session_fleamark['errors']);
}
print '<hr>';

        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery.js', array(), 'add_js');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');

        $fieldset = $this->create_fieldset();

        $view_model = ViewModel::forge('fleamarket/index');
        $view_model->set('app_config', $this->app_config);
        $view_model->set('form', $fieldset->form(), false);
        $this->template->title = 'フリーマーケット情報登録';

        if (isset($session_fleamark['back'])
            && $session_fleamark['back'] === 'back'
        ) {
            if (isset($session_fleamark['errors'])) {
                $view_model->set('errors', $session_fleamark['errors']);
            }
            if (isset($session_fleamark['data'])) {
                $fieldset->populate($session_fleamark['data']);
            }
        }

        $this->template->content = $view_model;
    }

    /**
     * 確認からの戻り処理
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_back()
    {
        if (Input::method() != 'POST') {
            throw new HttpNotFoundException;
        }

        Session::keep_flash('fleamarket');
        Session::set_flash('fleamarket.back', 'back');
        Response::redirect('fleamarket/index');
    }

    /**
     * 確認画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_confirm()
    {
        if (Input::method() != 'POST') {
            throw new HttpNotFoundException;
        }

        Asset::js('jquery.js', array(), 'add_js');

        $fieldset = $this->create_fieldset();
        $fieldset->repopulate();

        $validation = $fieldset->validation();
        $validation->add_callable('Custom_Validation');

        if ($validation->run()) {
            $data = $validation->validated();

            $this->template->title = 'フリーマーケット情報登録';
            $view_model = ViewModel::forge('fleamarket/confirm');
            $view_model->set('app_config', $this->app_config);
            $view_model->set('form', $fieldset->form(), false);
            $view_model->set('data', $data);
            Session::set_flash('fleamarket.data', $data);

            $this->template->content = $view_model;
        } else {
            Session::set_flash('fleamarket', array(
                'data' => Input::post(),
                'errors' => $validation->error_message(),
                'back' => 'back'
            ));
            Response::redirect('fleamarket/index');
        }
    }

    /**
     * 登録処理
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_register()
    {
        if (Input::method() != 'POST') {
            throw new HttpNotFoundException;
        }

        try {
            DB::start_transaction();

            $data = Session::get_flash('fleamarket.data');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_user'] = 0;

            $location = $this->create_location($data);
            $location_result = Locations::insert($location);

            $location_id = $location_result['last_insert_id'];
            $fleamarket = $this->create_fleamarket($location_id, $data);
            $fleamarket_result = Fleamarkets::insert($fleamarket);

            $fleamarket_id = $fleamarket_result['last_insert_id'];
            $fleamarket_abouts = $this->create_fleamarket_abouts(
                $fleamarket_id, $data
            );
            $fleamarket_abouts_result = FleamarketAbouts::insertMany(
                $fleamarket_abouts
            );

            DB::commit_transaction();

            Response::redirect('fleamarket/thanks');
        } catch (Exception $e) {
            var_dump($e);
            exit;
            DB::rollback_transaction();
            Response::redirect('error/index');
        }
    }

    /**
     * 登録完了処理
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_thanks()
    {
        $view_model = ViewModel::forge('fleamarket/thanks');
        $this->template->title = 'フリーマーケット情報登録';
        $this->template->content = $view_model;
    }

    /**
     * locationの配列を生成する
     *
     * @access private
     * @param array $data 入力データの配列
     * @return array
     * @author ida
     */
    private function create_location($data)
    {
        $location = array();
        $location['name'] = $data['location_name'];
        $location['zip'] = $data['zip'];
        $location['prefecture_id'] = $data['prefecture'];
        $location['address'] = $data['address'];
        $location['googlemap_address'] = $data['address'];
        $location['register_type'] = Locations::REGISTER_TYPE_USER;
        $location['created_user'] = 0;
        $location['created_at'] = $data['created_at'];

        return $location;
    }

    /**
     * fleamarketsの配列を生成する
     *
     * @access private
     * @param int $location_id 開催地ID
     * @param array $data 入力データの配列
     * @return array
     * @author ida
     */
    private function create_fleamarket($location_id, $data)
    {
        if (! $location_id) {
            throw new Exception();
        }

        $fleamarket = array();
        $fleamarket['location_id'] = $location_id;
        $fleamarket['name'] = $data['name'];
        $fleamarket['promoter_name'] = $data['promoter_name'];
        $fleamarket['event_number'] = 1;
        $event_datetime = '';
        if ($data['event_date'] != ''
            && $data['event_hour'] != '' && $data['event_minute'] != ''
        ) {
            $event_datetime = $data['event_date'];
            $event_datetime .= ' ' . $data['event_hour'];
            $event_datetime .= ':' . $data['event_minute'];
        }
        $fleamarket['event_datetime'] = $event_datetime;
        $fleamarket['event_status'] = Fleamarkets::EVENT_SCHEDULE;
        $fleamarket['headline'] = '';
        $fleamarket['information'] = '';
        $fleamarket['description'] = $data['description'];
        $fleamarket['reservation_serial'] = 0;
        $fleamarket['reservation_start'] = null;
        $fleamarket['reservation_end'] = null;
        $reservation_tel = '';
        if ($data['reservation_tel1'] != ''
            && $data['reservation_tel2'] != ''
            && $data['reservation_tel3'] != ''
        ) {
            $reservation_tel = $data['reservation_tel1'];
            $reservation_tel .= '-' . $data['reservation_tel2'];
            $reservation_tel .= '-' . $data['reservation_tel3'];
        }
        $fleamarket['reservation_tel'] = $reservation_tel;
        $fleamarket['reservation_email'] = $data['reservation_email'];
        $fleamarket['website'] = $data['website'];
        $fleamarket['item_categories'] = '';
        $fleamarket['link_from_list'] = '';
        $fleamarket['reservation_flag'] = Fleamarkets::RESERVATION_FLAG_NG;
        $fleamarket['car_shop_flag'] = Fleamarkets::CAR_SHOP_FLAG_NG;
        $fleamarket['parking_flag'] = Fleamarkets::PARKING_FLAG_NG;
        $fleamarket['shop_fee_flag'] = Fleamarkets::SHOP_FEE_FLAG_FREE;
        $fleamarket['donation_fee'] = 0;
        $fleamarket['donation_point'] = '';
        $fleamarket['register_type'] = Fleamarkets::REGISTER_TYPE_USER;
        $fleamarket['display_flag'] = Fleamarkets::DISPLAY_FLAG_ON;
        $fleamarket['created_user'] = $data['created_user'];
        $fleamarket['created_at'] = $data['created_at'];

        return $fleamarket;
    }

    /**
     * fleamarket_aboutsの配列を生成する
     *
     * @access private
     * @param int $fleamarket_id フリーマーケットID
     * @param array $data 入力データの配列
     * @return array
     * @author ida
     */
    private function create_fleamarket_abouts($fleamarket_id, $data)
    {
        if (! $fleamarket_id) {
            throw new Exception();
        }

        $event_abouts = $this->app_config['event_abouts'];
        $fleamarket_abouts = array();
        foreach ($event_abouts as $i => $event_about) {
            if (!isset($data[$event_about['name']])
                || $data[$event_about['name']] === ''
            ) {
                continue;
            }

            $fleamarket_abouts[$i]['fleamarket_id'] = $fleamarket_id;
            $fleamarket_abouts[$i]['title'] = $event_about['title'];
            $fleamarket_abouts[$i]['description'] = $data[$event_about['name']];
            $fleamarket_abouts[$i]['created_user'] = $data['created_user'];
            $fleamarket_abouts[$i]['created_at'] = $data['created_at'];
        }

        return $fleamarket_abouts;
    }

    /**
     * 新規登録のFieldsetオブジェクトを生成する
     *
     * @access private
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function create_fieldset()
    {
        $fieldset = Fieldset::instance('fleamarket');
        if (false !== $fieldset) {
            return $fieldset;
        } else {
            $fieldset = Fieldset::forge('fleamarket');
        }

        $fieldset->add('name', 'フリーマーケット名')
            ->add_rule('required')
            ->add_rule('max_length', 100);

        $fieldset->add('promoter_name', '主催者')
            ->add_rule('required')
            ->add_rule('max_length', 100);

        $fieldset->add('website', '主催者ホームページ')
            ->add_rule('max_length', 250);

        $fieldset->add('reservation_tel1', '予約受付電話番号')
            ->add_rule('valid_tel');
        $fieldset->add('reservation_tel2', '予約受付電話番号');
        $fieldset->add('reservation_tel3', '予約受付電話番号');

        $fieldset->add('reservation_email', '予約受付メールアドレス')
            ->add_rule('valid_email')
            ->add_rule('max_length', 250);

        $fieldset->add('event_date', '開催日時')
            ->add_rule('required')
            ->add_rule('valid_date');

        $fieldset->add('event_hour', '開催時間')
            ->add_rule('array_key_exists', $this->app_config['event_hours']);

        $fieldset->add('event_minute', '開催時間')
            ->add_rule('array_key_exists', $this->app_config['event_minutes']);

        $fieldset->add('location_name', '会場名')
            ->add_rule('required')
            ->add_rule('max_length', 50);

        $fieldset->add('zip', '郵便番号')
            ->add_rule('required')
            ->add_rule('max_length', 7);

        $fieldset->add('prefecture', '都道府県')
            ->add_rule('required')
            ->add_rule('array_key_exists', $this->app_config['prefectures']);

        $fieldset->add('address', '住所')
            ->add_rule('required')
            ->add_rule('max_length', 50);

        $fieldset->add('description', '詳細')
            ->add_rule('required')
            ->add_rule('max_length', 5000);

        $fieldset->add('about_access', '最寄り駅または交通アクセス')
            ->add_rule('max_length', 500);

        $fieldset->add('about_event_time', '開催時間について')
            ->add_rule('max_length', 500);

        $fieldset->add('about_booth', '募集ブース数について')
            ->add_rule('max_length', 500);

        $fieldset->add('about_shop_cautions', '出店に際してのご注意')
            ->add_rule('max_length', 500);

        $fieldset->add('about_shop_style', '出店形態について')
            ->add_rule('max_length', 500);

        $fieldset->add('about_shop_fee', '出店料金について')
            ->add_rule('max_length', 500);

        $fieldset->add('about_parking', '駐車場について')
            ->add_rule('max_length', 500);

        return $fieldset;
    }
}
