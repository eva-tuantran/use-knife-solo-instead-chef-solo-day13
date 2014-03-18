<?php

class Model_Fleamarket extends \Orm\Model
{

    protected static $_primary_key = array('fleamarket_id');
    protected static $_has_many = array(
        'fleamarket_entry_styles' => array(
            'key_from' => 'fleamarket_id',
        )
    );

	protected static $_properties = array(
		'fleamarket_id',
		'location_id',
		'group_code',
		'name',
		'promoter_name',
		'event_number',
		'event_datetime',
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
	protected static $_table_name = 'fleamarkets';

}
