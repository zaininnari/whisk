<?php
/* States Test cases generated on: 2010-05-30 15:05:39 : 1275199779*/
App::import('Controller', 'States');

class TestStatesController extends StatesController {
	var $autoRender = false;
	var $redirectUrl = false;
	var $statusCode = false;

	function redirect($url, $status = null, $exit = true) {
		return $this->redirectUrl = $url;
	}

	function cakeError($method, $messages = array()) {
		return $this->statusCode = $method;
	}

}

class StatesControllerTestCase extends WhiskCakeTestCase {
	var $fixtures = array('app.project', 'app.state', 'app.user', 'app.ticket', 'app.comment');
	/**
	 * @var TestStatesController
	 */
	var $States;


	function startTest() {
		$this->_createControllerInstance($this);
	}

	function endTest() {
		parent::endTest();
	}

	function testIndexError404() {
		$this->_initControllerAction('index', 'states', false);
		$this->assertFalse($this->States->redirectUrl);
		$this->assertEqual($this->States->statusCode, 'error404');
	}

	function testIndex() {
		$this->_initControllerAction('index', 'p/whisk/states', true);
		$this->assertFalse($this->States->redirectUrl);
		$this->States->index();
		$output = $this->States->render('index');
		$this->assertFalse(strpos($output, '<pre class="cake-debug">'));
	}

	function testAdd() {
		$this->_initControllerAction('add', 'p/whisk/states/add', true);
		$_expect = $this->States->data = array('State' => array(
			'name' => 'name',
		));
		$beforeCOunt = $this->States->State->find('count', array('conditions' => array('project_id' => $this->States->getProjectId())));
		$this->States->add();
		$this->assertEqual($this->States->redirectUrl, array('action' => 'index'));

		$stateId = $this->States->State->getInsertID();
		$state = $this->States->State->findById($stateId);
		$expect = array_merge($_expect['State'], array(
			'hex' => 'ff6600',
			'type' => '0',
			'project_id' => $this->States->getProjectId(),
			'position' => $beforeCOunt)
		);
		$this->assertEqual(array_intersect_key($state['State'], $expect), $expect);
	}

	function testAjaxEdit() {

	}

	function testAjaxSort() {

	}



}
