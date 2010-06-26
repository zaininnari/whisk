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
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		// see __construct()
	);

	function __construct()
	{
		$_records = array(
			array('name' => 'new', 'hex' => 'ff1177', 'position' => '0', 'type' => '0'),
			array('name' => 'open', 'hex' => 'aaaaaa', 'position' => '1', 'type' => '0'),
			array('name' => 'hold', 'hex' => 'EEBB00', 'position' => '2', 'type' => '0'),
			array('name' => 'resolved', 'hex' => '66AA00', 'position' => '3', 'type' => '1'),
			array('name' => 'duplicate', 'hex' => 'AA3300', 'position' => '4', 'type' => '1'),
			array('name' => 'wont-fix', 'hex' => 'AA3300', 'position' => '5', 'type' => '1'),
			array('name' => 'invalid', 'hex' => 'AA3300', 'position' => '6', 'type' => '1'),
		);
		$m = array(
			'project_id' => 1,
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00'
		);
		foreach ($_records as $k => $v) {
			$_records[$k] = array_merge($v, $m);
		}
		$this->records = $_records;
		parent::__construct();
	}

}
