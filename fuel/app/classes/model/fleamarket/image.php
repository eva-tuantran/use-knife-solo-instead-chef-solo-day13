<?php

class Model_Fleamarket_Image extends Model_Base
{
    protected static $_table_name = 'fleamarket_images';

    protected static $_primary_key  = array('fleamarket_image_id');

    protected static $_properties = array(
        'fleamarket_image_id',
        'fleamarket_id',
        'file_name',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
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

    protected static $_soft_delete = array(
        'deleted_field'   => 'deleted_at',
        'mysql_timestamp' => true,
    );

    /**
     * 指定されたフリーマーケットIDでフリーマーケット画像情報を取得する
     *
     * @access public
     * @param mixed $fleamarket_id フリーマーケットID
     * @void array
     * @author ida
     */
    public static function findByFleamarketId($fleamarket_id)
    {
        $result = self::find('all', array(
            'select' => array(
                'fleamarket_image_id', 'fleamarket_id', 'file_name'
            ),
            'where' => array(
                array('fleamarket_id', $fleamarket_id),
                array('deleted_at', null),
            ),
        ));

        return $result;
    }

    public function Url()
    {
        return '/files/fleamarket/img/' . $this->file_name;
    }
}
