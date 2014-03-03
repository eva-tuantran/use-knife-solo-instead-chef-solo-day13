<?php
namespace Model;

use \DB;

/**
 * Locations Model
 *
 * 開催地情報
 *
 * @author ida
 */
class Locations extends \Model
{
    /**
     * 登録タイプ定数
     */
    const REGISTER_TYPE_ADMIN = 1;
    const REGISTER_TYPE_USER = 2;

    /**
     * テーブル名
     *
     * @var string $table_name
     */
    protected static $table_name = 'locations';

    /**
     * 指定されたIDで開催地情報を取得する
     *
     * @access public
     * @param mixed $location_id フリーマーケットID
     * @return array 開催地情報
     * @author ida
     */
    public static function find($location_id = null)
    {
        if (! $location_id) {
            return null;
        }

        $placeholders = array('location_id' => $location_id);
        $table_name = self::$table_name;
        $query = <<<"QUERY"
SELECT * FROM {$table_name} WHERE location_id = :location_id
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
     * 開催地情報を登録する
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
        $table_name = self::$table_name;
        $query = <<<"QUERY"
INSERT INTO {$table_name}({$fields}) VALUES ({$values})
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
     * 開催地情報を更新する
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

        $location_id = $data['location_id'];
        $placeholders = array();
        $field_list = array();
        foreach ($data as $field => $value) {
            $placeholder = ':' . $field;
            $field_list[] = $field . '=' . $placeholder;
            $placeholders[$placeholder] = $value;
        }

        $fields = implode(',', $field_list);
        $table_name = self::$table_name;
        $query = <<<"QUERY"
UPDATE FROM {$table_name} SET {$fields} WHERE location_id = :location_id
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
