<?php
require_once APP . '/tests/lib/whisk_cake_test_case.php';

App::import('Controller', 'Users');


class TestUsersController extends UsersController {
	//public $autoRender = false;
	public $redirectUrl = false;
	public function redirect($url, $status = null, $exit = true)
	{
		return $this->redirectUrl = $url;
	}

}

class UsersControllerTestCase extends WhiskCakeTestCase {
	/**
	 * controller
	 *
	 * @var UsersController
	 */
	var $Users;
	var $fixtures = array('app.user', 'app.ticket', 'app.state', 'app.project', 'app.comment');

	function startTest() {
		$this->_createControllerInstance($this);
	}

	function endTest() {
		parent::endTest();
	}

	function testNologin()
	{
		$result = $this->testAction('/users');
		$this->assertEqual($this->_parsejson($result) , '/users/login');

		$result = $this->testAction('/users/add');
		$this->assertNull($this->_parsejson($result));

		$result = $this->testAction('/users/edit');
		$this->assertEqual($this->_parsejson($result) , array('action' => 'index'));

		$result = $this->testAction('/users/edit/1');
		$this->assertEqual($this->_parsejson($result) , '/users/login');

		$result = $this->testAction('/users/view');
		$this->assertEqual($this->_parsejson($result) , array('action' => 'index'));

		$result = $this->testAction('/users/view/1');
		$this->assertEqual($this->_parsejson($result) , '/users/login');

		$result = $this->testAction('/users/delete');
		$this->assertEqual($this->_parsejson($result) , array('action' => 'index'));

		$result = $this->testAction('/users/delete/1');
		$this->assertEqual($this->_parsejson($result) , array('action' => 'index'));
	}

	function testIndex() {
		$this->_initControllerAction('index', 'users', true);
		$this->Users->index();
		$output = $this->Users->render('index');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testView() {
		$this->_initControllerAction('index', 'users/view', true);
		$this->Users->view();
		$output = $this->Users->render('view');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testAdd() {
		$this->_initControllerAction('index', 'users/view', true);
		$this->Users->data = array('User' => array(
			'username' => 'bbbb',
			'password' => 'cccc'
		));
		$this->Users->add();
		$this->assertEqual($this->Users->redirectUrl, array('action' => 'index'));
	}


	function testlogin()
	{
		$this->login();
		$result = $this->testAction('/users');
		$this->assertNull($this->_parsejson($result));
	}
/*
	function testView() {
		$this->_initControllerAction('index', 'users/view', false);
		$result = $this->Users->index();
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
*/
	function testEdit() {

	}

	function testDelete() {

	}

}
