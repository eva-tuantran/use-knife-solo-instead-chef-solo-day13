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
     * @access public
     * @param array $condition_list 検索条件
     * @param mixed $page ページ
     * @param mixed $row_count ページあたりの行数
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findBySearch(
        $condition_list, $page = 0, $row_count = 0
    ) {
        $placeholders = array(
            ':display_flag' => FLEAMARKET_DISPLAY_FLAG_ON,
            ':about_access_id' => FLEAMARKET_ABOUT_ACCESS,
            ':register_status' => LOCATION_REGISTER_TYPE_ADMIN,
        );

        $where = '';
        if (! empty($condition_list)) {
            $conditions = array();
            foreach ($condition_list as $condition) {
                $field = $condition[0];
                $placeholder = ':' . $field;
                $operator = $condition[1];
                if ($operator === 'IN') {
                    $value = implode(',', $condition[2]);
                    $conditions[] = $field . ' ' . $operator . ' (' . $placeholder . ')';
                } else {
                    $value = @trim($condition[2]);
                    $conditions[] = $field . ' ' . $operator . ' ' . $placeholder;
                }
                $placeholders[$placeholder] = $value;
            }

            $where = ' AND ';
            $where .= implode(' AND ', $conditions);
        }

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page * $row_count) - 1;
            $limit = ' LIMIT ' . $offset . ', ' . $row_count;
        }

        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    DATE_FORMAT(f.event_date, '%Y年%m月%d日') AS event_date,
    DATE_FORMAT(f.event_time_start, '%k時%i分') AS event_time_start,
    DATE_FORMAT(f.event_time_end, '%k時%i分') AS event_time_end,
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
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_entry_styles AS fes ON f.fleamarket_id = fes.fleamarket_id
WHERE
    f.display_flag = :display_flag
    {$where}
ORDER BY
    f.register_type = :register_status,
    f.event_date DESC,
    f.event_time_start
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
    public static function findBySearchCount($condition_list)
    {
        $placeholders = array(
            ':display_flag' => FLEAMARKET_DISPLAY_FLAG_ON,
            ':about_access_id' => FLEAMARKET_ABOUT_ACCESS,
            ':register_status' => LOCATION_REGISTER_TYPE_ADMIN,
        );

        $where = '';
        if (! empty($condition_list)) {
            $conditions = array();
            foreach ($condition_list as $condition) {
                $field = $condition[0];
                $placeholder = ':' . $field;
                $operator = $condition[1];
                if ($operator === 'IN') {
                    $value = implode(',', $condition[2]);
                    $conditions[] = $field . ' ' . $operator . ' (' . $placeholder . ')';
                } else {
                    $value = @trim($condition[2]);
                    $conditions[] = $field . ' ' . $operator . ' ' . $placeholder;
                }
                $placeholders[$placeholder] = $value;
            }

            $where = ' AND ';
            $where .= implode(' AND ', $conditions);
        }

        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    COUNT(f.fleamarket_id) AS cnt
FROM
    {$table_name} AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_entry_styles AS fes ON f.fleamarket_id = fes.fleamarket_id
WHERE
    f.display_flag = :display_flag
    {$where}
ORDER BY
    f.register_type = :register_status,
    f.event_date DESC,
    f.event_time_start
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

        $res = false;
        if (! empty($result)) {
            $res['last_insert_id'] = $result[0];
            $res['affected_rows'] = $result[1];
        }

        return $res;
    }

    /**
     * フリーマーケット情報を更新する
     *
     * @access public
     * @param array $data 更新するデータ配列
     * @return int 更新した件数
     * @author ida
     */
    public static function update($data)
    {
        if (! $data || ! isset($data['flearmarket_id'])) {
            return false;
        }

        $placeholders = array('flearmarket_id' => $data['fleamarket_id']);
        unset($data['fleamarket_id']);
        $field_list = array();


        foreach ($data as $field => $value) {
            $placeholder = ':' . $field;
            $field_list[] = $field . '=' . $placeholder;
            $placeholders[$placeholder] = $value;
        }

        $fields = implode(',', $field_list);
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
UPDATE FROM {$table_name} SET {$fields},updated_at=now()
WHERE fleamarket_id = :fleamarket_id
QUERY;
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        return $result;
    }
}
