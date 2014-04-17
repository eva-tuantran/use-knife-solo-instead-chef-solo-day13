<?php

/**
 * Fleamarket_Entry_Style Model
 *
 * フリーマーケット出店形態情報テーブル
 *
 * @author ida
 */
class Model_Fleamarket_Entry_Style extends Model_Base
{
    /**
     * テーブル名
     *
     * @var string $table_name
     */
    protected static $_table_name = 'fleamarket_entry_styles';

    /**
     * プライマリーキー
     *
     * @var string $_primariy
     */
    protected static $_primary_key  = array('fleamarket_entry_style_id');

    /**
     * フィールド設定
     *
     * @var array
     */
    protected static $_properties = array(
        'fleamarket_entry_style_id',
        'fleamarket_id',
        'entry_style_id',
        'booth_fee',
        'max_booth',
        'reservation_booth_limit',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
    );

    /**
     * オブサーバ設定
     *
     * @var array
     */
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => true,
        ),
    );

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

    /**
     * エントリスタイルごとの予約数を取得する
     *
     * @access public
     * @param int $fleamarket_id フリーマーケットID
     * @return array
     * @author ida
     */
    public static function getMaxBoothByFleamarketId(
        $fleamarket_id, $is_entry_style_grouping = true
    ) {
        if (! $fleamarket_id) {
            return null;
        }

        $placeholders = array(
            ':flearmarket_id' => $fleamarket_id,
        );

        $field = '';
        $groupby = '';
        if ($is_entry_style_grouping) {
            $field = "entry_style_id,";
            $groupby = " GROUP BY entry_style_id";
        }
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    {$field}
    SUM(max_booth) AS max_booth
FROM
    {$table_name}
WHERE
    fleamarket_id = :flearmarket_id
{$groupby}
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
     * 予約ブース数の総数を取得
     *
     * @access public
     * @param  int
     * @return bool
     * @author kobayasi
     */
    public function sumReservedBooth()
    {
        $query = DB::select(DB::expr('SUM(reserved_booth) as sum_result'));
        $query->from(\Model_Entry::table());

        $query->where(array(
            'fleamarket_id'             => $this->fleamarket_id,
            'fleamarket_entry_style_id' => $this->fleamarket_entry_style_id,
            'entry_status'              => \Model_Entry::ENTRY_STATUS_RESERVED,
        ));

        return $query->execute()->get('sum_result');
    }

    /**
     * 予約ブース数の最大数を超えてしまったかどうか
     *
     * @access public
     * @param  int
     * @return bool
     * @author kobayasi
     */
    public function isOverReservationLimit()
    {
        return $this->max_booth < $this->sumReservedBooth();
    }

    /**
     * キャンセル待ちが必要かどうか
     *
     * @access public
     * @param  int
     * @return bool
     * @author kobayasi
     */
    public function isNeedWaiting()
    {
        return $this->max_booth <= $this->sumReservedBooth();
    }

    /**
     * キャンセル待ちしているエントリーを取得
     *
     * @access public
     * @param  void
     * @return Model_Entry の array
     * @author kobayasi
     */
    public function getWaitingEntry()
    {
        $entries =
            \Model_Entry::query()
            ->where(array(
                'fleamarket_id'             => $this->fleamarket_id,
                'fleamarket_entry_style_id' => $this->fleamarket_entry_style_id,
                'entry_status'              => \Model_Entry::ENTRY_STATUS_WAITING,
            ))
            ->get();
        return $entries;
    }
}
