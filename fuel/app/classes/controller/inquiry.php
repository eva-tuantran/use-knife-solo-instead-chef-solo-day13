<?php

/**
 * お問い合わせフォーム
 *
 * @extends  Controller_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Inquiry extends Controller_Template
{
    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $this->template->title   = 'お問い合わせ';
        $view = View::forge('inquiry/index');
        $fieldset = $this->createFieldset();
        $view->set('fieldset', $fieldset, false);
        $this->template->content = $view;
    }
    /**
     * 確認画面
     *
     * @access public
     * @return void
     */
    public function action_confirm()
    {
        $fieldset = $this->createFieldset();
        $validation = $fieldset->validation();

        if(! $validation->run() ){
            $fieldset->repopulate();
            $this->template->title   = 'お問い合わせ';
            $view = View::forge('inquiry/index');
        }else{
            $this->template->title   = 'お問い合わせ';

            $validated = $validation->validated();

            $view = View::forge('inquiry/confirm');
            $view->set('input', $validated,false);
            $this->template->content = $view;
            
            Session::set_flash('inquiry',array(
                'data' => $validated,
            ));
        }

        $view->set('fieldset', $fieldset, false);
        $this->template->content = $view;
    }

    /**
     * 完了画面
     *
     * @access public
     * @return void
     */
    public function action_thanks()
    {
        $contact = $this->register_contact();
        if(! $contact){
            return Response::redirect('inquiry');
        }else{
            $this->sendmailToUser($contact);
            $this->template->title   = 'お問い合わせ';
            $this->template->content = View::forge('inquiry/thanks');
        }
    }

    /**
     * fieldsetの作成
     *
     * @access private
     * @return Fieldsetオブジェクト
     */
    private function createFieldset()
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

    /**
     * contactテーブルへの登録
     *
     * @access private
     * @return Model_Contactオブジェクト
     */
    private function register_contact()
    {
        $data = $this->getContactData();
        if(! $data ){
            return false;
        }else{
            $contact = Model_Contact::forge();
            $contact->set($data);
            $contact->save();
            return $contact;
        }
    }

    /**
     * セッションからcontactのデータを取得、整形
     *
     * @access private
     * @return array contactのデータ
     */
    private function getContactData(){
        $data = Session::get_flash('inquiry.data');

        if(! isset($data)){
            return false;
        }

        foreach( array('email2','submit') as $column ){
            unset($data[$column]);
        }

        return array_merge($data,array(
            'user_id' => 1,
        ));
    }

    /**
     * ユーザーにメールを送信
     *
     * @para $contact Model_Contact のobject
     * @access private
     * @return void
     */
    private function sendmailToUser($contact)
    {
        $email = Email::forge();
        $email->from('h_kobayashi@aucfan.com','Hiroyuki Kobayashi');
        $email->to(array('h_kobayashi@aucfan.com'));
        $email->subject(mb_encode_mimeheader('subject'),'jis');
        $email->body(mb_convert_encoding($this->createMailBody($contact),'jis'));
        
        try {
            $email->send();
        }catch( \EmailValidationFailedException $e ){
            var_dump($e);
        }catch( \EmailSendingFailedException $e ){
            var_dump($e);
        }
    }

    /**
     * メール本文の作成
     *
     * @access private
     * @return Viewオブジェクト
     */
    private function createMailBody($contact)
    {
        $view = View::forge('inquiry/mail_body');
        $view->set('contact',$contact,false);
        return $view;
    }
}
