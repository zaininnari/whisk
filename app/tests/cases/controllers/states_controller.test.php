<?php
/* States Test cases generated on: 2010-05-30 15:05:39 : 1275199779*/
App::import('Controller', 'States');

class TestStatesController extends StatesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class StatesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.state', 'app.project', 'app.user', 'app.ticket', 'app.comment');


	function startCase()
	{
		Configure::write('Session.save', 'php');
	}

	function startTest() {
		$this->States =& new TestStatesController();
		$this->States->constructClasses();
	}

	function endTest() {
		unset($this->States);
		ClassRegistry::flush();
	}

	function testIndexError404() {

		$result = $this->testAction('/states');
		$josn = json_decode($result, true);
		$function = $josn !== null ? Set::extract('function', $josn) : null;
		if ($function === 'cakeError') {
			$result = Set::extract('method', $josn);
		} elseif ($function === 'redirect') {
			$result = Set::extract('url', $josn);
		}
		$this->assertEqual($result , 'error404');

	}

	function testAdd() {

	}

	function testAjaxEdit() {

	}

	function testAjaxSort() {

	}



}
