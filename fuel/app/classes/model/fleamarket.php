<?php

/**
 * Fleamarkets Model
 *
 * フリーマーケット情報テーブル
 *
 * @author ida
 */
class Model_Fleamarket extends \Orm\Model
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
     * 出店料 0:有料,1:無料
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
     * 予約状況  1. まだまだあります 2. 残り僅か！ 3. 満員
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
        )
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
            'form'  => array('type' => false)
        ),
        'headline' => array(
            'validation' => array(
                'max_length' => array(100)
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
            'validation' => array('valid_tel')
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
            'label' => '出品物の種類',
            'form'  => array('type' => false)
        ),
        'pickup_flag' => array(
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'shop_fee_flag' => array(
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'car_shop_flag' => array(
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'pro_shop_flag' => array(
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'rainy_location_flag' => array(
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'charge_parking_flag' => array(
            'validation' => array(
                'numeric_between' => array(0, 1)
            )
        ),
        'free_parking_flag' => array(
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
            'form'  => array('type' => false)
        ),
        'display_flag' => array(
            'form'  => array('type' => false)
        ),
        'event_reservation_status' => array(
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
     * 開催状況リスト
     */
    protected static $event_statuses = array(
        self::EVENT_STATUS_SCHEDULE    => '開催予定',
        self::EVENT_STATUS_RESERVATION_RECEIPT => '予約受付中',
        self::EVENT_STATUS_RECEIPT_END => '受付終了',
        self::EVENT_STATUS_CLOSE       => '開催終了',
        self::EVENT_STATUS_CANCEL      => '開催中止',
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

        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    DATE_FORMAT(f.event_date, '%Y-%m-%d') AS event_date
FROM
    {$table_name} AS f
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
        list($where, $placeholders) = self::buildSearchWhere($condition_list);

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page - 1) * $row_count;
            $limit = ' LIMIT ' . $offset . ', ' . $row_count;
        }

        $table_name = self::$_table_name;
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
    fa.description AS about_access
FROM
    {$table_name} AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_entry_styles AS fes ON f.fleamarket_id = fes.fleamarket_id
WHERE
    f.display_flag = :display_flag
    AND f.deleted_at IS NULL
    {$where}
GROUP BY
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
	location_name,
	zip,
	prefecture_id,
	address,
	googlemap_address,
	about_access
ORDER BY
    f.register_type,
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
     * 指定された条件でフリーマーケット情報の件数を取得する
     *
     * @access public
     * @param array $condition_list 検索条件
     * @return array フリーマーケット情報
     * @author ida
     */
    public static function getCountBySearch($condition_list)
    {
        list($where, $placeholders) = self::buildSearchWhere($condition_list);

        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    COUNT(DISTINCT f.fleamarket_id) AS cnt
FROM
    {$table_name} AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_entry_styles AS fes ON f.fleamarket_id = fes.fleamarket_id
WHERE
    f.display_flag = :display_flag
    AND f.deleted_at IS NULL
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

        $table_name = self::$_table_name;
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
    {$table_name} AS f
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

        return $rows[0];
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

        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.event_status,
    f.event_date,
    l.name AS location_name,
    l.prefecture_id,
    SUM(fes.max_booth) AS max_booth
FROM
    {$table_name} AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_entry_styles AS fes ON f.fleamarket_id = fes.fleamarket_id
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
    f.register_type,
    f.event_date,
    l.prefecture_id AS prefecture_id
FROM
    {$table_name} AS f
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
    f.headline,
    f.event_date,
    l.name AS location_name,
    l.prefecture_id AS prefecture_id
FROM
    {$table_name} AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
WHERE
    f.display_flag = :display_flag
    AND f.register_type = :register_status
    AND f.event_status <= :event_status
    AND DATE_FORMAT(f.event_date, '%Y-%m-%d') >= CURDATE()
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
     *
     * @todo: こちらの実装がお気に入りから取得になっているので修正
     */
    public static function getUserFleamarkets($user_id, $page = 0, $row_count = 0)
    {
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
    e.fleamarket_entry_style_id,
    DATE_FORMAT(f.event_date, '%Y年%m月%d日') AS event_date,
    DATE_FORMAT(f.event_time_start, '%k時%i分') AS event_time_start,
    DATE_FORMAT(f.event_time_end, '%k時%i分') AS event_time_end,
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
    fes.booth_fee AS booth_fee
FROM
    favorites AS fav
LEFT JOIN
    entries AS e ON
    fav.fleamarket_id = e.fleamarket_id
LEFT JOIN
    fleamarkets AS f ON
    fav.fleamarket_id = f.fleamarket_id
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_entry_styles AS fes ON f.fleamarket_id = fes.fleamarket_id
WHERE
    fav.user_id = :user_id AND
    f.display_flag = :display_flag AND
    fav.deleted_at IS NULL
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
     * 検索条件を取得する
     *
     * @access private
     * @param array $data 選択された検索条件
     * @return array 検索条件
     * @author void
     */
    public static function createSearchCondition($data)
    {
        $conditions = array();

        if (isset($data['event_date']) && $data['event_date'] !== '') {
            $conditions[] = array(
                'DATE_FORMAT(event_date, \'%Y/%m/%d\')',
                '=',
                $data['event_date']
            );
        }

        if (isset($data['keyword']) && $data['keyword'] !== '') {
            $conditions[] = array(
                'f.name', 'like', '%' . $data['keyword'] . '%'
            );
        }

        if (isset($data['region']) && $data['region'] !== '') {
            $region_prefectures = \Config::get('master.region_prefectures');
            $prefecture = $region_prefectures[$data['region']];
            $conditions[] = array('prefecture_id', 'IN', $prefecture);
        }

        if (isset($data['prefecture']) && $data['prefecture'] !== '') {
            $conditions[] = array('prefecture_id', '=', $data['prefecture']);
        }

        if (isset($data['shop_fee']) && $data['shop_fee'] !== '') {
            $operator = '=';
            if (is_array($data['shop_fee'])) {
                $operator = 'IN';
            }
            $conditions[] = array(
                'shop_fee_flag', $operator, $data['shop_fee']
            );
        }

        if (isset($data['car_shop']) && $data['car_shop'] !== '') {
            $conditions[] = array('car_shop_flag', '=', $data['car_shop']);
        }

        if (isset($data['pro_shop']) && $data['pro_shop'] !== '') {
            $conditions[] = array('pro_shop_flag', '=', $data['pro_shop']);
        }

        if (isset($data['rainy_location']) && $data['rainy_location'] !== '') {
            $conditions[] = array(
                'rainy_location_flag', '=', $data['rainy_location']
            );
        }

        if (isset($data['charge_parking']) && $data['charge_parking'] !== '') {
            $conditions[] = array(
                'charge_parking_flag', '=', $data['charge_parking']
            );
        }

        if (isset($data['free_parking']) && $data['free_parking'] !== '') {
            $conditions[] = array(
                'free_parking_flag', '=', $data['free_parking']
            );
        }

        if (isset($data['event_status']) && is_array($data['event_status'])) {
            $operator = '=';
            if (is_array($data['event_status'])) {
                $operator = 'IN';
            }
            $conditions[] = array(
                'f.event_status', $operator, $data['event_status']
            );
        }

        if (isset($data['entry_style']) && is_array($data['entry_style'])) {
            $operator = '=';
            if (is_array($data['entry_style'])) {
                $operator = 'IN';
            }
            $conditions[] = array(
                'fes.entry_style_id', $operator, $data['entry_style']
            );
        }

        if (isset($data['date']) && $data['date']) {
            $conditions[] = array(
                'f.event_date', '=', $data['date']
            );
        }

        if (isset($data['upcomming']) && $data['upcomming']) {
            $conditions[] = array(
                'f.event_date >= CURDATE()'
            );
        }

        if (isset($data['reservation']) && $data['reservation']) {
            $conditions[] = array(
                'f.register_type', '=', \Model_Fleamarket::REGISTER_TYPE_ADMIN
            );
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
        $where = '';
        $placeholders = array(
            ':display_flag' => self::DISPLAY_FLAG_ON,
            ':about_access_id' => \Model_Fleamarket_About::ACCESS,
            ':register_status' => self::REGISTER_TYPE_ADMIN,
        );

        if (empty($condition_list)) {
            return array($where, $placeholders);
        }

        $conditions = array();
        foreach ($condition_list as $condition) {
            if (count($condition) == 1) {
                $conditions[] = $condition[0];
            } else {
                $field = $condition[0];
                $operator = $condition[1];
                if ($operator === 'IN') {
                    $placeholder = ':' . $field;
                    $values = $condition[2];
                    $placeholder_strings = array();
                    foreach ($values as $key => $value) {
                        $placeholder_in = $placeholder . $key;
                        $placeholder_strings[] = $placeholder_in;
                        $placeholders[$placeholder_in] = $value;
                    }
                    $value = implode(',', $values);
                    $placeholder_string = implode(',', $placeholder_strings);
                    $conditions[] = $field . ' '
                                  . $operator . ' '
                                  . '(' . $placeholder_string . ')';
                } else {
                    $placeholder = ':' . $field;
                    $value = trim($condition[2]);
                    $conditions[] = $field . ' ' . $operator . ' ' . $placeholder;
                    $placeholders[$placeholder] = $value;
                }
            }
        }

        $where = ' AND ';
        $where .= implode(' AND ', $conditions);

        return array($where, $placeholders);
    }

    /*
     * Fieldsetオブジェクトの生成
     *
     * @access public
     * @param is_admin: 管理画面かどうか
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

    /*
     * event_reservation_status の更新
     *
     * @access public
     * @param
     * @return
     * @author kobayasi
     */
    public function updateEventReservationStatus($save = true)
    {
        $is_full = true;
        foreach ($this->fleamarket_entry_styles as $fleamarket_entry_style) {
            if (! $fleamarket_entry_style->isNeedWaiting()) {
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

    public static function findForUpdate($fleamarket_id)
    {
        $query = DB::select()
            ->from('fleamarkets')
            ->where('fleamarket_id',$fleamarket_id) . " FOR UPDATE";

        $result = DB::query($query)->as_object('Model_Fleamarket')->execute();

        return $result ? $result[0] : null;
    }
}
