<?php
App::import('Core', array('Dispatcher', 'Router'));

class RoutingTestCase extends CakeTestCase
{
	var $fixtures = array('app.state', 'app.project', 'app.user', 'app.ticket', 'app.comment');
	public function testParseBase()
	{
		App::import('Core', array('Session'));
		new SessionComponent();
		$Dispatcher = new Dispatcher();
		$params = $Dispatcher->parseParams('/');
		$model =& ClassRegistry::getObject('Session');
		$this->assertIdentical('projects', $params['controller']);
		$this->assertIdentical('index', $params['action']);
		$this->assertIdentical(array(), $params['pass']);
		$this->assertIdentical(array(), $params['named']);
	}


	public function testParseParamsProjectName()
	{
		$Dispatcher = new Dispatcher();
		$params = $Dispatcher->parseParams('/p/whisk/tickets');

		$this->assertIdentical('tickets', $params['controller']);

		$this->assertIdentical('index', $params['action']);
		$this->assertIdentical('whisk', $params['project']);

		$params = $Dispatcher->parseParams('/p/whisk/comments');
		$this->assertIdentical('comments', $params['controller']);
		$this->assertIdentical('index', $params['action']);
		$this->assertIdentical('whisk', $params['project']);

		$params = $Dispatcher->parseParams('/p/whisk/states');
		$this->assertIdentical('states', $params['controller']);
		$this->assertIdentical('index', $params['action']);
		$this->assertIdentical('whisk', $params['project']);
	}
}



