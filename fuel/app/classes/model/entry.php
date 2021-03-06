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
     * 反響項目ジャンル
     */
    const LINK_FROM_MOBILE          = '楽市モバイルサイト';
    const LINK_FROM_PC              = '楽市PCサイト';
    const LINK_FROM_PAMPHLET        = '会場設置チラシ';
    const LINK_FROM_FRIEND          = '友人・知人から聞いて';
    const LINK_FROM_SEARCH          = 'GOOGLE・YAHOO検索';
    const LINK_FROM_NEWSPAPER       = '地域情報誌';
    const LINK_FROM_FLYER           = '新聞折り込み';
    const LINK_FROM_GOTOFREEMARKET  = 'フリーマーケットへ行こう';
    const LINK_FROM_FREEMARKETGUIDE = 'フリーマーケットガイド(モバフリ)';
    const LINK_FROM_POSTER          = 'ポスター';
    const LINK_FROM_MAILMAGAZINE    = '楽市メルマガ';
    const LINK_FROM_BLOG            = '楽市ブログ';
    const LINK_FROM_FACEBOOK        = 'Facebook';
    const LINK_FROM_MIXI            = 'mixi';

    /**
     * 出品物ジャンルの最大・最少ID
     */
    const ITEM_GENRES_MIN = 1;
    const ITEM_GENRES_MAX = 15;

    /**
     * 登録元 0:不明,1:WEB,3:電話
     */
    const DEVICE_OTHER = 0;
    const DEVICE_WEB = 1;
    const DEVICE_TEL = 2;

    /**
     * 出品物種類リスト
     */
    private static $item_categories = array(
        self::ITEM_CATEGORY_RECYCLE  => 'リサイクル品',
        self::ITEM_CATEGORY_HANDMADE => '手作り品',
    );

    /**
     * 出品物ジャンルリスト
     */
    private static $item_genres = array(
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
     * 反響項目リスト
     */
    private static $link_from_list = array(
        self::LINK_FROM_MOBILE          => '楽市モバイルサイト',
        self::LINK_FROM_PC              => '楽市PCサイト',
        self::LINK_FROM_PAMPHLET        => '会場設置チラシ',
        self::LINK_FROM_FRIEND          => '友人・知人から聞いて',
        self::LINK_FROM_SEARCH          => 'GOOGLE・YAHOO検索',
        self::LINK_FROM_NEWSPAPER       => '地域情報誌',
        self::LINK_FROM_FLYER           => '新聞折り込み',
        self::LINK_FROM_GOTOFREEMARKET  => 'フリーマーケットへ行こう',
        self::LINK_FROM_FREEMARKETGUIDE => 'フリーマーケットガイド(モバフリ)',
        self::LINK_FROM_POSTER          => 'ポスター',
        self::LINK_FROM_MAILMAGAZINE    => '楽市メルマガ',
        self::LINK_FROM_BLOG            => '楽市ブログ',
        self::LINK_FROM_FACEBOOK        => 'Facebook',
        self::LINK_FROM_MIXI            => 'mixi',
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
            'model_to' => 'Model_User',
            'key_from' => 'user_id',
            'key_to' => 'user_id',
            'cascade_save' => false,
            'cascade_delete' => false,
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
     * 登録元一覧
     */
    private static $devices = array(
        self::DEVICE_OTHER => '不明',
        self::DEVICE_WEB => 'WEB',
        self::DEVICE_TEL => '電話',
    );

    /**
     * 開催状況リスト
     */
    protected static $entry_statuses = array(
        self::ENTRY_STATUS_RESERVED => '出店予約',
        self::ENTRY_STATUS_WAITING  => 'キャンセル待ち',
        self::ENTRY_STATUS_CANCELED => 'キャンセル',
    );

    /**
     * 登録元一覧を取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getDevices()
    {
        return self::$devices;
    }

    /**
     * 出店予約状況一覧を取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getEntryStatuses()
    {
        return self::$entry_statuses;
    }

    /**
     * ｄ
     *
     * @access public
     * @param
     * @return array
     * @author nakata
     */
    public static function getLinkFromList()
    {
        return self::$link_from_list;
    }

    /**
     * カテゴリの番号と名前の連想配列を返す
     *
     * @access public
     * @return array
     * @author kobayasi
     */
    public static function getItemCategories()
    {
        return self::$item_categories;
    }

    /**
     * ジャンルの番号と名前の連想配列を返す
     *
     * @access public
     * @return array
     * @author kobayasi
     */
    public static function getItemGenres()
    {
        return self::$item_genres;
    }

    /**
     * 特定のフリマに出店予約したユーザを取得する
     *
     * @access public
     * @param int $fleamarket_id フリーマーケットID
     * @return array
     * @author ida
     */
    public static function getEntriesByFleamarketId(
        $fleamarket_id, $entry_status = self::ENTRY_STATUS_RESERVED
    ) {
        if (! $fleamarket_id) {
            return null;
        }

        $placeholders = array(
            ':flearmarket_id' => $fleamarket_id,
            ':entry_status' => $entry_status,
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
    AND u.deleted_at IS NULL
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
     * 出店形態ごとの予約数を取得する
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
    entries
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
     * 特定のユーザ、開催状況の一覧を取得する
     *
     * @access public
     * @param mixed $user_id ユーザID
     * @param int $entry_status 出店予約状況
     * @return array
     * @author ida
     */
    public static function getUserEntriesByEntryStatus($user_id, $entry_status)
    {
        $query = \DB::select(
            'e.fleamarket_id', 'e.entry_status',
            array('f.event_date', 'event_date')
        );
        $query->from(array('entries', 'e'))
            ->join(array('fleamarkets', 'f'), 'inner')
            ->on('e.fleamarket_id', '=', 'f.fleamarket_id')
            ->where(array(
                array('e.user_id', '=', $user_id),
                array('e.entry_status', '=', $entry_status),
                array('f.event_date', '>=', \DB::expr('CURDATE()')),
            ));

        return $query->execute()->as_array();
    }

    /**
     * 特定のユーザが出店（予約）したフリマ情報の件数を取得します
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
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
    AND f.deleted_at IS NULL
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
    AND l.deleted_at IS NULL
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
    AND fa.deleted_at IS NULL
LEFT JOIN
    (
        SELECT
            fi.fleamarket_image_id,
            fi.fleamarket_id,
            fi.file_name,
            MIN(fi.priority)
        FROM
            fleamarket_images AS fi
        WHERE
            deleted_at IS NULL
        GROUP BY
            fi.fleamarket_id
        ORDER BY
            priority
    ) AS fi ON f.fleamarket_id = fi.fleamarket_id
WHERE
    e.user_id = :user_id
    AND e.entry_status = :entry_status
    AND f.display_flag = :display_flag
    AND e.deleted_at IS NULL
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
    COUNT(*) AS count
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
    AND f.deleted_at IS NULL
WHERE
    e.user_id = :user_id
    AND e.entry_status = :entry_status
    AND f.display_flag = :display_flag
    AND e.deleted_at IS NULL
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
    e.entry_id,
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    e.fleamarket_entry_style_id,
    e.reservation_number,
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
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
    AND f.deleted_at IS NULL
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
    AND l.deleted_at IS NULL
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
    AND fa.deleted_at IS NULL
LEFT JOIN
    (
        SELECT
            fi.fleamarket_image_id,
            fi.fleamarket_id,
            fi.file_name,
            MIN(fi.priority)
        FROM
            fleamarket_images AS fi
        WHERE
            deleted_at IS NULL
        GROUP BY
            fi.fleamarket_id
        ORDER BY
            priority
    ) AS fi ON f.fleamarket_id = fi.fleamarket_id
WHERE
    e.user_id = :user_id
    AND e.entry_status = :entry_status
    AND f.display_flag = :display_flag
    AND f.event_date >= CURDATE()
    AND e.deleted_at IS NULL
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
    COUNT(*) AS count
FROM
    entries AS e
LEFT JOIN
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
    AND f.deleted_at IS NULL
WHERE
    e.user_id = :user_id
    AND e.entry_status = :entry_status
    AND f.display_flag = :display_flag
    AND f.event_date >= CURDATE()
    AND e.deleted_at IS NULL
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
    e.entry_id,
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
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
    AND f.deleted_at IS NULL
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
    AND l.deleted_at IS NULL
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
    AND fa.deleted_at IS NULL
LEFT JOIN
    (
        SELECT
            fi.fleamarket_image_id,
            fi.fleamarket_id,
            fi.file_name,
            MIN(fi.priority)
        FROM
            fleamarket_images AS fi
        WHERE
            deleted_at IS NULL
        GROUP BY
            fi.fleamarket_id
        ORDER BY
            priority
    ) AS fi ON f.fleamarket_id = fi.fleamarket_id
WHERE
    e.user_id = :user_id
    AND e.entry_status = :entry_status
    AND f.display_flag = :display_flag
    AND f.event_date >= CURDATE()
    AND e.deleted_at IS NULL
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
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
    AND f.deleted_at IS NULL
WHERE
    e.user_id = :user_id
    AND e.entry_status = :entry_status
    AND f.display_flag = :display_flag
    AND f.event_date >= CURDATE()
    AND e.deleted_at IS NULL
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
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
    AND f.deleted_at IS NULL
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
    AND l.deleted_at IS NULL
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
    AND fa.deleted_at IS NULL
LEFT JOIN
    (
        SELECT
            fi.fleamarket_image_id,
            fi.fleamarket_id,
            fi.file_name,
            MIN(fi.priority)
        FROM
            fleamarket_images AS fi
        WHERE
            deleted_at IS NULL
        GROUP BY
            fi.fleamarket_id
        ORDER BY
            priority
    ) AS fi ON f.fleamarket_id = fi.fleamarket_id
WHERE
    e.user_id = :user_id
    AND e.entry_status = :entry_status
    AND f.display_flag = :display_flag
    AND f.event_date < CURDATE()
    AND e.deleted_at IS NULL
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
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
    AND f.deleted_at IS NULL
WHERE
    e.user_id = :user_id
    AND f.event_date < CURDATE()
    AND e.entry_status = :entry_status
    AND e.deleted_at IS NULL
QUERY;

        $finished_entry_count = \DB::query($query)->parameters($placeholders)->execute()->get('count');

        return $finished_entry_count;
    }

    /**
     * 特定の出店予約をキャンセルします
     *
     * @access public
     * @param mixed $entry_id
     * @param mixed $updated_user
     * @return bool
     * @author shimma
     */
    public static function cancel($entry_id, $updated_user)
    {
        try {
            $entry = self::find('last', array(
                'where' => array(
                    array('entry_id' => $entry_id),
                )
            ));
            $entry->entry_status = self::ENTRY_STATUS_CANCELED;
            $entry->updated_user = $updated_user;
            $entry->save();
        } catch (\Exception $e) {
            throw $e;
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
     * @param array 入力データ
     * @return object
     * @autho kobayashi
     */
    public static function createFieldset($input)
    {
        $entry = self::forge($input);
        $fieldset = Fieldset::forge();
        $fieldset->add_model($entry);

        return $fieldset;
    }

    /**
     * 指定された条件で出店予約一覧を取得する
     *
     * 予約履歴一覧
     *
     * @param array $condition_list 検索条件
     * @param mixed $page ページ
     * @param mixed $row_count ページあたりの行数
     * @return array
     * @author ida
     */
    public static function findAdminBySearch(
        $condition_list, $page = 0, $row_count = 0
    ) {
        $search_where = self::buildAdminSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $where = '';
        if ($conditions) {
            $where = ' AND ';
            $where .= implode(' AND ', $conditions);
        }

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = ' LIMIT ' . $offset . ', ' . $row_count;
        }

        $sql = <<<"SQL"
SELECT
    e.entry_id,
    e.user_id,
    u.last_name,
    u.first_name,
    e.fleamarket_id,
    f.name,
    e.fleamarket_entry_style_id,
    e.reservation_number,
    e.item_category,
    e.item_genres,
    e.reserved_booth,
    e.link_from,
    e.entry_status,
    e.device,
    e.created_at,
    fes.entry_style_id
FROM
    entries AS e
INNER JOIN
    users AS u ON e.user_id = u.user_id
INNER JOIN
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
INNER JOIN
    fleamarket_entry_styles AS fes ON e.fleamarket_entry_style_id = fes.fleamarket_entry_style_id
WHERE
    u.deleted_at IS NULL
{$where}
{$limit}
SQL;

        $query = \DB::query($sql)->parameters($placeholders);
        $result = $query->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows;
    }

    /**
     * 指定された条件で出店予約情報の件数を取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @return int
     * @author ida
     */
    public static function getCountByAdminSearch($condition_list)
    {
        $search_where = self::buildAdminSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $where = '';
        if ($conditions) {
            $where = ' AND ';
            $where .= implode(' AND ', $conditions);
        }

        $sql = <<<"SQL"
SELECT
    COUNT(e.user_id) AS cnt
FROM
    entries AS e
INNER JOIN
    users AS u ON e.user_id = u.user_id
INNER JOIN
    fleamarkets AS f ON e.fleamarket_id = f.fleamarket_id
INNER JOIN
    fleamarket_entry_styles AS fes ON e.fleamarket_entry_style_id = fes.fleamarket_entry_style_id
WHERE
    u.deleted_at IS NULL
{$where}
SQL;

        $query = \DB::query($sql)->parameters($placeholders);
        $result = $query->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows[0]['cnt'];
    }

    /**
     * 検索条件を取得する
     *
     * @access private
     * @param array $condition_list 検索条件
     * @return array 検索条件
     * @author ida
     */
    public static function createAdminSearchCondition(
        $conditions = array()
    ) {
        $condition_list = array();

        if (! $conditions) {
            return $condition_list;
        }

        foreach ($conditions as $field => $condition) {
            if ($condition == '') {
                continue;
            }

            $operator = '=';
            switch ($field) {
                case 'fleamarket_id':
                    $condition_list['e.fleamarket_id'] = array(
                        $operator, $condition
                    );
                    break;
                case 'reservation_number':
                    $condition_list['e.reservation_number'] = array(
                        ' LIKE ', $condition . '%'
                    );
                    break;
                case 'user_id':
                    $condition_list['e.user_id'] = array(
                        ' LIKE ', $condition . '%'
                    );
                    break;
                case 'user_name':
                    $field = \DB::expr('CONCAT(u.last_name, u.first_name)');
                    $condition_list[$field->value()] = array(' LIKE ', '%' . $condition . '%');
                    break;
                default:
                    break;
            }
        }

        return $condition_list;
    }

    /**
     * ユーザーにメールを送信
     *
     * 渡されていない場合、entry_statusで決める
     * 渡されてきた場合、$mail_typeで決める
     *
     * @access private
     * @para object $user ユーザ情報
     * @para string $template_name 送信するメール名（テンプレート名）
     * @return void
     * @author kobayashi
     * @author ida
     */
    public function sendmail($user = null, $template_name = null)
    {
        if (empty($user)) {
            return false;
        }

        $params = array();
        $objects = array(
            'entry'                  => $this,
            'fleamarket'             => $this->fleamarket,
            'fleamarket_entry_style' => $this->fleamarket_entry_style,
            'user'                   => $this->user,
            'location'               => $this->fleamarket->location,
        );

        $fleamarket_abouts = array();
        foreach ($this->fleamarket->fleamarket_abouts as $fleamarket_about) {
            $fleamarket_abouts[$fleamarket_about->about_id] = $fleamarket_about;
        }

        foreach (Model_Fleamarket_About::getAboutTitles() as $id => $title){
            if (isset($fleamarket_abouts[$id])) {
                $objects["fleamarket_about_${id}"] = $fleamarket_abouts[$id];
            }else{
                $params["fleamarket_about_${id}.description"] = '';
            }
        }

        foreach ($objects as $name => $obj) {
            foreach (array_keys($obj->properties()) as $column) {
                $params["${name}.${column}"] = $obj->get($column);
            }
        }

        $entry_styles = \Config::get('master.entry_styles');
        $params['fleamarket_entry_style.entry_style_name']
            = $entry_styles[$this->fleamarket_entry_style->entry_style_id];

        // 出店形態を成形
        $entry_style_list = array_map(function($obj) use ($entry_styles) {
            return $entry_styles[$obj->entry_style_id];
        }, $this->fleamarket->fleamarket_entry_styles);
        $params['fleamarket_entry_styles.entry_style_name'] = implode('/', $entry_style_list);

        // 出店形態:金額を成形
        $fee_list = array_map(function($obj) use ($entry_styles) {
            return $entry_styles[$obj->entry_style_id] . ':' . number_format($obj->booth_fee);
        }, $this->fleamarket->fleamarket_entry_styles);
        $params['fleamarket_entry_styles.fee'] = implode('/', $fee_list);

        foreach (array('fleamarket.event_time_start','fleamarket.event_time_end') as $column) {
            $params[$column] = substr($params[$column], 0, 5);
        }

        if ($template_name) {
            $user->sendmail($template_name, $params);
        } elseif ($this->entry_status == \Model_Entry::ENTRY_STATUS_RESERVED) {
            $user->sendmail('reservation', $params);
        } elseif ($this->entry_status == \Model_Entry::ENTRY_STATUS_WAITING) {
            $user->sendmail('waiting', $params);
        }
    }

    /**
     * 指定された検索条件よりWHERE句とプレースホルダ―を生成する
     *
     * @access private
     * @param array $condition_list
     * @return array
     * @author ida
     */
    private static function buildAdminSearchWhere($condition_list)
    {
        $conditions = array();
        $placeholders = array();

        if (empty($condition_list)) {
            return array($conditions, $placeholders);
        }

        foreach ($condition_list as $field => $condition) {

            $operator = $condition[0];
            if (count($condition) == 1) {
                $conditions[$field] = $field . $condition[0];
            } elseif ($operator === 'IN') {
                $placeholder = ':' . $field;
                $values = $condition[1];
                $placeholder_list = array();
                foreach ($values as $key => $value) {
                    $placeholder_in = $placeholder . $key;
                    $placeholder_list[] = $placeholder_in;
                    $placeholders[$placeholder_in] = $value;
                }
                $value = implode(',', $values);
                $placeholder_string = implode(',', $placeholder_list);
                $conditions[$field] = $field . ' '
                              . $operator . ' '
                              . '(' . $placeholder_string . ')';
            } else {
                $placeholder = ':' . $field;
                $value = $condition[1];
                $conditions[$field] = $field . $operator . $placeholder;
                $placeholders[$placeholder] = $value;
            }
        }

        return array($conditions, $placeholders);
    }
}
