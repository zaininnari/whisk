<?php
/* User Fixture generated on: 2010-05-30 19:05:23 : 1275216203 */
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
			'created' => '2010-04-28 03:05:41',
			'modified' => '2010-04-28 03:05:41',
			'username' => 'aaaa',
			'password' => 'f9172a49ea8ed463c1d9946c233a4fb1de699a80'
		),
	);

}
