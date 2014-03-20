<?php

/**
 * Entry Model
 *
 * 出店予約情報テーブル
 *
 * @author ida
 */
class Model_Entry extends \Orm\Model
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
