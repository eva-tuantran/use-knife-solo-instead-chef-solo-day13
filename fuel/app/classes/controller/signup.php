<?php

/**
 * 新規ユーザ登録
 *
 * @author Ricky <master@mistdev.com>
 */
class Controller_Signup extends Controller_Template
{

    //SSL設定の項目です。テスト期間につきSSLは利用していません。
    // public $_secure = array('index', 'auth');

    /**
     * 各アクション共通実行項目
     *
     * @access public
     * @return void
     * @todo 既にログインしているユーザに対して、会員IDを発行できるようにするのか確認
     * @todo タイムアウト時間の確認
     */
    public function before()
    {
        parent::before();
    }

    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $fieldset = $this->createFieldset();

        $this->template->title = '楽市楽座ID(無料)を登録する';
        $this->template->content = ViewModel::forge('signup/index');
        $this->template->content->set('html_form', $fieldset->build('signup/confirm'), false);
        $this->template->content->set('errmsg', '');
    }

    /**
     * ユーザ入力項目確認画面
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        if (Input::method() !== 'POST') {
            Response::redirect('/');
        }

        $fieldset = $this->createFieldset();
        $fieldset->repopulate();
        $validation = $fieldset->validation();

        $this->template->title = '楽市楽座ID(無料)を登録する';
        if (!$validation->run()) {
            $this->template->content = ViewModel::forge('signup/index');
            $this->template->content->set('html_form', $fieldset->build('signup/confirm'), false);
            $this->template->content->set('errmsg',  $validation->show_errors(), false);
        } else {
            $this->template->content = ViewModel::forge('signup/confirm');
            $this->template->content->set('user_input', $validation->validated());
        };
    }

    /**
     * 仮登録完了画面
     * ユーザ登録実行後、アクティベートURLを含む認証メールをユーザに送付します
     * ユーザ作成箇所につきこの箇所のみCSRFチェックを実行いたします。
     *
     * @todo エラーメッセージのview側への組み込み
     * @todo 検討: emailにunique制約が入っており、ここで中途半端にページを閉じると同じIDで登録できない
     * @access public
     * @return void
     */
    public function action_verify()
    {
        if (Input::method() !== 'POST') {
            Response::redirect('/');
        }

        if (!Security::check_token()) {
            Response::redirect('signup/timeout');
        }

        $fieldset = $this->createFieldset();
        $fieldset->repopulate();
        $validation = $fieldset->validation();

        if (!$validation->run()) {
            $this->template->content->set('errmsg',  $validation->show_errors(), false);
        } else {
            $user_data = $validation->validated();
            $user_data['password']        = \Auth::hash_password($user_data['password']);
            $user_data['register_status'] = \REGISTER_STATUS_INACTIVATED;

            try {
                $new_user = Model_User::forge($user_data);
                $new_user->save();
                $new_token = Model_Token::createToken($new_user->user_id);
                self::sendActivateEmail($new_user);
            } catch (Orm\ValidationFailed $e) {
                $this->template->content->set('errmsg',  $e->getMessage(), false);
            }
        };

        $this->template->title = '楽市楽座ID(無料)を登録する';
        $this->template->content = ViewModel::forge('signup/verify');
    }

    /**
     * 該当ユーザへアクティベートメールの配信
     * tokenテーブルをチェックし、該当するトークンURLを含むメールを配信します
     *
     * @todo 仮想環境(vagrant)上からメール送信が出来ていないので、そこが確認できていない
     * @param  Model_User $user
     * @access public
     * @return bool
     */
    public static function sendActivateEmail(Model_User $user)
    {
        $valid_token = Model_Token::findByUserId($user->user_id);

        if (empty($valid_token)) {
            return false;
        }

        $data = array(
            'nick_name'    => $user->nick_name,
            'activate_url' => Uri::base().'signup/activate?token='.$valid_token->hash,
        );

        $body = View::forge('email/signup/activate', $data)->render();

        //@todo 以下要修正
        exit($body);
        $user->sendmail('確認メール', $body);
    }

    /**
     * Emailアドレス認証
     * 発行されたトークンを認証し、会員DBのユーザステータスを仮登録から認証済みに変更します
     *
     * @todo 検討: 夫々の処理でエラーが発生した際にどのようにユーザ側に見える表示するのか
     * @todo エラーのリダイレクト先を共通コントローラ完成後修正
     * @access public
     * @return void
     */
    public function action_activate()
    {
        $hash = Input::get('token');
        if (empty($hash)) {
            Response::redirect('/');
        }

        try {
            $valid_token = Model_Token::findByHash($hash);
            $user = Model_User::find($valid_token->user_id);
            $user->register_status = \REGISTER_STATUS_ACTIVATED;
            $user->save();
            $valid_token->delete();
            Response::redirect('signup/thanks');
        } catch (Exception $e) {
            Response::redirect('error/503');
        }

        $this->template->title = '楽市楽座ID(無料)を登録する';
        $this->template->content = '認証しています...';
    }

    /**
     * ユーザ登録完了画面
     *
     * @access public
     * @return void
     */
    public function action_thanks()
    {
        $this->template->title = '楽市楽座ID(無料)を登録する';
        $this->template->content = View::forge('signup/thanks');
    }

    /**
     * タイムアウト画面。基本的にverifyのCSRFでチェック失敗した時に飛びます。
     *
     * @access public
     * @return void
     */
    public function action_timeout()
    {
        $this->template->title = '楽市楽座ID(無料)を登録する';
        $this->template->content = View::forge('signup/timeout');
    }

    /**
     * フォーム項目作成
     * Model_Userに記載されたデフォルトの登録項目で不要な箇所をfalseにして非表示にします
     *
     * @access public
     * @return Fieldset $fieldset
     */
    public function createFieldset()
    {
        $fieldset = Fieldset::forge('signup');
        $fieldset = Model_User::getBaseFieldset($fieldset);

        $fieldset->field('device')->set_type(false);
        $fieldset->field('tel')->set_type(false);
        $fieldset->field('mobile_email')->set_type(false);
        $fieldset->add('submit', '確認', array('type' => 'submit','value' => '確認'));

        return $fieldset;
    }

}
