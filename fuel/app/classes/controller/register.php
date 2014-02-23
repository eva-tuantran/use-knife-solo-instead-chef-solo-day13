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

    public function action_index()
    {
        $form = $this->form_register();

        $this->template->title = '楽市楽座ID(無料)を登録する';
        $this->template->content = View::forge('register/index');
        $this->template->content->set_safe('html_form', $form->build('register/confirm'));
        $this->template->content->set_safe('errmsg', "");
    }

    public function action_confirm()
    {
        $form = $this->form_register();
        $form->repopulate();

        $this->template->title = '楽市楽座会員へ登録確認';
        $validation = $form->validation();
        if($validation->run()){
            $data['input'] = $validation->validated();
            $this->template->content = View::forge('register/confirm', $data);
        } else {
            $this->template->content = View::forge('register/index');
            $this->template->content->set_safe('html_form', $form->build('register/confirm'));
            $this->template->content->set_safe('errmsg',  $validation->show_errors());
        };
    }

    public function action_thanks()
    {
        $form = $this->form_register();
        $form->repopulate();
        $form->validation()->run();

        $this->template->title = '楽市楽座へようこそ';
        $this->template->content = View::forge('register/pre');
        $this->template->content->set_safe('html_form', $form->build('/register/pre'));
        $this->template->content->set_safe('errmsg', "");
    }

    public function form_register()
    {
        $form = \Fieldset::forge('register',
            array('form_attributes' => array('id' => '','class' => ''))
        );


        $form->add('name-first', '名',
            array(
            ))
            ->add_rule('required')
            ->add_rule('trim')
            ->add_rule('max_length', 10)
            ->add_rule('valid_string', array('alpha', 'numeric', 'utf8'));

        $form->add('name-last', '姓',
            array(
                'class' => 'pretty_input',
                'rows'  => '5',
            ))
            ->add_rule('required')
            ->add_rule('trim')
            ->add_rule('max_length', 10)
            ->add_rule('valid_string', array('alpha', 'numeric', 'utf8'));

        $form->add('postal-code', '郵便番号',
            array(
                'class' => 'pretty_input',
                'style' => 'ime-mode:disabled',
            ))
            ->add_rule('required')
            ->add_rule('trim')
            ->add_rule('max_length', 10)
            ->add_rule('valid_string', array('alpha', 'numeric', 'utf8'));

        $form->add('address', '住所',
            array(
            ))
            ->add_rule('required');

        $form->add('email', 'Eメール',
            array(
                'type'  => 'email',
                'style' => 'ime-mode:disabled',
                'class' => 'pretty_input'
            ))
            ->add_rule('required')
            ->add_rule('valid_email');

        $form->add('username', 'ニックネーム',
            array(
            ))
            ->add_rule('required')
            ->add_rule('min_length', 4)
            ->add_rule('max_length', 15);


        $form->add('password', 'パスワード',
            array(
                'type'  => 'password',
                'style' => 'ime-mode:disabled',
            ))
            ->add_rule('required')
            ->add_rule('min_length', 6)
            ->add_rule('max_length', 20)
            ->add_rule('valid_string', array('alpha', 'numeric', 'utf8'));


        $form->add('submit', '',
            array(
                'type' => 'submit',
                'value' => '確認'
            ));

        return $form;
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
                    $this->template->content = View::forge('auth/created');
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
        $this->template->content = View::forge('auth/create');
        $this->template->content->set_safe('errmsg', $result_validate);
    }


    public function action_404()
    {
        $this->template->title = 'ページが見つかりません。';
        $this->template->content = View::forge('auth/404');
    }

    public function action_timeout()
    {
        $this->template->title = '有効期限が切れました。';
        $this->template->content = View::forge('auth/timeout');
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
        $this->template->content = View::forge('auth/login');
        $this->template->content->set_safe('errmsg', $result_validate);
    }

    public function action_logout()
    {
        // ログアウト処理
        Auth::logout();
        $this->template->title = 'ログアウト';
        $this->template->content = View::forge('auth/logout');
    }
}

