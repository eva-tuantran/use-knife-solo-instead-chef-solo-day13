<?php

/**
 * Fleamarket Controller.
 *
 * @extends  Controller_Template
 */
class Controller_Fleamarket extends Controller_Template
{

    /**
     * フリマ登録画面表示
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        $this->template->title = 'フリマ登録';
        $this->template->content = View::forge('fleamarket/index');
    }

    /**
     * A typical "Hello, Bob!" type example.  This uses a ViewModel to
     * show how to use them.
     *
     * @access  public
     * @return  Response
     */
    public function action_confirm()
    {
        return Response::forge(ViewModel::forge('welcome/hello'));
    }

    /**
     * The 404 action for the application.
     *
     * @access  public
     * @return  Response
     */
    public function action_thanks()
    {
        return Response::forge(ViewModel::forge('welcome/404'), 404);
    }

    /**
     * 新規登録のバリデーションをセット
     */
    private function validate_create()
    {
        // 入力チェック
        $validation = Validation::forge();
        $validation->add('sponsor_name', '主催者')
            ->add_rule('required')
            ->add_rule('max_length', 50);
        $validation->add('sponsor_website', '主催者ホームページ')
            ->add_rule('max_length', 255);
        $validation->add('sponser_tel', '予約受付電話番号')
            ->add_rule('valid_tel');
        $validation->add('valid_email', '予約受付メールアドレス')
            ->add_rule('valid_tel');
        $validation->add('event_date', '開催日')
            ->add_rule('required')
            ->add_rule('valid_date');
        $validation->add('event_time', '開催時間')
            ->add_rule('valid_time');

        return $validation;
    }
}
