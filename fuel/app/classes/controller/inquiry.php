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
        $fieldset = $this->getFieldset();
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
        $fieldset = $this->getFieldset();
        Session::set_flash('inquiry.fieldset', $fieldset);

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
            throw new SystemException(\Model_Error::ER00602);
        }

        $view = View::forge('inquiry/thanks');
        $this->setMetaTag('inquiry/thanks');

        $this->template->content = $view;

        try {
            $contact = $this->registerContact();
        } catch ( Exception $e ) {
            throw new SystemException(\Model_Error::ER00601);
        }

        try{
            $this->sendMailToUserAndAdmin($contact);
        } catch ( Exception $e ) {
            throw new SystemException(\Model_Error::ER00602);
        }
    }

    private function getFieldset()
    {
        if ($this->request->action == 'index') {
            $fieldset = Session::get_flash('inquiry.fieldset');
            if (! $fieldset) {
                $fieldset = $this->createFieldset();
            }
        } elseif ($this->request->action == 'confirm') {
            $fieldset = $this->createFieldset();
        } elseif ($this->request->action == 'thanks') {
            $fieldset = Session::set_flash('inquiry.fieldset', $fieldset);
        }
        return $fieldset;
    }

    /**
     * fieldsetの作成
     *
     * @access private
     * @return Fieldsetオブジェクト
     */
    private function createFieldset()
    {
        $fieldset = Model_Contact::createFieldset();
        $fieldset->repopulate();
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
            throw new Exception(\Model_Error::ER00603);
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

        foreach (array('contact_id', 'last_name', 'first_name', 'subject', 'email', 'tel', 'contents') as $key) {
            $params[$key] = $contact->get($key);
        }
        $params['inquiry_type_label'] = $contact->inquiry_type_label();

        $email = new Model_Email();
        $email->sendMailByParams("inquiry/user" , $params, array($contact->email));
        $email->sendMailByParams("inquiry/admin", $params, '', array('reply_to' => $contact->email));
    }
}

