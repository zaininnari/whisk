<?php
/* State Fixture generated on: 2010-06-22 20:06:52 : 1277206192 */
class StateFixture extends CakeTestFixture {
	var $name = 'State';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'hex' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6),
		'position' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'type' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

}
