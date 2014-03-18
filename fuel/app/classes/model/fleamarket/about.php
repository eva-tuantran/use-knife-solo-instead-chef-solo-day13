<?php
namespace Model;

/**
 * FleamarketAbouts Model
 *
 * フリーマーケット説明情報テーブル
 *
 * @author ida
 */
class Fleamarket_About extends \Model
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
            $rows = $result->as_array();
        }

        return $rows;
    }


    /**
     * 指定されたフリーマーケットIDでフリーマーケット説明情報を取得する
     *
     * @access public
     * @param mixed $fleamarket_id フリーマーケットID
     * @param array $options オプション設定
     *  'field': 取得するフィールドを配列で指定する
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findByFleamarketId(
        $fleamarket_id = null, $options = array()
    ) {
        if (! $fleamarket_id) {
            return null;
        }

        $defaults = array('field' => array('*'));
        $options = array_merge($defaults, $options);
        $fielsds = implode(',', $options['field']);

        $placeholders = array('flearmarket_id' => $fleamarket_id);
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT {$fielsds} FROM {$table_name} WHERE fleamarket_id = :flearmarket_id
ORDER BY about_id
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
INSERT INTO {$table_name}({$fields},created_at) VALUES ({$values},now())
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
     * フリーマーケット説明情報を登録する
     *
     * @access public
     * @param array $data_list 登録するデータ配列
     * @return bool 登録結果
     * @author ida
     */
    public static function insertMany($data_list)
    {
        if (! $data_list) {
            return false;
        }

        $res = true;
        foreach ($data_list as $data) {
            $result = self::insert($data);
            if (! $result['affected_rows'] == 0) {
                $res = false;
                break;
            }
        }

        return $res;
    }

    /**
     * フリーマーケット説明情報を更新する
     *
     * @access public
     * @param array $data 更新するデータ配列
     * @return int 更新した件数
     * @author ida
     */
    public static function update($data)
    {
        if (! $data || ! isset($data['fleamarket_about_id'])) {
            return false;
        }

        $placeholders = array(
            'fleamarket_about_id' => $data['fleamarket_about_id']
        );
        unset($data['fleamarket_about_id']);
        $field_list = array();

        foreach ($data as $field => $value) {
            $placeholder = ':' . $field;
            $field_list[] = $field . '=' . $placeholder;
            $placeholders[$placeholder] = $value;
        }

        $fields = implode(',', $field_list);
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
UPDATE {$table_name} SET {$fields},updated_at=now()
WHERE fleamarket_about_id = :fleamarket_about_id
QUERY;
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        return $result;
    }
}
