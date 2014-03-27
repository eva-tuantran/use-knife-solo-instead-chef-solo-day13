<?php

/**
 * 
 *
 * マイリストテーブル
 *
 * @author kobayasi
 */
class Model_Favorite extends \Orm\Model_Soft
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
}
