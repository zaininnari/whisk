<?php
/* Project Test cases generated on: 2010-06-13 21:06:07 : 1276431727*/
App::import('Model', 'Project');

class ProjectTestCase extends CakeTestCase {
	var $fixtures = array('app.project', 'app.user', 'app.ticket', 'app.state', 'app.comment');
	/**
	 * @var Project
	 */
	public $Project;

	function startTest() {
		$this->Project =& ClassRegistry::init('Project');
	}

	function endTest() {
		unset($this->Project);
		ClassRegistry::flush();
	}

	function testValidates() {
		$data = array('Project' => array(
			'name' => 'name',
			'type' => 'type',
			'license' => 'license'
		));
		$this->Project->create($data);
		$result = $this->Project->validates();
		$this->assertTrue($result);

		$data = array('Project' => array(
			'name' => 'あ',
		));
		$this->Project->create($data);
		$result = $this->Project->validates();
		$this->assertEqual($this->Project->validationErrors, array(
			'name' => $this->Project->validate['name']['allowedChars']['message'],
			'type' => $this->Project->validate['type']['notempty']['message'],
			'license' => $this->Project->validate['license']['notempty']['message'],
		));

		$data = array('Project' => array(
			'name' => 'whisk',
			'type' => 'type',
			'license' => 'license'
		));
		$this->Project->create($data);
		$result = $this->Project->validates();
		$this->assertEqual($this->Project->validationErrors, array(
			'name' => $this->Project->validate['name']['unique']['message']
		));
	}

}
