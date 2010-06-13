<?php



class WhiskCakeTestCase extends CakeTestCase
{

	public $name;
	protected $_this;

	protected function _createControllerInstance(&$_this)
	{
		$this->_this = $_this;
		$this->name = $name = str_replace('ControllerTestCase', '', get_class($_this));
		$controllerName = $name . 'Controller';

		$_this->$name =& new $controllerName;
		$_this->$name->constructClasses();
		$_this->$name->params['controller'] = strtolower($name);
		$_this->$name->params['pass'] = array();
		$_this->$name->params['named'] = array();
	}

	protected function _initControllerAction($action = 'index', $url, $login = false)
	{
		$this->_this->{$this->name}->params['action'] = $action;
		$this->_this->{$this->name}->params['url']['url'] = $url;
		$this->_this->{$this->name}->Component->initialize($this->_this->{$this->name});
		if ($login) {
			$this->_this->{$this->name}->Session->write('Auth.User', array(
				'id' => 1,
				'username' => 'admin',
			));
		}
		$this->_this->{$this->name}->beforeFilter();
		$this->_this->{$this->name}->Component->startup($this->_this->{$this->name});
	}


	function endTest()
	{
		unset($this->_this->{$this->name});
		ClassRegistry::flush();
	}
}
