<?php

/**
 * 新規ユーザ登録
 *
 */
class Controller_Signup extends Controller_Base_Template
{

    protected $_secure_actions = array(
        'index',
        'confirm',
        'verify',
        'activate',
        'auth',
    );

    protected $_nologin_actions = array(
        'index',
        'confirm',
        'verify',
        'activate',
        'auth',
    );

    /**
     * 各アクション共通実行項目
     *
     * @todo 既にログインしているユーザに対して、会員IDを発行できるようにするのか確認
     * @todo タイムアウト時間の確認
     * @access public
     * @return void
     * @author shimma
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
     * @author shimma
     */
    public function action_index()
    {
        $fieldset = self::createFieldset();

        $this->setMetaTag('signup/index');
        $this->template->content = View::forge('signup/index');
        $this->template->content->set('html_form', $fieldset->build('signup/confirm'), false);
        $this->template->content->set('errmsg', $fieldset->validation()->show_errors(), false);
    }

    /**
     * ユーザ入力項目確認画面
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function post_confirm()
    {
        $fieldset = self::createFieldset();
        $fieldset->repopulate();
        $validation = $fieldset->validation();

        $this->setMetaTag('signup/confirm');

        Session::set_flash('signup.fieldset', $fieldset);
        if (! $validation->run()) {
            return \Response::redirect('signup');
        } else {
            $this->template->content = View::forge('signup/confirm');
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
     * @author shimma
     * @access public
     * @return void
     */
    public function post_verify()
    {
        if (! Security::check_token()) {
            return \Response::redirect('errors/doubletransmission');
        }

        $fieldset = self::createFieldset();
        $user_data = $fieldset->validation()->validated();
        $user_data['password']        = \Auth::hash_password($user_data['password']);
        $user_data['register_status'] = \REGISTER_STATUS_INACTIVATED;

        try {
            $new_user = Model_User::forge($user_data);
            $new_user->save();

            $new_token = Model_Token::generate($new_user->user_id);
            $data = array(
                'nick_name'    => $new_user->nick_name,
                'activate_url' => Uri::base().'signup/activate?token='.$new_token->hash,
            );

            $body = View::forge('email/signup/activate', $data)->render();
            $new_user->sendmail('確認メール', $body);
        } catch (Orm\ValidationFailed $e) {
            return \Response::redirect('errors/timeout');
        }

        $this->setMetaTag('signup/verify');
        $this->template->content = View::forge('signup/verify');
        $this->template->content->set('user_input', $user_data);
    }

    /**
     * Emailアドレス認証
     * 発行されたトークンを認証し、会員DBのユーザステータスを仮登録から認証済みに変更します
     *
     * @todo 検討: 夫々の処理でエラーが発生した際にどのようにユーザ側に見える表示するのか
     * @todo エラーのリダイレクト先を共通コントローラ完成後修正
     * @author shimma
     * @access public
     * @return void
     */
    public function get_activate()
    {
        $hash = Input::get('token');
        if (empty($hash)) {
            return Response::redirect('/');
        }

        try {
            $valid_token = Model_Token::findByHash($hash);
            $user = Model_User::find($valid_token->user_id);
            $user->register_status = \REGISTER_STATUS_ACTIVATED;
            $user->save();
            $valid_token->delete();
            return Response::redirect('signup/thanks');
        } catch (Exception $e) {
            return Response::redirect('error/503');
        }
    }

    /**
     * ユーザ登録完了画面
     *
     * @author shimma
     * @access public
     * @return void
     */
    public function action_thanks()
    {
        $this->setMetaTag('signup/thanks');
        $this->template->content = View::forge('signup/thanks');
    }

    /**
     * フォーム項目作成
     * Model_Userに記載されたデフォルトの登録項目で不要な箇所をfalseにして非表示にします
     *
     * @access public
     * @return Fieldset $fieldset
     * @author shimma
     */
    public static function createFieldset()
    {
        $fieldset = Session::get_flash('signup.fieldset');

        if (! $fieldset) {
            $fieldset = Fieldset::forge('signup');
            $fieldset = Model_User::getBaseFieldset($fieldset);

            $fieldset->field('device')->set_type(false);
            $fieldset->field('tel')->set_type(false);
            $fieldset->field('mobile_email')->set_type(false);
        }

        return $fieldset;
    }

}
