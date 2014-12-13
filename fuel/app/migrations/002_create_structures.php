<?php

namespace Fuel\Migrations;

class Create_structures
{
	public function up()
	{
		\DBUtil::create_table('structures', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'queue_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
			'json' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'), true, false, null, array(
		array(
			'key' => 'queue_id',
			'reference' => array(
				'table' => 'queues',
				'column' => 'id',
			),
			'on_update' => 'CASCADE',
			'on_delete' => 'CASCADE',
		),
		));
	}

	public function down()
	{
		\DBUtil::drop_table('structures');
	}
}