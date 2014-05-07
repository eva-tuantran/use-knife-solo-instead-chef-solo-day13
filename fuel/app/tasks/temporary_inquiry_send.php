<?php
namespace Fuel\Tasks;

use \Model_Email;
use \Model_Contact;


class temporary_inquiry_send
{
    public function run()
    {
        $contacts = \Model_Contact::find('all');

        foreach ($contacts as $contact) {
            $this->sendMailToAdmin($contact);
        }

    }


    /**
     * ユーザーにメールを送信
     *
     * @para $contact Model_Contact
     * @access private
     * @return void
     */
    private function sendMailToAdmin($contact)
    {
        $params = array();

        foreach (array('last_name', 'first_name', 'subject', 'email', 'tel', 'contents') as $key) {
            $params[$key] = $contact->get($key);
        }
        $params['inquiry_type_label'] = $contact->inquiry_type_label();

        $email = new Model_Email();
        $email->sendMailByParams("inquiry/admin", $params);
    }
}
