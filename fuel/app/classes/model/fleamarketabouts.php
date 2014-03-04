<?php
namespace Model;

use \DB;

/**
 * FleamarketAbouts Model
 *
 * フリーマーケット説明情報テーブル
 *
 * @author ida
 */
class FleamarketAbouts extends \Model
{
    /**
     * テーブル名
     *
     * @var string $table_name
     */
    protected static $_table_name = 'fleamarket_abouts';

    /**
     * 指定されたIDでフリーマーケット説明情報を取得する
     *
     * @access public
     * @param mixed $fleamarket_id フリーマーケットID
     * @return array フリーマーケット説明情報
     * @author ida
     */
    public static function find($fleamarket_about_id = null)
    {
        if (! $fleamarket_about_id) {
            return null;
        }

        $placeholders = array('fleamarket_about_id' => $fleamarket_about_id);
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
     * フリーマーケット説明情報を登録する
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
     * フリーマーケット説明情報を登録する
     *
     * @access public
     * @param array $data_list 更新するデータ配列
     * @return array 登録結果
     * @author ida
     */
    public static function insertMany($data_list)
    {
        if (! $data_list) {
            return false;
        }

        $results = array();
        foreach ($data_list as $data) {
            $results[] = self::insert($data);
        }

        return $results;
    }

    /**
     * フリーマーケット説明情報を更新する
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
UPDATE FROM {$table_name} SET {$fields} WHERE fleamarket_id = :fleamarket_id
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
