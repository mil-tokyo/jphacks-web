<?php

namespace Fuel\Migrations;

class Create_queues
{
	public function up()
	{
		\DBUtil::create_table('queues', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'state' => array('type' => 'tinyint', 'unsigned' => true),
			'started_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'), true, false, null, array(
		array(
			'key' => 'user_id',
			'reference' => array(
				'table' => 'users',
				'column' => 'id',
			),
			'on_update' => 'CASCADE',
			'on_delete' => 'CASCADE',
		),
		));
	}

	public function down()
	{
		\DBUtil::drop_table('queues');
	}
}