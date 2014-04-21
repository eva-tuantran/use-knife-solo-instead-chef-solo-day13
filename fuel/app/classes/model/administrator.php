<?php

class Model_Administrator extends Model_Base
{
    protected static $_primary_key = array('administrator_id');

    protected static $_properties = array(
        'administrator_id',
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'tel',
        'mobile_tel',
        'email',
        'mobile_email',
        'password',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property' => 'created_at',
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => true,
            'property' => 'updated_at',
        ),
    );
    protected static $_table_name = 'administrators';
}
