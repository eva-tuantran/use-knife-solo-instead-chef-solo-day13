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
     * 送信ステータス 送信ステータス 0:未送信(未処理),1:送信済,2:送信エラー
     */
    const SEND_STATUS_UNSENT = 0;
    const SEND_STATUS_NORMAL_END = 1;
    const SEND_STATUS_ERROR_END = 2;

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

    /**
     * 送信ステータス一覧
     */
    private static $send_statuses = array(
        self::SEND_STATUS_UNSENT => '未送信',
        self::SEND_STATUS_NORMAL_END => '送信済',
        self::SEND_STATUS_ERROR_END => '送信エラー',
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
     * @return array
     * @author ida
     */
    public static function findByMailMagazineId($mail_magazine_id)
    {
        $result = self::find('all', array(
            'select'=> array('user_id'),
            'where' => array(
                array('mail_magazine_id' => $mail_magazine_id),
            ),
        ));

        return $result;
    }
}