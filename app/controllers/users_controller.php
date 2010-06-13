<?php
class UsersController extends AppController {

	var $name = 'Users';

	function beforeFilter()
	{
		$this->Auth->allow('add'); // not auth action

		$params = Router::parse($this->Session->read('Auth.redirect'));
		if (Set::extract($params, 'controller') === 'users') {
			$this->Session->write('Auth.redirect', array('controller' => 'projects'));
		}

		$action = Set::extract($this->params, 'action');
		// no hash passowrd action
		if (in_array(Set::extract($this->params, 'action'), array('add', 'edit'), true)) {
			$this->Auth->authenticate = ClassRegistry::init('User');
		}
	}

	function login()
	{
		// Processing is handovered to Auth component.
	}


	function logout()
	{
		$this->Session->setFlash('logout');
		$this->Auth->logout();
		$this->redirect(array('action' => 'index'));
  }

	function index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null)
	{
		if (!$id) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add()
	{
		if (!empty($this->data)) {
			$this->User->create($this->data);
			if ($this->User->validates()) {
					$path = $this->Auth->getModel()->alias . '.' . $this->Auth->fields['password'];
					$this->data = Set::insert($this->data, $path, $this->Auth->password(Set::extract($this->data, $path)));
				if ($this->User->save($this->data, false)) {
					$this->Session->setFlash(__('The User has been saved', true));
					$this->redirect(array('action' => 'index'));
				}
			}
			$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
		}
	}

	function edit($id = null) {
		if ((!$id && empty($this->data)) || !$id) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->User->create($this->data);
			if ($this->User->validates()) {
				$path = $this->Auth->getModel()->alias . '.' . $this->Auth->fields['password'];
				$this->data = Set::insert($this->data, $path, $this->Auth->password(Set::extract($this->data, $path)));
				if ($this->User->save($this->data, false)) {
					$this->Session->setFlash(__('The User has been saved', true));
					$this->redirect(array('action' => 'index'));
				}
			}
			$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The User could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
