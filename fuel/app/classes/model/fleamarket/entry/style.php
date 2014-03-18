<?php

class Model_Fleamarket_Entry_Style extends \Orm\Model
{
    protected static $_primary_key = array('fleamarket_entry_style_id');

	protected static $_properties = array(
		'fleamarket_entry_style_id',
		'fleamarket_id',
		'entry_style_id',
		'booth_fee',
		'reservation_booth_limit',
		'created_user',
        'updated_user',
		'created_at',
		'updated_at',
        'deleted_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'fleamarket_entry_styles';

}
