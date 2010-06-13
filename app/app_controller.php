<?php

class AppController extends Controller {

	var $components = array(
		'Security',
		'Auth',
		'Session',
		'Project',
		//{{{!debug
		'DebugKit.Toolbar'
		//}}}!debug
	);

	protected $_project = null;

	public function beforeFilter()
	{
		$this->beforeFilterAuth();
		$this->beforeFilterProjectRoute();
		return parent::beforeFilter();
	}

	protected function beforeFilterAuth()
	{
		$this->Auth->loginRedirect = array('controller' => 'projects');
		$this->Auth->allow('index', 'view'); // not auth action
	}

	protected function beforeFilterProjectRoute()
	{
		if ($this->isProjectRoute() && $this->uses !== array()) {
			if (self::getProjectId() === null) {
				return $this->cakeError('error404');
			}
			$this->layout = 'project';
		}
	}

	protected function beforeFilterRequireProject()
	{
		if ($this->isProjectRoute() && $this->uses !== array()) {
			if (self::getProjectId() === null) {
				return $this->cakeError('error404');
			}
			$this->layout = 'project';
		}
	}

	protected function isProjectRoute()
	{
		// FIXME
		return isset($this->params['project']) ;//&& $this->getProjectId();
	}

	protected function isOwner($id)
	{
		$data = $this->{$this->modelClass}->read(null, $id);
		return $data[$this->modelClass]['user_id'] === $this->getUserId();
	}

	protected function isAllowed()
	{
		static $isAllowed = null;
		if ($isAllowed === null) {
			if (!in_array('Auth', $this->components) && !array_key_exists('Auth', $this->components)) {
				$isAllowed = true;
			} else {
				$action = strtolower($this->params['action']);
				$allowedActions = array_map('strtolower', $this->Auth->allowedActions);
				$isAllowed = $this->Auth->allowedActions == array('*') || in_array($action, $allowedActions);
			}
		}
		return $isAllowed;
	}

	public function getProjectId()
	{
		return Configure::read('projectId');
	}

	public function getUserId()
	{
		$data = null;
		//if ($this->isAllowed() === false) {
			$data = $this->Session->read($this->Auth->sessionKey);
			$data = is_array($data) && isset($data['id']) ? $data['id'] : null;
		//}
		return $data;
	}


}
