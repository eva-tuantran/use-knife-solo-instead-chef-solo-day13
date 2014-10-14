<?php

/**
 * View_Admin_Mailmagazine_Confirm ViewModel
 *
 * @author ida
 */
class View_Admin_Mailmagazine_Result extends \ViewModel
{
    /**
     * view method
     *
     * @access public
     * @return void
     * @author ida
     */
    public function view()
    {
        $mail_magazine = \Model_Mail_Magazine::find($this->mail_magazine_id);
        $additional_serialize_data = $mail_magazine['additional_serialize_data'];

        if (! empty($additional_serialize_data)) {
            $additional_data = $this->unserializeAdditionalData(
                $mail_magazine['mail_magazine_type'], $additional_serialize_data
            );
            $data = array_merge($mail_magazine->to_array(), $additional_data);
        }

        $replace_data = $this->setupData($data);

        $this->prefectures = \Config::get('master.prefectures');
        $this->mail_magazine_types = \Model_Mail_Magazine::getMailMagazinTypes();
    }

    /**
     * 表示に必要なデータを取得し設定する
     *
     * @access private
     * @param array $input_data 入力データ
     * @return array
     * @author ida
     */
    private function setupData($data)
    {
        $replace_data = array();
        $replace_data['user'] = $this->user;

        $mail_magazine_type = $data['mail_magazine_type'];
        switch ($mail_magazine_type) {
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                $this->set(
                    'prefectures', \Config::get('master.prefectures'), false
                );
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                $fleamarket_id = $data['reserved_fleamarket_id'];
                $fleamarket = \Model_Fleamarket::find($fleamarket_id);
                $replace_data['fleamarket'] = $fleamarket;

                $this->set('fleamarket', $fleamarket, false);
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_WAITING_ENTRY:
                $fleamarket_id = $data['waiting_fleamarket_id'];
                $fleamarket = \Model_Fleamarket::find($fleamarket_id);
                $replace_data['fleamarket'] = $fleamarket;

                $this->set('fleamarket', $fleamarket, false);
                break;
        }

        $users = \Model_Mail_Magazine_User::findListByMailMagazineId(
            $this->mail_magazine_id, null, null
        );
        $this->set('users', $users, false);

        $body = $data['body'];
        $pattern = \Model_Mail_Magazine::getPatternParameter($mail_magazine_type);
        list($pattern, $replacement) = \Model_Mail_Magazine::createReplaceParameter(
            $body, $pattern, $replace_data
        );
        $body = \Model_Mail_Magazine::replaceByParam($body, $pattern, $replacement);
        $this->set('body', $body, false);
        $this->set('input_data', $data, false);
    }

    /**
     * 追加条件のデータをアンシリアライズする
     *
     * @access private
     * @param array $additional_data 追加データ
     * @return array
     * @author ida
     */
    private function unserializeAdditionalData($mail_magazine_type, $additional_data)
    {
        try {
            $data = unserialize($additional_data);
        } catch (\Exception $e) {
            return array();
        }

        $result =  array();
        switch ($mail_magazine_type) {
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                $result = array(
                    'prefecture_id' => $data['prefecture_id'],
                    'organization_flag' => $data['organization_flag'],
                );
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                $result = array(
                    'reserved_fleamarket_id' => $data['fleamarket_id']
                );
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_WAITING_ENTRY:
                $result = array(
                    'waiting_fleamarket_id' => $data['fleamarket_id']
                );
                break;
        }

        return $result;
    }
}
