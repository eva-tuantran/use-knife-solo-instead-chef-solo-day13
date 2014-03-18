<?php

namespace Fuel\Migrations;

class Create_entries
{
	public function up()
	{
		\DBUtil::create_table('entries', array(
			'entry_id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'fleamarket_id' => array('constraint' => 11, 'type' => 'int'),
			'fleamarket_entry_style_id' => array('constraint' => 11, 'type' => 'int'),
			'reservation_number' => array('constraint' => 11, 'type' => 'int'),
			'item_category' => array('constraint' => 50, 'type' => 'varchar'),
			'item_genres' => array('constraint' => 255, 'type' => 'varchar'),
			'reserved_booth' => array('type' => 'tinyint'),
			'link_from' => array('constraint' => 50, 'type' => 'varchar'),
			'remarks' => array('constraint' => 511, 'type' => 'varchar'),
			'entry_status' => array('type' => 'tinyint'),
			'created_user' => array('constraint' => 11, 'type' => 'int'),
			'updated_user' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('entry_id'));
	}

	public function down()
	{
		\DBUtil::drop_table('entries');
	}
}