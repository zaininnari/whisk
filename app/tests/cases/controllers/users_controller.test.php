<?php

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
	 * @var TestUsersController
	 */
	var $Users;
	var $fixtures = array('app.user', 'app.ticket', 'app.state', 'app.project', 'app.comment');

	function startTest() {
		$this->_createControllerInstance($this);
	}

	function endTest() {
		parent::endTest();
	}

	function testLogin() {
		$this->Users->data = array('User' => array(
			'username' => 'aaaa',
			'password' => 'aaaa'
		));
		$this->_initControllerAction('login', 'users/login', false);
		$this->assertEqual($this->Users->redirectUrl, '/');
		$this->assertNotEqual($this->Users->Auth->user(), null);
	}

	function testLogout() {
		$this->_initControllerAction('logout', 'users/logout', true);
		$this->assertNotEqual($this->Users->Auth->user(), null);
		$this->Users->logout();
		$this->assertNull($this->Users->Auth->user());
		$this->assertEqual($this->Users->redirectUrl, array('action' => 'index'));
	}

	function testCheckLoginAction()
	{
		$this->_initControllerAction('index', 'users', false);
		$this->assertEqual($this->Users->redirectUrl, '/users/login');

		$this->Users->redirectUrl = false;
		$this->_initControllerAction('add', 'users/add', false);
		$this->assertFalse($this->Users->redirectUrl);

		$this->Users->redirectUrl = false;
		$this->_initControllerAction('edit', 'users/edit/1', false);
		$this->assertEqual($this->Users->redirectUrl, '/users/login');

		$this->Users->redirectUrl = false;
		$this->_initControllerAction('view', 'users/view/1', false);
		$this->assertEqual($this->Users->redirectUrl, '/users/login');

		$this->Users->redirectUrl = false;
		$this->_initControllerAction('delete', 'users/delete/1', false);
		$this->assertEqual($this->Users->redirectUrl, '/users/login');
	}

	function testIndex() {
		$this->_initControllerAction('index', 'users', true);
		$this->assertFalse($this->Users->redirectUrl);
		$this->assertNotEqual($this->Users->Auth->user(), null);
		$this->Users->index();
		$output = $this->Users->render('index');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testView() {
		$this->_initControllerAction('view', 'users/view', true);
		$this->assertFalse($this->Users->redirectUrl);
		$this->Users->view();
		$output = $this->Users->render('view');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testAdd() {
		$this->_initControllerAction('add', 'users/add', true);

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



}
