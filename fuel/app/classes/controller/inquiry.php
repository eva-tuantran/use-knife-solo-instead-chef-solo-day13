<?php

/**
 * Controller_Inquiry
 *
 * @extends  Controller_Template
 * @author
 */

class Controller_Inquiry extends Controller_Template
{
    /**
     * index
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $this->template->title   = 'title';
        $this->template->content = View::forge('inquiry/index');
        //$this->set_fields();
        $fieldset = $this->create_fieldset();
        $this->template->content->set_safe('fieldset', $fieldset);
    }
    /**
     * confirm
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        $fieldset = $this->create_fieldset();
        $validation = $fieldset->validation();

        if(! $validation->run() ){
            $fieldset->repopulate();
            $this->template->title   = 'title';
            $this->template->content = View::forge('inquiry/index');
            $this->template->content->set_safe('fieldset', $fieldset);
        }else{
            $this->template->title   = 'title';
            $this->template->content = View::forge('inquiry/confirm');
            Session::set_flash('inquiry',array(
                'data' => $validation->validated(),
            ));
        }
    }

    public function action_thanks()
    {
        $this->register_contact();
        $this->sendmail_to_user();
        $this->template->title   = 'title';
        $this->template->content = View::forge('inquiry/thanks');
    }

    private function create_fieldset()
    {
        $contact = Model_Contact::forge();
        $fieldset = Fieldset::forge();
        $fieldset->add_model($contact);
        $fieldset->add('submit','',array('type' => 'submit','value' => '確認'));
        $fieldset->add('email2','メールアドレス確認用',array(
            'type' => 'text',
        ));
        $fieldset->field('email2')
            ->add_rule('required')
            ->add_rule('match_field','email');
        return $fieldset;
    }

    private function register_contact()
    {
    }

    private function sendmail_to_user()
    {
    }
}
