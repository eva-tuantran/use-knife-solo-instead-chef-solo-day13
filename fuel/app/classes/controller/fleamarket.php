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
        $this->template->title = 'フリマ情報入力';
        $view = View::forge('fleamarket/index');
        $view->set_safe('form', $this->create_fieldset()->form());

        $this->template->content = $view;
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
        if ($validation->run()) {
            $data = $validation->validated();
            Session::set('fleamarket.data', $data);

            $this->template->title = 'フリマ情報確認';
            $view = View::forge('fleamarket/confirm');
            $view->set_safe('form', $fieldset->form());
            $view->set_safe('data', $data);
        } else {
            $this->template->title = 'フリマ情報入力';
            $view = View::forge('fleamarket/index');
            $view->set_safe('form', $fieldset->form());
            $view->set_safe('errors', $validation->error());
        }

        $this->template->content = $view;
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

        $data = Session::get('fleamarket.data');
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
        return Response::forge(ViewModel::forge('welcome/404'), 404);
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
        // 入力チェック
        $fieldset = Fieldset::forge('fleamarket');
        $fieldset->add(
            'sponsor_name', '主催者',
            array('type' => 'text'),
            array(array('required'), array('max_length', 50))
        );
        $fieldset->add(
            'sponsor_website', '主催者ホームページ',
            array('type' => 'text')
        );
        $fieldset->add(
            'sponser_tel1', '予約受付電話番号',
            array('type' => 'text', 'maxlength' => 4),
            array('is_numeric')
        );
        $fieldset->add(
            'sponser_tel2', '',
            array('type' => 'text', 'maxlength' => 4),
            array('is_numeric')
        );
        $fieldset->add(
            'sponser_tel3', '',
            array('type' => 'text', 'maxlength' => 4),
            array('is_numeric')
        );
        $fieldset->add(
            'sponser_email', '予約受付メールアドレス',
            array('type' => 'text'),
            array(array('valid_email'), array('max_length', 250))
        );
        $fieldset->add(
            'event_date', '開催日時',
            array('type' => 'text'),
            array(array('required'), array('valid_date'))
        );
        $fieldset->add(
            'event_time_hour', '',
            array('type' => 'select', 'options' => $this->app['hours']),
            array(array('array_key_exists', $this->app['hours']))
        );
        $fieldset->add(
            'event_time_minute', '',
            array('type' => 'select', 'options' => $this->app['minutes']),
            array(array('array_key_exists', $this->app['minutes']))
        );
        $fieldset->add(
            'fleamarket_name', 'フリマ・会場名',
            array('type' => 'text'),
            array(array('required'), array('max_length', 50))
        );
        $fieldset->add(
            'zip', '郵便番号',
            array('type' => 'text')
        );
        $fieldset->add(
            'prefecture', '都道府県',
            array('type' => 'select', 'options' => $this->app['prefectures']),
            array(array('array_key_exists', $this->app['prefectures']))
        );
        $fieldset->add(
            'address', '住所',
            array('type' => 'text'),
            array(array('max_length', 50))
        );
        $fieldset->add(
            'description', '詳細',
            array('type' => 'textarea'),
            array(array('max_length', 5000))
        );
        $fieldset->add(
            'about_access', '最寄り駅または交通アクセス',
            array('type' => 'textarea'),
            array(array('max_length', 500))
        );
        $fieldset->add(
            'about_event_time', '開催時間について',
            array('type' => 'textarea'),
            array(array('max_length', 500))
        );
        $fieldset->add(
            'about_booth', '募集ブース数について',
            array('type' => 'textarea'),
            array(array('max_length', 500))
        );
        $fieldset->add(
            'about_shop_cautions', '出店に際してのご注意',
            array('type' => 'textarea'),
            array(array('max_length', 500))
        );
        $fieldset->add(
            'about_shop_style', '出店形態について',
            array('type' => 'textarea'),
            array(array('max_length', 500))
        );
        $fieldset->add(
            'about_shop_fee', '出店料金について',
            array('type' => 'textarea'),
            array(array('max_length', 500))
        );
        $fieldset->add(
            'about_parking', '駐車場について',
            array('type' => 'textarea'),
            array(array('max_length', 500))
        );
        $fieldset->add('confirm', '', array('type'=>'submit', 'value' => '確認'));

        return $fieldset;
    }
}
