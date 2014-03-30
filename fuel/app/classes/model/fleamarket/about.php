<?php

/**
 * FleamarketAbouts Model
 *
 * フリーマーケット説明情報テーブル
 *
 * @author ida
 */
class Model_Fleamarket_About extends \Orm\Model
{
    /**
     * 説明区分
     */
    const ACCESS = 1;
    const EVENT_TIME = 2;
    const BOOTH = 3;
    const SHOP_STYLE = 4;
    const SHOP_FEE = 5;
    const SHOP_CAUTION = 6;
    const PARKING = 7;

    /**
     * 説明区分タイトルリスト
     */
    protected static $about_titles = array(
        self::ACCESS        => '最寄り駅または交通アクセス',
        self::EVENT_TIME    => '開催時間について',
        self::BOOTH         => '募集ブース数について',
        self::SHOP_STYLE    => '出店形態について',
        self::SHOP_FEE      => '出店料金について',
        self::SHOP_CAUTION  => '出店に際してのご注意',
        self::PARKING       => '駐車場について',
    );

    /**
     * 説明区分リスト
     */
    protected static $about_names = array(
        self::ACCESS        => 'about_access',
        self::EVENT_TIME    => 'about_event_time',
        self::BOOTH         => 'about_booth',
        self::SHOP_STYLE    => 'about_shop_style',
        self::SHOP_FEE      => 'about_shop_fee',
        self::SHOP_CAUTION  => 'about_shop_caution',
        self::PARKING       => 'about_parking',
    );

    protected static $_table_name = 'fleamarket_abouts';

    protected static $_primary_key  = array('fleamarket_about_id');

    protected static $_properties = array(
        'fleamarket_about_id' => array(
            'form'  => array('type' => false)
        ),
        'fleamarket_id' => array(
            'form'  => array('type' => false)
        ),
        'about_id' => array(
            'form'  => array('type' => false)
        ),
        'title' =>  array(
            'label' => 'タイトル',
            'validation' => array(
                'max_length' => array(50)
            )
        ),
        'description' => array(
            'label' => '内容',
            'validation' => array(
                'max_length' => array(500)
            )
        ),
        'created_user' => array(
            'form'  => array('type' => false)
        ),
        'updated_user' => array(
            'form'  => array('type' => false)
        ),
        'created_at' => array(
            'form'  => array('type' => false)
        ),
        'updated_at' => array(
            'form'  => array('type' => false)
        ),
        'deleted_at' => array(
            'form'  => array('type' => false)
        ),
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

    /**
     * 説明区分表示名リストを取得する
     *
     * @access public
     * @return array
     * @author
     */
    public static function getAboutTitles()
    {
        return self::$about_titles;
    }

    /**
     * 説明区分リストを取得する
     *
     * @access public
     * @return array
     * @author
     */
    public static function getAboutNames()
    {
        return self::$about_names;
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

    /*
     * Fieldsetオブジェクトの生成
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function createFieldset()
    {
        $about = self::forge();
        $fieldset = \Fieldset::forge('fleamarket_about');
        $fieldset->add_model($about);

        return $fieldset;
    }
}
