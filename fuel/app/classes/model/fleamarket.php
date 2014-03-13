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
