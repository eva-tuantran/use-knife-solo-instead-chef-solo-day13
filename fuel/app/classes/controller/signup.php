<?php


class Controller_Signup extends Controller_Template
{

    /**
     * 共通定義を保持
     *
     * @access private
     * @author ida
     */
    private $app = null;


    public function before()
    {
        parent::before();
        $this->app = Config::load('app');

        // POSTチェック
        $post_methods = array(
            'index',
            'confirm',
        );
        $method = Uri::segment(2);
        if (Input::method() !== 'POST' && in_array($method, $post_methods)) {
            Response::redirect('error/forbidden');
        }

        // // ログインチェック
        // $auth_methods = array(
            // 'logined',
            // 'logout',
            // 'update',
        // );
        // if (in_array($method, $auth_methods) && !Auth::check()) {
            // Response::redirect('auth/login');
        // }

        // // ログイン済みチェック
        // $nologin_methods = array(
            // 'login',
        // );

        // if (in_array($method, $nologin_methods) && Auth::check()) {
            // Response::redirect('auth/logined');
        // }

        // CSRFチェック
        // if (Input::method() === 'POST') {
            // if (!Security::check_token()) {
                // Response::redirect('signup/timeout');
            // }
        // }
    }

    public function after($response)
    {
        $response = parent::after($response);

        return $response;
    }

    public function action_index()
    {
        $fieldset = $this->create_fieldset();

        $this->template->title = '楽市楽座ID(無料)を登録する';
        $this->template->content = ViewModel::forge('signup/index');
        $this->template->content->set('html_form', $fieldset->build('signup/confirm'), false);
        $this->template->content->set('errmsg', "");
    }


    public function action_confirm()
    {
        $this->template->title = '楽市楽座ID(無料)を登録する';

        $fieldset = $this->create_fieldset();
        $fieldset->repopulate();
        $validation = $fieldset->validation();

        if(!$validation->run()){
            $this->template->content = ViewModel::forge('signup/index');
            $this->template->content->set('html_form', $fieldset->build('signup/confirm'), false);
            $this->template->content->set('errmsg',  $validation->show_errors(), false);
        } else {
            $this->template->content = ViewModel::forge('signup/confirm');
            $this->template->content->set('user_input', $validation->validated());
        };
    }

    public function action_verify()
    {
        $this->template->title = '楽市楽座ID(無料)を登録する';

        $fieldset = $this->create_fieldset();
        $fieldset->repopulate();
        $validation = $fieldset->validation();

        if(!$validation->run()){
            Response::redirect('error/503');
        } else {
            $this->template->content = ViewModel::forge('signup/verify');
            $user_data = $validation->validated();
            $user_data['register_status'] = \REGISTER_STATUS_INACTIVATED;
            //@TODO: スマートなやり方求む(validate()で取得するとdeleted_atに0がセットされる)
            unset($user_data['deleted_at']);

            try{
                $new_user = Model_User::forge($user_data);
                $new_user->save();
                $new_token = Model_Token::createToken($new_user->user_id);
                self::sendActivateEmail($new_user);
            }catch (Orm\ValidationFailed $e) {
                Response::redirect('error/503');
            }
        };
    }


    public static function sendActivateEmail(Model_User $user)
    {
        $token = Model_Token::findByUserId($user->user_id);

        $data = array(
            'user_name'    => $user->nick_name,
            'activate_url' => 'https://www.rakuichi-rakuza.jp/signup/activate?token='.$token->hash,
        );

        $body = \View::forge('email/signup/activate', $data)->render();

        exit($body);
        //@TODO: メールがVagrantから遅れていないので、メール送信テストが出来ていない
        $user->sendmail('確認メール', $body);
    }


    public function action_activate()
    {
        $hash = Input::get('token');
        if(empty($hash)){
            //トークン以外の処理は全てトップページにリダイレクトします
            Response::redirect('/');
        }

        try{
            $valid_token = Model_Token::findByHash($hash);
            $user = Model_User::find($valid_token->user_id);
            $user->register_status = \REGISTER_STATUS_ACTIVATED;
            $user->save();
            $valid_token->delete();

            Response::redirect('signup/thanks');
        }catch(Exception $e){
            //@TODO: 色々なExceptionを投げ、エラーが分かるように分岐します
            //       (hashが既に有効期限切れなど)

            //トークンが無効な場合などはこちらに遷移します
            Response::redirect('error/503');
        }

        $this->template->title = '楽市楽座ID(無料)を登録する';
        $this->template->content = '認証しています...';

    }

    public function action_thanks()
    {
        $this->template->title = '楽市楽座ID(無料)を登録する';
        $this->template->content = View::forge('signup/thanks');
    }


    public function create_fieldset()
    {
        $fieldset = Fieldset::forge('signup');
        $fieldset = Model_User::getBaseFieldset($fieldset);

        //ユーザの初回会員登録にあたり不要な登録項目は消します
        $fieldset->field('device')->set_type(false);
        $fieldset->field('tel')->set_type(false);
        $fieldset->field('mobile_email')->set_type(false);
        $fieldset->add('submit', '確認', array('type' => 'submit','value' => '確認'));

        return $fieldset;
    }


    public function action_404()
    {
        $this->template->title = 'ページが見つかりません。';
        $this->template->content = ViewModel::forge('auth/404');
    }

    public function action_timeout()
    {
        $this->template->title = '有効期限が切れました。';
        $this->template->content = ViewModel::forge('auth/timeout');
    }

    private function validate_login()
    {
        $validation = Validation::forge();
        $validation->add('username', 'ユーザー名')
        ->add_rule('required')
        ->add_rule('min_length', 4)
        ->add_rule('max_length', 15);
        $validation->add('password', 'パスワード')
        ->add_rule('required')
        ->add_rule('min_length', 6)
        ->add_rule('max_length', 20);
        $validation->run();
        return $validation;
    }

    public function action_login()
    {
        $username = Input::post('username', null);
        $password = Input::post('password', null);
        $result_validate = '';
        if ($username !== null && $password !== null) {
            $validation = $this->validate_login();
            $errors = $validation->error();
            if (empty($errors)) {
                // ログイン認証を行う
                $auth = Auth::instance();
                if ($auth->login($username, $password)) {
                    // ログイン成功
                    Response::redirect('auth/logined');
                }
                $result_validate = "ログインに失敗しました。";
            } else {
                $result_validate = $validation->show_errors();
            }
        }
        $this->template->title = 'ログイン';
        $this->template->content = ViewModel::forge('auth/login');
        $this->template->content->set('errmsg', $result_validate);
    }

    public function action_logout()
    {
        // ログアウト処理
        Auth::logout();
        $this->template->title = 'ログアウト';
        $this->template->content = ViewModel::forge('auth/logout');
    }
}

