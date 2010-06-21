<?php

class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2010-01-01 00:00:00',
			'modified' => '2010-01-01 00:00:00',
			'username' => 'aaaa',
			'password' => '886cda4198f50ec0167c8eb38edf7036c838c3aa'
		),
	);

}
