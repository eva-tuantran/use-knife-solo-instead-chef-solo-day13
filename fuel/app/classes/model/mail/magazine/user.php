<?php

/**
 * mail_magazine_user Model
 *
 * メールマガジン情報テーブル
 *
 * @author ida
 */
class Model_Mail_Magazine_User extends Model_Base
{
    /**
     * 送信ステータス 送信ステータス 0:送信待ち,1:送信済,2:送信エラー3,未送信
     */
    const SEND_STATUS_WAITING = 0;
    const SEND_STATUS_NORMAL_END = 1;
    const SEND_STATUS_ERROR_END = 2;
    const SEND_STATUS_UNSENT = 3;

    protected static $_table_name = 'mail_magazine_users';

    protected static $_primary_key = array('mail_magazine_user_id');

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

    protected static $_soft_delete = array(
        'deleted_field'   => 'deleted_at',
        'mysql_timestamp' => true,
    );

    protected static $_belongs_to = array(
        'user' => array(
            'model_to' => 'Model_User',
            'key_from' => 'user_id',
            'key_to' => 'user_id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );

    /**
     * 送信ステータス一覧
     */
    private static $send_statuses = array(
        self::SEND_STATUS_WAITING => '未送信',
        self::SEND_STATUS_NORMAL_END => '送信済',
        self::SEND_STATUS_ERROR_END => '送信エラー',
        self::SEND_STATUS_UNSENT => '未送信',
    );

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
     * 指定されたメルマガIDでユーザ一覧を取得する
     *
     * @access public
     * @param mixed $mail_magazine_id メルマガID
     * @param int $page 取得を開始するデータの位置
     * @param int $limit 取得する件数
     * @return array
     * @author ida
     */
    public static function findByMailMagazineId(
        $mail_magazine_id, $offset = 0, $limit = 0
    ) {
        $placeholders = array(':mail_magazine_id' => $mail_magazine_id);

        $query = \DB::select(
            'mmu.mail_magazine_user_id',
            'mmu.user_id',
            'u.last_name',
            'u.first_name',
            'u.email',
            'mmu.send_status'
        );
        $query->from(array('mail_magazine_users', 'mmu'))
            ->join(array('users', 'u'), 'inner')
            ->on('mmu.user_id', '=', 'u.user_id')
            ->on('u.deleted_at', 'IS', \DB::expr('NULL'))
            ->where(array(
                array('mmu.mail_magazine_id', '=', $mail_magazine_id),
            ))
            ->order_by('mmu.mail_magazine_user_id', 'asc')
            ->limit($limit)
            ->offset($offset);
        $result = $query->as_object()->execute();;

        return $result;
    }

    /**
     * 指定されたメルマガIDでユーザ一覧を取得する
     *
     * @access public
     * @param mixed $mail_magazine_id メルマガID
     * @param mixed $page ページ
     * @param mixed $row_count ページあたりの行数
     * @return array
     * @author ida
     */
    public static function findListByMailMagazineId(
        $mail_magazine_id, $page = 0, $row_count = 0
    ) {
        $placeholders = array(':mail_magazine_id' => $mail_magazine_id);

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = ' LIMIT ' . $offset . ', ' . $row_count;
        }

        $query = <<<"QUERY"
SELECT
    mmu.user_id,
    u.last_name,
    u.first_name,
    mmu.send_status,
    mmu.updated_at
FROM
    mail_magazine_users AS mmu
LEFT JOIN
    users AS u ON mmu.user_id = u.user_id
WHERE
    mail_magazine_id = :mail_magazine_id
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
     * 指定されたメルマガIDでユーザ一覧を取得する
     *
     * @access public
     * @param mixed $mail_magazine_id メルマガID
     * @return array
     * @author ida
     */
    public static function getCountByMailMagazineId($mail_magazine_id)
    {
        $placeholders = array(':mail_magazine_id' => $mail_magazine_id);

        $query = <<<"QUERY"
SELECT
    COUNT(user_id) AS cnt
FROM
    mail_magazine_users
WHERE
    mail_magazine_id = :mail_magazine_id
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
     * 更新する
     *
     * @access public
     * @param array $values
     * @param array $where
     * @return bool
     * @author ida
     */
    public static function updateStatus($values = array(), $where = array())
    {
        $result = false;
        if (! empty($values) && ! empty($where)) {
            $db = \Database_Connection::instance('master');
            $values['updated_at'] = \Date::forge()->format('mysql');
            $result = \DB::update(self::$_table_name)
                ->set($values)
                ->where($where)
                ->execute($db);
        }

        return $result;
    }
}
