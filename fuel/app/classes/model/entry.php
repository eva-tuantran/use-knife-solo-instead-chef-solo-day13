<?php

/**
 * Entry Model
 *
 * 出店予約情報テーブル
 *
 * @author ida
 */
class Model_Entry extends Model_Base
{
    /**
     * エントリーステータス 1:エントリ,2:キャンセル待ち,3:キャンセル
     */
    const ENTRY_STATUS_RESERVED = 1;
    const ENTRY_STATUS_WAITING  = 2;
    const ENTRY_STATUS_CANCELED = 3;

    /**
     * 出品物種類 1:リサイクル品,2:手作り品
     */
    const ITEM_CATEGORY_RECYCLE  = 1;
    const ITEM_CATEGORY_HANDMADE = 2;

    /**
     * 出品物種類の最大・最少ID
     */
    const ITEM_CATEGORY_MIN = 1;
    const ITEM_CATEGORY_MAX = 2;

    /**
     * 出品物ジャンル
     */
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

    /**
     * 出品物ジャンルの最大・最少ID
     */
    const ITEM_GENRES_MIN = 1;
    const ITEM_GENRES_MAX = 15;

    /**
     * 出品物種類リスト
     */
    private static $item_category_define = array(
        self::ITEM_CATEGORY_RECYCLE  => 'リサイクル品',
        self::ITEM_CATEGORY_HANDMADE => '手作り品',
    );

    /**
     * 出品物ジャンルリスト
     */
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

    protected static $_table_name = 'entries';

    protected static $_primary_key  = array('entry_id');

