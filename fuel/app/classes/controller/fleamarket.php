<?php
use Fuel\Core\DB;
use \Controller\Base;
use \Model\Fleamarket;
use \Model\Fleamarket_About;
use \Model\Location;

/**
 * Fleamarket Controller.
 *
 * @extends  Controller_Template
 */
class Controller_Fleamarket extends Controller_Base
{
    /**
     * 事前処理
     *
     * アクション実行前の共通処理
     *
     * @access public
     * @return void
     * @author ida
     */
    public function before()
    {
        $this->postActions = array('confirm', 'thanks');
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
        $session_fleamarket = Session::get_flash('fleamarket');

        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::css('jquery-ui-timepicker.css', array(), 'add_css');
        Asset::js('jquery.js', array(), 'add_js');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker.js', array(), 'add_js');
        Asset::js('jquery-ui-timepicker-ja.js', array(), 'add_js');

        $fieldset = $this->createFieldset();

        $view_model = ViewModel::forge('fleamarket/index');
        $view_model->set('form', $fieldset->form(), false);
        $this->template->title = 'フリーマーケット情報登録';

        if (isset($session_fleamarket['errors'])) {
            $view_model->set('errors', $session_fleamarket['errors']);
        }
        if (isset($session_fleamarket['data'])) {
            $fieldset->populate($session_fleamarket['data']);
        }

        $this->template->content = $view_model;
    }

    /**
     * 入力内容の確認画面
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_confirm()
    {
        $data = Input::post();
        $this->castReservationTel($data);
        $fieldset = $this->createFieldset();

        $validation = $fieldset->validation();
        $validation->add_callable('Custom_Validation');

        if (!$validation->run($data)) {
            Session::set_flash('fleamarket', array(
                'data' => $data,
                'errors' => $validation->error_message(),
            ));
            Response::redirect('fleamarket/index');
        }

        $this->template->title = 'フリーマーケット情報登録';
        $view_model = ViewModel::forge('fleamarket/confirm');
        $view_model->set('form', $fieldset->form(), false);

        $data = $validation->validated();
        $view_model->set('data', $data);
        Session::set_flash('fleamarket.data', $data);

        $this->template->content = $view_model;
    }

    /**
     * 登録処理
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_thanks()
    {
        if (!Security::check_token()) {
            Response::redirect('errors/doubletransmission');
        }

        try {
            DB::start_transaction();

            $data = Session::get_flash('fleamarket.data');
            $data['created_user'] = 0;

            $location = $this->createLocation($data);
            $location_result = Location::insert($location);

            $location_id = $location_result['last_insert_id'];
            $fleamarket = $this->createFleamarket($location_id, $data);
            $fleamarket_result = Fleamarket::insert($fleamarket);

            $fleamarket_id = $fleamarket_result['last_insert_id'];
            $fleamarket_abouts = $this->createFleamarketAbouts(
                $fleamarket_id, $data
            );
            $fleamarket_about_result = Fleamarket_About::insertMany(
                $fleamarket_abouts
            );

            DB::commit_transaction();
        } catch (Exception $e) {
            DB::rollback_transaction();
            exit;
            Response::redirect('errors/index');
        }

        $view_model = ViewModel::forge('fleamarket/thanks');
        $this->template->title = 'フリーマーケット情報登録';
        $this->template->content = $view_model;
    }

    /**
     * 予約電話番号を成形し取得する
     *
     * @access private
     * @para array $data 入力データの配列（参照渡し）
     * @return void
     * @author ida
     */
    private function castReservationTel(&$data)
    {
        $reservationTel = '';
        if (isset($data['reservation_tel1'])
            && $data['reservation_tel1'] !== ''
        ) {
            $reservationTel = $data['reservation_tel1'];
        }
        if (isset($data['reservation_tel2'])
            && $data['reservation_tel2'] !== ''
        ) {
            $reservationTel .= '-' . $data['reservation_tel2'];
        }
        if (isset($data['reservation_tel3'])
            && $data['reservation_tel3'] !== ''
        ) {
            $reservationTel .= '-' . $data['reservation_tel3'];
        }
        $data['reservation_tel'] = $reservationTel;
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
            'name'          => $data['location_name'],
            'zip'           => $data['zip'],
            'prefecture_id' => $data['prefecture_id'],
            'address'       => $data['address'],
            'googlemap_address' => $address,
            'register_type' => Location::REGISTER_TYPE_USER,
            'created_user'  => $data['created_user'],
        );

