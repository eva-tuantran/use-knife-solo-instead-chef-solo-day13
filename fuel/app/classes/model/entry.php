<?php

class Model_Entry extends \Orm\Model
{
    protected static $_primary_key = array('entry_id');

    protected static $_belongs_to = array('fleamarket', 'fleamarket_entry_style');
    
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
        ),
		'item_genres' => array(
            'label' => 'ジャンル',
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

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'entries';

    const ITEM_CATEGORY_RECYCLE  = 1;
    const ITEM_CATEGORY_HANDMADE = 2;

    public static $item_category_define = array(
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
    const ITEM_GENRES_JEWELRY  = 9
    const ITEM_GENRES_BEAUTY   = 10;
    const ITEM_GENRES_INTERIOR = 11;
    const ITEM_GENRES_OFFICE   = 12;
    const ITEM_GENRES_BABY     = 13;
    const ITEM_GENRES_GOODS    = 14;
    const ITEM_GENRES_COMMIC   = 15;

    public static $item_genres_define = array(
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
    
    public function _validation_reserved_booth()
    {
        return true;
        return $this->fleamarket_entry_style->reservation_booth_limit >= $this->reserved_booth;
    }

    /*
     * Fieldsetオブジェクトの生成
     *
     * @access public
     * @return string
     */
    public static function createFieldset($input)
    {
        $entry = self::forge();
        foreach (self::properties() as $key => $value) {
            if (isset($input[$key])) {
                $entry->set($key,$input[$key]);
            }
        }
        $fieldset = Fieldset::forge();
        $fieldset->add_model($entry);
        return $fieldset;
    }

    public function _validation_fleamarket_entry_style_id($fleamarket_entry_style_id)
    {
        if (! $this->fleamarket_id) {
            return false;
        }

        $count = self::query()->where(array(
            'fleamarket_id' => $this->fleamarket_id,
            'fleamarket_entry_style_id' => $fleamarket_entry_style_id,
        ))->count();

        return $count > 0;
    }
}
