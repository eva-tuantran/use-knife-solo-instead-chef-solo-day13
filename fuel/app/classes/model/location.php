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
    protected static $_primary_key  = array('entry_id');
}
