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
     * テーブル名
     *
     * @var string $_table_name
     */
    protected static $_table_name = 'fleamarkets';

    /**
     * プライマリーキー
     *
     * @var string $_primary_key
     */
    protected static $_primary_key = array('fleamarket_id');


    protected static $_properties = array(
        'fleamarket_id',
        'location_id',
        'group_code',
        'name',
        'promoter_name',
        'event_number',
        'event_date',
        'event_time_start',
        'event_time_end',
        'event_status',
        'headline',
        'information',
        'description',
        'reservation_serial',
        'reservation_start',
        'reservation_end',
        'reservation_tel',
        'reservation_email',
        'website',
        'item_categories',
        'link_from_list',
        'pickup_flag',
        'shop_fee_flag',
        'car_shop_flag',
        'pro_shop_flag',
        'charge_parking_flag',
        'free_parking_flag',
        'rainy_location_flag',
        'donation_fee',
        'donation_point',
        'register_type',
        'display_flag',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
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
     * @return array
     * @author ida
     */
    public static function getEventStatuses()
    {
        return $event_statuses;
    }

    /**
     * 指定された年月に開催されるフリーマーケット情報リストを取得する
     *
     * @access public
     * @param mixed $year 対象年
     * @param mixed $month 対象月
     * @return array フリーマーケット情報
     * @author ida
     *
     * @TODO: 実装途中
     */
    public static function findByEventDate($year, $month)
    {
        $query = self::find("all")
            ->where('event_date', 'between', array($date.'000000', $date.'235959'))
            ->get();
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
        list($where, $placeholders) = self::createWhereBySearch(
            $condition_list
        );

        $limit = '';
        if (is_numeric($page) && is_numeric($row_count)) {
            $offset = ($page * $row_count) - 1;
            $limit = ' LIMIT ' . $offset . ', ' . $row_count;
        }

        $table_name = self::$_table_name;
        $query = <<<"QUERY"
SELECT
    f.fleamarket_id,
    f.name,
    f.promoter_name,
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
    f.register_type = :register_status,
    f.event_date DESC,
    f.event_time_start
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
    public static function findBySearchCount($condition_list)
    {
        list($where, $placeholders) = self::createWhereBySearch(
            $condition_list
        );

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
    public static function findByDetail($fleamarket_id)
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
    l.googlemap_address AS googlemap_address
FROM
    {$table_name} AS f
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
WHERE
    f.display_flag = :display_flag
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
     * 検索条件を取得する
     *
     * @access private
     * @param array $data 選択された検索条件
     * @return array 検索条件
     * @author void
     */
    public static function createConditionList($data)
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
    private static function createWhereBySearch($condition_list)
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
            $field = $condition[0];
            $operator = $condition[1];
            if ($operator === 'IN') {
                $placeholder = ':' . $field;
                $values = $condition[2];
                $placeholder_string = '';
                foreach ($values as $key => $value) {
                    $placeholder_in = $placeholder . $key;
                    $placeholder_string .= $placeholder_string == '' ? '' : ',';
                    $placeholder_string .= $placeholder_in;
                    $placeholders[$placeholder_in] = $value;
                }
                $value = implode(',', $values);
                $conditions[] = $field . ' ' . $operator . ' (' . $placeholder_string . ')';
            } else {
                $placeholder = ':' . $field;
                $value = trim($condition[2]);
                $conditions[] = $field . ' ' . $operator . ' ' . $placeholder;
                $placeholders[$placeholder] = $value;
            }
        }

        $where = ' AND ';
        $where .= implode(' AND ', $conditions);

        return array($where, $placeholders);
    }
}
