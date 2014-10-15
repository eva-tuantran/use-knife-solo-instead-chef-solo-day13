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
     * メールマガジンタイプ 1全員,2:希望者全員,3:出店予約者
     */
    const MAIL_MAGAZINE_TYPE_ALL = 1;
    const MAIL_MAGAZINE_TYPE_REQUEST = 2;
    const MAIL_MAGAZINE_TYPE_RESEVED_ENTRY = 3;
    const MAIL_MAGAZINE_TYPE_WAITING_ENTRY = 4;

    /**
     * 送信ステータス 0:保存,1:送信待ち,2:送信中,3:正常終了,4:異常終了,9:キャンセル
     */
    const SEND_STATUS_SAVED = 0;
    const SEND_STATUS_WAITING = 1;
    const SEND_STATUS_PROGRESS = 2;
    const SEND_STATUS_NORMAL_END = 3;
    const SEND_STATUS_ERROR_END = 4;
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
                'required', 'max_length' => array(60000),
            ),
        ),
        'additional_serialize_data' => array(
            'label' => '送信条件',
            'validation' => array(
                'max_length' => array(1023),
            ),
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

    protected static $_soft_delete = array(
        'deleted_field'   => 'deleted_at',
        'mysql_timestamp' => true,
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
     * メールマガジンタイプ一覧
     */
    private static $mail_magazine_types = array(
        self::MAIL_MAGAZINE_TYPE_ALL => '全員',
        self::MAIL_MAGAZINE_TYPE_REQUEST => 'メルマガ希望者',
        self::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY => '出店予約者',
        self::MAIL_MAGAZINE_TYPE_WAITING_ENTRY => 'キャンセル待ち'
    );

    /**
     * 送信ステータス一覧
     */
    private static $send_statuses = array(
        self::SEND_STATUS_SAVED => '保存',
        self::SEND_STATUS_WAITING => '送信待ち',
        self::SEND_STATUS_PROGRESS => '送信中',
        self::SEND_STATUS_NORMAL_END => '正常終了',
        self::SEND_STATUS_ERROR_END => '異常終了',
        self::SEND_STATUS_CANCEL => '中止',
    );

    /**
     * メールマガジンタイプ一覧を取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getMailMagazinTypes()
    {
        return self::$mail_magazine_types;
    }

    /**
     * 送信ステータス一覧を取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getSendStatuses()
    {
        return self::$send_statuses;
    }

    /**
     * 指定された条件でフリーマーケット情報リストを取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @param mixed $page ページ
     * @param mixed $row_count ページあたりの行数
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findAdminBySearch(
        $condition_list, $page = 0, $row_count = 0
    ) {
        $search_where = self::buildSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $where = '';
        if ($conditions) {
            $where = ' WHERE ';
            $where .= implode(' AND ', $conditions);
        }

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = ' LIMIT ' . $offset . ', ' . $row_count;
        }

        $query = <<<"QUERY"
SELECT
    mail_magazine_id,
    send_datetime,
    mail_magazine_type,
    query,
    from_email,
    from_name,
    subject,
    body,
    additional_serialize_data,
    send_status,
    created_user,
    updated_user,
    created_at,
    updated_at,
    deleted_at
FROM
    mail_magazines
{$where}
ORDER BY
    send_datetime DESC,
    created_at DESC,
    send_status DESC,
    mail_magazine_id ASC
{$limit}
QUERY;

        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows;
    }

    /**
     * 指定された条件でフリーマーケット情報の件数を取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function getCountByAdminSearch($condition_list)
    {
        $search_where = self::buildSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $where = '';
        if ($conditions) {
            $where = ' WHERE ';
            $where .= implode(' AND ', $conditions);
        }

        $query = <<<"QUERY"
SELECT
    COUNT(mail_magazine_id) AS cnt
FROM
    mail_magazines
{$where}
QUERY;

        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows[0]['cnt'];
    }

    /**
     * 検索条件を取得する
     *
     * @access private
     * @param array $condition_list 検索条件
     * @return array 検索条件
     * @author ida
     */
    public static function createAdminSearchCondition($condition_list = array())
    {
        $conditions = array();
        if (! $condition_list) {
            return $conditions;
        }

        foreach ($condition_list as $field => $condition) {
            if ($condition == '') {
                continue;
            }

            $operator = '=';
            if (is_array($condition)) {
                $operator = 'IN';
            }

            switch ($field) {
                case 'mail_magazine_type':
                    $conditions['mail_magazine_type'] = array($operator, $condition);
                    break;
                case 'send_status':
                    $conditions['send_status'] = array($operator, $condition);
                    break;
                default:
                    break;
            }
        }

        return $conditions;
    }

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
        switch ($mail_magazine_type) {
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                $param = array('user_name');
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                $param = array('user_name');
                break;
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
            case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_WAITING_ENTRY:
                $param = array(
                    'user_name',
                    'fleamarket_name',
                    'event_date',
                    'start_time',
                    'end_time',
                );
                break;
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
                    $replacement[] = $user->last_name . ' ' . $user->first_name;
                    break;
                case 'fleamarket_name':
                    $replacement[] = $fleamarket->name;
                    break;
                case 'event_date':
                    $event_date = strtotime($fleamarket->event_date);
                    $replacement[] = date('Y年m月d日', $event_date);
                    break;
                case 'start_time':
                    $event_time_start = strtotime($fleamarket->event_time_start);
                    $replacement[] = date('H:i', $event_time_start);
                    break;
                case 'end_time':
                    $event_time_end = strtotime($fleamarket->event_time_end);
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
     * @access private
     * @param mixed $mail_magazine_id メルマガID
     * @return bool
     * @author ida
     */
    public static function isProcess($mail_magazine_id = null)
    {
        $where = array(
            array('send_status', self::SEND_STATUS_PROGRESS)
        );
        if ($mail_magazine_id) {
            $where[] = array('mail_magazine_id', $mail_magazine_id);
        }
        $mail_magazine = self::find('all', array('where' => $where));

        return count($mail_magazine) > 0;
    }

    /**
     * 送信開始
     *
     * @access private
     * @param mixed $mail_magazine_id メルマガID
     * @return object
     * @author ida
     */
    public static function startProcess($mail_magazine_id = null)
    {
        if (! $mail_magazine_id) {
            return false;
        }

        $mail_magazine = self::find('first', array(
            'where' => array(
                array('mail_magazine_id', $mail_magazine_id),
            )
        ));

        $mail_magazine->send_status = self::SEND_STATUS_PROGRESS;
        $mail_magazine->save();

        return $mail_magazine;
    }

    /**
     * 送信キャンセル
     *
     * @access private
     * @param mixed $mail_magazine_id メルマガID
     * @return void
     * @author ida
     */
    public static function cancelProcess($mail_magazine_id = null)
    {
        if (! $mail_magazine_id) {
            return false;
        }

        $mail_magazine = self::find('first', array(
            'where' => array(
                array('mail_magazine_id', $mail_magazine_id),
            )
        ));

        $mail_magazine->send_status = self::SEND_STATUS_CANCEL;
        $mail_magazine->save();
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

    /**
     * 指定された検索条件よりWHERE句とプレースホルダ―を生成する
     *
     * @access private
     * @param array $condition_list
     * @return array
     * @author ida
     */
    private static function buildSearchWhere($condition_list)
    {
        $conditions = array();
        $placeholders = array();

        if (empty($condition_list)) {
            return array($conditions, $placeholders);
        }

        foreach ($condition_list as $field => $condition) {
            $operator = $condition[0];
            if (count($condition) == 1) {
                $conditions[$field] = $field . $condition[0];
            } elseif ($operator === 'IN') {
                $placeholder = ':' . $field;
                $values = $condition[1];
                $placeholder_list = array();
                foreach ($values as $key => $value) {
                    $placeholder_in = $placeholder . $key;
                    $placeholder_list[] = $placeholder_in;
                    $placeholders[$placeholder_in] = $value;
                }
                $value = implode(',', $values);
                $placeholder_string = implode(',', $placeholder_list);
                $conditions[$field] = $field . ' '
                              . $operator . ' '
                              . '(' . $placeholder_string . ')';
            } else {
                $placeholder = ':' . $field;
                $value = $condition[1];
                $conditions[$field] = $field . $operator . $placeholder;
                $placeholders[$placeholder] = $value;
            }
        }

        return array($conditions, $placeholders);
    }
}
