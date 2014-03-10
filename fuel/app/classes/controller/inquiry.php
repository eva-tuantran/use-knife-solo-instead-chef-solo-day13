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

        $fieldset = $this->get_fieldset();
        $this->template->content->set_safe('html_form', $fieldset->build('/inqury/confirm'),false);
    }
    /**
     * confirm
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        $this->template->title   = 'title';
        $this->template->content = View::forge('inquiry/confirm');
    }

    private function get_fieldset()
    {
        $fieldset = Fieldset::forge();

        $fieldset->add('inquiry_type','お問い合わせの種類',array('options' => 
                array(
                    1 => 1,
                    2 => 2
                ),'type' => 'select'))
            ->add_rule('required')
            ->add_rule('numeric_min',1)
            ->add_rule('numeric_max',10);
        
        $fieldset->add('subject','件名')
            ->add_rule('required')
            ->add_rule('max_length',255);
        
        $fieldset->add('email','メールアドレス')
            ->add_rule('required')
            ->add_rule('valid_email')
            ->add_rule('max_length',255);
        
        $fieldset->add('tel','電話番号')
            ->add_rule('required')
            ->add_rule('max_legnth',20);
        
        $fieldset->add('contents','お問い合わせ内容',array('type' => 'textarea', 'cols' => 70, 'rows' => 6))
            ->add_rule('required');

        return $fieldset;
    }
}
