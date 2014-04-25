<?php

class Controller_Admin extends Controller_Admin_Base_Template
{
    public function action_index()
    {
        $this->template->content = View::forge('admin/index');
    }

    public function get_login()
    {
        $this->template->content = View::forge('admin/login');
    }

    public function post_login()
    {
        $administrator = Model_Administrator::query()
            ->where('email', Input::param('email'))
            ->where('password', \Auth::hash_password(Input::param('password')))
            ->get_one();

        if ($administrator) {
            Session::set('admin.administrator',$administrator);
            return Response::redirect('/admin/fleamarket/list');
        } else {
            $view = View::forge('admin/login');
            $view->set('failed',true ,false);
            $this->template->content = $view;
        }
    }

    public function action_logout()
    {
        Session::delete('admin.administrator');
        return Response::redirect('admin/login');
    }
}
