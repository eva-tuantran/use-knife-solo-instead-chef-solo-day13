<?php
namespace Model;

use \DB;

/**
 * Fleamarkets Model
 *
 * フリーマーケット情報テーブル
 *
 * @author ida
 */
class Fleamarket extends \Model
{
    /**
     * 開催状況ステータス
     */
    const EVENT_SCHEDULE = 1;
    const EVENT_RESERVATION_RECEIPT = 2;
    const EVENT_RECEIPT_END = 3;
    const EVENT_CLOSE = 4;
    const EVENT_CANCEL = 5;

    /**
     * 予約可否フラグ
     */
    const RESERVATION_FLAG_NG = 0;
    const RESERVATION_FLAG_OK = 0;

    /**
     * 車出店可否フラグ
     */
    const CAR_SHOP_FLAG_NG = 0;
    const CAR_SHOP_FLAG_OK = 0;

    /**
     * 車出店可否フラグ
     */
    const PARKING_FLAG_NG = 0;
    const PARKING_FLAG_OK = 0;

    /**
     * 出店料フラグ
     */
    const SHOP_FEE_FLAG_FREE = 0;
    const PARKING_FLAG_CHARGE = 1;

    /**
     * 表示フラグ
     */
    const DISPLAY_FLAG_OFF = 0;
    const DISPLAY_FLAG_ON = 1;

    /**
     * 登録タイプ
     */
    const REGISTER_TYPE_ADMIN = 1;
    const REGISTER_TYPE_USER = 2;

    /**
     * テーブル名
     *
     * @var string $table_name
     */
    protected static $_table_name = 'fleamarkets';

    /**
     * 指定されたIDでフリーマーケット情報を取得する
     *
     * @access public
     * @param mixed $fleamarket_id フリーマーケットID
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function find($fleamarket_id = null)
    {
        if (! $fleamarket_id) {
            return null;
        }

        $placeholders = array('flearmarket_id' => $fleamarket_id);
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT * FROM {$table_name} WHERE fleamarket_id = :flearmarket_id
QUERY;
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_assoc();
        }

        return $rows;
    }

    /**
     * フリーマーケット情報を登録する
     *
     * @access public
     * @param array $data 登録するデータ配列
     * @return array 登録結果
     * @author ida
     */
    public static function insert($data)
    {
        if (! $data) {
            return false;
        }

        $placeholders = array();
        $field_list = array();
        $value_list = array();
        foreach ($data as $field => $value) {
            $placeholder = ':' . $field;
            $field_list[] = $field;
            $value_list[] = $placeholder;
            $placeholders[$placeholder] = $value;
        }

        $fields = implode(',', $field_list);
        $values = implode(',', $value_list);
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
INSERT INTO {$table_name}({$fields},created_at) VALUES ({$values}, now())
QUERY;
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = false;
        if (! empty($result)) {
            $rows['last_insert_id'] = $result[0];
            $rows['affected_rows'] = $result[1];
        }
        return $rows;
    }

    /**
     * フリーマーケット情報を更新する
     *
     * @access public
     * @param array $data 更新するデータ配列
     * @return array 登録結果
     * @author ida
     */
    public static function update($data)
    {
        if (! $data) {
            return false;
        }

        $placeholders = array();
        $field_list = array();
        foreach ($data as $field => $value) {
            $placeholder = ':' . $field;
            $field_list[] = $field . '=' . $placeholder;
            $placeholders[$placeholder] = $value;
        }

        $fields = implode(',', $field_list);
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
UPDATE FROM {$table_name} SET {$fields},updated_at = now()
WHERE fleamarket_id = :fleamarket_id
QUERY;
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = false;
        if (! empty($result)) {
            $rows = $result->as_assoc();
        }

        return $rows;
    }
}
