<?php

/**
 *
 *
 * マイリストテーブル
 *
 * @author kobayasi
 */
class Model_Favorite extends Model_Base
{
    /**
     * テーブル名
     *
     * @var string $table_name
     */
    protected static $_table_name = 'favorites';

    /**
     * プライマリーキー
     *
     * @var string $_primary_key
     */
    protected static $_primary_key  = array('favorite_id');

    protected static $_belongs_to = array(
        'user' => array(
            'key_to' => 'user_id',
        ),
        'fleamarket' => array(
            'key_to' => 'fleamarket_id',
        ),
    );

    protected static $_properties = array(
        'favorite_id',
        'user_id',
        'fleamarket_id',
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
     * 特定のユーザのお気に入りリストを取得します
     *
     * @access public
     * @param int $user_id
     * @param int $fleamarket_id
     * @return bool
     * @author shimma
     */
    public static function getUserFavorites(
        $user_id, $page = 0, $row_count = 0
    ) {
        $placeholders = array(
            'user_id' => $user_id,
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
    f.event_date,
    f.event_time_start,
    f.event_time_end,
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
    favorites AS fav
LEFT JOIN
    fleamarkets AS f ON
    fav.fleamarket_id = f.fleamarket_id
LEFT JOIN
    locations AS l ON f.location_id = l.location_id
LEFT JOIN
    fleamarket_abouts AS fa ON f.fleamarket_id = fa.fleamarket_id
    AND fa.about_id = :about_access_id
LEFT JOIN
    fleamarket_images AS fi ON
    f.fleamarket_id = fi.fleamarket_id AND priority = 1
WHERE
    fav.user_id = :user_id AND
    f.display_flag = :display_flag AND
    fa.about_id = :about_access_id AND
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
     * 特定のユーザのお気に入り個数を取得します
     *
     * @param mixed $user_id
     * @access public
     * @return void
     * @author shimma
     *
     * @todo ormのcountでも良いかも
     */
    public static function getUserfavoriteCount($user_id)
    {
        $placeholders = array(
            'user_id' => $user_id,
        );

        $query = <<<QUERY
SELECT
    COUNT(*) as count
FROM
    favorites AS f
WHERE
    f.user_id = :user_id AND
    f.deleted_at IS NULL
QUERY;

        $favorite_count = \DB::query($query)->parameters($placeholders)->execute()->get('count');

        return $favorite_count;
    }


}
