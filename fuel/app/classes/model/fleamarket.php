<?php

/**
 * Fleamarkets Model
 *
 * フリーマーケット情報テーブル
 *
 * @author ida
 */
class Model_Fleamarket extends Model_Base
{
    /**
     * 開催状況 1:開催予定,2:予約受付中,3:受付終了,4:開催終了,5:中止
     */
    const EVENT_STATUS_SCHEDULE = 1;
    const EVENT_STATUS_RESERVATION_RECEIPT = 2;
    const EVENT_STATUS_RECEIPT_END = 3;
    const EVENT_STATUS_CLOSE = 4;
    const EVENT_STATUS_CANCEL = 5;

    /**
     * 出店料 0:無料,1:有料
     */
    const SHOP_FEE_FLAG_FREE = 0;
    const SHOP_FEE_FLAG_CHARGE = 1;

    /**
     * 車出店 0:NG,1:OK
     */
    const CAR_SHOP_FLAG_NG = 0;
    const CAR_SHOP_FLAG_OK = 1;

    /**
     * プロ出店 0:NG,1:OK
     */
    const PRO_SHOP_FLAG_NG = 0;
    const PRO_SHOP_FLAG_OK = 1;

    /**
     * 有料駐車場 0:なし,1:あり
     */
    const CHARGE_PARKING_FLAG_NONE = 0;
    const CHARGE_PARKING_FLAG_EXIST = 1;

    /**
     * 無料駐車場 0:なし,1:あり
     */
    const FREE_PARKING_FLAG_NONE = 0;
    const FREE_PARKING_FLAG_EXIST = 1;

    /**
     * 雨天開催会場 0:NG 1:OK
     */
    const RAINY_LOCATION_FLAG_NONE = 0;
    const RAINY_LOCATION_FLAG_EXIST = 1;

    /**
     * 登録タイプ 1:運営者,2:ユーザ投稿
     */
    const REGISTER_TYPE_ADMIN = 1;
    const REGISTER_TYPE_USER = 2;

    /**
     * 表示 0:非表示,1:表示
     */
    const DISPLAY_FLAG_OFF = 0;
    const DISPLAY_FLAG_ON = 1;

    /**
     * ピックアップ 0:対象外,1:対象
     */
    const PICKUP_FLAG_OFF = 0;
    const PICKUP_FLAG_ON = 1;

    /**
     * 予約状況  1:まだまだあります,2:残り僅か！,3:満員
     */
    const EVENT_RESERVATION_STATUS_ENOUGH = 1;
    const EVENT_RESERVATION_STATUS_FEW    = 2;
    const EVENT_RESERVATION_STATUS_FULL   = 3;

    protected static $_table_name = 'fleamarkets';

    protected static $_primary_key = array('fleamarket_id');

    protected static $_has_many = array(
        'fleamarket_entry_styles' => array(
            'key_from' => 'fleamarket_id',
        ),
        'fleamarket_images' => array(
            'key_from' => 'fleamarket_id',
        ),
        'fleamarket_abouts' => array(
            'key_from' => 'fleamarket_id',
        ),
        'entries' => array(
            'key_from' => 'fleamarket_id',
        ),
    );

    protected static $_belongs_to = array(
        'location' => array(
            'key_to' => 'location_id',
        ),
    );

