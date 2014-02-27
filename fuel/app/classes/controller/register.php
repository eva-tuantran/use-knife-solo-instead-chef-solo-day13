<?php


class Controller_Register extends Controller_Template
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

        // 初期処理
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
                // Response::redirect('register/timeout');
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
        $this->template->content = ViewModel::forge('register/index');

        //@TODO: buildを利用しているので、デザインが上がり次第修正
        $this->template->content->set('html_form', $fieldset->build('register/confirm'), false);
        $this->template->content->set('errmsg', "");
    }


    public function action_confirm()
    {
        $fieldset = $this->create_fieldset();
        $fieldset->repopulate();

        $this->template->title = '楽市楽座ID(無料)を登録する';
        $validation = $fieldset->validation();
        if($validation->run()){
            $this->template->content = ViewModel::forge('register/confirm');
            $this->template->content->set('user_input', $validation->validated());
        } else {
            $this->template->content = ViewModel::forge('register/index');
            $this->template->content->set('html_form', $fieldset->build('register/confirm'), false);
            $this->template->content->set('errmsg',  $validation->show_errors(), false);
        };
    }

    public function action_thanks()
    {
        $fieldset = $this->create_fieldset();
        $fieldset->repopulate();
        $fieldset->validation()->run();

        $this->template->title = '楽市楽座へようこそ';
        $this->template->content = ViewModel::forge('register/pre');
        $this->template->content->set('html_form', $fieldset->build('/register/pre'));
        $this->template->content->set('errmsg', "");
    }

    public function create_fieldset()
    {
        $fieldset = Fieldset::forge('register',
            array('form_attributes' => array('id' => '','class' => ''))
        );


        $fieldset->add(
            'first_name', '名',
            array('type' => 'text'),
            array(array('required'), array('max_length', 10))
        );

        $fieldset->add(
            'last_name', '姓',
            array('type' => 'text'),
            array(array('required'), array('max_length', 10))
        );

        $fieldset->add(
            'first_name_kana', 'メイ',
            array('type' => 'text'),
            array(array('required'), array('max_length', 10))
        );

        $fieldset->add(
            'last_name_kana', 'セイ',
            array('type' => 'text'),
            array(array('required'), array('max_length', 10))
        );


        $fieldset->add(
            'prefecture', '都道府県',
            array('type' => 'select', 'options' => $this->app['prefectures']),
            array(array('array_key_exists', $this->app['prefectures']))
        );
        $fieldset->add(
            'address', '住所',
            array('type' => 'text'),
            array(array('required'), array('max_length', 50))
        );

        $fieldset->add(
            'zip', '郵便番号',
            array('type' => 'text', 'class' => 'pretty_input', 'style' => 'ime-mode:disabled'),
            array(array('valid_string', array('alpha', 'numeric', 'utf8')))
        );

        $fieldset->add(
            'email', 'Eメール',
            array('type'  => 'email', 'style' => 'ime-mode:disabled', 'class' => 'pretty_input'),
            array(array('required'), array('valid_email'))
        );


        $fieldset->add(
            'password', 'パスワード',
            array('type'  => 'password', 'style' => 'ime-mode:disabled',),
            array(array('required'), array('min_length', 6), array('max_length', 20), array('valid_string', array('alpha', 'numeric', 'utf8')))
        );

        $fieldset->add('submit', '',
            array(
                'type' => 'submit',
                'value' => '確認'
            ));

        return $fieldset;
    }




    // public function action_confirm()
    // {
        // if($this->validate_index()){
            // $user = Model_User::forge(array(
                // 'num' => $val->validated('num'),
                // 'name' => $val->validated('name'),
                // 'login_id' => $val->validated('login_id'),
                // 'password' => $auth->hash_password($val->vaildated('password')),
            // ));

            // if($user->save()){
                // Response::redirect('thanks');
            // }
        // }
    // }


    public function action_created()
    {
        // ユーザー登録
        $validation = $this->validate_create();
        $errors = $validation->error();
        try {
            if (empty($errors)) {
                $auth = Auth::instance();
                $input = $validation->input();
                if ($auth->create_user($input['username'], $input['password'], $input['email'])) {
                    $this->template->title = 'ユーザー登録完了';
                    $this->template->content = ViewModel::forge('auth/created');
                    return;
                }
                $result_validate = 'ユーザー作成に失敗しました。';
            } else {
                $result_validate = $validation->show_errors();
            }
        } catch (SimpleUserUpdateException $e) {
            $result_validate = $e->getMessage();
        }
        $this->template->title = 'ユーザー作成';
        $this->template->content = ViewModel::forge('auth/create');
        $this->template->content->set('errmsg', $result_validate);
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

