<?php 

class Controller_Register extends Controller_Template
{

    public function before()
    {
        parent::before();
        // 初期処理
        // POSTチェック
        $post_methods = array(
            'created',
        );
        $method = Uri::segment(2);
        if (Input::method() !== 'POST' && in_array($method, $post_methods)) {
            Response::redirect('auth/timeout');
        }
        // ログインチェック
        $auth_methods = array(
            'logined',
            'logout',
            'update',
        );
        if (in_array($method, $auth_methods) && !Auth::check()) {
            Response::redirect('auth/login');
        }
        // ログイン済みチェック
        $nologin_methods = array(
            'login',
        );
        if (in_array($method, $nologin_methods) && Auth::check()) {
            Response::redirect('auth/logined');
        }
        // CSRFチェック
        if (Input::method() === 'POST') {
            if (!Security::check_token()) {
                Response::redirect('auth/timeout');
            }
        }
    }

    public function action_index()
    {
        // ユーザー作成
        $this->template->title = '楽市楽座へようこそ';
        $this->template->content = View::forge('register/index');
        $this->template->content->set_safe('errmsg', "");
    }


    public function action_confirm()
    {
        if($this->validate_index()){
            $user = Model_User::forge(array(
                'num' => $val->validated('num'),
                'name' => $val->validated('name'),
                'login_id' => $val->validated('login_id'),
                'password' => $auth->hash_password($val->vaildated('password')),
            ));

            if($user->save()){
                Response::redirect('thanks');
            }
        }
    }


    private function validate_index()
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
        $validation->add('email', 'Eメール')
        ->add_rule('required')
        ->add_rule('valid_email');
        $validation->run();

        return $validation;
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