    protected static $_properties = array(
        'fleamarket_id',
        'location_id',
        'group_code',
        'name' => array(
            'label' => 'フリマ名',
            'validation' => array(
                'required',
                'max_length' => array(100)
            )
        ),
        'promoter_name' => array(
            'label' => '主催者名',
            'validation' => array(
                'required',
                'max_length' => array(100)
            )
        ),
        'event_number' => array(
            'form'  => array('type' => false)
        ),
        'event_date' => array(
            'label' => '開催日',
            'validation' => array('required', 'valid_date')
        ),
        'event_time_start' => array(
            'label' => '開始時間',
            'validation' => array('valid_time')
        ),
        'event_time_end' => array(
            'label' => '終了時間',
            'validation' => array('valid_time')
        ),
        'event_status' => array(
            'label' => '開催状況',
            'form'  => array('type' => false),
            'validation' => array('required'),
        ),
        'event_reservation_status' => array(
            'label' => '予約状況',
            'validation' => array(
                'required',
            )
        ),
        'headline' => array(
            'validation' => array(
                'max_length' => array(100),
            )
        ),
        'information' => array(
            'validation' => array(
                'max_length' => array(200)
            )
        ),
        'description' => array(
            'label' => '内容',
            'validation' => array(
                'required', 'max_length' => array(5000)
            )
        ),
        'reservation_serial' => array(
            'form'  => array('type' => false)
        ),
        'reservation_start' => array(
            'label' => '予約受付開始日',
            'validation' => array('valid_date')
        ),
        'reservation_end' => array(
            'label' => '予約受付終了日',
            'validation' => array('valid_date')
        ),
        'reservation_tel' => array(
            'label' => '予約受付電話番号',
//            'validation' => array('valid_tel')
        ),
        'reservation_email' => array(
            'label' => '予約受付E-mailアドレス',
            'validation' => array(
                'max_length' => array(250)
            )
        ),
        'website' => array(
            'label' => '主催者ホームページ',
            'validation' => array(
                'max_length' => array(250)
            )
        ),
        'item_categories' => array(
            'label' => '出品物の種類',
            'form'  => array('type' => false)
        ),
        'link_from_list' => array(
            'label' => '反響項目リスト',
            'form'  => array('type' => false)
        ),
        'pickup_flag' => array(
            'label' => 'ピックアップ',
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'shop_fee_flag' => array(
            'label' => '出店料',
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'car_shop_flag' => array(
            'label' => '車出店',
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'pro_shop_flag' => array(
            'label' => 'プロ出店',
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'rainy_location_flag' => array(
            'label' => '雨天開催会場',
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'charge_parking_flag' => array(
            'label' => '有料駐車場',
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'free_parking_flag' => array(
            'label' => '無料駐車場',
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'donation_fee' => array(
            'label' => '寄付金',
            'form'  => array('type' => false)
        ),
        'donation_point' => array(
            'label' => '寄付先',
            'form'  => array('type' => false)
        ),
        'register_type' => array(
            'label' => '登録タイプ',
            'form'  => array('type' => false)
        ),
        'display_flag' => array(
            'label' => '表示',
            'form'  => array('type' => false)
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
     * 開催状況一覧
     */
    private static $event_statuses = array(
        self::EVENT_STATUS_SCHEDULE    => '開催予定',
        self::EVENT_STATUS_RESERVATION_RECEIPT => '予約受付中',
        self::EVENT_STATUS_RECEIPT_END => '受付終了',
        self::EVENT_STATUS_CLOSE       => '開催終了',
        self::EVENT_STATUS_CANCEL      => '開催中止',
    );

    /**
     * 登録タイプ一覧
     */
    private static $register_types = array(
        self::REGISTER_TYPE_ADMIN => '運営事務局',
        self::REGISTER_TYPE_USER => 'ユーザ投稿',
    );

    /**
     * 開催状況リストを取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getEventStatuses()
    {
        return self::$event_statuses;
    }

    /**
     * 登録タイプリストを取得する
     *
     * @access public
     * @param
     * @return array
     * @author ida
     */
    public static function getRegisterTypes()
    {
        return self::$register_types;
    }

    /**
     * 指定されたユーザのフリーマーケット情報を取得する
     *
     * @access public
     * @param mixed $user_id ユーザID
     * @return array
     * @author ida
     */
    public static function findByUserId($fleamarket_id, $user_id)
    {
        if (! $fleamarket_id || ! $user_id) {
            return false;
        }

        $result =  self::find('first', array(
            'where' => array(
                'fleamarket_id' => $fleamarket_id,
                'created_user' => $user_id,
                'register_type' => self::REGISTER_TYPE_USER,
            )
        ));

        return $result;
    }

    /**
     * 指定された年月に開催されるフリーマーケット情報リストを取得する
     *
     * @access public
     * @param mixed $year 対象年
     * @param mixed $month 対象月
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findByEventDate($year, $month)
    {
        $placeholders = array(
            ':display_flag' => self::DISPLAY_FLAG_ON,
            ':ym' => $year . '/' . $month,
        );

        $query = <<<"QUERY"
SELECT
    f.event_date
FROM
    fleamarkets AS f
WHERE
    display_flag = :display_flag
    AND DATE_FORMAT(f.event_date, '%Y/%c') = :ym
    AND f.deleted_at IS NULL
QUERY;

        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array('event_date');
        }

        return $rows;
    }

    /**
     * 指定された条件でフリーマーケット情報リストを取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @param mixed $page ページ
     * @param mixed $row_count ページあたりの行数
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findBySearch(
        $condition_list, $page = 0, $row_count = 0
    ) {
        $search_where = self::buildSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $entry_style_where = '';
        if (isset($conditions['fes.entry_style_id'])) {
            $entry_style_where = 'AND ' . $conditions['fes.entry_style_id'];
            unset($conditions['fes.entry_style_id']);
        }

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

        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    f.event_date,
    f.event_time_start,
    f.event_time_end,
    f.event_status,
    f.description,
    f.reservation_start,
    f.reservation_end,
    f.reservation_tel,
    f.reservation_email,
    f.event_reservation_status,
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
    fleamarkets AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_images AS fi ON
    f.fleamarket_id = fi.fleamarket_id AND priority = 1
WHERE
QUERY;

        if ($entry_style_where != '') {
            $entry_style_query = <<<"ENTRY_STYLE_QUERY"
    EXISTS (
        SELECT * FROM fleamarket_entry_styles AS fes
        WHERE f.fleamarket_id = fes.fleamarket_id
          AND fes.deleted_at IS NULL
          {$entry_style_where}
    ) AND
ENTRY_STYLE_QUERY;
            $query .= $entry_style_query;
        }

        $query .= <<<"WHERE_QUERY"
    f.display_flag = :display_flag
    AND f.deleted_at IS NULL
    {$where}
    ORDER BY
        f.register_type,
        f.event_date
    {$limit}
WHERE_QUERY;

        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows;
    }

    /**
     * 指定された条件でフリーマーケット情報の件数を取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function getCountBySearch($condition_list)
    {
        $search_where = self::buildSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $entry_style_where = '';
        if (isset($conditions['fes.entry_style_id'])) {
            $entry_style_where = 'AND ' . $conditions['fes.entry_style_id'];
            unset($conditions['fes.entry_style_id']);
        }

        $where = '';
        if ($conditions) {
            $where = ' AND ';
            $where .= implode(' AND ', $conditions);
        }

        $query = <<<"QUERY"
SELECT
    COUNT(f.fleamarket_id) AS cnt
FROM
    fleamarkets AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
WHERE
QUERY;

        if ($entry_style_where != '') {
            $entry_style_query = <<<"ENTRY_STYLE_QUERY"
    EXISTS (
        SELECT * FROM fleamarket_entry_styles AS fes
        WHERE f.fleamarket_id = fes.fleamarket_id
          AND fes.deleted_at IS NULL
          {$entry_style_where}
    ) AND
ENTRY_STYLE_QUERY;
            $query .= $entry_style_query;
        }

        $query .= <<<"WHERE_QUERY"
    f.display_flag = :display_flag
    AND f.deleted_at IS NULL
    {$where}
WHERE_QUERY;

      $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return $rows[0]['cnt'];
    }

    /**
     * 指定された条件でフリーマーケット情報を取得する
     *
     * 開催地情報、フリーマーケットエントリスタイル情報、フリーマーケット説明情報
     *
     * @access public
     * @param mixed $fleamarket_id フリーマーケットID
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findDetail($fleamarket_id)
    {
        $placeholders = array(
            ':fleamarket_id' => $fleamarket_id,
            ':display_flag' => self::DISPLAY_FLAG_ON,
        );

        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    f.event_date,
    f.event_time_start,
    f.event_time_end,
    f.event_status,
    f.description,
    f.reservation_start,
    f.reservation_end,
    f.reservation_tel,
    f.reservation_email,
    f.event_reservation_status,
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
    l.googlemap_address AS googlemap_address
FROM
    fleamarkets AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
WHERE
    f.display_flag = :display_flag
    AND f.deleted_at IS NULL
    AND f.fleamarket_id = :fleamarket_id
QUERY;

        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

        $rows = null;
        if (! empty($result)) {
            $rows = $result->as_array();
        }

        return isset($rows[0]) ? $rows[0] : null;
    }

    /**
     * 最新のフリーマーケット情報を取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @param mixed $row_count 取得行数
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findLatest($row_count = 10)
    {
        $placeholders = array(
            ':event_status' => self::EVENT_STATUS_RESERVATION_RECEIPT,
            ':display_flag' => self::DISPLAY_FLAG_ON,
            ':register_status' => self::REGISTER_TYPE_ADMIN,
        );

        $limit = '';
        if (! is_int($row_count)) {
            $row_count = 10;
        }
        $limit = ' LIMIT ' . $row_count;

        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.event_status,
    f.event_date,
    l.name AS location_name,
    l.prefecture_id,
    fi.file_name
FROM
    fleamarkets AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_images AS fi ON
    f.fleamarket_id = fi.fleamarket_id AND priority = 1
WHERE
    f.display_flag = :display_flag
    AND f.register_type = :register_status
    AND f.event_status <= :event_status
    AND f.deleted_at IS NULL
GROUP BY
    f.fleamarket_id,
    f.name,
    f.event_status,
    f.event_date,
    l.name,
    l.prefecture_id
ORDER BY
    f.event_date DESC
{$limit}
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
     * 近日開催予定のフリーマーケット情報を取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @param mixed $row_count 取得行数
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findUpcoming($row_count = 10)
    {
        $placeholders = array(
            ':event_status' => self::EVENT_STATUS_RECEIPT_END,
            ':display_flag' => self::DISPLAY_FLAG_ON,
            ':register_status' => self::REGISTER_TYPE_ADMIN,
        );

        $limit = '';
        if (! is_int($row_count)) {
            $row_count = 10;
        }
        $limit = ' LIMIT ' . $row_count;

        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.event_status,
    f.event_date,
    f.event_time_start,
    f.event_time_end,
    f.register_type,
    l.prefecture_id AS prefecture_id,
    l.name AS location_name
FROM
    fleamarkets AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
WHERE
    f.display_flag = :display_flag
    AND f.register_type = :register_status
    AND f.event_status <= :event_status
    AND f.deleted_at IS NULL
    AND DATE_FORMAT(f.event_date, '%Y-%m-%d') >= CURDATE()
ORDER BY
    f.event_date
{$limit}
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
     * 人気のフリーマーケット情報を取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @param mixed $row_count 取得行数
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findPopular($row_count = 3)
    {
        $placeholders = array(
            ':event_status' => self::EVENT_STATUS_RECEIPT_END,
            ':display_flag' => self::DISPLAY_FLAG_ON,
            ':register_status' => self::REGISTER_TYPE_ADMIN,
            ':pickup_flag' => self::PICKUP_FLAG_ON,
            ':about_access_id' => \Model_Fleamarket_About::ACCESS,
        );
        $limit = '';
        if (! is_int($row_count)) {
            $row_count = 10;
        }
        $limit = ' LIMIT ' . $row_count;

        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.event_status,
    f.event_date,
    f.event_time_start,
    f.event_time_end,
    f.headline,
    f.event_date,
    l.name AS location_name,
    l.prefecture_id AS prefecture_id,
    fa.description AS about_access,
    fi.file_name
FROM
    fleamarkets AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_images AS fi ON
    f.fleamarket_id = fi.fleamarket_id AND priority = 1
WHERE
    f.display_flag = :display_flag
    AND f.register_type = :register_status
    AND f.event_status <= :event_status
    AND DATE_FORMAT(f.event_date, '%Y-%m-%d') >= CURDATE()
    AND f.pickup_flag = :pickup_flag
    AND f.deleted_at IS NULL
ORDER BY
    f.event_date
{$limit}
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
     * 特定のユーザの投稿したフリマ情報を取得します
     *
     * @access public
     * @param int $user_id
     * @param int $fleamarket_id
     * @return bool
     * @author shimma
     * @author ida
     */
    public static function getUserFleamarkets(
        $user_id, $page = 0, $row_count = 0
    ) {
        $placeholders = array(
            'user_id'         => $user_id,
            'about_access_id' => \Model_Fleamarket_About::ACCESS,
            'display_flag'    => \Model_Fleamarket::DISPLAY_FLAG_ON,
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
    event_date,
    event_time_start,
    event_time_end,
    f.event_status,
    f.description,
    f.reservation_start,
    f.reservation_end,
    f.reservation_tel,
    f.reservation_email,
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
    fleamarkets AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_images AS fi ON
    f.fleamarket_id = fi.fleamarket_id AND priority = 1
WHERE
    f.created_user = :user_id AND
    f.display_flag = :display_flag AND
    f.deleted_at IS NULL
ORDER BY
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
     * 特定のユーザの投稿したフリマ情報をカウントを取得します
     *
     * @access public
     * @param int $user_id
     * @param int $fleamarket_id
     * @return bool
     * @author shimma
     * @author ida
     */
    public static function getUserMyFleamarketCount($user_id)
    {
        $placeholders = array(
            'user_id'         => $user_id,
            'display_flag'    => \Model_Fleamarket::DISPLAY_FLAG_ON,
        );

        $query = <<<QUERY
SELECT
    COUNT(f.fleamarket_id) AS my_fleamarket_count
FROM
    fleamarkets AS f
WHERE
    f.created_user = :user_id AND
    f.display_flag = :display_flag AND
    f.deleted_at IS NULL
ORDER BY
    f.event_date DESC,
    f.event_time_start
QUERY;

        $query = \DB::query($query)->parameters($placeholders);
        $count = $query->execute()->get('my_fleamarket_count');

        return $count;
    }

    /**
     * 指定された条件でフリーマーケット情報リストを取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @param mixed $page ページ
     * @param mixed $row_count ページあたりの行数
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function findAdminBySearch(
        $condition_list, $page = 0, $row_count = 0
    ) {
        $search_where = self::buildSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $where = '';
        if ($conditions) {
            $where = ' WHERE ';
            $where .= implode(' AND ', $conditions);
        }

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = ' LIMIT ' . $offset . ', ' . $row_count;
        }

        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
    f.event_date,
    f.event_time_start,
    f.event_time_end,
    f.event_status,
    f.description,
    f.reservation_start,
    f.reservation_end,
    f.reservation_tel,
    f.reservation_email,
    f.event_reservation_status,
    f.display_flag,
    f.deleted_at,
    f.register_type,
    l.name AS location_name,
    l.zip AS zip,
    l.prefecture_id AS prefecture_id,
    l.address AS address
FROM
    fleamarkets AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
{$where}
ORDER BY
    f.event_date DESC,
    f.event_status ASC,
    f.register_type
{$limit}
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
     * 指定された条件でフリーマーケット情報の件数を取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function getCountByAdminSearch($condition_list)
    {
        $search_where = self::buildSearchWhere($condition_list);
        list($conditions, $placeholders) = $search_where;

        $where = '';
        if ($conditions) {
            $where = ' WHERE ';
            $where .= implode(' AND ', $conditions);
        }

        $query = <<<"QUERY"
SELECT
    COUNT(f.fleamarket_id) AS cnt
FROM
    fleamarkets AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
{$where}
QUERY;

        $statement = \DB::query($query)->parameters($placeholders);
        $result = $statement->execute();

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
        $condition_list = array()
    ) {
        $conditions = array();

        if (! $condition_list) {
            return $conditions;
        }

        foreach ($condition_list as $field => $condition) {
            if ($condition == '') {
                continue;
            }

            $operator = '=';
            if (is_array($condition)) {
                $operator = 'IN';
            }

            switch ($field) {
                case 'register_type':
                    if ($condition != 'all') {
                        $conditions['f.register_type'] = array($operator, $condition);
                    }
                    break;
                case 'event_status':
                    if ($condition != 'all') {
                        $conditions['f.event_status'] = array($operator, $condition);
                    }
                    break;
                case 'prefecture':
                    $conditions['l.prefecture_id'] = array($operator, $condition);
                    break;
                case 'keyword':
                    $conditions['f.name'] = array(
                        ' like ', '%' . $condition . '%'
                    );
                    break;
                default:
                    break;
            }
        }

        return $conditions;
    }

    /**
     * 検索条件を取得する
     *
     * @access private
     * @param array $condition_list 検索条件
     * @return array 検索条件
     * @author void
     */
    public static function createSearchCondition($condition_list = array())
    {
        $conditions = array();

        if (! $condition_list) {
            return $conditions;
        }

        $is_event_date = false;
        foreach ($condition_list as $field => $condition) {
            if ($condition == '') {
                continue;
            }

            $operator = '=';
            if (is_array($condition)) {
                $operator = 'IN';
            }

            switch ($field) {
                case 'keyword':
                    $conditions['f.name'] = array(
                        ' like ', '%' . $condition . '%'
                    );
                    break;
                case 'prefecture':
                    $conditions['prefecture_id'] = array($operator, $condition);
                    break;
                case 'region':
                    if (! isset($condition_list['prefecture'])) {
                        $region_prefectures =
                            \Config::get('master.region_prefectures');
                        $prefecture = $region_prefectures[$condition];
                        $conditions['prefecture_id'] = array('IN', $prefecture);
                    }
                    break;
                case 'shop_fee':
                    $conditions['shop_fee_flag'] = array($operator, $condition);
                    break;
                case 'car_shop':
                    $conditions['car_shop_flag'] = array($operator, $condition);
                    break;
                case 'pro_shop':
                    $conditions['pro_shop_flag'] = array($operator, $condition);
                    break;
                case 'rainy_location':
                    $conditions['rainy_location_flag'] = array(
                        $operator, $condition
                    );
                    break;
                case 'charge_parking':
                    $conditions['charge_parking_flag'] = array(
                        $operator, $condition
                    );
                    break;
                case 'free_parking':
                    $conditions['free_parking_flag'] = array(
                        $operator, $condition
                    );
                    break;
                case 'event_status':
                    $conditions['event_status'] = array($operator, $condition);
                    break;
                case 'entry_style':
                    $conditions['fes.entry_style_id'] = array(
                        $operator, $condition
                    );
                    break;
                case 'calendar':
                    $is_event_date = true;
                    $conditions['event_date'] = array($operator, $condition);
                    break;
                case 'upcomming':
                    $is_event_date = true;
                    $conditions['event_date'] = array('>= CURDATE()');
                    $conditions['event_status'] = array(
                        '<=',
                        self::EVENT_STATUS_RECEIPT_END
                    );
                    break;
                case 'reservation':
                    $is_event_date = true;
                    $conditions['event_date'] = array('>= CURDATE()');
                    $conditions['event_status'] = array(
                        $operator,
                        self::EVENT_STATUS_RESERVATION_RECEIPT,
                    );
                    $conditions['f.register_type'] = array(
                        $operator,
                        self::REGISTER_TYPE_ADMIN,
                    );
                    break;
                default:
                    break;
            }
        }

        if (! $is_event_date) {
            $conditions['event_date'] = array('>= CURDATE()');
        }

        return $conditions;
    }

    /**
     * 指定された検索条件よりWHERE句とプレースホルダ―を生成する
     *
     * @access private
     * @param array $condition_list
     * @return array
     * @author ida
     */
    private static function buildSearchWhere($condition_list)
    {
        $conditions = array();
        $placeholders = array(
            ':display_flag' => self::DISPLAY_FLAG_ON,
            ':about_access_id' => \Model_Fleamarket_About::ACCESS,
        );

        if (empty($condition_list)) {
            return array($conditions, $placeholders);
        }

        $conditions = array();
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

    /**
     * Fieldsetオブジェクトの生成
     *
     * @access public
     * @param bool $is_admin 管理画面かどうか
     * @return array
     * @author ida
     * @author kobayasi
     */
    public static function createFieldset($is_admin = false)
    {
        $fieldset = \Fieldset::forge('fleamarket');
        $fieldset->add_model('Model_Fleamarket');

        if (! $is_admin) {
            $fieldset->add('reservation_email_confirm')
                ->add_rule('match_field', 'reservation_email');
        }
        return $fieldset;
    }

    /**
     * event_reservation_status の更新
     *
     * @access public
     * @param bool $save
     * @return void
     * @author kobayasi
     */
    public function updateEventReservationStatus($save = true)
    {
        $is_full = true;
        foreach ($this->fleamarket_entry_styles as $fleamarket_entry_style) {
            if (! $fleamarket_entry_style->isFullBooth()){
                $is_full = false;
                break;
            }
        }
        if ($is_full) {
            $this->event_reservation_status = self::EVENT_RESERVATION_STATUS_FULL;
            if ($save) {
                $this->save();
            }
        }
    }

    public function incrementReservationSerial($save = true)
    {
        $this->reservation_serial = DB::expr('reservation_serial + 1');
        if ($save) {
            $this->save();
        }
    }

    public function fleamarket_image($n)
    {
        foreach ($this->fleamarket_images as $fleamarket_image) {
            if ($fleamarket_image->priority == $n) {
                return $fleamarket_image;
            }
        }
        return null;
    }

    public function canReserve()
    {
        return
            $this->event_status             == Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT &&
            $this->event_reservation_status != Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL;
    }
}
