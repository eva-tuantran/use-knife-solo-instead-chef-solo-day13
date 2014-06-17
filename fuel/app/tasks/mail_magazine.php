<?php
namespace Fuel\Tasks;

/**
 * メールマガジン送信
 *
 * @author kobayasi
 */
class Mail_Magazine
{
    /**
     * ログファイルのハンドラー
     *
     * @var object
     */
    private $log_handler = null;

    /**
     * メールマガジン送信
     *
     * @access public
     * @param int $mail_magazine_id メルマガID
     * @param int $administrator_id 管理者ID
     * @param int $limit 1回で処理する件数
     * @return void
     * @author ida
     */
    public function run($mail_magazine_id, $administrator_id = 0, $limit = 1000)
    {
        $this->openLog($mail_magazine_id);
        $this->log('メルマガID: '. $mail_magazine_id . ' の送信を開始します' . "\n");

        if (\Model_Mail_Magazine::isProcess()) {
            $this->log('メルマガ送信中のため送信できません' . "\n");
            exit;
        }

        $mail_magazine = \Model_Mail_Magazine::startProcess($mail_magazine_id);

        $offset = 0;
        if (! is_numeric($limit) || $limit <= 0) {
            $limit = 1000;
        }

        $total_count = 0;
        $success_count = 0;
        $fail_count = 0;

        while ($limit > 0) {
            $mail_magazine_users = \Model_Mail_Magazine_User::findByMailMagazineId(
                $mail_magazine_id, $offset, $limit
            );
            if (count($mail_magazine_users) == 0) {
                break;
            }

            $is_stop = false;
            $replace_data = $this->makeReplaceData($mail_magazine);

            foreach ($mail_magazine_users as $mail_magazine_user) {
                try {
                    usleep(300000);
                    if (! \Model_Mail_Magazine::isProcess($mail_magazine_id)) {
                        $is_stop = true;
                        $this->log($mail_magazine_user->user_id . ": cancel.\n");
                        break;
                    }

                    $send_result = $this->send(
                        $mail_magazine_user, $mail_magazine, $replace_data
                    );
                    \Model_Mail_Magazine_User::updateStatus(
                        array(
                            'send_status' => $send_result,
                            'error' => null,
                            'updated_user' => $administrator_id
                        ),
                        array('mail_magazine_user_id' => $mail_magazine_user->mail_magazine_user_id)
                    );

                    $this->log($mail_magazine_user->user_id . " : success\n");
                    $success_count++;
                } catch (\Exception $e) {
                    $message = $e->getMessage();
                    $this->log($mail_magazine_user->user_id . ' : fail ' . $message . "\n");
                    \Model_Mail_Magazine_User::updateStatus(
                        array(
                            'send_status' => \Model_Mail_Magazine_User::SEND_STATUS_ERROR_END,
                            'error' => $message,
                            'updated_user' => $administrator_id
                        ),
                        array('mail_magazine_user_id' => $mail_magazine_user->mail_magazine_user_id)
                    );
                    $fail_count++;
                }
                $total_count++;
            }
            $offset += $limit;
        }

        $this->log('[total] ' . $total_count . ' [success] ' . $success_count . ' [fail] ' . $fail_count . "\n");
        $this->log('送信を終了しました');
        $this->closeLog();

        $mail_magazine->send_datetime = \Date::forge()->format('mysql');
        if ($is_stop) {
            $mail_magazine->send_status = \Model_Mail_Magazine::SEND_STATUS_CANCEL;
        } else {
            $mail_magazine->send_status = \Model_Mail_Magazine::SEND_STATUS_NORMAL_END;
        }
        $mail_magazine->save();
    }

    /**
     * 本文のリプレイス情報を生成する
     *
     * @access private
     * @param array $mail_magazine メルマガ情報
     * @return array
     * @author ida
     */
    private function makeReplaceData($mail_magazine)
    {
        $replace_data= array();
        $add_data = unserialize($mail_magazine['additional_serialize_data']);

        $mail_magazine_type = $mail_magazine['mail_magazine_type'];
        switch ($mail_magazine_type) {
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_WAITING_ENTRY:
                $fleamarket_id = $add_data['fleamarket_id'];
                $fleamarket = \Model_Fleamarket::find($fleamarket_id);
                $replace_data['fleamarket'] = $fleamarket;
                break;
        }

        return $replace_data;
    }

    /**
     * メール送信処理
     *
     * @access public
     * @param array $mail_magazine_user 送信先ユーザ情報
     * @param array $mail_magazine メルマガ情報
     * @param array $replace_data 本文リプレイス情報
     * @return bool/string
     * @author ida
     */
    private function send($mail_magazine_user, $mail_magazine, $replace_data)
    {
        if (empty($mail_magazine_user->email)) {
            throw new \Exception('email is not registered');
        }
        if ($mail_magazine_user->email === 'anonymous@rakuichi-rakuza.jp') {
            throw new \Exception('email is anonymous@');
        }

        $mail_magazine_type = $mail_magazine['mail_magazine_type'];
        $from_name = $mail_magazine['from_name'];
        $from_email = $mail_magazine['from_email'];
        $to = $mail_magazine_user->email;
        $subject = \Model_Mail_Magazine::convertEncoding(
            $mail_magazine['subject']
        );
        $body = $mail_magazine['body'];

        $replace_data['user'] = $mail_magazine_user;
        $pattern = \Model_Mail_Magazine::getPatternParameter($mail_magazine_type);
        list($pattern, $replacement) = \Model_Mail_Magazine::createReplaceParameter(
            $body, $pattern, $replace_data
        );
        $body = \Model_Mail_Magazine::replaceByParam($body, $pattern, $replacement);

        $result = \Model_Mail_Magazine::sendMail(
            $from_name, $from_email, $to, $subject, $body
        );

        if (true === $result) {
            $result = \Model_Mail_Magazine_User::SEND_STATUS_NORMAL_END;
        } elseif (false === $send_result) {
            $result = \Model_Mail_Magazine_User::SEND_STATUS_UNSENT;
        }

        return $result;
    }

    /**
     * ログファイルを生成する
     *
     * @access private
     * @param mixed $mail_magazine_id メールマガジンID
     * @return void
     * @author ida
     */
    private function openLog($mail_magazine_id)
    {
//        $dir = realpath(APPPATH . '/../../') . DS . 'public' . DS . 'files' . DS . 'mailmagazine' . DS;
        $dir = '/tmp/';
        $file_name = 'log_mail_magazine_' . str_pad($mail_magazine_id, 5, '0', STR_PAD_LEFT) . '_' . date('YmdHis');
        \File::create($dir, $file_name);

        $this->log_handler = \File::open_file($dir . $file_name);
    }

    /**
     * ログファイルを閉じる
     *
     * @access private
     * @param
     * @return void
     * @author ida
     */
    private function closeLog()
    {
        \File::close_file($this->log_handler);
    }

    /**
     * ログ出力
     *
     * @access private
     * @param mixed $message 出力文字列
     * @return void
     * @author ida
     */
    private function log($message)
    {
        $string = '[' . date('Y/m/d H:i:s') . '] ' . $message;
        fwrite($this->log_handler, $string);
    }
}
