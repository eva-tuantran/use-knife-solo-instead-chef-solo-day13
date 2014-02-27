<?php
namespace Model;

use \DB;

/**
 * Fleamarkets Model
 *
 * @author ida
 */
class Fleamarkets extends \Model
{
    /**
     * 表示フラグ定数
     */
    const DISPLAY_FLAG_OFF = 0;
    const DISPLAY_FLAG_ON = 1;

    /**
     * 登録タイプ定数
     */
    const REGISTER_TYPE_ADMIN = 1;
    const REGISTER_TYPE_USER = 2;

    /**
     * テーブル名
     *
     * @var string $tableName
     */
    protected static $table_name = 'fleamarkets';

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
        $query = <<<"QUERY"
SELECT * FROM {$this->table_name} WHERE fleamarket_id = :flearmarket_id
QUERY;
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execut();

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
     * @param array $data 登録するデータ
     * @return array 登録結果
     * @author ida
     */
    public static function insert($data)
    {
        if (! $data) {
            return false;
        }

        $data['register_type'] = 1;
        $data['display_flag'] = 1;
        $data['created_at']  = date('Y-m-d H:i:s');
        $data['created_user'] = 1;

        $placeholders = array();
        $field_list = array();
        $value_list = array();
        foreach ($data as $field => $value) {
            $placeholder = ':' . $field;
            $field_list[] = $field;
            $value_list[] = $placeholder;
            $placeholders[$placeholder] = $value;
        }

        $fields = explode(',', $field_list);
        $values = explode(',', $value_list);
        $query = <<<"QUERY"
INSET INTO {$this->table_name}({$fields}) VALUES ({$values})
QUERY;
echo 'insert query > ' . var_xport($query, true);
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execut();

        $rows = false;
echo 'insert result > ' . var_xport($result, true);
        if (! empty($result)) {
            $rows = $result->as_array();
        }
echo 'insert rows > ' . var_xport($rows, true);
        return $rows;
    }

    /**
     * フリーマーケット情報を更新する
     *
     * @access public
     * @param array $data 登録するデータ
     * @return array 登録結果
     * @author ida
     */
    public static function update($data)
    {
        if (! $data) {
            return false;
        }

        $data['updated_at']  = date('Y-m-d H:i:s');
        $data['updated_user'] = 1;


        $fleamarket_id = $data['fleamarket_id'];
        $placeholders = array();
        $field_list = array();
        foreach ($data as $field => $value) {
            $placeholder = ':' . $field;
            $field_list[] = $field . '=' . $placeholder;
            $placeholders[$placeholder] = $value;
        }

        $fields = explode(',', $field_list);
        $query = <<<"QUERY"
UPDATE FROM {$this->table_name} SET {$fields} WHERE fleamarket_id = :fleamarket_id
QUERY;
echo 'update query > ' . var_xport($query, true);
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execut();

        $rows = false;
echo 'update result > ' . var_xport($result, true);
        if (! empty($result)) {
            $rows = $result->as_array();
        }
echo 'update rows > ' . var_xport($rows, true);
        return $rows;
    }
}
