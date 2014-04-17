<?php

/**
 * mail_magazine Model
 *
 * メールマガジン情報テーブル
 *
 * @author ida
 */
class Model_Mail_Magazine extends Model_Base
{
    /**
     * メールマガジン関連ファイルディレクトリ
     */
    const ROOT_DIR = '/var/www/html/public/files/mailmagazine/';
    /**
     * メールマガジンタイプ 1全員,2:希望者全員,3:出店予約者
     */
    const MAIL_MAGAZINE_TYPE_ALL = 1;
    const MAIL_MAGAZINE_TYPE_REQUEST = 2;
    const MAIL_MAGAZINE_TYPE_RESEVED_ENTRY = 3;

    /**
     * 送信ステータス 0:送信待ち,1:送信中,2:正常終了,3エラー終了,9:キャンセル
     */
    const SEND_STATUS_WAITING = 0;
    const SEND_STATUS_PROGRESS = 1;
    const SEND_STATUS_NORMAL_END = 2;
    const SEND_STATUS_ERROR_END = 3;
    const SEND_STATUS_CANCEL = 9;

    protected static $_table_name = 'mail_magazines';

    protected static $_primary_key = array('mail_magazine_id');

    protected static $_properties = array(
        'mail_magazine_id' => array(
            'form'  => array('type' => false)
        ),
        'send_datetime' => array(
            'form'  => array('type' => false)
        ),
        'mail_magazine_type' => array(
            'form'  => array('type' => false)
        ),
        'query' => array(
            'form'  => array('type' => false)
        ),
        'from_email' => array(
            'label' => '送信メールアドレス',
            'validation' => array(
                'required', 'valid_email', 'max_length' => array(250),
            ),
        ),
        'from_name' => array(
            'label' => '送信名',
            'validation' => array(
                'required', 'max_length' => array(250),
            ),
        ),
        'subject' => array(
            'label' => '件名',
            'validation' => array(
                'required', 'max_length' => array(250),
            ),
        ),
        'body' => array(
            'label' => '本文',
            'validation' => array(
                'required', 'max_length' => array(250),
            ),
        ),
        'additional_serialize_data' => array(
            'form'  => array('type' => false)
        ),
        'send_status' => array(
            'form'  => array('type' => false)
        ),
        'created_user' => array(
            'form'  => array('type' => false)
        ),
        'updated_user' => array(
            'form'  => array('type' => false)
        ),
        'created_at' => array(
            'form'  => array('type' => false)
        ),
        'updated_at' => array(
            'form'  => array('type' => false)
        ),
        'deleted_at' => array(
            'form'  => array('type' => false)
        ),
    );

    protected static $_observers = array(
        'Orm\\Observer_CreatedAt' => array(
            'events'          => array('before_insert'),
            'mysql_timestamp' => true,
            'property'        => 'created_at',
        ),
        'Orm\\Observer_UpdatedAt' => array(
            'events'          => array('before_update'),
            'mysql_timestamp' => true,
            'property'        => 'updated_at',
        ),
    );

    /**
     * 本文で置換するパラメータを取得する
     *
     * メールマガジン種別ごと
     *
     * @access public
     * @param mixed $mail_magazine_type メールマガジンタイプ
     * @return array
     * @author ida
     */
    public static function getPatternParameter($mail_magazine_type)
    {
        if ($mail_magazine_type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL) {
            $param = array('user_name');
        } elseif ($mail_magazine_type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST) {
            $param = array('user_name');
        } elseif ($mail_magazine_type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY) {
            $param = array(
                'user_name',
                'fleamarket_name',
                'event_date',
                'start_time',
                'end_time',
            );
        }

        return $param;
    }

