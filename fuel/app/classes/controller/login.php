<?php


class Controller_Login extends Controller_Template
{

    public function before()
    {
        parent::before();
    }


    public function after($response)
    {
        $response = parent::after($response);

        return $response;
    }


    //@TODO: rurlの実装(認証が必要なページでリダイレクト仕返してくれるgetのパラメータ)
    //       ただしループにならないように実装を気をつけること
    //@TODO: sslを利用した強制リダイレクト実装
    public function action_index()
    {
        $this->template->title = 'Login';
        $this->template->content = View::forge('login/index');
    }


    //@TODO: index_actionとの統合(logintestの廃止)
    //@TODO: Authチェックのエラーの表示(set_flashを利用して作成出来るはず)
    public function action_logintest()
    {
        //すでにログイン済みの人は下記のURLに流し込む
        //@TODO: ここの完成
        if(Auth::check()){
            exit(Auth::get_screen_name() . 'さん。既にログイン済みです');
            Response::redirect($this->get_groups_redirect_path());
        }

        //@TODO: ここの完成
        //POST以外の人はトップページに飛ばします
        if (Input::method() != 'POST') {
            Response::redirect('/');
        };

        $validation = Validation::forge();
        $validation->add('email', 'Email')->add_rule('required');
        $validation->add('password', 'Password')->add_rule('required');
        if ($validation->run()) {
            if (Auth::instance()->login(Input::post('email'), Input::post('password'))) {
                // $current_user = Model_User::find_by_username(Auth::get_screen_name());
                // Session::set_flash('success', e('Welcome, '.$current_user->username));

                // Response::redirect($this->get_groups_redirect_path());
                exit(Auth::get_screen_name()."さん、ログイン成功しました");
            }
            // Session::set_flash('error', e('login error. please try agein'));
        }

        $this->template->title   = 'Login';
        $this->template->content = '認証に失敗しました';
        // $this->template->content = View::forge('admin/login')->set('val', $validation, false);
    }


    //@TODO: URLを遷移すると強制的にログアウトするので何らかのリファラをチェックしたい
    //@TODO: 名前を決める
    public function action_out()
    {
        if(!Auth::logout())
        {
            Session::set_flash('info', e('logout success'));
            Response::redirect('login');
        }
    }


    //@TODO: ある程度確認出来たら削除
    public function action_test()
    {
        Auth::check();
        exit(Auth::get_screen_name());
    }


    //@TODO: 実装としてこちらを利用するか確認(ユーザの属性ごとにリダイレクト先を変更する)
    public function get_groups_redirect_path()
    {
        $groups = Auth::instance()->get_groups();
        $group = $groups[0][1];

        $redirect_path = '/';

        return $redirect_path;
    }
}
