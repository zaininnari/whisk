<?php
require_once APP . '/tests/lib/whisk_cake_test_case.php';

App::import('Controller', 'Users');


class TestUsersController extends UsersController
{
	public $autoRender = false;
	public $redirectUrl = false;
	public function redirect($url, $status = null, $exit = true)
	{
		return $this->redirectUrl = $url;
	}
}

class UsersControllerTestCase extends WhiskCakeTestCase
{
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
		$this->assertEqual($this->_parsejson($result) , '/users/login');

		$result = $this->testAction('/users/edit/1');
		$this->assertEqual($this->_parsejson($result) , '/users/login');

		$result = $this->testAction('/users/view');
		$this->assertEqual($this->_parsejson($result) , '/users/login');

		$result = $this->testAction('/users/view/1');
		$this->assertEqual($this->_parsejson($result) , '/users/login');

		$result = $this->testAction('/users/delete');
		$this->assertEqual($this->_parsejson($result) , '/users/login');

		$result = $this->testAction('/users/delete/1');
		$this->assertEqual($this->_parsejson($result) , '/users/login');
	}

	function testIndex() {
		$this->_initControllerAction('index', 'users', true);
		$this->Users->index();
		$output = $this->Users->render('index');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testView() {
		$this->_initControllerAction('view', 'users/view', true);
		$this->Users->view();
		$output = $this->Users->render('view');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testAdd() {
		$this->_initControllerAction('add', 'users/view', true);

		$beforeCount = $this->Users->User->find('count');
		$this->assertEqual(1, $beforeCount);

		$this->Users->data = array('User' => array(
			'username' => 'bbbb',
			'password' => 'cccc'
		));
		$this->Users->add();
		$this->assertEqual($this->Users->redirectUrl, array('action' => 'index'));

		$afterCount = $this->Users->User->find('count');
		$this->assertEqual($beforeCount + 1, $afterCount);

		$user = $this->Users->User->findById($afterCount);
		$expect = array(
			'username' => $this->Users->data['User']['username'],
			'password' => $this->Users->Auth->hashPasswords($this->Users->data['User']['password']),
		);
		$this->assertEqual(array_intersect_key($user['User'], $expect), $expect);
	}

	function testDelete() {
		$this->_initControllerAction('delete', 'users/delete/1', true);
		$beforeCount = $this->Users->User->find('count');
		$this->Users->delete(1);
		$this->assertEqual($this->Users->redirectUrl, array('action' => 'index'));

		$afterCount = $this->Users->User->find('count');
		$this->assertEqual($beforeCount - 1, $afterCount);
		$this->assertEqual(false, $this->Users->User->findById(1));
	}

	function testEdit() {
		$this->_initControllerAction('edit', 'users/edit/1', true);
		$this->Users->data = array('User' => array(
			'id' => '1',
			'username' => 'modified',
			'password' => 'modified'
		));
		$this->Users->edit(1);
		$this->assertEqual($this->Users->redirectUrl, array('action' => 'index'));

		$user = $this->Users->User->findById(1);
		$expect = array(
			'username' => $this->Users->data['User']['username'],
			'password' => $this->Users->Auth->hashPasswords($this->Users->data['User']['password']),
		);
		$this->assertEqual(array_intersect_key($user['User'], $expect), $expect);
	}

	function testlogin()
	{
		$this->_userLogin();
	}

	function testlogout()
	{
		$this->_userLogout();
	}

}
