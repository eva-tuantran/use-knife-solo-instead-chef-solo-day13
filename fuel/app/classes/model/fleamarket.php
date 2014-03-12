<?php
namespace Model;

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
     *  1:開催予定,2:予約受付中,3:受付終了,4:開催終了,5:中止
     */
    const EVENT_SCHEDULE = 1;
    const EVENT_RESERVATION_RECEIPT = 2;
    const EVENT_RECEIPT_END = 3;
    const EVENT_CLOSE = 4;
    const EVENT_CANCEL = 5;

    /**
     * 出店料
     *  1:有料,2:無料
     */
    const SHOP_FEE_FLAG_CHARGE = 1;
    const SHOP_FEE_FLAG_FREE = 2;

    /**
     * 車出店
     *  0:NG,1:OK
     */
    const CAR_SHOP_FLAG_NG = 0;
    const CAR_SHOP_FLAG_OK = 1;

    /**
     * プロ出店
     *  0:NG,1:OK
     */
    const PRO_SHOP_FLAG_NG = 0;
    const PRO_SHOP_FLAG_OK = 1;

    /**
     * 有料駐車場
     *  有料駐車場 0:なし,1:あり
     */
    const CHARGE_PARKING_FLAG_NONE = 0;
    const CHARGE_PARKING_FLAG_EXIST = 1;

    /**
     * 無料駐車場
     *  無料駐車場 0:なし,1:あり
     */
    const FREE_PARKING_FLAG_NONE = 0;
    const FREE_PARKING_FLAG_EXIST = 1;

    /**
     * 雨天開催会場
     *  0:NG 1:OK
     */
    const RAINY_LOCATION_FLAG_NONE = 0;
    const RAINY_LOCATION_FLAG_EXIST = 1;

    /**
     * 登録タイプ
     *  1:運営者,2:ユーザ投稿
     */
    const REGISTER_TYPE_ADMIN = 1;
    const REGISTER_TYPE_USER = 2;

    /**
     * 表示フラグ
     *  0:非表示,1:表示
     */
    const DISPLAY_FLAG_OFF = 0;
    const DISPLAY_FLAG_ON = 1;

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
            $rows = $result->as_array();
        }

        return $rows;
    }

    /**
     * 指定された条件でフリーマーケット情報リストを取得する
     *
     * フリーマーケット説明情報をJOINする
     *
     * @TODO: about_idの指定をかえたい
     *
     * @access public
     * @param array $conditions 検索条件
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findBySearch($conditions)
    {
var_dump($conditions);
        if (!empty($conditions)) {
            $placeholders = array();
            $condition_list = array();

            foreach ($conditions as $condition) {
                $field = $condition[0];
                $placeholder = ':' . $field;
                $operator = $condition[1];
                $value = trim($condition[2]);
                $condition_list[] = $field . ' ' . $operator . ' ' . $placeholder;
                $placeholders[$placeholder] = $value;
            }
        }

        $table_name = self::$_table_name;
        $placeholders[':display_flag'] = self::DISPLAY_FLAG_ON;
        $where = implode(' AND ', $condition_list);
        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    DATE_FORMAT(f.event_date, '%Y年%m月%d日') AS event_date,
    DATE_FORMAT(f.event_start_time, '%k時%i分') AS event_start_time,
    DATE_FORMAT(f.event_end_time, '%k時%i分') AS event_end_time,
    f.event_status,
    f.description,
    f.reservation_start,
    f.reservation_end,
    f.reservation_tel,
    f.reservation_email,
    f.website,
    f.shop_fee_flag,
    f.car_shop_flag,
    f.pro_shop_flag,
    f.charge_parking_flag,
    f.free_parking_flag,
    f.rainy_location_flag,
    f.register_type,
    l.name AS location_name,
    l.zip AS zip,
    l.prefecture_id AS prefecture_id,
    l.address AS address,
    l.googlemap_address AS googlemap_address,
    fa.description AS about_access
FROM
    {$table_name} AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = 1
WHERE
    {$where}
    AND f.display_flag = :display_flag
ORDER BY
    f.event_date DESC,
    f.event_start_time DESC
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
     * 指定された条件でフリーマーケット情報リストを取得する
     *
     * フリーマーケット説明情報をJOINする
     *
     * @TODO: about_idの指定をかえたい
     *
     * @access public
     * @param array $conditions 検索条件
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findJoins($conditions)
    {
        return array();
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
            $rows = $result->as_array();
        }

        return $rows;
    }
}
