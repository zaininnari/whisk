<?php
require_once APP . '/tests/lib/whisk_cake_test_case.php';

App::import('Controller', 'Users');


class TestUsersController extends UsersController {
	public $autoRender = false;
	public function redirect($url, $status = null, $exit = true)
	{
		$this->redirectUrl = $url;
	}
}

class UsersControllerTestCase extends WhiskCakeTestCase {
	var $fixtures = array('app.user', 'app.ticket', 'app.state', 'app.project', 'app.comment');

	function startTest() {
		$this->_createControllerInstance($this);
	}

	function endTest() {
		parent::endTest();
	}

	function testIndex() {
		$this->_initControllerAction('index', 'users', true);
		$this->Users->index();
		$output = $this->Users->render('index');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testView() {

	}

	function testAdd()
	{
		// check table empty
		//$this->assertEqual(array() , $this->Users->User->find('all'));
		$beforeCount = $this->Users->User->find('count');
		$this->assertEqual(1, $beforeCount);

		$data = array('User' => array(
			'username' => 'bbbb',
			'password' => 'cccc'
		));
		$result = $this->testAction('/users/add', array(
			'data' => $data,
			'method' => 'post',
		));
		$this->assertEqual('index', Set::extract(json_decode($result, true), 'url.action'));
		$this->assertEqual($beforeCount + 1, $this->Users->User->find('count'));

		$data = $this->Users->User->find('first', array('order' => 'User.id  DESC'));

		$expect = array(
			'username' => 'bbbb',
			'password' => Security::hash('cccc', null, true)
		);
		$this->assertEqual(array_intersect_key($data['User'], $expect), $expect);
	}

	function testEdit() {

	}

	function testDelete() {

	}

}
