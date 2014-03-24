<?php

namespace Fuel\Migrations;

class Create_fleamarket_entry_styles
{
	public function up()
	{
		\DBUtil::create_table('fleamarket_entry_styles', array(
			'fleamarket_entry_style_id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'fleamarket_id' => array('constraint' => 11, 'type' => 'int'),
			'entry_style_id' => array('constraint' => 11, 'type' => 'int'),
			'booth_fee' => array('constraint' => 11, 'type' => 'int'),
			'reservation_booth_limit' => array('constraint' => 11, 'type' => 'int'),
			'created_user' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('fleamarket_entry_style_id'));
	}

	public function down()
	{
		\DBUtil::drop_table('fleamarket_entry_styles');
	}
}