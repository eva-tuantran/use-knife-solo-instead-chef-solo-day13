<?php

/**
 * Locations Model
 *
 * 開催地情報テーブル
 *
 * @author ida
 */
class Model_Location extends \Orm\Model
{
    /**
     * 登録タイプ定数
     */
    const REGISTER_TYPE_ADMIN = 1;
    const REGISTER_TYPE_USER = 2;

    /**
     * テーブル名
     *
     * @var string $table_name
     */
    protected static $_table_name = 'locations';

    /**
     * プライマリーキー
     *
     * @var string $_primary_key
     */
    protected static $_primary_key  = array('location_id');

   /**
     * フィールド設定
     *
     * @var array $_properties
     */
    protected static $_properties = array(
        'location_id',
        'branch_id',
        'name',
        'zip',
        'prefecture_id',
        'address',
        'googlemap_address',
        'register_type',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
    );

    /**
     * オブサーバ設定
     *
     * @var array $_observers
     */
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