    protected static $_belongs_to = array(
        'fleamarket' => array(
            'key_to' => 'fleamarket_id',
        ),
        'fleamarket_entry_style' => array(
            'key_to' => 'fleamarket_entry_style_id',
        ),
        'user' => array(
            'key_to' => 'user_id',
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
     * 特定のフリマに出店予約したユーザを取得する
     *
     * @access public
     * @param int $fleamarket_id フリーマーケットID
     * @return array
     * @author ida
     */
    public static function getEntriesByFleamarketId($fleamarket_id)
    {
        if (! $fleamarket_id) {
            return null;
        }

        $placeholders = array(
            ':flearmarket_id' => $fleamarket_id,
            ':entry_status' => \Model_Entry::ENTRY_STATUS_RESERVED,
        );

        $query = <<<"QUERY"
SELECT
    e.user_id,
    u.last_name,
    u.first_name,
    u.email
FROM
    entries AS e
INNER JOIN
    users AS u ON e.user_id = u.user_id
WHERE
    e.fleamarket_id = :flearmarket_id
    AND e.entry_status = :entry_status
    AND e.deleted_at IS NULL
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
     * @param bool $is_entry_style_grouping 出店形態でグルーピング
     * @return array
     * @author ida
     */
    public static function getTotalEntryByFleamarketId(
        $fleamarket_id, $is_entry_style_grouping = true
    ) {
        if (! $fleamarket_id) {
            return null;
        }

        $placeholders = array(
            ':flearmarket_id' => $fleamarket_id,
            ':entry_status' => Model_Entry::ENTRY_STATUS_RESERVED,
        );

        $field = '';
        $groupby = '';
        if ($is_entry_style_grouping) {
            $field = "fleamarket_entry_style_id,";
            $groupby = " GROUP BY fleamarket_entry_style_id";
        }
        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    {$field}
    COUNT(user_id) AS entry_count,
    SUM(reserved_booth) AS reserved_booth
FROM
    {$table_name}
WHERE
    fleamarket_id = :flearmarket_id
    AND entry_status = :entry_status
    AND deleted_at IS NULL
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
     * 特定のユーザの出店（予約）したフリマ情報の件数を取得します
     *
     * @param mixed $user_id
     * @access public
     * @return void
     * @author shimma
     */
    public static function getUserEntries($user_id, $page = 0, $row_count = 0)
    {
        $placeholders = array(
            'user_id'         => $user_id,
            'about_access_id' => \Model_Fleamarket_About::ACCESS,
            'register_status' => \Model_Fleamarket::REGISTER_TYPE_ADMIN,
            'display_flag'    => \Model_Fleamarket::DISPLAY_FLAG_ON,
            'entry_status'    => self::ENTRY_STATUS_RESERVED,
        );

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = $offset . ', ' . $row_count;
        }

        $query = <<<QUERY
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    e.fleamarket_entry_style_id,
    f.event_date,
    f.event_time_start,
    f.event_time_end,
    f.event_status,
    f.event_reservation_status,
    f.description,
    f.shop_fee_flag,
    f.car_shop_flag,
    f.pro_shop_flag,
    f.charge_parking_flag,
    f.free_parking_flag,
    f.rainy_location_flag,
    f.register_type,
    l.name AS location_name,
    l.zip AS zip,
    l.prefecture_id AS prefecture_id,
    l.address AS address,
    l.googlemap_address AS googlemap_address,
    fa.description AS about_access,
    fi.file_name
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON
    e.fleamarket_id = f.fleamarket_id
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_images AS fi ON
    e.fleamarket_id = fi.fleamarket_id AND priority = 1
WHERE
    e.user_id = :user_id AND
    e.entry_status = :entry_status AND
    f.display_flag = :display_flag AND
    e.deleted_at IS NULL
ORDER BY
    f.register_type = :register_status,
    f.event_date DESC,
    f.event_time_start
LIMIT
    {$limit}
QUERY;

        $res = \DB::query($query)->parameters($placeholders)->execute();
        if (! empty($res)) {
            return $res->as_array();
        }

        return array();
    }

    /**
     * 特定のユーザの出店（予約）したフリマの件数を取得します
     *
     * @param mixed $user_id
     * @access public
     * @return void
     * @author shimma
     */
    public static function getUserEntryCount($user_id)
    {
        $placeholders = array(
            'user_id'      => $user_id,
            'display_flag'    => \Model_Fleamarket::DISPLAY_FLAG_ON,
            'entry_status'    => self::ENTRY_STATUS_RESERVED,
        );

        $query = <<<QUERY
SELECT
    COUNT(*) as count
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON
    e.fleamarket_id = f.fleamarket_id
WHERE
    e.user_id = :user_id AND
    e.entry_status = :entry_status AND
    f.display_flag = :display_flag AND
    e.deleted_at IS NULL
QUERY;

        $entry_count = \DB::query($query)->parameters($placeholders)->execute()->get('count');

        return $entry_count;
    }

    /**
     * 特定のユーザの出店予約中のフリマ情報を取得します
     *
     * 実行日移行のデータ
     *
     * @param mixed $user_id
     * @access public
     * @return void
     * @author shimma
     * @author ida
     */
    public static function getUserReservedEntries($user_id, $page = 0, $row_count = 0)
    {
        $placeholders = array(
            'user_id'         => $user_id,
            'about_access_id' => \Model_Fleamarket_About::ACCESS,
            'register_status' => \Model_Fleamarket::REGISTER_TYPE_ADMIN,
            'display_flag'    => \Model_Fleamarket::DISPLAY_FLAG_ON,
            'entry_status'    => \Model_Entry::ENTRY_STATUS_RESERVED,
        );

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = $offset . ', ' . $row_count;
        }

        $query = <<<QUERY
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    e.fleamarket_entry_style_id,
    f.event_date,
    f.event_time_start,
    f.event_time_end,
    f.event_status,
    f.event_reservation_status,
    f.description,
    f.website,
    f.shop_fee_flag,
    f.car_shop_flag,
    f.pro_shop_flag,
    f.charge_parking_flag,
    f.free_parking_flag,
    f.rainy_location_flag,
    f.register_type,
    l.name AS location_name,
    l.zip AS zip,
    l.prefecture_id AS prefecture_id,
    l.address AS address,
    l.googlemap_address AS googlemap_address,
    fa.description AS about_access,
    fi.file_name
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON
    e.fleamarket_id = f.fleamarket_id
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_images AS fi ON
    e.fleamarket_id = fi.fleamarket_id AND priority = 1
WHERE
    e.user_id = :user_id AND
    e.entry_status = :entry_status AND
    f.display_flag = :display_flag AND
    f.event_date >= CURDATE() AND
    e.deleted_at IS NULL
ORDER BY
    f.register_type = :register_status,
    f.event_date DESC,
    f.event_time_start
LIMIT
    {$limit}
QUERY;

        $res = \DB::query($query)->parameters($placeholders)->execute();
        if (! empty($res)) {
            return $res->as_array();
        }

        return array();
    }

    /**
     * 特定のユーザの出店予約中のフリマ情報件数を取得します。
     *
     * 実行日移行のデータ
     *
     * @param mixed $user_id
     * @access public
     * @return void
     * @author shimma
     */
    public static function getUserReservedEntryCount($user_id)
    {
        $placeholders = array(
            'user_id'      => $user_id,
            'display_flag'    => \Model_Fleamarket::DISPLAY_FLAG_ON,
            'entry_status'    => \Model_Entry::ENTRY_STATUS_RESERVED,
        );

        $query = <<<QUERY
SELECT
    COUNT(*) as count
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON
    e.fleamarket_id = f.fleamarket_id
WHERE
    e.user_id = :user_id AND
    e.entry_status = :entry_status AND
    f.display_flag = :display_flag AND
    f.event_date >= CURDATE() AND
    e.deleted_at IS NULL
QUERY;

        $reserved_entry_count = \DB::query($query)->parameters($placeholders)->execute()->get('count');

        return $reserved_entry_count;
    }

    /**
     * 特定のユーザのキャンセル待ちしたフリマ情報を取得します。
     *
     * @param mixed $user_id
     * @access public
     * @return void
     * @author kobayashi
     */
    public static function getUserWaitingEntries($user_id, $page = 0, $row_count = 0)
    {
        $placeholders = array(
            'user_id'         => $user_id,
            'about_access_id' => \Model_Fleamarket_About::ACCESS,
            'register_status' => \Model_Fleamarket::REGISTER_TYPE_ADMIN,
            'display_flag'    => \Model_Fleamarket::DISPLAY_FLAG_ON,
            'entry_status'    => \Model_Entry::ENTRY_STATUS_WAITING,
        );

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = $offset . ', ' . $row_count;
        }

        $query = <<<QUERY
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    e.fleamarket_entry_style_id,
    f.event_date,
    f.event_time_start,
    f.event_time_end,
    f.event_status,
    f.event_reservation_status,
    f.description,
    f.shop_fee_flag,
    f.car_shop_flag,
    f.pro_shop_flag,
    f.charge_parking_flag,
    f.free_parking_flag,
    f.rainy_location_flag,
    f.register_type,
    l.name AS location_name,
    l.zip AS zip,
    l.prefecture_id AS prefecture_id,
    l.address AS address,
    l.googlemap_address AS googlemap_address,
    fa.description AS about_access,
    fi.file_name
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON
    e.fleamarket_id = f.fleamarket_id
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_images AS fi ON
    e.fleamarket_id = fi.fleamarket_id AND priority = 1
WHERE
    e.user_id = :user_id AND
    e.entry_status = :entry_status AND
    f.display_flag = :display_flag AND
    f.event_date >= CURDATE() AND
    e.deleted_at IS NULL
ORDER BY
    f.register_type = :register_status,
    f.event_date DESC,
    f.event_time_start
LIMIT
    {$limit}
QUERY;

        $res = \DB::query($query)->parameters($placeholders)->execute();
        if (! empty($res)) {
            return $res->as_array();
        }

        return array();
    }

    /**
     * 特定のユーザのキャンセル待ちのフリマの件数を取得します
     *
     * @param mixed $user_id
     * @access public
     * @return void
     * @author shimma
     */
    public static function getUserWaitingEntryCount($user_id)
    {
        $placeholders = array(
            'user_id'      => $user_id,
            'display_flag' => \Model_Fleamarket::DISPLAY_FLAG_ON,
            'entry_status' => self::ENTRY_STATUS_WAITING,
        );

        $query = <<<QUERY
SELECT
    COUNT(*) as count
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON
    e.fleamarket_id = f.fleamarket_id
WHERE
    e.user_id = :user_id AND
    e.entry_status = :entry_status AND
    f.display_flag = :display_flag AND
    f.event_date >= CURDATE() AND
    e.deleted_at IS NULL
QUERY;

        $reserved_entry_count = \DB::query($query)->parameters($placeholders)->execute()->get('count');

        return $reserved_entry_count;
    }

    /**
     * 特定のユーザの参加したフリマ情報を取得します
     *
     * @param mixed $user_id
     * @access public
     * @return void
     * @author ida
     */
    public static function getUserFinishedEntries(
        $user_id, $page = 0, $row_count = 0
    ) {
        $placeholders = array(
            'user_id'         => $user_id,
            'about_access_id' => \Model_Fleamarket_About::ACCESS,
            'register_status' => \Model_Fleamarket::REGISTER_TYPE_ADMIN,
            'display_flag'    => \Model_Fleamarket::DISPLAY_FLAG_ON,
            'entry_status'    => \Model_Entry::ENTRY_STATUS_RESERVED,
        );

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = $offset . ', ' . $row_count;
        }

        $query = <<<QUERY
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    e.fleamarket_entry_style_id,
    f.event_date,
    f.event_time_start,
    f.event_time_end,
    f.event_status,
    f.event_reservation_status,
    f.description,
    f.shop_fee_flag,
    f.car_shop_flag,
    f.pro_shop_flag,
    f.charge_parking_flag,
    f.free_parking_flag,
    f.rainy_location_flag,
    f.register_type,
    l.name AS location_name,
    l.zip AS zip,
    l.prefecture_id AS prefecture_id,
    l.address AS address,
    l.googlemap_address AS googlemap_address,
    fa.description AS about_access,
    fi.file_name
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON
    e.fleamarket_id = f.fleamarket_id
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_images AS fi ON
    e.fleamarket_id = fi.fleamarket_id AND priority = 1
WHERE
    e.user_id = :user_id AND
    e.entry_status = :entry_status AND
    f.display_flag = :display_flag AND
    f.event_date < CURDATE() AND
    e.deleted_at IS NULL
ORDER BY
    f.register_type = :register_status,
    f.event_date DESC,
    f.event_time_start
LIMIT
    {$limit}
QUERY;

        $res = \DB::query($query)->parameters($placeholders)->execute();
        if (! empty($res)) {
            return $res->as_array();
        }

        return array();
    }

