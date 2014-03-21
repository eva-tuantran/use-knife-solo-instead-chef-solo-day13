<?php

/**
 * Entry Model
 *
 * 出店予約情報テーブル
 *
 * @author ida
 */
class Model_Entry extends \Orm\Model_Soft
{
    /**
     * テーブル名
     *
     * @var string $table_name
     */
    protected static $_table_name = 'entries';

    /**
     * プライマリーキー
     *
     * @var string $_primary_key
     */
    protected static $_primary_key  = array('entry_id');


    protected static $_properties = array(
        'entry_id',
        'user_id',
        'fleamarket_id',
        'fleamarket_entry_style_id',
        'reservation_number',
        'item_category',
        'item_genres',
        'reserved_booth',
        'link_from',
        'remarks',
        'entry_status',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
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


    const ENTRY_STATUS_RESERVED = 1;
    const ENTRY_STATUS_WAITING  = 2;
    const ENTRY_STATUS_CANCELED = 3;


    /**
     * エントリスタイルごとの予約数を取得する
     *
     * @access public
     * @param int $fleamarket_id フリーマーケットID
     * @return array
     * @author ida
     */
    public static function getTotalEntryByFlearmarketId($fleamarket_id)
    {
        if (! $fleamarket_id) {
            return null;
        }

        $placeholders = array('flearmarket_id' => $fleamarket_id);
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    fleamarket_entry_style_id,
    COUNT(user_id) AS entry_count,
    SUM(reserved_booth) AS reserved_booth
FROM
    {$table_name}
WHERE
    fleamarket_id = :flearmarket_id
GROUP BY
    fleamarket_entry_style_id
QUERY;
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows;
    }
}
