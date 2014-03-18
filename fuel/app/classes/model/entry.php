<?php

class Model_Entry extends \Orm\Model
{
    protected static $_primary_key = array('entry_id');

    protected static $_belongs_to = array('fleamarket','fleamarket_entry_style');
    
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

    public static $item_category_define = array(
        1 => 'リサイクル品',
        2 => '手作り品',
    );

    public static $item_genres_define = array(
        1 => 'コンピュータ',
        2 => '家電、AV',
        3 => 'カメラ',
        4 => '音楽、CD',
        5 => 'おもちゃ、ゲーム',
        6 => 'アンティーク、一点もの',
        7 => 'スポーツ、レジャー',
        8 => 'ファッション、ブランド',
        9 => 'アクセサリー、時計',
        10 => 'ビューティ、ヘルスケア',
        11 => 'インテリア、DIY',
        12 => '事務、店舗用品',
        13 => 'ベビー用品',
        14 => 'タレントグッズ',
        15 => 'コミック、アニメグッズ',
    );
    
    public function _validation_reserved_booth()
    {
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
        foreach (self::properties() as $key => $value){
            if (isset($input[$key])){
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
