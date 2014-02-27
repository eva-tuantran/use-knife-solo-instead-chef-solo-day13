<?php

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
        $this->app = Config::load('app');
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
var_dump($session_fleamark['back']);
print '<hr>';
var_dump($session_fleamark['data']);
print '<hr>';
var_dump($session_fleamark['errors']);
print '<hr>';
*/

        Asset::css('jquery-ui.min.css', array(), 'add_css');
        Asset::js('jquery-1.10.2.js', array(), 'add_js');
        Asset::js('jquery-ui.min.js', array(), 'add_js');
        Asset::js('jquery.ui.datepicker-ja.js', array(), 'add_js');

        $fieldset = $this->create_fieldset();

        $view_model = ViewModel::forge('fleamarket/index');
        $view_model->set('config', $this->app);
        $view_model->set('form', $fieldset->form(), false);
        $this->template->title = 'フリーマーケット情報入力';

        if ($session_fleamark['back'] === 'back') {
            $view_model->set('errors', $session_fleamark['errors']);
            $fieldset->populate($session_fleamark['data']);
        }

        $this->template->content = $view_model;
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
            $this->action_404();
        }

        $fieldset = $this->create_fieldset();
        $fieldset->repopulate();

        $validation = $fieldset->validation();
        $validation->add_callable('CustomValidation');

        if ($validation->run()) {
            $data = $validation->validated();

            $this->template->title = 'フリーマーケット情報確認';
            $view_model = ViewModel::forge('fleamarket/confirm');
            $view_model->set('form', $fieldset->form(), false);
            $view_model->set('data', $data, false);

            $this->template->content = $view_model;
        } else {
            Session::set_flash('fleamarket', array(
                'data' => Input::post(),
                'errors' => $validation->error_message(),
                'back' => 'back'
            ));
            Response::redirect('fleamarket/index');
            // $this->action_index();
            //return  Request::forge('fleamarket/index')->execute()->response();
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
            $this->action_404();
        }
        if (! Security::check_token()) {
            // エラー表示
        } else {
            // 正常なデータ登録
        }

        $data = Session::get('fleamarket.data');
        Session::delete('fleamarket.data');
        $fleamarkets = Fleamarkets::forge();
        $fleamarkets->set($data);

        if ($fleamarkets->save()) {
            Response::redirect('fleamarket/thanks');
        } else {
            $this->action_404();
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
        $this->template->title = 'フリマ情報登録完了';
        $this->template->content = View::forge('fleamarket/thanks');
    }

    /**
     * The 404 action for the application.
     *
     * @access  public
     * @return  Response
     */
    public function action_404()
    {
        return Response::forge(View::forge('error/notfound'));
    }

    /**
     *
     * @param type $fieldset
     * @param type $data
     */
    private function set_data($fieldset, $data) {

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

        $fieldset->add('sponsor_name', '主催者')
            ->add_rule('required')
            ->add_rule('max_length', 50);

        $fieldset->add('sponsor_website', '主催者ホームページ')
            ->add_rule('max_length', 250);

        $fieldset->add('sponsor_tel1', '予約受付電話番号')
            ->add_rule('required_tel')
            ->add_rule('valid_tel');
        $fieldset->add('sponsor_tel2', '予約受付電話番号');
        $fieldset->add('sponsor_tel3', '予約受付電話番号');

        $fieldset->add('sponsor_email', '予約受付メールアドレス')
            ->add_rule('valid_email')
            ->add_rule('max_length', 250);

        $fieldset->add('event_date', '開催日')
            ->add_rule('required')
            ->add_rule('valid_date');

        $fieldset->add('event_time_hour', '開催時間')
            ->add_rule('array_key_exists', $this->app['hours']);

        $fieldset->add('event_time_minute', '開催時間')
            ->add_rule('array_key_exists', $this->app['minutes']);

        $fieldset->add('fleamarket_name', 'フリマ・会場名')
            ->add_rule('required')
            ->add_rule('max_length', 50);

        $fieldset->add('zip', '郵便番号')
            ->add_rule('max_length', 7);

        $fieldset->add('prefecture', '都道府県')
            ->add_rule('array_key_exists', $this->app['prefectures']);

        $fieldset->add('address', '住所')
            ->add_rule('max_length', 50);

        $fieldset->add('description', '詳細')
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