    /**
     * 特定のユーザの参加したフリマの件数を取得します
     *
     * @param mixed $user_id
     * @access public
     * @return void
     * @author shimma
     */
    public static function getUserFinishedEntryCount($user_id)
    {
        $placeholders = array(
            'user_id'      => $user_id,
            'entry_status' => self::ENTRY_STATUS_RESERVED,
        );

        $query = <<<QUERY
SELECT
    COUNT(*) as count
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON
    e.fleamarket_id = f.fleamarket_id
WHERE
    e.user_id = :user_id AND
    f.event_date < CURDATE() AND
    e.entry_status = :entry_status AND
    e.deleted_at IS NULL
QUERY;

        $finished_entry_count = \DB::query($query)->parameters($placeholders)->execute()->get('count');

        return $finished_entry_count;
    }

    /**
     * 特定のユーザの出店予約をキャンセルします
     *
     * @access public
     * @param int $user_id
     * @param int $fleamarket_id
     * @return bool
     * @author shimma
     */
    public static function cancelUserEntry($user_id, $fleamarket_id)
    {

        try {
            $entry = self::find('last', array(
                'where' => array(
                    array('user_id' => $user_id),
                    array('fleamarket_id' => $fleamarket_id),
                )
            ));
            $entry->entry_status = self::ENTRY_STATUS_CANCELED;
            $entry->save();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * 指定された条件で出店予約情報を取得する
     *
     * @access public
     * @param array $condition 検索条件
     * @return array
     * @author ida
     */
    public static function findBy($condition)
    {
        if (! $condition) {
            return false;
        }

        return self::find('first', array('where' => $condition));
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

        $count = \Model_Fleamarket_Entry_Style::query()->where(array(
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

    private static function getFindByKeywordQuery($input)
    {
        $query = static::query();

        foreach (array('reservation_number','user_id','fleamarket_id') as $field) {
            if(! empty($input[$field])){
                $query->where($field, 'LIKE', static::makeLikeValue($input[$field]));
            }
        }

        return $query;
    }

    private static function makeLikeValue($word)
    {
        $like = preg_replace('/([_%\\\\])/','\\\\${1}',$word);
        $like = "%${like}%";
        return $like;
    }

    public static function findByKeyword($input, $limit, $offset)
    {
        $query = static::getFindByKeywordQuery($input)
            ->limit($limit)
            ->offset($offset);

        return $query->get();
    }

    public static function findByKeywordCount($input)
    {
        return static::getFindByKeywordQuery($input)->count();
    }
}