        return $location;
    }

    /**
     * フリーマーケット情報の登録用配列を生成する
     *
     * @access private
     * @param int $location_id 開催地ID
     * @param array $data 入力データの配列
     * @return array
     * @author ida
     */
    private function createFleamarket($location_id, $data)
    {
        if (! $location_id) {
            throw new Exception();
        }

        $fleamarket = array(
            'location_id'       => $location_id,
            'name'              =>  $data['name'],
            'promoter_name'     => $data['promoter_name'],
            'event_number'      => 1,
            'event_datetime'    => $data['event_datetime'],
            'event_status'      => Fleamarket::EVENT_SCHEDULE,
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
            'reservation_flag'  => Fleamarket::RESERVATION_FLAG_NG,
            'car_shop_flag'     => Fleamarket::CAR_SHOP_FLAG_NG,
            'parking_flag'      => Fleamarket::PARKING_FLAG_NG,
            'shop_fee_flag'     => Fleamarket::SHOP_FEE_FLAG_FREE,
            'donation_fee'      => 0,
            'donation_point'    => '',
            'register_type'     => Fleamarket::REGISTER_TYPE_USER,
            'display_flag'      => Fleamarket::DISPLAY_FLAG_ON,
            'created_user'      => $data['created_user'],
        );

        return $fleamarket;
    }

    /**
     * フリーマーケット「～ついて」情報の登録用配列を生成する
     *
     * @access private
     * @param int $fleamarket_id フリーマーケットID
     * @param array $data 入力データの配列
     * @return array
     * @author ida
     */
    private function createFleamarketAbouts($fleamarket_id, $data)
    {
        if (! $fleamarket_id) {
            throw new Exception();
        }

        $event_abouts = Config::get('master.event_abouts');
        $fleamarket_abouts = array();
        foreach ($event_abouts as $i => $event_about) {
            if (!isset($data[$event_about['name']])
                || $data[$event_about['name']] === ''
            ) {
                continue;
            }

            $fleamarket_abouts[$i] = array(
                'fleamarket_id' => $fleamarket_id,
                'title'         => $event_about['title'],
                'description'   => $data[$event_about['name']],
                'created_user'  => $data['created_user'],
            );
        }

        return $fleamarket_abouts;
    }

    /**
     * Fieldsetオブジェクトを生成する
     *
     * @access private
     * @return object Fieldsetオブジェクト
     * @author ida
     */
    private function createFieldset()
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

        $fieldset->add('reservation_tel1', '市外局番');
        $fieldset->add('reservation_tel2', '市内局番');
        $fieldset->add('reservation_tel3', '加入者番号');
        $fieldset->add('reservation_tel', '予約受付電話番号')
            ->add_rule('valid_tel');

        $fieldset->add('reservation_email', '予約受付メールアドレス')
            ->add_rule('max_length', 250)
            ->add_rule('valid_email');

        $fieldset->add('event_datetime', '開催日時')
            ->add_rule('required')
            ->add_rule('valid_datetime');

        $fieldset->add('location_name', '会場名')
            ->add_rule('required')
            ->add_rule('max_length', 50);

        $fieldset->add('zip', '郵便番号')
            ->add_rule('required')
            ->add_rule('valid_string', array('numeric', 'utf8'))
            ->add_rule('max_length', 7);

        $fieldset->add('prefecture_id', '都道府県')
            ->add_rule('required')
            ->add_rule('array_key_exists', Config::get('master.prefectures'));

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
