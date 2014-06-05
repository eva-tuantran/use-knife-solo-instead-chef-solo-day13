<?php

/**
 * パスワード忘れた人
 *
 * @author shimma
 */
class Controller_Reminder extends Controller_Base_Template
{
    protected $_secure_actions = array(
        'index',
        'submit',
        'change',
        'resetpassword',
        'thanks',
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
        $data = array(
            'info_message'  => '',
            'error_message' => '',
        );

        $fieldset = self::createFieldset();
        $status = Session::get_flash('status');
        $data['info_message'] = $this->getStatusMessage($status);

        $this->template->content = View::forge('reminder/index', $data);
        $this->template->content->set('input', $fieldset->input());
        $this->template->content->set('error', $fieldset->validation()->error_message());
    }

    /**
     * リマインダメール送信
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function post_submit()
    {
        if (! Security::check_token()) {
            return \Response::redirect('errors/doubletransmission');
        }

        $fieldset = self::createFieldset();
        $validation = $fieldset->validation();
        Session::set_flash('reminder.email.fieldset', $fieldset);

        if (! $validation->run()) {
            return \Response::redirect('/reminder');
        }


        try {
            $reset_user = Model_User::find('last', array(
                'where' => array(
                    array('email' => $fieldset->input('email')),
                ),
            ));

            if ($reset_user) {
                $new_token = Model_Token::generate($reset_user->user_id);
                $email_template_params = array(
                    'nick_name'          => $reset_user->nick_name,
                    'reset_password_url' => $new_token->getVelificationUrl('reset_password'),
                );
                $reset_user->sendmail('reminder/submit', $email_template_params);
            }
        } catch (Orm\ValidationFailed $e) {
            return \Response::redirect('errors/timeout');
        }

        $this->template->content = View::forge('reminder/submit');
    }

    /**
     * activate
     * トークンの内容を確認します
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function action_change()
    {
        $hash = Input::get('token');
        if (empty($hash)) {
            return \Response::redirect('errors/forbidden');
        }

        $valid_token = Model_Token::findByHash($hash);
        if (! $valid_token) {
            return \Response::redirect('errors/forbidden');
        }

        $fieldset_password = self::createFieldsetPassword();
        $this->template->content = View::forge('reminder/change');
        $this->template->content->set('hash', $hash);
        $this->template->content->set('input', $fieldset_password->input());
        $this->template->content->set('error', $fieldset_password->validation()->error_message());
    }


    /**
     * パスワードの変更を行います
     *
     * @author shimma
     * @access public
     * @return void
     */
    public function post_resetpassword()
    {
        $hash = Input::get('token');
        $valid_token = Model_Token::findByHash($hash);


        if (! Security::check_token() || empty($hash) || ! $valid_token) {
            return \Response::redirect('errors/forbidden');
        }

        $fieldset_password = self::createFieldsetPassword();
        $validation = $fieldset_password->validation();
        Session::set_flash('reminder.password.fieldset', $fieldset_password);

        if (! $validation->run()) {
            return \Response::redirect('/reminder/change?token='. $hash);
        }

        try {
            $user = Model_User::find($valid_token->user_id);
            $user->setPassword($fieldset_password->input('password'));
            $user->save();
            $valid_token->delete();

            return \Response::redirect('reminder/thanks');
        } catch (Exception $e) {
            return \Response::redirect('errors/forbidden');
        }
    }


    /**
     * パスワード変更登録完了画面
     *
     * @author shimma
     * @access public
     * @return void
     */
    public function action_thanks()
    {
        $this->template->content = View::forge('reminder/thanks');
        $this->setLazyRedirect('/');
    }


    /**
     * reminder送信用のFieldsetをレスポンスします
     *
     * @access public
     * @return Fieldset fieldset
     * @author shimma
     */
    public function createFieldset()
    {
        $fieldset = Session::get_flash('reminder.email.fieldset');

        if (! $fieldset) {
            $fieldset = \Fieldset::forge('reminder.email');
            $fieldset->add('email', 'Email')
                ->add_rule('required')
                ->add_rule('valid_email');
        }

        $fieldset->repopulate();
        return $fieldset;
    }


    /**
     * パスワード変更用のFieldsetをレスポンスします
     *
     * @access public
     * @return Fieldset fieldset
     * @author shimma
     *
     * ちゃんとmin_lengthが動いているか確認
     */
    public function createFieldsetPassword()
    {
        $fieldset = Session::get_flash('reminder.password.fieldset');

        if (! $fieldset) {
            $fieldset = \Fieldset::forge('reminder.password');
            $fieldset->add('password', 'Passowrd')
                ->add_rule('required')
                ->add_rule('min_length', '6')
                ->add_rule('max_length', '50');
            $fieldset->add('password2', 'Passowrd2')
                ->add_rule('required')
                ->add_rule('match_field', 'password');
        }

        $fieldset->repopulate();
        return $fieldset;
    }


}

