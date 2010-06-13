<?php
class UsersController extends AppController {

	var $name = 'Users';

	function beforeFilter()
	{
		$this->Auth->allow('add'); // not auth action

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
/*		//////////////////////////////////////////////
		// avoid Auth component password auto hash
		//////////////////////////////////////////////
		$auth['avoidKey'] = array('password');
		$auth['fields'] = $auth['_fields'] = $this->Auth->fields;
		$auth['avoidKeyPrefix'] = '_';
		foreach ($auth['_fields'] as $k => $v) {
			if (in_array($k, $auth['avoidKey'])) {
				$auth['fields'][$k] = $auth['avoidKeyPrefix'] . $v;
			}
		}
		$this->set('auth', $auth);

		if (!empty($this->data['User'])) {
			$data = $this->data['User'];

			// for model, avoid Auth component in invalid error
			foreach ($auth['avoidKey'] as $v) {
				if (isset($data[$v])) continue;
				$data[$v] = $data[$auth['avoidKeyPrefix'] . $v];
				unset($data[$auth['avoidKeyPrefix'] . $v]);
			}

			$this->data['User'] = $data;
			$this->User->create($data);

			if ($this->User->validates()) {
				$authPw = $this->Auth->fields['password'];
				$data[$authPw] = $this->Auth->password($data[$authPw]);
				$this->data['User'] = $data;

				if ($this->User->save($this->data)) {
					$this->Session->setFlash(__('The User has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
				}

			} else {
				// avoid Auth component
				// for view HtmlHelper::input() in invalid error
				foreach ($this->User->validationErrors as $key => $val) {
					$search = array_search($key, $auth['avoidKey']);
					if($search !== false) {
						$search = $auth['fields'][$auth['avoidKey'][$search]];
						$this->User->validationErrors[$search] = $val;
						unset($this->User->validationErrors[$key]);
					}
				}
			} // end if $this->User->validates()
		}*/

	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
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
