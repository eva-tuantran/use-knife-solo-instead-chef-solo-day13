<?php

namespace Fuel\Migrations;

class Create_fleamarkets
{
	public function up()
	{
		\DBUtil::create_table('fleamarkets', array(
			'fleamarket_id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'location_id' => array('constraint' => 11, 'type' => 'int'),
			'group_code' => array('constraint' => 6, 'type' => 'char'),
			'name' => array('constraint' => 127, 'type' => 'varchar'),
			'promoter_name' => array('constraint' => 127, 'type' => 'varchar', 'null' => true),
			'event_number' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'event_datetime' => array('type' => 'datetime'),
			'event_status' => array('type' => 'tinyint'),
			'headline' => array('constraint' => 127, 'type' => 'varchar', 'null' => true),
			'information' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'description' => array('type' => 'text', 'null' => true),
			'reservation_serial' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'reservation_start' => array('type' => 'datetime', 'null' => true),
			'reservation_end' => array('type' => 'datetime', 'null' => true),
			'reservation_tel' => array('constraint' => 20, 'type' => 'varchar'),
			'reservation_email' => array('constraint' => 255, 'type' => 'varchar'),
			'website' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'item_categories' => array('constraint' => 255, 'type' => 'varchar'),
			'link_from_list' => array('constraint' => 511, 'type' => 'varchar', 'null' => true),
			'shop_fee_flag' => array('type' => 'tinyint'),
			'car_shop_flag' => array('type' => 'tinyint'),
			'pro_shop_flag' => array('type' => 'tinyint'),
			'charge_parking_flag' => array('type' => 'tinyint'),
			'free_parking_flag' => array('type' => 'tinyint'),
			'rainy_location_flag' => array('type' => 'tinyint'),
			'donation_fee' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'donation_point' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'register_type' => array('type' => 'tinyint', 'null' => true),
			'display_flag' => array('type' => 'tinyint', 'null' => true),
			'created_user' => array('constraint' => 11, 'type' => 'int'),
			'updated_user' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('fleamarket_id'));
	}

	public function down()
	{
		\DBUtil::drop_table('fleamarkets');
	}
}