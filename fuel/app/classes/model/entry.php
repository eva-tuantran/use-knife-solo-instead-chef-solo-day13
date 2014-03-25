<?php

/**
 * Entry Model
 *
 * 出店予約情報テーブル
 *
 * @author ida
 */
class Model_Entry extends \Orm\Model_Soft
{
    /**
     * テーブル名
     *
     * @var string $table_name
     */
    protected static $_table_name = 'entries';

    /**
     * プライマリーキー
     *
     * @var string $_primary_key
     */
    protected static $_primary_key  = array('entry_id');

    protected static $_belongs_to = array(
        'fleamarket' => array(
            'key_to' => 'fleamarket_id',
        ),
        'fleamarket_entry_style' => array(
            'key_to' => 'fleamarket_entry_style_id',
        ),
    );
    
    protected static $_properties = array(
        'entry_id',
        'user_id',
        'fleamarket_id',
        'fleamarket_entry_style_id' => array(
            'label'     => '出店方法',
            'validation' => array(
                'required',
                'fleamarket_entry_style_id',
            ),
        ),
        'reservation_number',
        'item_category' => array(
            'label' => '出品物の種類',
            'validation' => array(
                'required',
                'numeric_min' => array(self::ITEM_CATEGORY_MIN),
                'numeric_max' => array(self::ITEM_CATEGORY_MAX),
            ),
        ),
        'item_genres' => array(
            'label' => 'ジャンル',
            'validation' => array(
                'required',
                'numeric_min' => array(self::ITEM_GENRES_MIN),
                'numeric_max' => array(self::ITEM_GENRES_MAX),
            ),
        ),
        'reserved_booth' => array(
            'label'     => '予約ブース数',
            'validation' => array(
                'required',
                'valid_string' => array('numeric'),
            ),
        ),
        'link_from',
        'remarks',
        'entry_status',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
    );

    protected static $_soft_delete = array(
        'deleted_field'   => 'deleted_at',
        'mysql_timestamp' => true,
    );


    protected static $_observers = array(
        'Orm\\Observer_CreatedAt' => array(
            'events'          => array('before_insert'),
            'mysql_timestamp' => true,
            'property'        => 'created_at',
        ),
        'Orm\\Observer_UpdatedAt' => array(
            'events'          => array('before_update'),
            'mysql_timestamp' => true,
            'property'        => 'updated_at',
        ),
    );


    const ENTRY_STATUS_RESERVED = 1;
    const ENTRY_STATUS_WAITING  = 2;
    const ENTRY_STATUS_CANCELED = 3;


    /**
     * エントリスタイルごとの予約数を取得する
     *
     * @access public
     * @param int $fleamarket_id フリーマーケットID
     * @return array
     * @author ida
     */
    public static function getTotalEntryByFlearmarketId($fleamarket_id)
    {
        if (! $fleamarket_id) {
            return null;
        }

        $placeholders = array('flearmarket_id' => $fleamarket_id);
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    fleamarket_entry_style_id,
    COUNT(user_id) AS entry_count,
    SUM(reserved_booth) AS reserved_booth
FROM
    {$table_name}
WHERE
    fleamarket_id = :flearmarket_id
GROUP BY
    fleamarket_entry_style_id
QUERY;
        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows;
    }

    const ITEM_CATEGORY_RECYCLE  = 1;
    const ITEM_CATEGORY_HANDMADE = 2;

    const ITEM_CATEGORY_MIN = 1;
    const ITEM_CATEGORY_MAX = 2;

    private static $item_category_define = array(
        self::ITEM_CATEGORY_RECYCLE  => 'リサイクル品',
        self::ITEM_CATEGORY_HANDMADE => '手作り品',
    );

    const ITEM_GENRES_COMPUTER = 1;
    const ITEM_GENRES_AV       = 2;
    const ITEM_GENRES_CAMERA   = 3;
    const ITEM_GENRES_MUSIC    = 4;
    const ITEM_GENRES_TOY      = 5;
    const ITEM_GENRES_ANTIQUE  = 6;
    const ITEM_GENRES_SPORTS   = 7;
    const ITEM_GENRES_FASHION  = 8;
    const ITEM_GENRES_JEWELRY  = 9;
    const ITEM_GENRES_BEAUTY   = 10;
    const ITEM_GENRES_INTERIOR = 11;
    const ITEM_GENRES_OFFICE   = 12;
    const ITEM_GENRES_BABY     = 13;
    const ITEM_GENRES_GOODS    = 14;
    const ITEM_GENRES_COMMIC   = 15;

    const ITEM_GENRES_MIN = 1;
    const ITEM_GENRES_MAX = 15;

    private static $item_genres_define = array(
        self::ITEM_GENRES_COMPUTER => 'コンピュータ',
        self::ITEM_GENRES_AV       => '家電、AV',
        self::ITEM_GENRES_CAMERA   => 'カメラ',
        self::ITEM_GENRES_MUSIC    => '音楽、CD',
        self::ITEM_GENRES_TOY      => 'おもちゃ、ゲーム',
        self::ITEM_GENRES_ANTIQUE  => 'アンティーク、一点もの',
        self::ITEM_GENRES_SPORTS   => 'スポーツ、レジャー',
        self::ITEM_GENRES_FASHION  => 'ファッション、ブランド',
        self::ITEM_GENRES_JEWELRY  => 'アクセサリー、時計',
        self::ITEM_GENRES_BEAUTY   => 'ビューティ、ヘルスケア',
        self::ITEM_GENRES_INTERIOR => 'インテリア、DIY',
        self::ITEM_GENRES_OFFICE   => '事務、店舗用品',
        self::ITEM_GENRES_BABY     => 'ベビー用品',
        self::ITEM_GENRES_GOODS    => 'タレントグッズ',
        self::ITEM_GENRES_COMMIC   => 'コミック、アニメグッズ',
    );

    /**
     * カテゴリの番号と名前の連想配列を返す
     *
     * @access public
     * @return array
     * @author kobayasi
     */
    public static function getItemCategoryDefine()
    {
        return self::$item_category_define;
    }

    /**
     * ジャンルの番号と名前の連想配列を返す
     *
     * @access public
     * @return array
     * @author kobayasi
     */
    public static function getItemGenresDefine()
    {
        return self::$item_genres_define;
    }

    /**
     * fleamarket_entry_style_id が fleamarket_entry_styles テーブルに
     * 存在するかチェック
     *
     * @access public
     * @param  int
     * @return bool
     * @author kobayasi
     */
    public function _validation_fleamarket_entry_style_id($fleamarket_entry_style_id)
    {
        if (! $this->fleamarket_id) {
            return false;
        }

        $count = Model_Fleamarket_Entry_Style::query()->where(array(
            'fleamarket_id' => $this->fleamarket_id,
            'fleamarket_entry_style_id' => $fleamarket_entry_style_id,
        ))->count();

        return $count > 0;
    }

    /*
     * Fieldsetオブジェクトの生成
     *
     * @access public
     * @return string
     */
    public static function createFieldset($input)
    {
        $entry = self::forge($input);
        $fieldset = Fieldset::forge();
        $fieldset->add_model($entry);
        return $fieldset;
    }
}
