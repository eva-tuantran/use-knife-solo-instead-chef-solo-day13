<?php
namespace Fuel\Tasks;

/**
 * キャンセル待ちユーザーメール送信task
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
     * @param
     * @return void
     * @author ida
     */
    public function run($mail_magazine_id, $administrator_id)
    {
        $this->openLog($mail_magazine_id);
        $this->log('メルマガID: '. $mail_magazine_id . ' の送信を開始します' . "\n");

        if (\Model_Mail_Magazine::isProcess()) {
            $this->log('他メルマガの送信中のため送信できませんでした' . "\n");
        }

        \Model_Mail_Magazine::startProcess($mail_magazine_id);

        $mail_magazine = \Model_Mail_Magazine::find($mail_magazine_id);
        $mail_magazine->send_status = \Model_Mail_Magazine::SEND_STATUS_PROGRESS;
        $mail_magazine->save();

        $mail_magazine_users = \Model_Mail_Magazine_User::findByMailMagazineId($mail_magazine_id);

        $is_stop = false;
        $total_count = 0;
        $success_count = 0;
        $error_count = 0;

        foreach ($mail_magazine_users as $mail_magazine_user) {
            if (! \Model_Mail_Magazine::isProcess($mail_magazine_id)) {
                $is_stop = true;
                $this->log($user->user_id . ": cancel.\n");
                break;
            }

            try {
                usleep(200000);
                $send_result = $this->send($mail_magazine_user, $mail_magazine);

                $this->log($mail_magazine_user->user_id . ": success\n");
                $send_status = $send_result
                             ? \Model_Mail_Magazine_User::SEND_STATUS_NORMAL_END
                             : \Model_Mail_Magazine_User::SEND_STATUS_UNSENT;
                $mail_magazine_user->set(array(
                    'send_status' => $send_status,
                    'error' => null,
                    'updated_user' => $administrator_id,
                ))->save();
                $success_count++;
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $this->log($mail_magazine_user->user_id . ": error " . $message . "\n");
                $mail_magazine_user->set(array(
                    'send_status' => \Model_Mail_Magazine_User::SEND_STATUS_ERROR_END,
                    'error' => $message,
                    'updated_user' => $administrator_id,
                ))->save();
                $error_count++;
            }
            $total_count++;
        }

        $this->log('[total] ' . $total_count . ' [success] ' . $success_count . ' [fail] ' . $error_count . "\n");
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
     * メール送信処理
     *
     * @access public
     * @param array $mail_magazine_user 送信先ユーザ情報
     * @param array $mail_magazine メールマガジン情報
     * @return bool
     * @author ida
     */
    private function send($mail_magazine_user, $mail_magazine)
    {
        if (empty($mail_magazine_user->user->email)) {
            return false;
        }

        $from_name = $mail_magazine['from_name'];
        $from_email = $mail_magazine['from_email'];
        $to = $mail_magazine_user->user->email;
        $subject = \Model_Mail_Magazine::convertEncoding(
            $mail_magazine['subject']
        );
        $body = $mail_magazine['body'];

        $replace_data= array();
        $replace_data['user'] = $mail_magazine_user->user;
        $add_data = unserialize($mail_magazine['additional_serialize_data']);

        $type = $mail_magazine['mail_magazine_type'];
        if ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL) {
        } elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST) {
        } elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY) {
            $fleamarket_id = $add_data['fleamarket']['fleamarket_id'];
            $fleamarket = \Model_Fleamarket::find($fleamarket_id);
            $replace_data['fleamarket'] = $fleamarket;
        }

        $pattern = \Model_Mail_Magazine::getPatternParameter($type);
        list($pattern, $replacement) = \Model_Mail_Magazine::createReplaceParameter(
            $body, $pattern, $replace_data
        );
        $body = \Model_Mail_Magazine::replaceByParam($body, $pattern, $replacement);

        $result = \Model_Mail_Magazine::sendMail(
            $from_name, $from_email, $to, $subject, $body
        );

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
        $file_name = 'log' . '_' . $mail_magazine_id . '_' . date('YmdHis');
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
