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
     * 初期画面
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function action_index()
    {
        Asset::js('http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js', array(), 'add_js');
        $fieldset = self::createFieldset();
        $this->template->content = View::forge('signup/index');
        $this->template->content->set('prefectures', Config::get('master.prefectures'));
        $this->template->content->set('input', $fieldset->input());
        $this->template->content->set('error', $fieldset->validation()->error_message());
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
        $validation = $fieldset->validation();

        Session::set_flash('signup.fieldset', $fieldset);
        if (! $validation->run()) {
            return \Response::redirect('signup');
        } else {
            $this->template->content = View::forge('signup/confirm');
            $this->template->content->set('input', $fieldset->input());
        };
    }

    /**
     * 仮登録完了画面
     * ユーザ登録実行後、アクティベートURLを含む認証メールをユーザに送付します
     * ユーザ作成箇所につきこの箇所のみCSRFチェックを実行いたします。
     *
     * @todo エラーメッセージのview側への組み込み
     * @todo 検討: emailにunique制約が入っており、ここで中途半端にページを閉じると同じIDで登録できない
     * @todo confirmでリロードした後にこの画面に遷移すると、passwordがとれずユーザが発行されない
     * @todo ユーザの作成からトークン発行までをtransaction処理にする
     * @author shimma
     * @access public
     * @return void
     */
    public function post_verify()
    {
        if (! Security::check_token()) {
            throw new SystemException('E00002');
        }

        $fieldset = self::createFieldset();
        $properties = array_filter($fieldset->validation()->validated(), 'strlen');

        try {
            $new_user = Model_User::createNewUser($properties['email'], $properties['password'], $properties);
            $new_token = Model_Token::generate($new_user->user_id);
            $email_template_params = array(
                'nick_name'    => $new_user->nick_name,
                'activate_url' => $new_token->getActivationUrl(),
            );
            $new_user->sendmail('signup/verify', $email_template_params);
        } catch (Exception $e) {
            throw $e;
        }

        $this->template->content = View::forge('signup/verify');
        $this->template->content->set('user_input', $properties);
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
            return \Response::redirect('/');
        }

        try {
            $valid_token = Model_Token::findByHash($hash);
            $user = Model_User::find($valid_token->user_id);
            $user->activate();
            $valid_token->delete();
            $email_template_params = array(
                'nick_name' => $user->nick_name,
            );
            $user->sendmail('signup/activate', $email_template_params);
        } catch (Exception $e) {
            return \Response::redirect('error/503');
        }

        \Auth::force_login($user->user_id);
        return \Response::redirect('signup/thanks');
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
        $this->template->content = View::forge('signup/thanks');
        $this->setLazyRedirect('/');
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
            $fieldset = Model_User::createFieldset();

            $fieldset->add('email2', 'メールアドレス確認用')
                ->add_rule('required')
                ->add_rule('match_field', 'email');

            $fieldset->add('password2', 'パスワード確認用')
                ->add_rule('required')
                ->add_rule('match_field', 'password');

            $fieldset->add('terms', '利用規約')
                ->add_rule('required');

            $fieldset->field('device')->set_type(false);
            $fieldset->field('tel')->set_type(false);
            $fieldset->field('mobile_email')->set_type(false);
        }

        $fieldset->repopulate();
        return $fieldset;
    }

}
