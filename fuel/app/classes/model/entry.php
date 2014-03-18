<?php

class Model_Entry extends \Orm\Model
{
    protected static $_primary_key = array('entry_id');

    protected static $_belongs_to = array('fleamarket_entry_style');

	protected static $_properties = array(
		'entry_id',
		'user_id',
		'fleamarket_id',
		'fleamarket_entry_style_id',
		'reservation_number',
		'item_category',
		'item_genres',
		'reserved_booth',
		'link_from',
		'remarks',
		'entry_status',
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
	protected static $_table_name = 'entries';

}
