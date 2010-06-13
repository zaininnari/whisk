<?php



class WhiskCakeTestCase extends CakeTestCase
{

	/**
	 * @var AppController
	 */
	public $name;
	protected $_this;

	protected function _parsejson($result)
	{
		$josn = json_decode($result, true);
		$function = $josn !== null ? Set::extract('function', $josn) : null;
		if ($function === 'cakeError') {
			$result = Set::extract('method', $josn);
		} elseif ($function === 'redirect') {
			$result = Set::extract('url', $josn);
		}
		return $result;
	}

	protected function login()
	{
		return $this->_this->{$this->name}->Session->write('Auth.User', array('id' => 1));
	}

	protected function _userLogin()
	{
		$data = array('User' => array(
			'username' => 'aaaa',
			'password' => 'aaaa',
		));
	$this->assertNull($this->_this->{$this->name}->Auth->user());
		$result = $this->testAction('/users/login', array(
			'data' => $data,
			'method' => 'post',
		));
		var_dump($this->_this->{$this->name}->Auth->user());exit;
		$this->assertEqual($this->_this->{$this->name}->Auth->isAuthorized() , true);
	}

	protected function _userLogout()
	{
		$result = $this->testAction('/users/logout');
		$this->assertEqual($this->_this->{$this->name}->Auth->isAuthorized() , false);
	}

	protected function _createControllerInstance(&$_this)
	{
		$this->_this = $_this;
		$this->name = $name = str_replace('ControllerTestCase', '', get_class($_this));
		$controllerName = 'Test' . $name . 'Controller';

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
		$a =$this->_this->{$this->name}->Component->initialize($this->_this->{$this->name});
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
