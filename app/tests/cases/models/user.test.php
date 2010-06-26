<?php
/* User Test cases generated on: 2010-06-13 20:06:49 : 1276427749*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	/**
	 * @var User
	 */
	public $User;
	var $fixtures = array('app.user', 'app.ticket', 'app.project', 'app.state', 'app.comment');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

	function testHashPassword() {
		$data = array('User' => array('password' => 'aaaa'));
		$result = $this->User->hashPasswords($data);
		$this->assertEqual($result, $data);
	}

	function testValidates() {
		$data = array('User' => array(
			'username' => 'bbbb',
			'password' => 'aaaa'
		));
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertTrue($result);

		$data = array('User' => array(
			'username' => 'aaaa',
			'password' => 'aaaa'
		));
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertEqual($this->User->validationErrors, array('username' => $this->User->validate['username']['isUnique']['message']));

		$data = array('User' => array(
			'username' => 'a',
			'password' => 'aaaa'
		));
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertEqual($this->User->validationErrors, array('username' => $this->User->validate['username']['between']['message']));

		$data = array('User' => array(
			'username' => 'あああああ',
			'password' => 'aaaa'
		));
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertEqual($this->User->validationErrors, array('username' => $this->User->validate['username']['alphaNumeric']['message']));

		$data = array('User' => array(
			'username' => 'xxxx',
			'password' => 'aaaあ'
		));
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertEqual($this->User->validationErrors, array('password' => $this->User->validate['password']['alphaNumeric']['message']));

		$data = array('User' => array(
			'username' => 'xxxx',
			'password' => 'aaa'
		));
		$this->User->create($data);
		$result = $this->User->validates();
		$this->assertEqual($this->User->validationErrors, array('password' => $this->User->validate['password']['between']['message']));
	}

}
