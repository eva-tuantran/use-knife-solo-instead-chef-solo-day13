<?php
/**
 * お問い合わせフォーム
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Inquiry extends Controller_Base_Template
{
    /**
     * 初期画面
     *
     * @access public
     * @return void
     */
    public function action_index()
    {
        $this->setMetaTag('inquiry/index');
        $view = View::forge('inquiry/index');
        $fieldset = $this->createFieldset();
        $fieldset->repopulate();
        $view->set('fieldset', $fieldset, false);
        $this->template->content = $view;
    }
    /**
     * 確認画面
     *
     * @access public
     * @return void
     */
    public function post_confirm()
    {
        $fieldset = $this->createFieldset();
        Session::set_flash('inquiry.fieldset',$fieldset);
        
        if (! $fieldset->validation()->run()) {
            return Response::redirect('inquiry');
        }

        $view = View::forge('inquiry/confirm');
        $view->set('fieldset', $fieldset, false);

        $this->setMetaTag('inquiry/confirm');
        $this->template->content = $view;
    }

    /**
     * 完了画面
     *
     * @access public
     * @return void
     */
    public function post_thanks()
    {
        if (! Security::check_token()) {
            return Response::redirect('errors/doubletransmission');
        }

        $view = View::forge('inquiry/thanks');
        $this->setMetaTag('inquiry/thanks');

        $this->template->content = $view;

        try {
            $contact = $this->registerContact();
            $this->sendMailToUserAndAdmin($contact);
        } catch ( Exception $e ) {
            $view->set('error',$e,false);
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
        $fieldset = Session::get_flash('inquiry.fieldset');

        if (! $fieldset) {
            $fieldset = Model_Contact::createFieldset();
        }

        return $fieldset;
    }

    /**
     * contacts テーブルへの登録
     *
     * @access private
     * @return Model_Contactオブジェクト
     */
    private function registerContact()
    {
        $data = $this->getContactData();
        if (! $data) {
            throw new Exception();
        } else {
            $contact = Model_Contact::forge();
            $contact->set($data);
            $contact->save(NULL, true);

            return $contact;
        }
    }

    /**
     * セッションからcontactのデータを取得、整形
     *
     * @access private
     * @return array contactのデータ
     */
    private function getContactData()
    {
        $fieldset = Session::get_flash('inquiry.fieldset');

        if (! $fieldset) {
            return false;
        }

        $input = $fieldset->validation()->validated();

        if ($input) {
            unset($input['email2']);
            $input['user_id'] = Auth::get_user_id();
        }

        return $input;
    }

    /**
     * ユーザーにメールを送信
     *
     * @para $contact Model_Contact
     * @access private
     * @return void
     */
    private function sendMailToUserAndAdmin($contact)
    {
        $params = array();

        foreach (array('subject','email','tel','contents') as $key) {
            $params[$key] = $contact->get($key);
        }
        $params['inquiry_type_label'] = $contact->inquiry_type_label();

        $this->sendMailByParams("inquiry_user" , $params, array($contact->email));
        $this->sendMailByParams("inquiry_admin", $params);
    }
}
