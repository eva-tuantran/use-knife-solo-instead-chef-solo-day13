<?php
namespace Model;

use \DB;

/**
 * Fleamarket_Entry_Style Model
 *
 * フリーマーケット出店形態情報テーブル
 *
 * @author ida
 */
class Fleamarket_Entry_Style extends \Model
{
    /**
     * テーブル名
     *
     * @var string $table_name
     */
    protected static $_table_name = 'fleamarket_entry_styles';

    /**
     * 指定されたフリーマーケットIDでフリーマーケット出店形態情報を取得する
     *
     * @access public
     * @param mixed $fleamarket_id フリーマーケットID
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function find($fleamarket_entry_style_id = null)
    {
        if (! $fleamarket_entry_style_id) {
            return null;
        }

        $placeholders = array(
            'fleamarket_entry_style_id' => $fleamarket_entry_style_id
        );
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT * FROM {$table_name}
WHERE fleamarket_entry_style_id = :fleamarket_entry_style_id
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
     * 指定されたフリーマーケットIDでフリーマーケット出店形態情報を取得する
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