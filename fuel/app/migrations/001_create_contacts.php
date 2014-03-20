<?php

namespace Fuel\Migrations;

class Create_contacts
{
	public function up()
	{
		\DBUtil::create_table('contacts', array(
			'contact_id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'inquiry_type' => array('type' => 'tinyint'),
			'inquiry_datetime' => array('type' => 'datetime'),
			'subject' => array('constraint' => 255, 'type' => 'varchar'),
			'contents' => array('type' => 'text'),
			'name' => array('constraint' => 127, 'type' => 'varchar'),
			'tel' => array('constraint' => 20, 'type' => 'varchar', 'null' => true),
			'email' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('contact_id'));
	}

	public function down()
	{
		\DBUtil::drop_table('contacts');
	}
}