    /**
     * 本文で置換するパラメータを取得する
     *
     * メールマガジン種別ごと
     *
     * @access public
     * @param string $str メール本文
     * @param array $pattern_list 置換パラメータ
     * @param array $options 置換情報
     * @return array
     * @author ida
     */
    public static function createReplaceParameter(
        $str, $pattern_list, $options
    ) {
        if (! $str || ! $pattern_list || ! $options) {
            return false;
        }

        if (isset($options['user'])) {
            $user = $options['user'];
        }
        if (isset($options['fleamarket'])) {
            $fleamarket = $options['fleamarket'];
        }

        $pattern = array();
        $replacement = array();
        foreach ($pattern_list as $p) {
            $pattern[] = '##' . $p . '##';
            switch ($p) {
                case 'user_name':
                    $replacement[] = $user['last_name'] . ' ' . $user['first_name'];
                    break;
                case 'fleamarket_name':
                    $replacement[] = $fleamarket['name'];
                    break;
                case 'event_date':
                    $event_date = strtotime($fleamarket['event_date']);
                    $replacement[] = date('Y年m月d日', $event_date);
                    break;
                case 'start_time':
                    $event_time_start = strtotime($fleamarket['event_time_start']);
                    $replacement[] = date('H:i', $event_time_start);
                    break;
                case 'end_time':
                    $event_time_end = strtotime($fleamarket['event_time_end']);
                    $replacement[] = date('H:i', $event_time_end);
                    break;
                default:
                    $replacement[] = '';
                    break;
            }
        }

        return array($pattern, $replacement);
    }

    /**
     * 文字列内を指定されたパラメータで置換する
     *
     * @access private
     * @param string $str 文字列
     * @param array $pattern 検索パターン
     * @param array $replacement 置換パラメータ
     * @return string
     * @author ida
     */
    public static function replaceByParam(
        $str = null, $pattern = array(), $replacement = array()
    ) {
        if ($str && $pattern && $replacement) {
            $str = str_replace($pattern, $replacement, $str);
        }

        return $str;
    }

    /**
     * 文字コードを変換する
     *
     * @access private
     * @param string $str 変換する文字列
     * @param string $encode 変換後の文字コード
     * @return string
     * @author ida
     */
    public static function convertEncoding($str, $encode = 'JIS')
    {
        $str = mb_convert_encoding($str, $encode, 'UTF-8');

        return $str;
    }

    /**
     * ユーザーにメールを送信
     *
     * @access protected
     * @param string $from_email 送信メールアドレス
     * @param string $from_name 送信名
     * @param string $to 送信先
     * @param string $subject 件名
     * @param string $body 本文
     * @return bool
     * @author ida
     */
    public static function sendMail(
        $from_name = null,
        $from_email = null,
        $to = null,
        $subject = null,
        $body = null
    ) {
        if (! $from_name || ! $from_email || ! $to || ! $subject || ! $body) {
            return false;
        }

        $email = \Email::forge();
        $email->from($from_email, $from_name);
        $email->to($to);
        $email->subject($subject);
        $email->body(self::convertEncoding($body));

        try {
            $email->send();
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }

    /**
     * メールマガジン送信中か確認する
     *
     * 処理ファイルを確認
     *
     * @TODO: ファイル名、ディレクトリの設定を移動する
     *
     * @access private
     * @param
     * @return bool
     * @author ida
     */
    public static function isProcess()
    {
        $process_file_name = 'process_mail_magazine';

        return file_exists(self::ROOT_DIR . $process_file_name);
    }

    /**
     * 送信実行確認ファイル処理
     *
     * @TODO: ファイル名、ディレクトリの設定を移動する
     *
     * @access private
     * @param　boolean $delete 削除（中止）
     * @return void
     * @author ida
     */
    public static function startProcess()
    {
        $process_file_name = 'process_mail_magazine';
        $result = \File::create(self::ROOT_DIR, $process_file_name);

        return $result;
    }

    /**
     * 送信実行確認ファイル処理
     *
     * @TODO: ファイル名、ディレクトリの設定を移動する
     *
     * @access private
     * @param　boolean $delete 削除（中止）
     * @return void
     * @author ida
     */
    public static function stopProcess()
    {
        $process_file_name = 'process_mail_magazine';
        $result = \File::delete(self::ROOT_DIR . $process_file_name);

        return $result;
    }

    /*
     * Fieldsetオブジェクトの生成
     *
     * @access public
     * @return array
     * @author ida
     */
    public static function createFieldset()
    {
        $fieldset = \Fieldset::forge('mail_magazine');
        $fieldset->add_model(self::forge());

        return $fieldset;
    }
}