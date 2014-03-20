<?php

class Model_Entry extends \Orm\Model
{
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

    protected static $_primary_key = array('entry_id');

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
                'reserved_booth' => array(
                    'valid_string' => array('numeric'),
                ),
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

	protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property' => 'created_at',
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => true,
            'property' => 'updated_at',
        ),
	);
	protected static $_table_name = 'entries';


    public static function getItemCategoryDefine()
    {
        return self::$item_category_define;
    }

    public static function getItemGenresDefine()
    {
        return self::$item_genres_define;
    }

    public function _validation_reserved_booth($reserved_booth)
    {
        $query = DB::select(DB::expr('SUM(reserved_booth) as sum_result'));
        $query->from(self::$_table_name);

        $query->where(array(
            'fleamarket_id'             => $this->fleamarket_id,
            'fleamarket_entry_style_id' => $this->fleamarket_entry_style_id,
        ));

        $sum = $query->execute()->get('sum_result');

        return $this->fleamarket_entry_style->reservation_booth_limit >= $sum + $reserved_booth;
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
}
