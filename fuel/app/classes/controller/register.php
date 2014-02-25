<?php

class Controller_Register extends Controller_Template
{

    public function before()
    {
        parent::before();
        // 初期処理
        // POSTチェック
        $post_methods = array(
            'index',
            'confirm',
        );
        $method = Uri::segment(2);
        if (Input::method() !== 'POST' && in_array($method, $post_methods)) {
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

        $this->template->title = '楽市楽座会員へ登録確認';
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


        $fieldset->add('name-first', '名',
            array(
            ))
            ->add_rule('required')
            ->add_rule('trim')
            ->add_rule('max_length', 10)
            ->add_rule('valid_string', array('alpha', 'numeric', 'utf8'));

        $fieldset->add('name-last', '姓',
            array(
                'class' => 'pretty_input',
                'rows'  => '5',
            ))
            ->add_rule('required')
            ->add_rule('trim')
            ->add_rule('max_length', 10)
            ->add_rule('valid_string', array('alpha', 'numeric', 'utf8'));

        $fieldset->add('postal-code', '郵便番号',
            array(
                'class' => 'pretty_input',
                'style' => 'ime-mode:disabled',
            ))
            ->add_rule('required')
            ->add_rule('trim')
            ->add_rule('max_length', 10)
            ->add_rule('valid_string', array('alpha', 'numeric', 'utf8'));

        $fieldset->add('address', '住所',
            array(
            ))
            ->add_rule('required');

        $fieldset->add('email', 'Eメール',
            array(
                'type'  => 'email',
                'style' => 'ime-mode:disabled',
                'class' => 'pretty_input'
            ))
            ->add_rule('required')
            ->add_rule('valid_email');

        $fieldset->add('username', 'ニックネーム',
            array(
            ))
            ->add_rule('required')
            ->add_rule('min_length', 4)
            ->add_rule('max_length', 15);


        $fieldset->add('password', 'パスワード',
            array(
                'type'  => 'password',
                'style' => 'ime-mode:disabled',
            ))
            ->add_rule('required')
            ->add_rule('min_length', 6)
            ->add_rule('max_length', 20)
            ->add_rule('valid_string', array('alpha', 'numeric', 'utf8'));


        $fieldset->add('submit', '',
            array(
                'type' => 'submit',
                'value' => '確認'
            ));

        return $fieldset;
    }

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

