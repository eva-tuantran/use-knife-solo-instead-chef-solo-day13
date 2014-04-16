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
    private $log = null;

    /**
     * メールマガジン送信
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    public function run($mail_magazine_id)
    {
        \Model_Mail_Magazine::startProcess();

        $logfile = $this->setLog();
        fwrite($this->log, 'メルマガID: '. $mail_magazine_id . ' の送信を開始します' . "\n");

        $mail_magazine = \Model_Mail_Magazine::find($mail_magazine_id);
        $query = $mail_magazine['query'];

        $users = \DB::query($query)->execute()->as_array();

        foreach ($users as $user) {
            if (! \Model_Mail_Magazine::isProcess()) {
                break;;
            }

            try {
                $this->send($user, $mail_magazine);
                fwrite($this->log, $user['user_id'] . ": OK\n");
            } catch (\Exception $e) {
                $message = $e->getMessage();
                fwrite($this->log, $user['user_id'] . ": NG " . $message . "\n");
                $success = false;
            }
        }
        \File::close_file($this->log);
        \Model_Mail_Magazine::stopProcess();
    }

    /**
     * メール送信処理
     *
     * @access public
     * @param
     * @return void
     * @author ida
     */
    private function send($user, $mail_magazine)
    {
        if (empty($user['email'])) {
            return;
        }
        $user_name = $user['last_name'] . ' ' . $user['first_name'];
        $user_name = \Model_Mail_Magazine::convertEncoding($user_name);
        $replace = array(
            'user_name' => $user_name
        );

        $from_name = $mail_magazine['from_name'];
        $from_email = $mail_magazine['from_email'];
        $to = $user['email'];
        $subject = \Model_Mail_Magazine::convertEncoding(
            $mail_magazine['subject']
        );
        $body = \Model_Mail_Magazine::replaceByParam(
            \Model_Mail_Magazine::convertEncoding($mail_magazine['body']),
            $replace
       );

        $result = \Model_Mail_Magazine::sendMail(
            $from_name, $from_email, $to, $subject, $body
        );

        return $result;
    }


    /**
     * ログファイルを生成する
     *
     * @access private
     * @param
     * @return void
     * @author ida
     */
    private function setLog()
    {
        $dir = realpath(APPPATH . '/../../') . DS . 'public' . DS . 'files' . DS . 'mailmagazine' . DS;
        $file_name = 'log' . date('YmdHis');
        \File::create($dir, $file_name);

        $this->log = \File::open_file($dir . $file_name);
    }
}
