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
     * 登録タイプ 1:運営者,2:ユーザ投稿
     */
    const REGISTER_TYPE_ADMIN = 1;
    const REGISTER_TYPE_USER = 2;

    protected static $_table_name = 'locations';

    protected static $_primary_key  = array('location_id');

    protected static $_properties = array(
        'location_id' => array(
            'form'  => array('type' => false)
        ),
        'branch_id' => array(
            'form'  => array('type' => false)
        ),
        'name' => array(
            'label' => '会場名',
            'validation' => array(
                'required', 'max_length' => array(50)
            )
        ),
        'zip' => array(
            'label' => '郵便番号',
            'validation' => array(
                'required',
                'valid_string' => array(array('numeric' => 'utf8')),
                'max_length' => array(7)
            ),
        ),
        'prefecture_id' => array(
            'label' => '都道府県',
            'validation' => array('required')
        ),
        'address' => array(
            'label' => '住所',
            'validation' => array(
                'required',
                'max_length' => array(100)
            )
        ),
        'googlemap_address' => array(
            'validation' => array(
                'max_length' => array(100)
            )
        ),
        'register_type' => array(
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
        $location = self::forge();
        $fieldset = \Fieldset::forge('location');
        $fieldset->add_model($location);
        // @TODO 'required', array('array_key_exists', Config::get('master.prefectures'))

        return $fieldset;
    }
}
